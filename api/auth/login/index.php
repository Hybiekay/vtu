<?php
    //Auto Load Classes
    require_once("../../autoloader.php");
    //Allowed API Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Allow: POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

  
    $response = array();
    $controller = new Account;
   
    date_default_timezone_set('Africa/Lagos');
            


    // -------------------------------------------------------------------
    //  Check Request Method
    // -------------------------------------------------------------------

    $requestMethod = $_SERVER["REQUEST_METHOD"]; 
    if ($requestMethod !== 'POST') {
        header('HTTP/1.0 400 Bad Request');
        $response["status"] = "fail";
        $response["msg"] = "Only POST method is allowed";
        echo json_encode($response); exit(); 
    } 
    
    // -------------------------------------------------------------------
    //  Check For Api Authorization
    // -------------------------------------------------------------------
    


    // -------------------------------------------------------------------
    //  Get The Request Details
    // -------------------------------------------------------------------
     
    $input = @file_get_contents("php://input");
    //decode the json file
    $body = json_decode($input);
    
    // Support Other API Format
    $phone= (isset($body->phone)) ? $body->phone : "";
    $accesspass= (isset($body->password)) ? $body->password : "";
    
    $phone = strip_tags($phone); $phone = filter_var($phone, FILTER_SANITIZE_STRING);
  
    
   
    // -------------------------------------------------------------------
    //  Check Inputs Parameters
    // -------------------------------------------------------------------

    $requiredField = "";
    
    if($phone == ""){$requiredField ="Phone Number Field Is Required"; }
    if($accesspass == ""){$requiredField ="Password Field Is Required"; }
    if(!is_numeric($phone)) {$requiredField ="Please Enter A Valid Phone Number";}
    if(strlen($phone) != 11){$requiredField ="Please Enter A Valid Phone Number";}

    if($requiredField <> ""){
        header('HTTP/1.0 400 Parameters Required');
        $response['status']="unauthorized";
        $response['msg'] = $requiredField;
        echo json_encode($response);
        exit();
    }

    // -------------------------------------------------------------------
    //  Verify Details
    // -------------------------------------------------------------------
    
    

    $result = $controller->loginUser($phone,$accesspass);
    if($result->status == 'success'){
        header('HTTP/1.0 200 Success');
        $response['status']="success";
        $response['msg'] = "Login Successfull";
        $response['token'] = $result->token;
        $response['accessToken'] = $result->accessToken;
        $response["user"] = $result->data;
        echo json_encode($response);
        exit();
    }
    elseif($result->status == "fail"){
        header('HTTP/1.0 200 Success');
        $response['status']="invalid";
        $response['msg'] = $result->msg;
        echo json_encode($response);
        exit();
    }
    elseif($result->status == 2){
        header('HTTP/1.0 200 Success');
        $response['status']="blocked";
        $response['msg'] = "Account Blocked, Please Contact Admin";
        echo json_encode($response);
        exit();
    }
     else{
        header('HTTP/1.0 500 Unauthorized');
        $response['status']="unauthorized";
        $response['msg'] = "Unauthorized Access";
        echo json_encode($response);
        exit();
    }
    
    







    // Your existing PHP code...
