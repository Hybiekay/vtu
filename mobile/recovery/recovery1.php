<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerhome.php');
?>
<link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">
<link rel="manifest" href="../assets/scripts/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">

<style type="text/css">#verCon{display: none;} #keyCon{display: none;}</style>
<style>
     body{background-image:url("");  background-repeat: no-repeat; background-size: cover;}
    .card{background: transparent; margin:20px;}
    .form-control{
        background-color: #fafafa !important; 
        border-radius: 5rem !important;
        padding-left: 50px !important;
    }

    .form-control:focus{
        background-color: #ffffff !important; 
    }

    .input-style i{
        padding-left: 20px !important;
    }
    .btn{
        border-radius: 5rem !important;
    }
    .silas1 {
        background-color: #FE5722FF;
    }
</style>
</head>
    
<body class="theme-light">
    

    
<div id="page">
    
      <div class="silas1" style="min-width:380px;"><br/><br/>
           
        
            <div class="text-center">
                   
                 <h4 class="font-20 mb-3 mt-3 text-white">Reset Password</h4>
                    <p class="mb-3 text-white">Enter the email account associated with your account!</p>
                </div>
        </div>
    
    <div class="page-content mt-3">
        
    <div style="display:flex; justify-content:center; align-content:center;">
    <div class="sila" style="min-width:350px">
            <div class="content">

                <form id="emailCon" method="post">
                <div class="px-2">
                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-at"></i>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required readonly />
                        <label for="email" class="color-highlight">Email</label>
                        <em>(required)</em>
                    </div>
                    
                    <button type="submit" id="submit-btn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Recover Password
                    </button>
                    <br/><br/><br/>
                        <div class="col-12 text-center font-15">
                        <a class="text-silver" href="../login/">Login Account</a> | <a class="text-silver" href="../register/">Create Account</a>
                        </div>
                        
                    

                </div>
                </form>

                <form id="verCon"  method="post">
                <div class="px2">
                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-barcode"></i>
                        <input type="number" class="form-control" id="vercode" name="code" placeholder="Verification Code" required />
                        <label for="vercode" class="color-highlight">Verification Code</label>
                        <em>(required)</em>
                    </div>
                    <input type="hidden" name="email" id="veremail" />
                    <button type="submit" id="submit-btn2" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Verify Code
                    </button>
                    <div class="row pt-5 mb-3">
                        <div class="col-12 text-center font-15">
                        <a class="text-silver" href="../login/">Login Account</a> 
                        </div>
                        <div class="col-12 text-center font-15 mt-2">
                            <a class="text-silver" href="../register/">Create Account</a>
                        </div>
                    </div>

                </div>
                </form>

                <form name="chngpwd" id="keyCon">
                <div class="px2">
                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required readonly />
                        <label for="password" class="color-highlight">New Password</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Retype Password" required readonly />
                        <label for="password" class="color-highlight">Retype Password</label>
                        <em>(required)</em>
                    </div>

                    <input type="hidden" id="keyemail" name="email" />
		            <input type="hidden" id="keycode" name="code" />

                    <button type="submit" id="submit-btn3" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Update Pasword
                    </button>
                    <div class="row pt-5 mb-3">
                        <div class="col-12 text-center font-15">
                        <a class="text-silver" href="../login/">
                        Login Account</a> 
                        </div>
                        <div class="col-12 text-center font-15 mt-2">
                            <a class="text-silver" href="../register/">Create Account</a>
                        </div>
                    </div>

                </div>
                </form>
                
            </div>
        </div>
        </div>
        
             
        
    </div>
    <!-- Page content ends here-->

</div>
<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'footerhome.php');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="../assets/scripts/custom.js"></script>

<script>
    $("document").ready(function(){
    //Enable Form Input
    $("#email").click(function(){$(this).removeAttr("readonly"); });
    $("#password").click(function(){$(this).removeAttr("readonly"); });
    $("#password2").click(function(){$(this).removeAttr("readonly"); });

    

    //Check If Email Exist And Send Verification Code
    $('#emailCon').submit(function(e){
            e.preventDefault()
            $('#submit-btn').removeClass("gradient-highlight");
            $('#submit-btn').addClass("btn-secondary");
            $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?get-user-code',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"A Verification Code Have Been Sent To Your Email Address, Please Check And Provide The Code To Continue.","success");
                        $("#emailCon").hide();
			            $("#verCon").show();
                        $("#veremail").val($("#email").val());
                    }else if(resp == 1){
                        swal('Alert!!',"Email Not Found, Please Verify Your Email And Try Again.","error");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support","error");
                    }

                $('#submit-btn').removeClass("btn-secondary");
                $('#submit-btn').addClass("gradient-highlight");
                $('#submit-btn').html("Recover Password");

                }
            })
        });

        //Verify Email Code And Allow Password Update
        $('#verCon').submit(function(e){
            e.preventDefault()
            $('#submit-btn2').removeClass("gradient-highlight");
            $('#submit-btn2').addClass("btn-secondary");
            $('#submit-btn2').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?verify-user-code',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"Code Verified, Please Enter Your New Password Below.","success");
                        $("#emailCon").hide();
                        $("#verCon").hide();
                        $("#keyCon").show();
                        $("#keyemail").val($("#email").val());
			            $("#keycode").val($("#vercode").val());
                    }else if(resp == 1){
                        swal('Alert!!',"Incorrect Code Provided, Please Verify Details And Try Again.","error");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support","error");
                    }

                $('#submit-btn2').removeClass("btn-secondary");
                $('#submit-btn2').addClass("gradient-highlight");
                $('#submit-btn2').html("Verify Code");

                }
            })
        });

        //Update User Password``````````
        $('#keyCon').submit(function(e){
            e.preventDefault()
            
            //Validate Password
            $msg=""; 
            if($("#password").val() != $("#password2").val()){$msg="New Password & Retyped Password Don't Match.";}
            if($("#password").val().length > 15){$msg="Password should not be more than 15 character.";}
            if($("#password").val().length < 8){$msg="Password should be at least 8 character.";}

            if($msg != ""){swal("Alert!!",$msg,"info");  $msg=""; return; }

            $('#submit-btn2').removeClass("gradient-highlight");
            $('#submit-btn2').addClass("btn-secondary");
            $('#submit-btn2').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?update-user-pass',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"Password Updated Successfully, You Can Now Login With Your Details.","success");
                        $("#verCon").hide();
                        $("#keyCon").hide();
                        $("#emailCon").show();
                        $("#emailCon")[0].reset();
                        $("#keyCon")[0].reset();
                        $("#verCon")[0].reset();
                    }else if(resp == 1){
                        swal('Alert!!',"Unable To Update Password, Please Try Again Later.","error");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support.","error");
                    }

                $('#submit-btn2').removeClass("btn-secondary");
                $('#submit-btn2').addClass("gradient-highlight");
                $('#submit-btn2').html("Verify Code");

                }
            })
        });

    });
    
   
	



</script>
</body>
</html>
