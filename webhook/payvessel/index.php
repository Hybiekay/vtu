<?php
    
    //PAY VESSEL API WEBHOOK NOTIFICATION
    
    //Auto Load Classes
    require_once("../autoloader.php");
    require_once("../../core/helpers/vendor/autoload.php");
    header('Content-Type: application/json');
    date_default_timezone_set('Africa/Lagos');
    
    $headers = getallheaders();
    $response = array();
    $controller = new ApiAccess;
    
    $input = @file_get_contents("php://input");
    $res = json_decode($input);
    
    $payvessel_signature = $_SERVER['HTTP_PAYVESSEL_HTTP_SIGNATURE'];
    $ip_address = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']; 
    
    $email = $res->customer->email;
    $amount = $res->order->amount;
    $transactionReference = $res->transaction->reference;
    
    //Verify The Transaction
    $check=$controller->verifyPayvesselRef($email,$payvessel_signature,$input);
   
    
    if($check->status == "success"):
            
            $userid = $check->userid;
            $userbalance = $check->balance;
            $email = $check->useremail;
            $charges = (float) $check->charges;
            $chargestype = $check->chargestype;
            $amount = (float) $amount;
           
            
            
            if($chargestype == "flat"): 
                $amounttosave = $amount - $charges;
                $chargesText ="N".$charges;
            else: 
                $amounttosave = $amount - ($amount * ($charges/100)); 
                $chargesText = $charges."%";
            endif;
            
            $servicename = "Wallet Topup";
            $servicedesc = "Wallet funding of N{$amount} via Payvessel transfer with a service charges of $chargesText";
            $servicedesc.=". You wallet have been credited with N{$amounttosave}";
            $transactionReference = "PAYVESSEL_".$transactionReference;
            $result = $controller->recordPayvesselTransaction($userid,$servicename,$servicedesc,$amounttosave,$userbalance,$transactionReference,"0");
            $message = "
            
            <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Abakon Newsletter</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }
        .email-header {
            background-color: #f7941d;
            padding: 10px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
            color: #333;
        }
        .email-footer {
            background-color: #f7941d;
            padding: 10px;
            text-align: center;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'>
            <img src='https://abakon.ng/images/Abakonnnn.png' alt='Abakon Logo' style='max-width: 150px;'>
        </div>
        <div class='email-body'>
            <h3>Wallet Funding via Bank Transfer</h3>
            <p>We are pleased to inform you that an amount of <b>₦{$amount}</b> has been successfully credited to your wallet through a Payvessel transfer.</p>
            <p> Please note that this transaction incurs a service charge of <b>{$chargesText}</b>.</p>
            <p>Your transaction reference is <b>$transactionReference</b></p>
            <p>Thank you for choosing Abakon. Stay connected with us for seamless transactions and reliable service.</p>
        </div>
        <div class='email-footer'>
            <p>&copy;  Abakon. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
 ";
            
            //Send Email Notification
            
            $controller->sendEmailNotification($servicename,$message,$email);
            

            echo "Success";
            http_response_code(200);
            exit();

    else:
        echo "UnAutorized"; http_response_code(401); exit();
    endif;
    
?>