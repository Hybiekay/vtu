<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerdash.php');
?>
<div class="col-md-8">

<style>
    .button-container {
  display: flex;
  justify-content: space-between;
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
<div class="">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Cable TV Subscription</p>
                <h1 class="text-center">Cable TV</h1>
                <style>
                    .text-center {
  background: linear-gradient(to right, orange, #FF5733);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
                </style>

                
                
                <hr/>

                <form method="post" class="verifycableplanForm" id="verifycableplanForm" action="confirm-cable-tv">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="cableid" class="color-theme opacity-80 font-700 font-12">Provider</label>
                                <select id="cableid" name="provider" required>
                                    <option value="" disabled="" selected="">Select Provider</option>
                                    <?php foreach($data AS $provider): if($provider->providerStatus == "On"): ?>
                                        <option value="<?php echo $provider->cId; ?>" providername="<?php echo $provider->provider; ?>"><?php echo $provider->provider; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <input type="hidden" name="cabledetails" id="cabledetails" />

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="cableplan" class="color-theme opacity-80 font-700 font-12">Plan</label>
                                <select id="cableplan" name="cableplan" required></select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="subtype" class="color-theme opacity-80 font-700 font-12">Subscription Type</label>
                                <select id="subtype" name="subtype" required>
                                    <option value="" disabled="" selected="">Select Type</option>
                                    <option value="change">Change</option>
                                    <option value="renew">Renew</option>
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
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">IUC Number</label>
                                <input type="number" name="iucnumber" placeholder="IUC Number" value="" class="round-small" required  />
                            </div>

                            <!-- 7528061720 -->
                            <!-- 01831375068 -->

                            <p id="verifyer"></p>

                            
                            <div class="button-container">
                            <button type="submit" id="cable-btn" name="verify-cable-sub" style="width: 100%;" class="fancy-button font-600 font-15 rounded-s">
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