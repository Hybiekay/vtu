<?php 
// Auto Load Classes
require_once("../../autoloader.php");

// Allowed API Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Allow: POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

// Retrieve request headers
 
$response = array();
$controller = new Account;

// Set default timezone
date_default_timezone_set("Africa/Lagos");

// -------------------------------------------------------------------
//  Check Request Method
// -------------------------------------------------------------------
$requestMethod = $_SERVER["REQUEST_METHOD"]; 
if ($requestMethod !== "POST") {
    http_response_code(405); // Method Not Allowed
    $response["status"] = "fail";
    $response["msg"] = "Only POST method is allowed";
    echo json_encode($response);
    exit(); 
}


// Read raw JSON input
$input = file_get_contents("php://input");
$body = json_decode($input, true); // true for associative array

if (isset($body["email"]) && isset($body["otp"])) {
    $email = $body["email"];
    $token = $body["otp"];
} else {
    http_response_code(422); // Unprocessable Entity
    $response["status"] = false;
    $response["message"] = "Email or token missing";
    echo json_encode($response);
    exit();
}

if (!preg_match("/^\d{4}$/", $token)) {
    http_response_code(400); // Bad Request
    $response["status"] = false;
    $response["message"] = "Token must be exactly 4 digits";
    echo json_encode($response);
    exit();
}

if (isset($_POST["email"]) && isset($_POST["otp"])) { 
    $body = $_POST;
}

// -------------------------------------------------------------------
//  Check Required Fields (email and token)
// -------------------------------------------------------------------


    if (isset($body["email"]) && isset($body["token"])) {
        $email = $body["email"];
        $token = $body["token"];

    // Validate the token (must be exactly 4 digits)
    

    // Verify the recovery code using the controller
    $result = $controller->verifyRecoveryCode($email, $token);

    if ($result) {
        http_response_code(200); // Success
        $response["status"] = true;
        $response["message"] = "Successfully verified";
        $response["data"] = $result; // Send user_id and token in response
    } else {
        http_response_code(400); // Bad Request
        $response["status"] = false;
        $response["message"] = "Invalid email or token";
    }
    echo json_encode($response);
    

} else {
    // Respond with error if required fields are missing
    http_response_code(422); // Unprocessable Entity
    $response["status"] = false;
    $response["message"] = "Email or token missing";
    echo json_encode($response);
    exit();
}
?>
