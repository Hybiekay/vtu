<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ABAKON - LOGIN ACCOUNT</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="https://abakon.ng/web/sky/vendors/feather/feather.css">
  <link rel="stylesheet" href="https://abakon.ng/web/sky/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="https://abakon.ng/web/sky/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="https://abakon.ng/web/sky/css/vertical-layout-light/style.css">
  <!-- endinject -->
   <!-- Favicons -->
  <link href="https://abakon.ng/abakoniconbg.png" rel="icon">
  <link href="https://abakon.ng/abakoniconbg.png" rel="apple-touch-icon">
</head>


    
<body class="theme-light">
    

    


 
   <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="https://abakon.ng/images/ABAKON.NG_.png" alt="logo">
              </div>
              <h4>Hello! Welcome to Abakon</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
                   
                
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
                    
                    <div class="mt-3">
                     <button type="submit" id="submit-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="/web/mobile/recovery" class="auth-link text-black">Forgot password?</a>
                </div>
               
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="/web/signup" class="text-primary">Create Account</a>
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



  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="https://abakon.ng/web/sky/js/off-canvas.js"></script>
  <script src="https://abakon.ng/web/sky/js/hoverable-collapse.js"></script>
  <script src="https://abakon.ng/web/sky/js/template.js"></script>
  <script src="https://abakon.ng/web/sky/js/settings.js"></script>
  <script src="https://abakon.ng/web/sky/js/todolist.js"></script>
  <!-- endinject -->

</body>

</body>
