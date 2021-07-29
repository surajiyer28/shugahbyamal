<?php
session_start();
$sprice = $_SESSION['total'];
$price = $sprice*(100);
$email = $_SESSION['email'];
?>
<form action="index.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="rzp_test_0wHuPM16WIkmTY" // Enter the Test API Key ID generated from Dashboard → Settings → API Keys
    data-amount= "<?php echo $price ?>" // Amount is in currency subunits. Hence, 29935 refers to 29935 paise or ₹299.35.
    data-currency="INR"// You can accept international payments by changing the currency code. Contact our Support Team to enable International for your account
    data-buttontext="Pay with Razorpay"
    data-name="Shugah"
    data-description="by Amal"
    data-image="D:\xampp\htdocs\projectt\logo.png"
    data-prefill.email="<?php echo $email?>"
    data-theme.color="#F66F8B2E"
></script>
<input type="hidden" custom="Hidden Element" name="hidden">
</form>
