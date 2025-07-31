<?php
session_start();

// Get payment details
$sprice = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
$price = $sprice * 100; // Convert to paise (Razorpay requirement)
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';

// If no order details, redirect back
if($sprice <= 0) {
    header('Location: menu.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Shugah</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="style.css">
    
    <style>
        .payment-container {
            background: linear-gradient(135deg, #d4c460, #f0e68c);
            color: white;
            padding: 60px 0;
            text-align: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .payment-card {
            background: white;
            color: #333;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .payment-icon {
            font-size: 4rem;
            color: #d4c460;
            margin-bottom: 20px;
        }
        
        .amount-display {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #d4c460;
        }
        
        .razorpay-payment-button {
            background: #d4c460 !important;
            color: white !important;
            border: none !important;
            padding: 15px 40px !important;
            font-size: 18px !important;
            border-radius: 50px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        }
        
        .razorpay-payment-button:hover {
            background: #c5b555 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
        }
        
        .order-summary {
            text-align: left;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="container">
            <div class="payment-card">
                <div class="payment-icon">
                    <i class="fa fa-credit-card"></i>
                </div>
                
                <h2>Complete Your Payment</h2>
                <p class="text-muted">Secure payment powered by Razorpay</p>
                
                <div class="amount-display">
                    <h3 class="mb-1">Total Amount</h3>
                    <h2 class="text-success mb-0">₹<?php echo number_format($sprice, 2); ?></h2>
                </div>
                
                <?php if(!empty($name)): ?>
                <div class="order-summary">
                    <h6><i class="fa fa-user"></i> Customer Details</h6>
                    <p class="mb-1"><strong>Customer:</strong> <?php echo htmlspecialchars($name); ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <?php if(!empty($phone)): ?>
                    <p class="mb-0"><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="mt-4">
                    <form action="payment_success.php" method="POST">
                        <script
                            src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="rzp_test_0wHuPM16WIkmTY"
                            data-amount="<?php echo $price; ?>"
                            data-currency="INR"
                            data-buttontext="Pay ₹<?php echo number_format($sprice, 2); ?>"
                            data-name="Shugah by Amal"
                            data-description="Fresh baked goods delivered to your door"
                            data-image="<?php echo file_exists('logo.png') ? '/logo.png' : ''; ?>"
                            data-prefill.name="<?php echo htmlspecialchars($name); ?>"
                            data-prefill.email="<?php echo htmlspecialchars($email); ?>"
                            data-prefill.contact="<?php echo htmlspecialchars($phone); ?>"
                            data-theme.color="#d4c460"
                        ></script>
                        <input type="hidden" name="hidden" value="payment_completed">
                        <input type="hidden" name="amount" value="<?php echo $sprice; ?>">
                        <input type="hidden" name="order_items" value="<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?> items">
                    </form>
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <p class="text-muted small mb-2">
                        <i class="fa fa-shield"></i> Secure payment processing
                    </p>
                    <p class="text-muted small mb-0">
                        Your payment information is encrypted and secure
                    </p>
                </div>
                
                <div class="mt-3">
                    <a href="checkout.php" class="btn btn-outline-secondary mr-2">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="menu.php" class="btn btn-outline-warning">
                        <i class="fa fa-shopping-cart"></i> Add More Items
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>