<!DOCTYPE HTML>
<html lang="en">
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Login</title>
<link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">    
<link rel="manifest" href="../assets/scripts/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon.png">
<link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
<?php if(isset($_SESSION['loginId'])){echo "<script>window.location.href='../home/';</script>"; } ?>
<style>
    body{background-image:url("");  background-repeat: no-repeat; background-size: cover;}
    .card{background: transparent; margin:20px;}
    .form-control{
        background-color: #fafafa !important; 
        border-radius: 5rem !important;
        padding:25px !important;
        padding-left: 50px !important;
    }

    .form-control:focus{
        background-color: #ffffff !important; 
    }


    .input-style i{
        padding-left: 20px !important;
    }

    .input-style em{
        padding-right: 20px !important;
    }

    .btn{
        border-radius: 5rem !important;
    }
    .silas {
        background-color: silver;
        border-radius: 6%;
    }
    .silas1 {
        background-color: #FE5722FF;
    }
    .button-container {
  display: flex;
  justify-content: space-between;
}

.fancy-button {
  flex: 1; /* This makes the buttons share the available space equally */
  background: linear-gradient(45deg, #FE5722FF, #FE9800FF);
  border: none;
  color: white;
  padding: 15px;
  border-radius: 5px;
  font-size: 20px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.fancy-button:hover {
  background: linear-gradient(45deg, #FE9800FF, #FE5722FF);
}
.fancy-button2 {
  flex: 1; /* This makes the buttons share the available space equally */
  background: linear-gradient(45deg, #FE5722FF, #000);
  border: none;
  color: white;
  padding: 15px;
  border-radius: 5px;
  font-size: 20px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.fancy-button2:hover {
  background: linear-gradient(45deg, #FE9800FF, #FE5722FF);
}
</style>
</head>
    
<body class="theme-light">
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    
     <div class="silas1" style="min-width:380px;"><br/><br/>
            <center><img src="https://cdn-icons-png.flaticon.com/512/5987/5987424.png" width="20%" /></center>
        
            <center> <h3 class="mb-3 text-white mt-5" id="accountname">Welcome Back</h3>
            
            </center>
          
        </div>
    
    <div class="page-content mt-2">
        
        
        <div style="display:flex; justify-content:center; align-content:center;"> 
       
        
        <div class="sila" style="min-width:350px">
            <div class="content ">

            <div class="text-center">
                   
                 
                   
                </div>
                <form id="login-form" method="post">
                <div class="px-2">
                    <div class="input-style no-borders has-icon mb-4" id="phonediv">
                        <i class="fa fa-phone"></i>
                        <input type="number" class="form-control" id="phonelogin" name="phone" placeholder="Phone Number" required readonly />
                        <label for="phone" class="color-highlight">Phone</label>
                        <em>(required)</em>
                    </div>
                    <div class="input-style no-borders has-icon mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" id="passwordlogin" name="password" placeholder="Password" required readonly />
                        <label for="password" class="color-highlight">Password</label>
                        <em>(required)</em>
                    </div>
                    
                    <button type="submit" id="submit-btn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 ">
                        Login
                    </button>

                    <div class="row pt-5 mb-3">
                        <div class="btn col-12 text-center font-15">
                            <a class="text-white" href="../recovery/">Forget Password? Recover It</a> 
                        </div>
                        <div class="btn col-12 text-center font-15 mt-2">
                            <a class="text-white" href="../register/">New User? Create Account</a>
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
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="../assets/scripts/custom.js"></script>

<script type="text/javascript">
$("document").ready(function(){

    //Save Phone Number
    checkIfPhoneNumberSaved();

    //Enable Form Input
    $("#phonelogin").click(function(){$(this).removeAttr("readonly"); });
    $("#passwordlogin").click(function(){$(this).removeAttr("readonly"); });

    //Registration Form
    $('#login-form').submit(function(e){
            e.preventDefault()
            $('#submit-btn').removeClass("gradient-highlight");
            $('#submit-btn').addClass("btn-secondary");
            $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?login',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    
                    resp = JSON.parse(resp);

                        if(resp.status == "success"){
                            swal('Alert!!',"Login Succesfull","success");
                            setTimeout(function(){
                                location.replace('../home/')
                            },1000)
                        }
                        else{
                            swal('Alert!!',resp.msg,"error");
                        }

                   $('#submit-btn').removeClass("btn-secondary");
                   $('#submit-btn').addClass("gradient-highlight");
                   $('#submit-btn').html("Login");

                }
            })
        });

});

    function checkIfPhoneNumberSaved() {
        $phone = atob(unescape(getCookie("loginPhone")));
        $name = atob(unescape(getCookie("loginName")));
        if($phone != null && $phone != ""){
            let msg='<p class="mb-3"><a href="javascript:showNumber();"><b class="btn text-white">Login With Another Account?</b></a></p>';
            $("#accountname2").after(msg);
            $("#accountname").append(" "+$name+"!");
            $("#phonediv").hide();
            $("#phonelogin").val($phone);
        }
    }

    function showNumber(){
        $("#phonediv").show();
    }
    
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    }

</script>

</body>
