<?php
// Start secure session
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

require_once('component.php');
require_once('createdb.php');

// Create database instance
$database = new CreateDb();
$success_message = "";
$error_message = "";

if(isset($_POST['add'])){
    $product_id = (int)$_POST['product_id']; // Cast to integer for security
    $qty = 1;
   
    // Check if product exists
    $stmt = mysqli_prepare($database->con, "SELECT product_name, product_price FROM Products WHERE id = ?");
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($result)) {
            $product_name = $row['product_name'];
            $product_price = $row['product_price'];
            
            // Initialize cart session if not exists
            if(!isset($_SESSION['cart'])){
                $_SESSION['cart'] = array();
            }
            
            // Check if item already in cart
            $item_exists = false;
            foreach($_SESSION['cart'] as $key => $item) {
                if($item['product_id'] == $product_id) {
                    $_SESSION['cart'][$key]['quantity']++;
                    $item_exists = true;
                    break;
                }
            }
            
            // Add new item if not exists
            if(!$item_exists) {
                $_SESSION['cart'][] = array(
                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    'product_price' => $product_price,
                    'quantity' => $qty
                );
            }
            
            $success_message = "Product added to basket successfully!";
        } else {
            $error_message = "Product not found.";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Database error occurred.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shugah-Menu</title>
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
            <img src="logo.png" width=220px height=220px alt="Shugah Logo">
            <a class="navbar-brand" href="menu.php">THE MENU</a>
            <a class="navbar-brand" href="login.php">LOGIN</a>
        </div>
        <br><br>
        <div class="page-content">
            <br>
            
            <?php if(!empty($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($success_message); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="shop_cart">
               <a href="shopcart.php">
               <?php
               $cart_count = 0;
               if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
                   foreach($_SESSION['cart'] as $item) {
                       $cart_count += isset($item['quantity']) ? $item['quantity'] : 1;
                   }
               }
               echo "<span id='cart_count'>" . $cart_count . "</span>";
               ?>
               <i class="fa fa-shopping-basket fa-2x"></i></a>
            </div>
            
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <h1 class="text-center">CUPCAKES</h1>
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <div class="row text-center py-3">
                <?php
                $result = $database->getDataCupcake();
                if($result) {
                    while ($row = mysqli_fetch_assoc($result)){
                        item_card($row['product_name'], $row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
                    }
                } else {
                    echo "<p class='col-12'>No cupcakes available at the moment.</p>";
                }
                ?>
            </div>
            
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <h1 class="text-center">COOKIES</h1>
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <div class="row text-center py-2">
                <?php
                $result = $database->getDataCookie();
                if($result) {
                    while ($row = mysqli_fetch_assoc($result)){
                        item_card($row['product_name'], $row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
                    }
                } else {
                    echo "<p class='col-12'>No cookies available at the moment.</p>";
                }
                ?>
            </div>
            
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <h1 class="text-center">TEA CAKES</h1>
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <div class="row text-center py-2">
                <?php
                $result = $database->getDataTeacake();
                if($result) {
                    while ($row = mysqli_fetch_assoc($result)){
                        item_card($row['product_name'], $row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
                    }
                } else {
                    echo "<p class='col-12'>No tea cakes available at the moment.</p>";
                }
                ?>
            </div>
            
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <h1 class="text-center">CHEESECAKES</h1>
            <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460">
            <div class="row text-center py-2">
                <?php
                $result = $database->getDataCheese();
                if($result) {
                    while ($row = mysqli_fetch_assoc($result)){
                        item_card($row['product_name'], $row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
                    }
                } else {
                    echo "<p class='col-12'>No cheesecakes available at the moment.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>