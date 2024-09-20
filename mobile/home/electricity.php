<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerdash.php');
?>



        <div class="col-md-8">
           



<style>
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
<div class="">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Electricity Payment</p>
                <h1 class="text-center">Electricity Bill</h1>

                
                <style>
                    .text-center {
  background: linear-gradient(to right, orange, #FF5733);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
                </style>
                <hr/>
                
                <form method="post" class="verifyelectricityplanForm" id="verifyelectricityplanForm" action="confirm-electricity">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="electricityid" class="color-theme opacity-80 font-700 font-12">Provider</label>
                                <select id="electricityid" name="provider" required>
                                    <option value="" disabled="" selected="">Select Provider</option>
                                    <?php foreach($data AS $provider): if($provider->providerStatus == "On"): ?>
                                        <option value="<?php echo $provider->eId; ?>" providername="<?php echo $provider->provider; ?>"><?php echo $provider->provider; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <input type="hidden" name="electricitydetails" id="electricitydetails" />


                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="metertype" class="color-theme opacity-80 font-700 font-12">Meter Type</label>
                                <select id="metertype" name="metertype" required>
                                    <option value="" disabled="" selected="">Select Type</option>
                                    <option value="prepaid">Prepaid</option>
                                    <option value="postpaid">Postpaid</option>
                                 </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
 
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Customer Phone Number</label>
                                <input type="number" name="phone" placeholder="Phone Number" value="" class="round-small" id="phone" required  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="meternumber" class="color-theme opacity-80 font-700 font-12">Meter Number</label>
                                <input type="number" name="meternumber" placeholder="Meter Number" value="" class="round-small" required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="meteramount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <input type="text" name="amount" placeholder="Amount" value="" class="round-small" id="meteramount"  required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            <!-- 30530021655 -->

                           
                            <div class="button-container">
                            <button type="submit" id="electricity-btn" name="verify-meter-no" style="width: 100%;" class="fancy-button font-600 font-15 rounded-s">
                                   Continue
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>
</div>
</div>




<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'footerdash.php');
?>

