<?php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

// Check if cart has items
if(empty($_SESSION['cart'])) {
    header('Location: shopcart.php');
    exit();
}

// Get total from POST or calculate from session
$total_amount = 0;
if(isset($_POST['thetotal'])) {
    $total_amount = (float)$_POST['thetotal'];
} else {
    // Calculate from session cart
    $subtotal = 0;
    foreach($_SESSION['cart'] as $item) {
        $subtotal += $item['product_price'] * $item['quantity'];
    }
    $tax = $subtotal * 0.05;
    $total_amount = $subtotal + $tax;
}

// Store total in session for later use
$_SESSION['checkout_total'] = $total_amount;

// Get user info if logged in
$name1 = "";
$email1 = "";
$phone1 = "";

if(isset($_SESSION['email'])){
    $name1 = $_SESSION['name'];
    $email1 = $_SESSION['email'];
    $phone1 = $_SESSION['phone'];
}

// Calculate cart totals for verification
$subtotal = 0;
foreach($_SESSION['cart'] as $item) {
    $subtotal += $item['product_price'] * $item['quantity'];
}
$tax = $subtotal * 0.05;
$calculated_total = $subtotal + $tax;

function cartItemDisplay($name, $qty, $price) {
    $line_total = $price * $qty;
    echo "<div class='row border-bottom py-2'>
            <div class='col-6'>
                <h6>" . htmlspecialchars($name) . "</h6>
                <small class='text-muted'>Rs. " . number_format($price, 2) . " each</small>
            </div>
            <div class='col-3 text-center'>
                <span class='badge badge-secondary'>" . $qty . "</span>
            </div>
            <div class='col-3 text-right'>
                <strong>Rs. " . number_format($line_total, 2) . "</strong>
            </div>
          </div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Shugah</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="navbar navbar-expand-sm navbar-light bg-light">
            <a class="navbar-brand" href="index.php">HOME</a>
            <a class="navbar-brand" href="about.php">ABOUT</a>
            
            <?php if(file_exists('logo.png')): ?>
                <img src="logo.png" width="220px" height="220px" alt="Shugah Logo">
            <?php else: ?>
                <div style="width: 220px; height: 220px; background: #d4c460; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">SHUGAH</div>
            <?php endif; ?>
            
            <a class="navbar-brand" href="menu.php">THE MENU</a>
            <a class="navbar-brand" href="login.php">LOGIN</a>
        </div>
        
        <div class="container mt-4">
            <div class="row">   
                <!-- Order Information -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="bg-light border rounded p-4">
                        <h5><i class="fa fa-list"></i> Order Information</h5>
                        <hr>
                        
                        <div class="row font-weight-bold border-bottom pb-2 mb-3">
                            <div class="col-6">Item</div>
                            <div class="col-3 text-center">Quantity</div>
                            <div class="col-3 text-right">Total</div>
                        </div>
                        
                        <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                            <?php 
                            $subtotal = 0;
                            foreach($_SESSION['cart'] as $item): 
                                $line_total = $item['product_price'] * $item['quantity'];
                                $subtotal += $line_total;
                            ?>
                                <div class='row border-bottom py-2'>
                                    <div class='col-6'>
                                        <h6><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                        <small class='text-muted'>Rs. <?php echo number_format($item['product_price'], 2); ?> each</small>
                                    </div>
                                    <div class='col-3 text-center'>
                                        <span class='badge badge-secondary'><?php echo $item['quantity']; ?></span>
                                    </div>
                                    <div class='col-3 text-right'>
                                        <strong>Rs. <?php echo number_format($line_total, 2); ?></strong>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php 
                            $tax = $subtotal * 0.05;
                            $calculated_total = $subtotal + $tax;
                            ?>
                        <?php else: ?>
                            <p class="text-muted">No items in cart</p>
                        <?php endif; ?>
                        
                        <hr>
                        <div class="row">
                            <div class="col-6"><strong>Subtotal:</strong></div>
                            <div class="col-6 text-right">Rs. <?php echo number_format($subtotal, 2); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><strong>Tax (5%):</strong></div>
                            <div class="col-6 text-right">Rs. <?php echo number_format($tax, 2); ?></div>
                        </div>
                        <div class="row border-top pt-2">
                            <div class="col-6"><h5><strong>Total Amount:</strong></h5></div>
                            <div class="col-6 text-right"><h5><strong>Rs. <?php echo number_format($calculated_total, 2); ?></strong></h5></div>
                        </div>
                    </div>   
                </div>
                
                <!-- Contact Information Form -->
                <div class="col-lg-6 col-md-12">
                    <div class="bg-light border rounded p-4">
                                                    <form action="final.php" method="post">
                            <h5><i class="fa fa-user"></i> Contact Information</h5>
                            <hr>
                            
                            <?php if(empty($email1)): ?>
                                <div class="alert alert-info">
                                    <small><i class="fa fa-info-circle"></i> 
                                    <a href="login.php">Log in</a> to auto-fill your information</small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for="name"><i class="fa fa-user"></i> Name *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo htmlspecialchars($name1); ?>" 
                                       placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email"><i class="fa fa-envelope"></i> Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($email1); ?>" 
                                       placeholder="Enter your email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone"><i class="fa fa-phone"></i> Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="form-control" 
                                       value="<?php echo htmlspecialchars($phone1); ?>" 
                                       placeholder="Enter your phone number" required>
                            </div>
                            
                            <h6 class="mt-4"><i class="fa fa-home"></i> Delivery Address</h6>
                            <hr>
                            
                            <div class="form-group">
                                <label for="address-line1">Address Line 1 *</label>
                                <input id="address-line1" name="address-line1" type="text" 
                                       placeholder="House/Flat No., Building Name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="address-line2">Address Line 2 *</label>
                                <input id="address-line2" name="address-line2" type="text" 
                                       placeholder="Street, Area, Landmark" class="form-control" required>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="shopcart.php" class="btn btn-outline-secondary mr-2">
                                    <i class="fa fa-arrow-left"></i> Back to Cart
                                </a>
                                <button type="submit" class="btn btn-success btn-lg" name="proceed">
                                    <i class="fa fa-credit-card"></i> Proceed to Payment
                                </button>
                            </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>