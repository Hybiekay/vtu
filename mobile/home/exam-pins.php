<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerdash.php');
?>
<div class="col-md-6">


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
        
        
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Exam Checker</p>
                <h1 class="text-center">Exam Pins</h1>
                 <style>
                    .text-center {
  background: linear-gradient(to right, orange, #FF5733);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
                </style>

               
                
                <hr/>
                <div class="card card-style" style="padding: 15px;">
                <form method="post" class="exampinForm" id="exampinForm" action="exam-pins">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="examid" class="color-theme opacity-80 font-700 font-12">Exam Type</label>
                                <select id="examid" name="provider" required>
                                    <option value="" disabled="" selected="">Select Provider</option>
                                    <?php foreach($data AS $provider): if($provider->providerStatus == "On"): ?>
                                        <option value="<?php echo $provider->eId; ?>" providername="<?php echo $provider->provider; ?>" providerprice="<?php echo $provider->price; ?>"><?php echo $provider->provider; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
                                
                            <input name="transkey" id="transkey" type="hidden" />
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="quantity" class="color-theme opacity-80 font-700 font-12">Quantity</label>
                                <input type="number" id="examquantity" name="quantity" placeholder="Quantity" value="" class="round-small" required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amount" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amount" placeholder="Amount" value="" class="round-small" id="amounttopay"  required readonly  />
                            </div>

                          
                            <div class="button-container">
                            <button type="submit" id="exampin-btn" name="purchase-exam-pin" style="width: 100%;" class="fancy-button font-600 font-15 rounded-s">
                                   Purchase Pin
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