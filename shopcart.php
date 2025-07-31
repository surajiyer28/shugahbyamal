<?php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

$message = "";

// Handle remove item
if(isset($_POST['remove']) && isset($_POST['product_id'])){
    $remove_id = (int)$_POST['product_id'];
    if(isset($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $key => $item) {
            if($item['product_id'] == $remove_id) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
                $message = "Item removed from cart.";
                break;
            }
        }
    }
}

// Handle quantity update
if(isset($_POST['update_qty']) && isset($_POST['product_id']) && isset($_POST['quantity'])){
    $update_id = (int)$_POST['product_id'];
    $new_qty = (int)$_POST['quantity'];
    
    if($new_qty > 0 && isset($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $key => $item) {
            if($item['product_id'] == $update_id) {
                $_SESSION['cart'][$key]['quantity'] = $new_qty;
                $message = "Quantity updated.";
                break;
            }
        }
    }
}

// Calculate totals
$subtotal = 0;
$tax_rate = 0.05;

if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $subtotal += $item['product_price'] * $item['quantity'];
    }
}

$tax = $subtotal * $tax_rate;
$total = $subtotal + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket - Shugah</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="style.css">
    
    <style>
        /* Prevent any duplicate content issues */
        .main-content {
            overflow: hidden;
        }
        
        .cart-container {
            min-height: 70vh;
        }
    </style>
</head>
<body>
    <div class="container-fluid main-content">
        <!-- Navigation -->
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
        
        <!-- Main Cart Content -->
        <div class="cart-container">
            <div class="page-content mt-4">
                <div class="col-md-12 border rounded bg-white pt-4">
                    <h4><i class="fa fa-shopping-basket"></i> My Basket</h4>
                    <hr>
                    
                    <?php if(!empty($message)): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="container mb-5">
                        <div class="row">
                            <!-- Cart Items Section -->
                            <div class="col-lg-8 col-xl-8 col-md-12 col-sm-12 mb-2">
                                <?php if(empty($_SESSION['cart']) || count($_SESSION['cart']) == 0): ?>
                                    <div class="text-center py-5">
                                        <i class="fa fa-shopping-basket fa-5x text-muted mb-3"></i>
                                        <h5>Your basket is empty</h5>
                                        <p class="text-muted">Add some delicious treats from our menu!</p>
                                        <a href="menu.php" class="btn btn-warning">
                                            <i class="fa fa-utensils"></i> Browse Menu
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <?php foreach($_SESSION['cart'] as $item): ?>
                                        <div class="border p-3 mt-3 clearfix">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                                    <p class="text-muted">Rs. <?php echo number_format($item['product_price'], 2); ?> each</p>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <form method="post" class="d-inline">
                                                        <label>Quantity:</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10" class="form-control">
                                                            <div class="input-group-append">
                                                                <button type="submit" name="update_qty" class="btn btn-outline-secondary btn-sm">
                                                                    <i class="fa fa-refresh"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                                    </form>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <strong>Rs. <?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></strong>
                                                </div>
                                                
                                                <div class="col-md-1">
                                                    <form method="post" class="d-inline">
                                                        <button type="submit" name="remove" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Order Summary Section -->
                            <?php if(!empty($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="border p-3">
                                    <h5 class="border-bottom pb-2"><strong>Order Summary</strong></h5>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span>Subtotal:</span>
                                        <span>Rs. <?php echo number_format($subtotal, 2); ?></span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span>Tax (5%):</span>
                                        <span>Rs. <?php echo number_format($tax, 2); ?></span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <strong>Rs. <?php echo number_format($total, 2); ?></strong>
                                    </div>
                                    
                                    <form action="checkout.php" method="post" class="mt-3">
                                        <input type="hidden" name="thetotal" value="<?php echo $total; ?>">
                                        <?php $_SESSION['total'] = $total; // Store total in session for original flow ?>
                                        <button type="submit" name="proceed" class="btn btn-success w-100">
                                            <i class="fa fa-credit-card"></i> Proceed to Checkout
                                        </button>
                                    </form>
                                    
                                    <a href="menu.php" class="btn btn-outline-warning w-100 mt-2">
                                        <i class="fa fa-plus"></i> Add More Items
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
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