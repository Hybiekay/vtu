<?php
require("../../vendor/autoload.php");


$openapi = \OpenApi\Generator::scan([
'../../api/auth/register', 
'../../api/auth/login', 
'../../api/auth/recover',
'../../api/auth/verify',
'../../api/auth/update-password',
'../../api/airtime',
'../../api/datapin',
'../../api/data',
'../../api/alphatopup',
'../../api/exam',
'../../api/user',
'../../api/smile-data',
]);


header('Content-Type: application/json');
echo $openapi->toJson();
