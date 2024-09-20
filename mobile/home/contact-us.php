<?php
// Assuming register4.php is in public_html/bill/mobile/register/

// Define the base path to the public_html directory
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/';

// Include the header file
include($basePath . 'headerdash.php');
?>


<style>
    .page-content {
        background-color: #f5f5f5;
        padding: 20px;
    }

    .card-style {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .content {
        padding: 20px;
    }

    h1 {
        color: #333333;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .list-group a {
        display: block;
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 8px;
        background-color: #f0f0f0;
        text-decoration: none;
        color: #333333;
        position: relative;
    }

    .list-group a i {
        margin-right: 10px;
    }

    .list-group a .badge {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 15px;
        background-color: #ff7e5f;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 5px;
    }
    h3 {
    background: linear-gradient(to right, #FE5722FF, #FE9800FF); /* Gradient from #FE5722FF to #FE9800FF */
    -webkit-background-clip: text; /* For WebKit browsers (optional) */
    color: transparent; /* Make the text color transparent so that the gradient is visible */
    font-size: 20px; /* Adjust the font size as needed */
    margin-bottom: 10px; /* Adjust the margin as needed */
}

</style>



<div class="page-content header-clear-medium">
    <div class="card card-style">
        <div class="content">
            <p class="mb-0 font-600 color-highlight">Get In Touch With Us</p>
            <h3>Contact Us</h3>
            <div class="list-group list-custom-small">
                <?php if ($data->phone <> ""): ?>
                    <a href="tel:<?php echo $data->phone; ?>" class="external-link">
                        <i class="fa font-14 fa-phone color-phone"></i>
                        <span><?php echo $data->phone; ?></span>
                        
                        <i class="fa fa-angle-right"></i>
                    </a>
                <?php endif; ?>
                <?php if ($data->email <> ""): ?>
                    <a href="mailto:<?php echo $data->email; ?>" class="external-link">
                        <i class="fa font-14 fa-envelope color-mail"></i>
                        <span><?php echo $data->email; ?></span>
                       
                        <i class="fa fa-angle-right"></i>
                    </a>
                <?php endif; ?>
                <!-- Add similar blocks for other social media links -->

            </div>
        </div>
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