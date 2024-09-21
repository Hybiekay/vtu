<?php
require_once("../../autoloader.php");
require_once("../../../core/helpers/InputValidator.php");

use Helpers\InputValidator;

// Allowed API Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization, Access-Control-Allow-Methods");

$controller = new Account;
$response = array();

// Check request method
$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod !== "POST") {
    http_response_code(405);
    $response["status"] = "fail";
    $response["msg"] = "Only POST method is allowed";
    echo json_encode($response);
    exit();
}

// Extract the Authorization header
if (!isset($headers['Authorization'])) {
    http_response_code(401); // Unauthorized
    $response["status"] = "fail";
    $response["msg"] = "Authorization token is required";
    echo json_encode($response);
    exit();
}

// Extract the token (Assuming it’s in the format 'Bearer <token>')
$authHeader = $headers['Authorization'];
$token = str_replace('Bearer ', '', $authHeader);

// Validate the token using the checkToken() function
$userId = $controller->checkToken($token);
if (!$userId) {
    http_response_code(401); // Unauthorized
    $response["status"] = "fail";
    $response["msg"] = "Invalid or expired token";
    echo json_encode($response);
    exit();
}

// Determine content type
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
    $response["msg"] = "Unsupported Media Type";
    echo json_encode($response);
    exit();
}

// Check required fields
if (isset($data["email"]) && isset($data["otp"])) {
    $email = strip_tags($data["email"]);
    $otp = strip_tags($data["otp"]);
    $password = isset($data["Password"]) ? strip_tags($data["Password"]) : '';

    // Clean parameters (add your own sanitization logic here)
    $email = InputValidator::cleanParameter($email, 'EMAIL');
    $otp = InputValidator::cleanParameter($otp, 'INTEGER');
    $password = InputValidator::cleanParameter($password, 'STRING');

    // Validate the OTP (must be exactly 4 digits)
    if (!preg_match("/^\d{4}$/", $otp)) {
        http_response_code(400); // Bad Request
        $response["status"] = false;
        $response["message"] = "OTP must be exactly 4 digits";
        echo json_encode($response);
        exit();
    }

    // Validate email and password are not empty after sanitization
    if (empty($email) || empty($password)) {
        http_response_code(400); // Bad Request
        $response["status"] = false;
        $response["message"] = "All inputs must be valid";
        echo json_encode($response);
        exit();
    }

    // Update the user key (password)
    $result = $controller->updateUserKey($email, $otp, $password);

    if ($result == 0) {
        $response["status"] = true;
        $response["message"] = "Password Updated Successfully";
        http_response_code(200);
    } else {
        $response["status"] = false;
        $response["message"] = "Code or Email is not correct";
        http_response_code(403);
    }
} else {
    $response["status"] = false;
    $response["message"] = "All fields are required";
    http_response_code(400);
}

echo json_encode($response);
exit();
?>
