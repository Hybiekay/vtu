<div class="page-content header-clear">

<div class="card notch-clear rounded-0 mb-n5 mt-0" data-card-height="250" style="background-color:<?php echo $sitecolor; ?>;">
            <div class="card-body pt-4 mt-2 mb-n2">
                <h1 class=" font-20 float-start color-white"><?php echo "Hi, ".$data->sFname; ?>!</h1>
                <h3 class=" font-17 float-end color-white">(<?php echo $controller->formatUserType($data->sType); ?>)</h3>
                <div class="clearfix"></div>
            </div>
            <div class="card card-style mt-2" style="height: 50px;">
        
               <div class="card-center ">
        
                    <h3 class="float-start font-16 ps-3 pt-2">
                    <span class="margin-right:10px;">Referral Bonus</span> 
                    &#8358; <?php echo number_format($data->sRefWallet); ?> 
                </h2>
                    <a href="referrals" class="btn float-end" style="background-color:<?php echo $sitecolor; ?>; border-radius:5rem; margin-right:7px"></b>Refer & Earn</a>
            
               </div>
              
            </div>
            <div class="card card-style mt-0 mb-5" style="height: 50px;">
                
               <div class="card-center ">
               
                    <h3 class="float-start font-16 ps-3 pt-2">
                    <span style="margin-right:10px;">Balance</span> 
                    <span id="hideEyeDiv" style="display:none;">&#8358;<?php echo number_format($data->sWallet); ?></span>
                    <span id="openEyeDiv" >&#8358; *********</span>
                
                    <span id="hideEye"><i class="fa fa-eye-slash" style="margin-left:20px;" aria-hidden="true"></i></span>
                    <span id="openEye" style="display:none; margin-left:20px;"><i class="fa fa-eye" aria-hidden="true"></i></span>
                    
                    </h3>
                    <a href="fund-wallet" class="btn float-end" style="background-color:<?php echo $sitecolor; ?>; border-radius:5rem; margin-right:7px"><b>Fund</b></a>
                
               </div>

                

            </div>

        </div>

        <div class="card card-style mt-3">
            <div class="content mb-2 mt-3">
                <div class="row text-center mb-0">
                    <a href="contact-us" class="col-3">
                        <span class="icon icon-l rounded-sm" style="background:#fafafa; color:<?php echo $sitecolor; ?>;">
                            <i class="fa fa-phone font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-11">Contact</p>
                    </a>
                    <a href="buy-airtime" class="col-3">
                        <span class="icon icon-l rounded-sm" style="background:#fafafa; color:<?php echo $sitecolor; ?>;">
                            <i class="fa fa-mobile font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-11">Airtime</p>
                    </a>
                    <a href="buy-data" class="col-3">
                        <span class="icon icon-l rounded-sm" style="background:#fafafa; color:<?php echo $sitecolor; ?>;">
                            <i class="fa fa-wifi font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-11">Data</p>
                    </a>
                    <a href="transactions" class="col-3">
                        <span class="icon icon-l rounded-sm" style="background:#fafafa; color:<?php echo $sitecolor; ?>;">
                            <i class="fa fa-receipt font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-11">History</p>
                    </a>
                </div>
            </div>
        </div>


        
       <div class="card card-style mt-n3">
            <div class="content mb-3 mt-3">
               <div>
                <h5>Services</h5>
                <hr/>
               </div>

                <div class="row text-center mb-0">
                    
                <a href="buy-airtime" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#cc0066;">
                            <i class="fa fa-phone font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Airtime</p>
                    </a>

                    <a href="buy-data" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#0066ff;">
                            <i class="fa fa-wifi font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Data</p>
                    </a>

                    <a href="buy-data-pin" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#00cc00;">
                            <i class="fa fa-barcode font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Data Card</p>
                    </a>

                    <a href="electricity" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#00cc00;">
                            <i class="fa fa-bolt font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Electricity</p>
                    </a>

                    <a href="exam-pins" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#ff6600;">
                            <i class="fa fa-graduation-cap font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Exam Pins</p>
                    </a>
                    
                    <a href="cable-tv" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#cc0066;">
                            <i class="fa fa-tv font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Cable Tv</p>
                    </a>

                    
                <a href="referrals" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#cc0066;">
                            <i class="fa fa-users font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Referrals</p>
                    </a>
                    
                    
                <a href="airtime-to-cash" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#cc0066;">
                            <i class="fa fa-receipt font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Airtime2Cash</p>
                    </a>
                    
                    
                <a href="fund-wallet" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#cc0066;">
                            <i class="fa fa-plus font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Fund-Wallet</p>
                    </a>
                    
                    <a href="pricing" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#0066ff;">
                            <i class="fa fa-list-alt font-19"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Our Price</p>
                    </a>

                    <a href="#agent-upgrade-modal" id="upgrade-agent-btn" data-menu="agent-upgrade-modal" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#00cc00;">
                            <i class="fa fa-user-secret font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Upgrade to Agent</p>
                    </a>

                    <a href="#vendor-upgrade-modal" id="upgrade-vendor-btn" data-menu="vendor-upgrade-modal" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#0066ff;">
                            <i class="fa fa-user-secret  font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Upgrade to vendor</p>
                    </a>
                    
                    <a href="contact-us" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#ff6600;">
                            <i class="fa fa-envelope font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Contact Us</p>
                    </a>

                    

                    <a href="profile" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#00cc00;">
                            <i class="fa fa-user font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Account settings</p>
                    </a>

                    <a href="logout" class="col-4 mt-2">
                        <span class="icon icon-l shadow-l rounded-sm" style="color:#ff6600;">
                            <i class="fa fa-lock  font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Logout</p>
                    </a>
                    
                </div>
            </div>
        </div>
          

</div>