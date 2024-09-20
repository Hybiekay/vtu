<?php

// Auto Load Classes
require_once("../../autoloader.php");

// Allowed API Headers  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

// Retrieve request headers
$headers = apache_request_headers();
$response = array();
$controller = new Account;

// -------------------------------------------------------------------
//  Check Request Method
// -------------------------------------------------------------------
$serverMethod = $_SERVER["REQUEST_METHOD"];
if ($serverMethod !== "POST") {
    http_response_code(405);
    $response["status"] = "fail";
    $response["message"] = "Only POST method is allowed on this route";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Determine Content Type and Handle Data
// -------------------------------------------------------------------
$contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : '';

if (strpos($contentType, 'application/json') !== false) {
    // Handle JSON payload
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
} elseif (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
    // Handle form-urlencoded payload
    $data = $_POST;
} else {
    // Unsupported content type
    http_response_code(415);
    $response["status"] = "fail";
    $response["message"] = "Unsupported Media Type";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Handle Email Recovery Request
// -------------------------------------------------------------------
if (isset($data["email"])) {
    // Sanitize and validate email
    $email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : "";

    if (empty($email)) {
        $response["status"] = "fail";
        $response["message"] = "A valid email is required";
        echo json_encode($response);
        exit();
    }

    // Proceed with recovering user login
    $result = $controller->recoverUserLogin($email);

    if ($result == 0) {
        $response["status"] = "success";
        $response["message"] = "Email sent successfully";
        http_response_code(200);
        echo json_encode($response);
    } elseif ($result == 1) {
        $response["status"] = "fail";
        $response["message"] = "Failed to send email";
        http_response_code(500);
        echo json_encode($response);
    } else {
        $response["status"] = "fail";
        $response["message"] = "User does not exist";
        http_response_code(404);
        echo json_encode($response);
    }
} else {
    $response["status"] = "fail";
    $response["message"] = "Email is required";
    http_response_code(400);
    echo json_encode($response);
    exit();
}
?>
