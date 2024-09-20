<div class="page-content header-clear-medium">

<div class="card card-style" data-card-height="200" style="background-image:url(../../assets/img/bg/cc.png); background-repeat: no-repeat; background-size: cover; border-radius:0px; ">
        <div style="height: 100vh; background-color:<?php echo $sitecolor; ?>;  opacity:0.9;">
            
            <div class="card-top ps-3 pt-2">
                <h1 class="color-white font-19"  ><?php echo "Hi, ".$data->sFname; ?></h1>
            </div>
            <div class="card-top pe-3 pt-2">
                <h5 class="color-white float-end"  >(<?php echo $controller->formatUserType($data->sType); ?>)</h5>
            </div>
            <div class="card-center ps-3 pt-2">
                <h2 class="color-white font-20" >
                N<?php echo number_format($data->sWallet); ?> 
                </h2>
                <h4 class="color-white font-16"  >
                Wallet Balance
                </h4>
            </div>
            <div class="card-center pe-3 pt-2">
            <a href="fund-wallet" class="float-end text-center">
                    <span class="icon icon-l bg-light shadow-l ">
                        <i class="fa fa-arrow-up font-18" style="color:<?php echo $sitecolor; ?>"></i>
                    </span>
                    <h5 class="mb-0 pt-1 font-14 text-white" >Add Funds</h5>
                </a>
            </div>
            <div class="card-bottom ps-3 pb-2 bt-3">
                <h3 class="font-15"><a href="fund-wallet" ><b class="text-white">Click Here To Fund Your Wallet</b></a></h3>
            </div>
            
            

        </div>
</div>

    <div class="container-fluid">
        
        <div class="card mt-2">
            <div class="content mb-3 mt-3">
               <div class="row text-center mb-0">
                    
                <a href="buy-airtime" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-phone font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Airtime</p>
                    </a>

                    <a href="buy-data" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-wifi font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Data</p>
                    </a>

                    <a href="cable-tv" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-tv font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Cable TV</p>
                    </a>

                    <a href="electricity" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-bolt font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Electricity</p>
                    </a>

                    <a href="exam-pins" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-graduation-cap font-18 "></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Exam Pins</p>
                    </a>
                    
                    <a href="buy-data-pin" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-barcode font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Data Pin</p>
                    </a>

                    <a href="airtime-to-cash" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-mobile font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Airtime Swap</p>
                    </a>

                    
                    <a href="pricing" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-list font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Pricing</p>
                    </a>

                    

                    <a href="profile" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-user  font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Profile</p>
                    </a>
                    
                    <a href="contact-us" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-envelope font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Contact</p>
                    </a>

                     

                    <a href="#agent-upgrade-modal" id="upgrade-agent-btn" data-menu="agent-upgrade-modal" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-user-secret font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Agent</p>
                    </a>

                    <a href="logout" class="col-3 mt-2">
                        <span class="icon icon-l shadow-l " style="color:<?php echo $sitecolor; ?>;  border-radius:50%; ">
                            <i class="fa fa-lock  font-18"></i>
                        </span>
                        <p class="mb-0 pt-1 font-13">Logout</p>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>

