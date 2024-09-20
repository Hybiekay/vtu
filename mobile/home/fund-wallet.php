<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerdash.php');
?>



<style>
    /* Basic Resets */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Card Style for Sections */
.card-style {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    padding: 20px;
    overflow: hidden;
}

/* Tab Controls */
.tab-controls {
    display: flex;
    justify-content: space-around;
    margin-bottom: 15px;
}

.tab-controls a {
    background-color: #e9e9e9;
    color: #333;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
}

.tab-controls a[data-active] {
    background-color: #007bff;
    color: #fff;
}

/* Content Styling */
.content {
    text-align: center;
}

.content h5 {
    color: #333;
    margin-bottom: 10px;
}

.content p {
    color: #666;
    font-size: 14px;
}

/* Button Styling */
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    color: #fff;
    text-align: center;
    font-weight: bold;
    margin-top: 10px;
}

.btn-primary {
    background-color: #007bff;
}

.btn-success {
    background-color: #28a745;
}

/* Additional Styling as Needed */

</style>
<style>
        .virtual-card {
            border: 1px solid #FF5733;
            border-radius: 20px;
            padding: 10px;
            max-width: 300px;
            margin: 4px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: orange;
            position: relative;
        }

        .virtual-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            background: linear-gradient(45deg, #fff, #e1e1e1);
            color: orange;
            z-index: -1;
        }

        .card-info {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            background-color: #FF5722;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }
        .fancy-button {
  flex: 1; /* This makes the buttons share the available space equally */
  background: linear-gradient(45deg, #FE5722FF, #FE9800FF);
  border: none;
  color: white;
  padding: 10px;
  border-radius: 5px;
  font-size: 20px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.fancy-button:hover {
  background: linear-gradient(45deg, #FE9800FF, #FE5722FF);
}
    </style>
    


<div class="page-conten header-clear-medium">
        
        
        <div class="card card-style bg-theme pb-0">
            <div class="content" id="tab-group-1">
               
                
                
                 <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
                     
                    <a href="#" data-active data-bs-toggle="collapse" class="fancy-button" data-bs-target="#tab-1">Bank</a>
                    <a href="#" data-bs-toggle="collapse" class="fancy-button" data-bs-target="#tab-2">Card</a>
                   
                </div>
                <div class="clearfix mb-3"></div>
                <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1">
                <div class="text-center">
                    
                   <b>Funds transferred to this bank accounts are instantly and automatically credited to your Abakon wallet!</b> <br><br>
                    


                    <!-- PAYVESSEL BANK START-->

                    <?php if($controller->getConfigValue($data2,"payvesselStatus") == "On"): ?>

                    <?php $payvesCharges = $controller->getConfigValue($data2,"payvesselCharges"); $payvesChargesType = $controller->getConfigValue($data2,"payvesselChargesType"); ?>

                    <?php $payvesChargesText = ($payvesChargesType == "flat") ? "N".$payvesCharges : $payvesCharges."%"; ?>

                    <?php if(empty($data->sPayvesselBank)): ?>
                        
                        <form method="POST" id="payvesform"><input type="hidden" name="generate-payvessel-account" value="YES" /></form>
                        <button class="btn btn-primary font-700 rounded-xl mt-3" id="payvesbtn" onclick="$('#payvesbtn').removeClass('btn-primary'); $('#payvesbtn').addClass('btn-secondary'); $('#payvesbtn').html('<i class=\'fa fa-spinner fa-spin\'></i> Processing ...'); $('#payvesform').submit();">Generate Account</button>
                    <?php else: ?>
                      <div class="virtual-card">
                    <p class="mb-2 text-dark font-600 font-16 card-info"><b>Bank Name: </b>9Payment Service Bank (9PSB)</p>
        <div style="display: flex; align-items: center;">
         <img src="https://abakon.ng/images/9PSB-logo-white-text-1024x383.png" alt="9PSB Logo" style="width: 80px; height: auto;">
           <div>
        <p class="mb-2 text-orange font-600 font-16 card-info"><b>Account No: </b><?php echo $data->sPayvesselBank; ?> <button class="" onclick="copyToClipboard('<?php echo $data->sPayvesselBank; ?>')"><i class="fa fa-clone" aria-hidden="true"></i></button></p>
        
        </div>
    </div>
        </div>
                    <?php endif; ?>
                    <hr/>
                    <?php endif; ?>
                    <!-- PAYVESSEL BANK END -->
                    
                    <?php if ($controller->getConfigValue($data2, "monifyWeStatus") == "On"): ?>
    
<?php endif; ?>



<?php if ($controller->getConfigValue($data2, "monifySaStatus") == "On"): ?>
    
<?php endif; ?>

                </div>
                </div>

                <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
                        <div class="text-center">
                            
                            <h5 class="">DEPOSIT</h5>
                            <p class="mb-2 text-dark font-600 font-12">
                                Pay with card, bank transfer, ussd, or bank deposit. Secured by Paystack
                            </p>
                    
                        </div>
                        
                        <?php if($controller->getConfigValue($data2,"paystackStatus") == "On"): ?>
                        <form  method="post">
                        <div class="mt-5 mb-3">
                            
                            <div class="input-style has-borders no-icon input-style-always-active mb-4">
                                <input type="hidden" value="<?php echo $controller->getConfigValue($data2,"paystackCharges"); ?>" id="paystackcharges" name="paystackcharges" />
                                <input type="number" onkeyup="calculatePaystackCharges()" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                                <label for="amount" class="color-highlight">Amount</label>
                                <em>(required)</em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                                <input type="text" class="form-control" id="charges" placeholder="Charges" readonly>
                                <label for="charges" class="color-highlight">Charges</label>
                                <em>(required)</em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                                <input type="text" class="form-control" id="amounttopay" placeholder="You Would Get" readonly>
                                <label for="amounttopay" class="color-highlight">You Would Get</label>
                                <em>(required)</em>
                            </div>

                            <input type="hidden" name="email" value="<?php echo $data->sEmail; ?>" />
                        </div>

                        <div class="text-center"><img src="../../assets/img/paystack.png" /></div>
                        <button type="submit" id="fund-with-paystack" name="fund-with-paystack" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                Pay Now
                        </button>
                        </form>
                        <?php else : ?>
                            <h3 class="text-center text-danger">Opps!! Card Payment Is Disabled</h3>
                        <?php endif; ?>
                </div>

                <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3">
                    
                    <h5 class="">DEPOSIT</h5>
                <div class="text-left">
                    
                    
                    <p class="mb-2 text-dark font-600 font-12"><b>Bank Name: </b><?php echo $data3->bankname; ?></p>
                    <p class="mb-2 text-dark font-600 font-12"><b>Account Name: </b><?php echo $data3->accountname; ?></p>
                    <p class="mb-2 text-dark font-600 font-12"><b>Account No: </b><?php echo $data3->accountno; ?> <button class="" onclick="copyToClipboard('<?php echo $data3->accountno; ?>')"><i class="fa fa-clone" aria-hidden="true"></i></button></p>
                    <p class="mb-2 text-danger font-600 font-12"><b>Note: </b> Please chat us after making your transfer.</p>
                    
                    <a class="btn btn-success font-700 rounded-xl mt-3" href="https://wa.me/234<?php echo $data3->whatsapp; ?>"> <i class="fa fa-chat" aria-hidden="true"></i> Chat Us</a>
                    
                </div>
                </div>

                
                
            </div>
        </div> 

</div>
<br/><br/>

 </div>
        </div> 

<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'footerdash.php');
?>