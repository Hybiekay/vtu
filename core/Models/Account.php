<?php

	class Account extends Model{
       
		//Verify Admin Login Deatils
		public function verifyAdminAccount($uname,$pass,$pin){
			$sql ="SELECT * FROM sysusers WHERE sysUsername=:uname AND sysToken=:password";
			if(!empty($pin)){$pin=substr(sha1(md5($pin)), 3, 10); $sql.=" AND sysPinToken=:token";}
		    
			$query= $this->connect()->prepare($sql);
		    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
		    $query-> bindParam(':password', $pass, PDO::PARAM_STR);
		    if(!empty($pin)){$query-> bindParam(':token', $pin, PDO::PARAM_STR);}
		    $query-> execute();

		    $result=$query->fetch(PDO::FETCH_ASSOC);
		    
		    if($query->rowCount() > 0){
				
		    		if($result["sysStatus"] <> 0){return json_encode(["status"=>"blocked"]); }
		    		if($result["sysPinStatus"] == 1 && empty($pin)){return json_encode(["status"=>"pinrequired"]);}

		    		$_SESSION['sysUser']=$result["sysUsername"];
		            $_SESSION['sysRole']=$result["sysRole"];
		            $_SESSION['sysName']=$result["sysName"];
		            $_SESSION['sysId']=$result["sysId"];
		    		return json_encode(["status"=>"success"]);
		   	} else {return json_encode(["status"=>"invalid"]);}

		} 

		public function verifyAdminAccount2(){
			$sql ="SELECT sysId,sysName,sysStatus,sysUsername,sysRole FROM sysusers";
		    $query= $this->connect()->prepare($sql);
		    $query-> execute();
		    $result=$query->fetchAll(PDO::FETCH_ASSOC);
		   	return $result;

		} 

		//Register/Create New User Account
		public function registerUser($fname,$lname,$email,$phone,$password,$state,$account,$referal,$transpin){
			
			//if registration is done by admin, dont save cookies data
			if($referal == "admin"){$saveCookies=FALSE; $referal="";}else{$saveCookies=TRUE;}

			//Verify Registration Details
			$dbh=$this->connect();
	    	$c="SELECT sEmail,sPhone,sType FROM subscribers WHERE ";
			$c.= ($email<>"") ? " sEmail=:e OR sPhone=:p" : " sPhone=:p";
	    	$queryC = $dbh->prepare($c);
	    	if($email<>""){$queryC->bindParam(':e',$email,PDO::PARAM_STR);}
	     	$queryC->bindParam(':p',$phone,PDO::PARAM_STR);
	     	$queryC->execute();
	      	$result=$queryC->fetch(PDO::FETCH_ASSOC);
	      	$data=4;

	      	//Output Error Message If Data Already Exist
	      	if($queryC->rowCount() > 0){
	          
	          if($result["sPhone"] == $phone){$data = ["status" => "error", "msg" => "Phone Number Already Exist"]; }
	          if($email<>""){if($result["sEmail"] == $email){ $data = ["status" => "error", "msg" => "Email Already Exist"]; }}
	          if($result["sEmail"] == $email && $result["sPhone"] == $phone){$data =  ["status" => "error", "msg" => "Phone Number And Email Already Exist"]; }
	          
	          return (object) $data; 
	      	}
	      
	      	//Insert And Register Member
	      	else{
			   
				$hash=substr(sha1(md5($password)), 3, 10);
				$apiKey = substr(str_shuffle("0123456789ABCDEFGHIJklmnopqrstvwxyzAbAcAdAeAfAgAhBaBbBcBdC1C23C3C4C5C6C7C8C9xix2x3"), 0, 60).time();
				$varCode=mt_rand(2000,9000);


		       $sql="INSERT INTO subscribers (sFname,sLname,sEmail,sPhone,sPass,sState,sType,sApiKey,sReferal,sPin,sVerCode,sRegStatus)VALUES(:fname,:lname,:email,:phone,:pass,:s,:a,:k,:ref,:pin,:code,0)";

		       $query = $dbh->prepare($sql);

		       $query->bindParam(':fname',$fname,PDO::PARAM_STR);
		       $query->bindParam(':lname',$lname,PDO::PARAM_STR);
		       $query->bindParam(':email',$email,PDO::PARAM_STR);
		       $query->bindParam(':phone',$phone,PDO::PARAM_STR);
		       $query->bindParam(':pass',$hash,PDO::PARAM_STR);
		       $query->bindParam(':s',$state,PDO::PARAM_STR);
		       $query->bindParam(':a',$account,PDO::PARAM_STR);
		       $query->bindParam(':k',$apiKey,PDO::PARAM_STR);
		       $query->bindParam(':ref',$referal,PDO::PARAM_STR);
		       $query->bindParam(':pin',$transpin,PDO::PARAM_INT);
		       $query->bindParam(':code',$varCode,PDO::PARAM_STR);
		       $query->execute();
		       
		       $lastInsertId = $dbh->lastInsertId();
		       if($lastInsertId){
		       		 
					$data=0; 

					if($saveCookies){
						$_SESSION["loginId"]=$lastInsertId;
						$_SESSION["loginName"]=$fname . " " . $lname;
						$_SESSION["loginEmail"]=$email;
						$_SESSION["loginPhone"]=$phone;
						
						$loginId=base64_encode($lastInsertId);
						$loginState=base64_encode($state);
						$loginPhone=base64_encode($phone);
						$loginAccount=base64_encode("1");
						$loginName=base64_encode($fname);
						
						
						setcookie("loginId", $loginId, time() + (2592000 * 30), "/");
						setcookie("loginState", $loginState, time() + (2592000 * 30), "/");
						setcookie("loginAccount", $loginAccount, time() + (2592000 * 30), "/");
						setcookie("loginPhone", $loginPhone, time() + (31540000 * 30), "/");
						setcookie("loginName", $loginName, time() + (31540000 * 30), "/");


						//Generate User Login Token
						$randomToken = substr(str_shuffle("ABCDEFGHIJklmnopqrstvwxyz"), 0, 10);
						$userLoginToken = time() . $randomToken . mt_rand(100,1000);

						//Set User Login Token
						$_SESSION["loginAccToken"]=$userLoginToken;

						//Save New User Login Token For One Device Login Check

						$sqlAc="INSERT INTO userlogin (user,token) VALUES (:user,:token)";
						$queryAc = $dbh->prepare($sqlAc);
						$queryAc->bindParam(':user',$lastInsertId,PDO::PARAM_STR);
						$queryAc->bindParam(':token',$userLoginToken,PDO::PARAM_STR);
						$queryAc->execute();
					}
					
					//Get API Details
					$d=$this->getApiConfiguration();
					$a=$this->getSiteConfiguration();
					$monifyStatus = $this->getConfigValue($d,"monifyStatus");
					$monifyApi = $this->getConfigValue($d,"monifyApi");
					$monifySecrete = $this->getConfigValue($d,"monifySecrete");
					$monifyContract = $this->getConfigValue($d,"monifyContract");
					$adminEmail = $a->email;
					
					//If Monnify Is Active, Create Virtual Account For User
					if($monifyStatus == "On"){
						$this->createVirtualBankAccount($lastInsertId,$fname,$lname,$phone,$email,$monifyApi,$monifySecrete,$monifyContract);
					}
					
					//Send Email To User
					$subject="Welcome (".$this->sitename.")";
					$message="
					
					
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
            <h3>Your New Verification Code</h3>
            <h4>Hi ".$fname.",</h4> 
            <p>We hope this message finds you well.</p>

<p>We offer a range of convenient services to meet your needs promptly. Our offerings include instant recharge options for Airtime, Data Bundles, Cable TV and Electricity Bill Payments.</p>

<h4><p><strong>Verification Code: ".$varCode." </strong></p></h4>

<p>Thank you for choosing Abakon. Stay connected with us for seamless transactions and reliable service.</p>
        </div>
        <div class='email-footer'>
            <p>&copy;  Abakon. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

	
				
					
					";
					$check=self::sendMail($email,$subject,$message);

					//Send Email To Admin
					$subject2="New User Registration (".$this->sitename.")";
					$message2="Hi ".$this->sitename.", "."This is to notify you that a new user just registered on your platform. Please find the below details for your usage: ";
					$message2.="<h3>Name: $fname $lname <br/> Phone Number: $phone <br/> Email: $email <br> State: $state</h3>";
					$message2.="<br/><br/><br/> <i>Notification Powered By Algoprime Technology</i>";
					$check=self::sendMail($adminEmail,$subject2,$message2);

					return (object) ["status" => "success", 
					"msg" => "Login Successfull", 
					"token"=> $userLoginToken ,
					"data"=> $result->fetchAll() , 
					
				];

		       		
		       } 
		       else{$data =  ["status" => "fail", "msg" => "Unexpected Error, Please Try Again Later"]; }

			   return (object) $data;
			}
		}

		//Login User Account
		public function loginUser($phone,$key){
			 
			//Verify Registration Details
			$dbh=$this->connect();
			$hash=substr(sha1(md5($key)), 3, 10);
		
			$hash=substr(sha1(md5($key)), 3, 10);
	    	$c="SELECT sId,sFname,sLname,sEmail, sApiKey, sPass,sPhone,sState,sType,sRegStatus FROM subscribers WHERE sPhone=:ph AND sPass=:p";
	    	$queryC = $dbh->prepare($c);
	    	$queryC->bindParam(':ph',$phone,PDO::PARAM_STR);
	     	$queryC->bindParam(':p',$hash,PDO::PARAM_STR);
	     	$queryC->execute();
	      	$result=$queryC->fetch(PDO::FETCH_OBJ);
	      	if($queryC->rowCount() > 0){

				if($result->sRegStatus == 1){return (object) ["status" => "fail", "msg" => "Account Blocked, Please Contact Customer Support For Additional Information"];}
				
	      		$_SESSION["loginId"]=$result->sId;
		       	$_SESSION["loginName"]=$result->sFname . " " . $result->sLname;
		       	$_SESSION["loginEmail"]=$result->sEmail;
		       	$_SESSION["loginPhone"]=$result->sPhone;
		       

				$loginId=base64_encode($result->sId);
				$loginState=base64_encode($result->sState);
				$loginAccount=base64_encode($result->sType);
				$loginPhone=base64_encode($result->sPhone);
				$loginName=base64_encode($result->sFname);
				
				setcookie("loginId", $loginId, time() + (2592000 * 30), "/");
				setcookie("loginState", $loginState, time() + (2592000 * 30), "/");
				setcookie("loginAccount", $loginAccount, time() + (2592000 * 30), "/");
				setcookie("loginPhone", $loginPhone, time() + (31540000 * 30), "/");
				setcookie("loginName", $loginName, time() + (31540000 * 30), "/");

				//Generate User Login Token
				$randomToken = substr(str_shuffle("ABCDEFGHIJklmnopqrstvwxyz"), 0, 10);
				$userLoginToken = time() . $randomToken . mt_rand(100,1000);

				//Set User Login Token
				$_SESSION["loginAccToken"]=$userLoginToken;

				//Save New User Login Token For One Device Login Check

				$sqlAc="INSERT INTO userlogin (user,token) VALUES (:user,:token)";
				$queryAc = $dbh->prepare($sqlAc);
				$queryAc->bindParam(':user',$result->sId,PDO::PARAM_STR);
				$queryAc->bindParam(':token',$userLoginToken,PDO::PARAM_STR);
				$queryAc->execute();

				//Login Notification

				//Send Email To User
				//$subject="Login Notification (".$this->sitename.")";
				//$message="<h3><b>Welcome Back ".$result->sFname."! </h3></b> <br/><br/> ";
				//$message.= "You have successfully logged in to your {$this->sitename} account at ";
				//$message.= date("d M Y h:iA").". <br/><br/>";
				//$message.= "If you think this action is suspicious, please change your password immediadtely and reach out to our customer support team. <br/><br/>";
				//$message.= "<b>Why send this email?</b> We take security very seriously and we want to keep you in the loop of activities on your account.";
				//$check=self::sendMail($result->sEmail,$subject,$message);

				
				return (object) ["status" => "success", 
				"msg" => "Login Successfull", 
				"token"=> $userLoginToken ,
				"accesstoken"=> $result-> sApiKey ,
				"data"=> $result, 
				
			];

	      	}
	      	else{return (object) ["status" => "fail", 
				"msg" => "Invalid Phone Or Password"];}

	    }
	      
		
		public function recoverUserLogin($email) {
			// Verify Registration Details
			$dbh = $this->connect();
			
			// Prepare the SQL query
			$query = "SELECT sId, sFname, sLname, sEmail, sPass FROM subscribers WHERE sEmail = :e";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(':e', $email, PDO::PARAM_STR);
			
			// Execute the query
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Check if user exists
			if ($result) {
				// Generate And Update Verification Code
				$varCode = mt_rand(2000, 9000);
				$updateStmt = "UPDATE subscribers SET sVerCode = :code WHERE sId = :id";
				$updateQuery = $dbh->prepare($updateStmt);
				$updateQuery->bindParam(':code', $varCode, PDO::PARAM_INT);
				$updateQuery->bindParam(':id', $result->sId, PDO::PARAM_INT);
				$updateQuery->execute();
		
				// Send Verification Code To User Email
				$email = $result->sEmail;
				$subject = "Account Recovery (" . $this->sitename . ")";
				$message = "
				<!DOCTYPE html>
				<html lang='en'>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<title>Account Recovery</title>
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
							<h3>Your Account Recovery</h3>
							<h4>Hi " . htmlspecialchars($result->sFname) . ",</h4> 
							<p>We hope this message finds you well.</p>
							<p>We've received your request for password recovery. To proceed, please utilize the following verification code: \"" . htmlspecialchars($varCode) . "\" </p>
							<p>This code will assist you in regaining access to your account.</p>
							<p>Thank you for choosing " . htmlspecialchars($this->sitename) . ". Stay connected with us for seamless transactions and reliable service.</p>
						</div>
						<div class='email-footer'>
							<p>&copy; Abakon. All rights reserved.</p>
						</div>
					</div>
				</body>
				</html>";
		
				$check = self::sendMail($email, $subject, $message);
				if ($check == 0) {
					return 0; // Success
				} else {
					return 2; // Failed to send email
				}
			} else {
				// Log for debugging
				error_log("User not found: Email = " . $email);
				return 1; // User does not exist
			}
		}
		

	    //Recover User Account
		public function verifyRecoveryCode($email, $code) {
			$respond = array();
		
			// Connect to the database
			$dbh = self::connect();
		
			// Verify if the email and code match
			$query = "SELECT sId FROM subscribers WHERE sEmail = :email AND sVerCode = :code";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':code', $code, PDO::PARAM_STR);
			$stmt->execute();
		
			// If a match is found
			if ($stmt->rowCount() > 0) {
				// Fetch the subscriber details
				$row = $stmt->fetch(PDO::FETCH_OBJ);
		
				// Generate User Login Token
				$randomToken = substr(str_shuffle("ABCDEFGHIJklmnopqrstvwxyz"), 0, 10);
				$userLoginToken = time() . $randomToken . mt_rand(100, 1000);
		
				// Insert the login token into the userlogin table
				$sqlAc = "INSERT INTO userlogin (user, token) VALUES (:user, :token)";
				$stmtAc = $dbh->prepare($sqlAc);
				$stmtAc->bindParam(':user', $row->sId, PDO::PARAM_STR);
				$stmtAc->bindParam(':token', $userLoginToken, PDO::PARAM_STR);
				$stmtAc->execute();
		
				// Prepare response data
				$respond["user_id"] = $row->sId;
				$respond["token"] = $userLoginToken;
		
				return $respond;
			} else {
				// No match found
				return false; // Use false instead of 1 for clarity
			}
		}
		
	    //Recover Seller Account
		public function updateUserKey($email,$code,$key){
			$passwrd = $key;
			//Verify Registratio Details
			$dbh=$this->connect();
			$hash=substr(sha1(md5($passwrd)), 3, 10);
			$verCode = mt_rand(1000,9999);
	    	$c="UPDATE subscribers SET sPass=:k,sVerCode=:v WHERE sEmail=:e AND sVerCode=:c";
	    	$queryC = $dbh->prepare($c);
	    	$queryC->bindParam(':e',$email,PDO::PARAM_STR);
	    	$queryC->bindParam(':c',$code,PDO::PARAM_STR);
	    	$queryC->bindParam(':k',$hash,PDO::PARAM_STR);
	    	$queryC->bindParam(':v',$verCode,PDO::PARAM_INT);

			$queryC->execute();
			if ($queryC->rowCount() > 0) {
				// Successfully updated
				return 0;
			} else {
				// No rows affected (user not found or verification code incorrect)
				return 1;
			}

	    }


		//Create Virtual Bank Account
		public function createVirtualBankAccount($id,$fname,$lname,$phone,$email,$monnifyApi,$monnifySecret,$monnifyContract){
           
			$fullname = $fname." ".$lname;
			$accessKey = "$monnifyApi:$monnifySecret";
			$apiKey = base64_encode($accessKey);
			
			//Get Authorization Data
			$url = 'https://api.monnify.com/api/v1/auth/login';
			//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
			$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
			//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic {$apiKey}",
                ),
			));
			
			
			$json = curl_exec($ch);
			$result = json_decode($json);
			curl_close($ch);
            
			$accessToken=$result->responseBody->accessToken;
			$ref=uniqid().rand(1000, 9000);

			//Request Account Creation
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
											"accountReference": "'.$ref.'",
											"accountName": "'.$fullname.'",
											"currencyCode": "NGN",
											"contractCode": "'.$monnifyContract.'",
											"customerEmail": "'.$email.'",
											"bvn": "22433145825",
											"customerName": "'.$fullname.'",
											"getAllAvailableBanks": false,
											"preferredBanks": ["035"]
										
									}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response, true);

			//Check And Save Account Details
			if($value["requestSuccessful"] == true){
				$account_name  = $value["responseBody"]["accountName"];
				if($value["responseBody"]["accounts"][0]["bankCode"]== "035"){
					$wema =  $value["responseBody"]["accounts"][0]["accountNumber"];
					$wema_name = $value["responseBody"]["accounts"][0]["bankName"];

					$dbh=$this->connect();
					$c="UPDATE subscribers SET sBankName=:bn,sBankNo=:bno WHERE sId=$id";
					$queryC = $dbh->prepare($c);
					$queryC->bindParam(':bn',$wema_name,PDO::PARAM_STR);
					$queryC->bindParam(':bno',$wema,PDO::PARAM_STR);
					$queryC->execute();
				}
			}
		}

		//Create Virtual Bank Account
		public function createVirtualBankAccount2($id,$fname,$lname,$phone,$email,$monnifyApi,$monnifySecret,$monnifyContract){
           
			$fullname = $fname." ".$lname;
			$accessKey = "$monnifyApi:$monnifySecret";
			$apiKey = base64_encode($accessKey);
			
			//Get Authorization Data
			$url = 'https://api.monnify.com/api/v1/auth/login';
			//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
			$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
			//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic {$apiKey}",
                ),
			));
			
			
			$json = curl_exec($ch);
			$result = json_decode($json);
			curl_close($ch);
            
			$accessToken=$result->responseBody->accessToken;
			$ref=uniqid().rand(1000, 9000);

			//Request Account Creation
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
											"accountReference": "'.$ref.'",
											"accountName": "'.$fullname.'",
											"currencyCode": "NGN",
											"contractCode": "'.$monnifyContract.'",
											"customerEmail": "'.$email.'",
											"bvn": "22433145825",
											"customerName": "'.$fullname.'",
											"getAllAvailableBanks": false,
											"preferredBanks": ["50515","232"]
										
									}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response, true);

			//Check And Save Account Details
			if($value["requestSuccessful"] == true){
				$account_name  = $value["responseBody"]["accountName"];
				$rolex=""; $sterling="";
				
				if($value["responseBody"]["accounts"][0]["bankCode"]== "50515"){
					$rolex =  $value["responseBody"]["accounts"][0]["accountNumber"];
				}
                elseif($value["responseBody"]["accounts"][1]["bankCode"]== "50515"){
					$rolex =  $value["responseBody"]["accounts"][1]["accountNumber"];
				}
                else{}
                
                if($value["responseBody"]["accounts"][0]["bankCode"]== "232"){
					$sterling =  $value["responseBody"]["accounts"][0]["accountNumber"];
				}
                elseif($value["responseBody"]["accounts"][1]["bankCode"]== "232"){
					$sterling =  $value["responseBody"]["accounts"][1]["accountNumber"];
				}
                else{}
				
				//Save Account Number
				
				$dbh=$this->connect();
					$c="UPDATE subscribers SET sRolexBank=:rb,sSterlingBank=:sb WHERE sId=$id";
					$queryC = $dbh->prepare($c);
					$queryC->bindParam(':rb',$rolex,PDO::PARAM_STR);
					$queryC->bindParam(':sb',$sterling,PDO::PARAM_STR);
					$queryC->execute();
			}
		}

		//Create Virtual Bank Account
		public function createVirtualBankAccount3($id,$fname,$lname,$phone,$email,$monnifyApi,$monnifySecret,$monnifyContract){
           
			$fullname = $fname." ".$lname;
			$accessKey = "$monnifyApi:$monnifySecret";
			$apiKey = base64_encode($accessKey);
			
			//Get Authorization Data
			$url = 'https://api.monnify.com/api/v1/auth/login';
			//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
			$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
			//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic {$apiKey}",
                ),
			));
			
			
			$json = curl_exec($ch);
			$result = json_decode($json);
			curl_close($ch);
            
			$accessToken=$result->responseBody->accessToken;
			$ref=uniqid().rand(1000, 9000);

			//Request Account Creation
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
											"accountReference": "'.$ref.'",
											"accountName": "'.$fullname.'",
											"currencyCode": "NGN",
											"contractCode": "'.$monnifyContract.'",
											"customerEmail": "'.$email.'",
											"bvn": "22433145825",
											"customerName": "'.$fullname.'",
											"getAllAvailableBanks": false,
											"preferredBanks": ["070"]
										
									}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response, true);

			//Check And Save Account Details
			if($value["requestSuccessful"] == true){
				$account_name  = $value["responseBody"]["accountName"];
				$fidelityBank ="";
				
				if($value["responseBody"]["accounts"][0]["bankCode"]== "070"){
					$fidelityBank =  $value["responseBody"]["accounts"][0]["accountNumber"];
				}
                elseif($value["responseBody"]["accounts"][1]["bankCode"]== "070"){
					$fidelityBank =  $value["responseBody"]["accounts"][1]["accountNumber"];
				}
                else{}
                
                
				//Save Account Number
				
				$dbh=$this->connect();
					$c="UPDATE subscribers SET sFidelityBank=:fb WHERE sId=$id";
					$queryC = $dbh->prepare($c);
					$queryC->bindParam(':fb',$fidelityBank,PDO::PARAM_STR);
					$queryC->execute();
			}
		}

		//Create Virtual Bank Account GT Bank
		public function createVirtualBankAccount4($id,$fname,$lname,$phone,$email,$monnifyApi,$monnifySecret,$monnifyContract){
           
			$fullname = $fname." ".$lname;
			$accessKey = "$monnifyApi:$monnifySecret";
			$apiKey = base64_encode($accessKey);
			
			//Get Authorization Data
			$url = 'https://api.monnify.com/api/v1/auth/login';
			//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
			$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
			//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic {$apiKey}",
                ),
			));
			
			
			$json = curl_exec($ch);
			$result = json_decode($json);
			curl_close($ch);
            
			$accessToken=$result->responseBody->accessToken;
			$ref=uniqid().rand(1000, 9000);

			//Request Account Creation
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
											"accountReference": "'.$ref.'",
											"accountName": "'.$fullname.'",
											"currencyCode": "NGN",
											"contractCode": "'.$monnifyContract.'",
											"customerEmail": "'.$email.'",
											"bvn": "22433145825",
											"customerName": "'.$fullname.'",
											"getAllAvailableBanks": false,
											"preferredBanks": ["058"]
										
									}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response, true);

			//Check And Save Account Details
			if(isset($value["requestSuccessful"])){
				if($value["requestSuccessful"] == true){
					$account_name  = $value["responseBody"]["accountName"];
					$gtBank ="";
					
					if($value["responseBody"]["accounts"][0]["bankCode"]== "058"){
						$gtBank =  $value["responseBody"]["accounts"][0]["accountNumber"];
					}
					elseif($value["responseBody"]["accounts"][1]["bankCode"]== "058"){
						$gtBank =  $value["responseBody"]["accounts"][1]["accountNumber"];
					}
					else{ return 1;}
					
					
					//Save Account Number
					
					$dbh=$this->connect();
					$c="UPDATE subscribers SET sGtBank=:fb WHERE sId=$id";
					$queryC = $dbh->prepare($c);
					$queryC->bindParam(':fb',$gtBank,PDO::PARAM_STR);
					$queryC->execute();

					return 0;

				} else{return 1; }
			} else{return 1;}
		}
		
		//GET LIST Of BANKS
		public function getFullBankList(){
		    
		    //Get API Details
			$d=$this->getApiConfiguration();
			$a=$this->getSiteConfiguration();
			$monifyStatus = $this->getConfigValue($d,"monifyStatus");
			$monifyApi = $this->getConfigValue($d,"monifyApi");
			$monifySecrete = $this->getConfigValue($d,"monifySecrete");
			$monifyContract = $this->getConfigValue($d,"monifyContract");
			$adminEmail = $a->email;
           
			$accessKey = $monifyApi.":".$monifySecrete;
			$apiKey = base64_encode($accessKey);
			
			//Get Authorization Data
			$url = 'https://api.monnify.com/api/v1/auth/login';
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic {$apiKey}",
                    "Content-Type: application/json"
                ),
			));
			
			
			$json = curl_exec($ch);
			$result = json_decode($json);
			curl_close($ch);
            
			$accessToken=$result->responseBody->accessToken;
			
			//Get Authorization Data
			$url2 = 'https://api.monnify.com/api/v1/banks';
			$ch2 = curl_init();
		    curl_setopt_array($ch2, array(
				CURLOPT_URL => $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$accessToken}",
                    "Content-Type: application/json"
                ),
			));
			
			
			$json2 = curl_exec($ch2);
			$result2 = json_decode($json2);
			curl_close($ch2);
            
			return $result2;
			
		}
		
		//Verify Bank Account Details
		public function verifyBankAccount($bankcode,$accountno){
		    
		    //Get API Details
			$d=$this->getApiConfiguration();
			$a=$this->getSiteConfiguration();
			$monifyStatus = $this->getConfigValue($d,"monifyStatus");
			$monifyApi = $this->getConfigValue($d,"monifyApi");
			$monifySecrete = $this->getConfigValue($d,"monifySecrete");
			$monifyContract = $this->getConfigValue($d,"monifyContract");
			$adminEmail = $a->email;
           
			$accessKey = $monifyApi.":".$monifySecrete;
			$apiKey = base64_encode($accessKey);
			
			//Get Authorization Data
			$url = 'https://api.monnify.com/api/v1/auth/login';
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic {$apiKey}",
                    "Content-Type: application/json"
                ),
			));
			
			
			$json = curl_exec($ch);
			$result = json_decode($json);
			curl_close($ch);
            
			$accessToken=$result->responseBody->accessToken;
			
			//Get Authorization Data
			$url2 = 'https://api.monnify.com/api/v1/disbursements/account/validate?accountNumber='.$accountno.'&bankCode='.$bankcode;
			$ch2 = curl_init();
		    curl_setopt_array($ch2, array(
				CURLOPT_URL => $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$accessToken}",
                    "Content-Type: application/json"
                ),
			));
			
			
			$json2 = curl_exec($ch2);
			$result2 = json_decode($json2);
			curl_close($ch2);
            
			return $result2;
			
		}

