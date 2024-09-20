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
        
       
            
            <div class="conten">
                
               <div class="card card-style" style="padding: 15px;">
                <h1 class="text-center">Buy Airtime</h1>
                <p class="mb-0 text-center font-600">Airtime For All Network</p>
                
 <style>
                    .text-center {
  background: linear-gradient(to right, orange, #FF5733);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
                </style>
                
                <hr/>
                <form method="post" class="airtimeForm" id="airtimeForm" action="buy-airtime">
                        <fieldset>
 
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="networkid" class="color-theme opacity-80 font-700 font-12">Network</label>
                                <select id="networkid" name="network">
                                    <option value="" disabled="" selected="">Select Network</option>
                                    <?php foreach($data AS $network): if($network->networkStatus == "On"): ?>
                                        <option value="<?php echo $network->nId; ?>" networkname="<?php echo $network->network; ?>" vtu="<?php echo $network->vtuStatus; ?>" sharesell="<?php echo $network->sharesellStatus; ?>"><?php echo $network->network; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="networktype" class="color-theme opacity-80 font-700 font-12">Type</label>
                                <select id="networktype" name="networktype">
                                    <option value="VTU">VTU</option>
                                    <option value="Share And Sell">Share And Sell</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

 
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Phone Number</label>
                                <input type="number" onkeyup="verifyNetwork()" name="phone" placeholder="Phone Number" value="" class="round-small" id="phone" required  />
                            </div>

                            <p id="verifyer"></p>

                            
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <input type="number" name="amount" placeholder="Amount" value="" class="round-small" id="airtimeamount" required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="number" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="discount" class="color-theme opacity-80 font-700 font-12">Discount</label>
                                <input type="text" name="discount" placeholder="Discount" value="" class="round-small" id="discount" readonly required  />
                            </div>

                            <div class="">
                                <input class="form-check-input" type="checkbox" name="ported_number" id="ported_number">
                                <label class="" for="ported_number">Bypass Number Validation</label>
                                <i class="icon-check-1 fa fa-square color-gray-dark font-14"></i>
                                <i class="icon-check-2 fa fa-check-square font-14 color-highlight"></i>
                            </div>

                            <input name="transref" type="hidden" value="<?php echo $transRef; ?>" />
                            <input name="transkey" id="transkey" type="hidden" />

                            
                            <div class="button-container">
                            <button type="submit" id="airtime-btn" name="purchase-airtime" style="width: 100%;" class="fancy-button font-600 font-15 rounded-s">
                                   Buy Airtime
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