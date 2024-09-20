<?php
require_once("../../autoloader.php");


// Allowed API Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: POST ");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

$headers = apache_request_headers();
$response = array();
$controller = new Account;

date_default_timezone_set('Africa/Lagos');
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod !== "POST") {
    header('HTTP/1.0 400 Bad Request');
    $response["status"] = "fail";
    $response["msg"] = "Only POST method is allowed";
    echo json_encode($response);
    exit();
}

// Get the JSON input and decode it
$input = @file_get_contents("php://input");
$body = json_decode($input);

// Initialize and sanitize inputs
$firstname = htmlspecialchars(trim($body->firstname ?? ""), ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars(trim($body->lastname ?? ""), ENT_QUOTES, 'UTF-8');
$email = filter_var($body->email ?? "", FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($body->phone ?? ""), ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars(trim($body->password ?? ""), ENT_QUOTES, 'UTF-8');
$state = htmlspecialchars(trim($body->state ?? ""), ENT_QUOTES, 'UTF-8');
$account = filter_var($body->account ?? 1, FILTER_SANITIZE_NUMBER_INT);
$referal = htmlspecialchars(trim($body->referal ?? ""), ENT_QUOTES, 'UTF-8');
$transpin = filter_var($body->transpin ?? "", FILTER_SANITIZE_NUMBER_INT);

// Validate the inputs

// Firstname and Lastname validation: Ensure no numbers or special characters
if (empty($firstname) || !preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
    $response["status"] = "fail";
    $response["msg"] = "Valid firstname is required";
    echo json_encode($response);
    exit();
}

if (empty($lastname) || !preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
    $response["status"] = "fail";
    $response["msg"] = "Valid lastname is required";
    echo json_encode($response);
    exit();
}

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["status"] = "fail";
    $response["msg"] = "Valid email is required";
    echo json_encode($response);
    exit();
}

// Phone validation: Ensure only digits, typically Nigerian phone numbers are 11 digits
if (empty($phone) || !preg_match("/^\d{10,15}$/", $phone)) {
    $response["status"] = "fail";
    $response["msg"] = "Valid phone number is required";
    echo json_encode($response);
    exit();
}

// Password validation: At least 8 characters, with letters and numbers
if (empty($password) || strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
    $response["status"] = "fail";
    $response["msg"] = "Password must be at least 8 characters long and contain both letters and numbers";
    echo json_encode($response);
    exit();
}

// State validation: Ensure it's not empty
if (empty($state)) {
    $response["status"] = "fail";
    $response["msg"] = "State is required";
    echo json_encode($response);
    exit();
}

// Account validation: Ensure it's numeric
if (!is_numeric($account)) {
    $response["status"] = "fail";
    $response["msg"] = "Account must be a numeric value";
    echo json_encode($response);
    exit();
}

// Optional fields: No need to validate referral unless you have specific requirements

// Transpin validation: Ensure it's a 4-6 digit number (depending on the app's requirement)
if (!empty($transpin) && !preg_match("/^\d{4,6}$/", $transpin)) {
    $response["status"] = "fail";
    $response["msg"] = "Transpin must be a 4-6 digit number";
    echo json_encode($response);
    exit();
}

// Call the registration function
$result = $controller->registerUser($firstname, $lastname, $email, $phone, $password, $state, $account, $referal, $transpin);

if ($result->status == 0) {
    // Registration successful
    header('HTTP/1.0 200 OK');
    $response["status"] = "success";
    $response["msg"] = "Registration successful";
    $response["data"] = $result;
} else {
    // Registration failed
    header('HTTP/1.0 400 Bad Request');
    $response["status"] = "fail";
    $response["msg"] = $result->msg;
}

echo json_encode($response);
exit();