//Create Payvessel Virtual Bank Account
		public function generatePayvesselAccount($id,$fname,$lname,$phone,$email){
           
			//Get Authorization Data
			$url = 'https://api.payvessel.com/api/external/request/customerReservedAccount/';
			
			$dbh=$this->connect();
            
            //Get API Details
			$d=$this->getApiConfiguration();
			$payvesselStatus = $this->getConfigValue($d,"payvesselStatus");
			$payvesselApiKey = $this->getConfigValue($d,"payvesselApiKey");
			$payvesselSecret = $this->getConfigValue($d,"payvesselSecret");
			$payvesselBusinessId = $this->getConfigValue($d,"payvesselBusinessId");
			
			$fname=str_replace(" ","",$fname); $fname=trim($fname);
			$lname=str_replace(" ","",$lname); $lname=trim($lname);
            $phone=trim($phone);
            $email=str_replace(" ","",$email);
		
			//Get Token
			
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>'{
                        "email":"'.$email.'",
                        "name":"'.$fname.' '.$lname.'",
                        "phoneNumber":"'.$phone.'",
                        "bankcode":["120001"],
                        "businessid":"'.$payvesselBusinessId.'"
                    
                    }',
				CURLOPT_HTTPHEADER => array(
                        "api-key:$payvesselApiKey",
                        "api-secret:Bearer $payvesselSecret",
                        "Content-Type:application/json"
                ),
			));
			
			
			$result = curl_exec($ch);
			curl_close($ch);
			$value = json_decode($result);
			
			file_put_contents("payversal_log.txt",$result);
			
			//Check And Save Account Details
			if(isset($value->banks[0]->accountNumber)){
				$accountNumber = $value->banks[0]->accountNumber;
                
				//Save Account Number
				
				$dbh=$this->connect();
				$c="UPDATE subscribers SET sPayvesselBank=:pb WHERE sId=$id";
				$queryC = $dbh->prepare($c);
				$queryC->bindParam(':pb',$accountNumber,PDO::PARAM_STR);
				$queryC->execute();
			}
		}

	    //Create Kuda Virtual Bank Account
		public function generateKudaAccount($id,$fname,$lname,$phone,$email,$kudaApi,$kudaEmail){
           
			//Get Authorization Data
			$url = 'https://kuda-openapi.kuda.com/v2.1/Account/GetToken/';
			$url2 = "https://kuda-openapi.kuda.com/v2.1/";
			
			//Get Token
			
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>'{
											"email": "'.$kudaEmail.'",
											"apiKey": "'.$kudaApi.'"
									}',
				CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                ),
			));
			
			
			$result = curl_exec($ch);
			curl_close($ch);
			
			
            
			$accessToken=$result;
			$ref="REQ_".uniqid().rand(1000, 9000);

			//Check Is User Have Middle Name
            $secondname= explode(" ",$lname);
            
            if(isset($secondname[0])): $lname = $secondname[0]; endif;
            if(isset($secondname[1])): $mname = $secondname[1]; else: $mname =""; endif;
            $fname=str_replace(" ","",$fname); $lname=str_replace(" ","",$lname); $mname=str_replace(" ","",$mname);
            $fname=trim($fname); $lname=trim($lname); $mname=trim($mname); $phone=trim($phone); $email=str_replace(" ","",$email);

			//Request Account Creation
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
                                    		"ServiceType":"ADMIN_CREATE_VIRTUAL_ACCOUNT",
                                    		"RequestRef":"'.$ref.'",
                                    		"Data":
                                    			{
                                    				"email": "'.$email.'",
                                    				"phoneNumber": "'.$phone.'",
                                    				"lastName": "'.$lname.'",
                                    				"firstName": "'.$fname.'",
                                    				"middleName": "'.$mname.'",
                                                    "businessName": "",
                                    				"trackingReference": "'.$email.'"
                                    			}
                                    }
                                ',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response);
			

			//Check And Save Account Details
			if(isset($value->data->accountNumber)){
				$accountNumber = $value->data->accountNumber;
                
				//Save Account Number
				
				$dbh=$this->connect();
				$c="UPDATE subscribers SET sKudaBank=:kb WHERE sId=$id";
				$queryC = $dbh->prepare($c);
				$queryC->bindParam(':kb',$accountNumber,PDO::PARAM_STR);
				$queryC->execute();
			}
		}

		//Complete Kuda Funding And Withdraw Funds From Virtual Account To Main Admin Wallet
		public function completeKudaFundingByWithdrawal($amount,$useremail){
           
            $dbh=$this->connect();
            
            //Get API Details
			$d=$this->getApiConfiguration();
			$kudaStatus = $this->getConfigValue($d,"kudaStatus");
			$kudaEmail = $this->getConfigValue($d,"kudaEmail");
			$kudaApi = $this->getConfigValue($d,"kudaApi");
					
			//Get Authorization Data
			$url = 'https://kuda-openapi.kuda.com/v2.1/Account/GetToken/';
			$url2 = "https://kuda-openapi.kuda.com/v2.1/";
			
			//Get Token
			
			$ch = curl_init();
		    curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>'{
											"email": "'.$kudaEmail.'",
											"apiKey": "'.$kudaApi.'"
									}',
				CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                ),
			));
			
			
			$result = curl_exec($ch);
			curl_close($ch);
			
			
            
			$accessToken=$result;
			$ref="REQ_".uniqid().rand(1000, 9000);

			//Request Account Creation
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL =>  $url2,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => 
									'{
                                    		"ServiceType":"WITHDRAW_VIRTUAL_ACCOUNT",
                                    		"RequestRef":"'.$ref.'",
                                    		"Data":
                                    			{
                                    				"trackingReference": "'.$useremail.'",
                                    				"amount": "'.$amount.'",
                                    				"narration": "Virtual Account Withdrawal",
                                    				"ClientFeeCharge": 0
                                    			}
                                    }
                                ',
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer ".$accessToken,
					"Content-Type: application/json"
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$value = json_decode($response);
			
			return $value;
		}
	    
	      	


		public function checkToken($token) {
			$dbh = self::connect();
			
			// Query to check if the token exists in the userlogin table
			$query = "SELECT user FROM userlogin WHERE token = :token";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(':token', $token, PDO::PARAM_STR);
			$stmt->execute();
		
			// Check if any row is returned
			if ($stmt->rowCount() > 0) {
				// Fetch user ID associated with the token
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				return $row->user; // Return the user ID
			} else {
				return false; // Token not found
			}
		}
		


		

	}

?>