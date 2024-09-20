<?php

    class Airtime extends ApiAccess{

        //Purchase Airtime
		public function purchaseMyAirtime($body,$networkDetails){

            $details=$this->model->getApiDetails();
 
            //Check Airtime Type
            if($body->airtime_type == "VTU"){$name="Vtu"; $thenetworkId=$networkDetails["vtuId"];} 
            else {$name ="Sharesell"; $thenetworkId=$networkDetails["sharesellId"]; }

            //Get Api Key Details
            $networkname = strtolower($networkDetails["network"]);
            $host = self::getConfigValue($details,$networkname.$name."Provider");
            $apiKey = self::getConfigValue($details,$networkname.$name."Key");

            
            //Check If API Is Is Using N3TData Or Bilalsubs
            if(strpos($host, 'n3tdata247') !== false){
                $hostuserurl="https://n3tdata247.com/api/user/";
                return $this->purchaseAirtimeWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId);
            }

            if(strpos($host, 'n3tdata') !== false){
                $hostuserurl="https://n3tdata.com/api/user/";
                return $this->purchaseAirtimeWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId);
            }

            if(strpos($host, 'legitdataway') !== false){
                $hostuserurl="https://legitdataway.com/api/user/";
                return $this->purchaseAirtimeWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId);
            }

            if(strpos($host, 'bilalsadasub') !== false){
                $hostuserurl="https://bilalsadasub.com/api/user/";
                return $this->purchaseAirtimeWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId);
            }
            
            if(strpos($host, 'rabdata360') !== false){
                $hostuserurl="https://rabdata360.com/api/user/";
                return $this->purchaseAirtimeWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId);
            }

            if(strpos($host, 'vtpass') !== false){
                return $this->purchaseAirtimeWithVTPass($body,$host,$apiKey,$thenetworkId,$networkname);
            }
            
            
            // ------------------------------------------
            //  Purchase Airtime
            // ------------------------------------------
            
            if($body->ported_number == "false"){$ported_number="false";} else{$ported_number="true";}

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "network": "'.$thenetworkId.'",
                "amount": "'.$body->amount.'",
                "mobile_number": "'.$body->phone.'",
                "Ported_number":'.$ported_number.',
                "request-id" : "'.$body->ref.'",
                "airtime_type": "'.$body->airtime_type.'"
            }',
             
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Token $apiKey"
            ),
            ));

            $exereq = curl_exec($curl);

            $err = curl_error($curl);
            
            if($err){
                $response["status"] = "fail";
                $response["msg"] = "Server Connection Error";
                file_put_contents("airtime_error_log2.txt",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

            if($result->Status=='successful' || $result->status=='success'){
                $response["status"] = "success";
            }
            elseif($result->Status=='processing' || $result->Status=='process'){
                $response["status"] = "processing";
                file_put_contents("airtime_processing_log.txt",json_encode($result));
            }
            elseif($result->Status=='failed' || $result->status=='fail'){
                $response["status"] = "fail";
                $response["msg"] = "Network Error, Please Try Again Later";
                file_put_contents("airtime_fail_log.txt",json_encode($result));
            }
            else{
                if(isset($result->error)){
                    $response["status"] = "fail";
                    if(strpos($host, 'balance') !== false || strpos($host, 'insufficient') !== false){$response["msg"] ="Server Error: Please Report To Admin";}
                    else{$response["msg"] = $result->error[0];}
                     file_put_contents("data_error_log.txt",json_encode($result));
                }
                else{
                    $response["status"] = "processing";
                    file_put_contents("data_processing_log.txt",json_encode($result));
                }
            }

            return $response;
		}

        //Purchase Airtime
		public function purchaseAirtimeWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId){

			
            $response = array();
            
            // ------------------------------------------
            //  Get User Access Token
            // ------------------------------------------
            
            if($body->ported_number == "false"){$ported_number=false;} else{$ported_number=true;}
    
            $curlA = curl_init();
                curl_setopt($curlA, CURLOPT_URL, $hostuserurl);
                curl_setopt($curlA, CURLOPT_POST, 1);
                curl_setopt($curlA, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt(
                   $curlA, CURLOPT_HTTPHEADER, [
                        "Authorization: Basic $apiKey",
                    ]
                );
            
            $exereqA = curl_exec($curlA);
            $err = curl_error($curlA);
            
            if($err){
                $response["status"] = "fail";
                $response["msg"] = "Server Connection Error "; //.$err;
                curl_close($curlA);
                return $response;
            }
            
            $resultA=json_decode($exereqA);
            $apiKey=$resultA->AccessToken;
            curl_close($curlA);
        
            
            // ------------------------------------------
            //  Purchase Airtime
            // ------------------------------------------
        
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "network": "'.$thenetworkId.'",
                "amount": "'.$body->amount.'",
                "phone": "'.$body->phone.'",
                "bypass":true,
                "request-id" : "'.$body->ref.'",
                "plan_type": "'.$body->airtime_type.'"
            }',
            
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Token $apiKey"
            ),
            ));

            $exereq = curl_exec($curl);

            $err = curl_error($curl);
            
            if($err){
                $response["status"] = "fail";
                $response["msg"] = "Server Connection Error"; //.$err;
                file_put_contents("basic_airtime_error_log2.txt",json_encode($response));
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

            if($result->status=='successful' || $result->status=='success'){
                $response["status"] = "success";
            }
            elseif($result->status=='processing' || $result->status=='process'){
                $response["status"] = "processing";
            }
            elseif($result->status=='fail'){
                $response["status"] = "fail";
                $response["msg"] = "Network Error, Please Try Again Later";
                file_put_contents("network_airtime_error_log.txt",json_encode($result));
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error";
                file_put_contents("basic_airtime_error_log.txt",json_encode($result));
            }

            return $response;
		}

        //VTPass Integration
		public function purchaseAirtimeWithVTPass($body,$host,$apiKey,$thenetworkId,$networkname){

			
            $response = array();
            
            
            // ------------------------------------------
            //  Purchase Airtime
            // ------------------------------------------
            
           
            $curl = curl_init();
            
            curl_setopt_array($curl, [
              CURLOPT_URL => "https://vtpass.com/api/pay",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => '{
                    "serviceID": "'.$networkname.'",
                    "amount": "'.$body->amount.'",
                    "phone": "'.$body->phone.'",
                    "bypass":true,
                    "request_id" : "'.$body->ref.'"
                }',
              CURLOPT_HTTPHEADER => [
               "Authorization: Basic $apiKey",
                "Content-Type: application/json"
              ],
            ]);
            
            $exereq = curl_exec($curl);

            $err = curl_error($curl);
            
            file_put_contents("tt_vtpass_airtime_error_log.txt",$exereq.$host);
            
            
            if($err){
                $response["status"] = "fail";
                $response["msg"] = "Server Connection Error"; //.$err;
                file_put_contents("vtpass_airtime_error_log2.txt",json_encode($response));
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

            if($result->code=='000' || $result->code=='099'){
                $response["status"] = "success";
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error";
                file_put_contents("vtpass_airtime_error_log.txt",json_encode($result));
            }

            return $response;
		}



    }

?>