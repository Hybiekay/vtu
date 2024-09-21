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
$headers = getallheaders(); // Use getallheaders() to retrieve all request headers
$response = array();
$controller = new Account;

// -------------------------------------------------------------------
//  Check Request Method
// -------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "status" => "fail",
        "message" => "Only POST method is allowed on this route"
    ]);
    exit();
}

// -------------------------------------------------------------------
//  Determine Content Type and Handle Data
// -------------------------------------------------------------------
$contentType = $headers['Content-Type'] ?? '';

if (stripos($contentType, 'application/json') !== false) {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
} elseif (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
    $data = $_POST;
} else {
    http_response_code(415);
    echo json_encode([
        "status" => "fail",
        "message" => "Unsupported Media Type"
    ]);
    exit();
}

// -------------------------------------------------------------------
//  Handle Email Recovery Request
// -------------------------------------------------------------------
if (isset($data["email"])) {
    $email = filter_var(trim($data["email"]), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode([
            "status" => "fail",
            "message" => "A valid email is required"
        ]);
        exit();
    }

    // Proceed with recovering user login
    $result = $controller->recoverUserLogin($email);
    switch ($result) {
        case 0:
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "message" => "Email sent successfully"
            ]);
            break;
        case 1:
            http_response_code(500);
            echo json_encode([
                "status" => "fail",
                "message" => "Failed to send email"
            ]);
            break;
        default: // User does not exist or some other issue
            http_response_code(404);
            echo json_encode([
                "status" => "fail",
                "message" => "User not found or invalid email"
            ]);
            break;
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "fail",
        "message" => "Email is required"
    ]);
    exit();
}
?>
