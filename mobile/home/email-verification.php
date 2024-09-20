<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerdash.php');
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body text-center">
            <img src="https://abakon.ng/images/message.png" style="width: 100px; height: 100px;" class="mb-4" />

            <h1 class="font-weight-bold text-primary">Email Verification</h1>
            <div class="alert alert-warning" role="alert">
                <p class="mb-2 font-weight-bold text-danger">A Verification Code Has Been Sent To Your Email. Please Provide The Code Below</p>
                <p class="mb-3 font-weight-bold text-danger">Check Inbox or Spam Folder.</p>
            </div>
            <form method="post" class="the-submit-form">
                <input type="hidden" name="email" value="<?php echo $data->sEmail; ?>" />
                <div class="form-group">
                    <input type="number" name="code" placeholder="Enter Code" value="" class="form-control" required />
                </div>

                <div class="form-group">
                    <button type="submit" name="email-verification" class="btn btn-primary btn-block">Verify</button>
                </div>
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