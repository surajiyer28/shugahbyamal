<?php
session_start();

// Get order details
$price = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
$email1 = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$name1 = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$phone1 = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';

// Get address from form
$address = "";
if(isset($_POST['address-line1']) && isset($_POST['address-line2'])) {
    $address = $_POST['address-line1'] . ", " . $_POST['address-line2'];
}

// Connect to database
$conn = mysqli_connect("sql210.infinityfree.com", "if0_39606139", "Edith283", "if0_39606139_sugah");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Generate IDs
$orderid = rand(1, 1000);
$custid = rand(1, 1000);

// Update signup table with address and custid if user is logged in
if(!empty($email1)) {
    $updatecust = "UPDATE signup SET address = ?, custid = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $updatecust);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "sis", $address, $custid, $email1);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Get data from cart session and put in orders table
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Calculate total if not set
    if($price == 0) {
        foreach($_SESSION['cart'] as $item) {
            $price += $item['product_price'] * $item['quantity'];
        }
        $price = $price * 1.05; // Add 5% tax
        $_SESSION['total'] = $price;
    }
    
    // Insert each cart item into orders table
    foreach($_SESSION['cart'] as $item) {
        $item_name = $item['product_name'];
        $qtty = $item['quantity'];
        
        $sql = "INSERT INTO orders (order_id, item, qty, custid, total_cost) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "isiid", $orderid, $item_name, $qtty, $custid, $price);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($conn);

// Redirect to payment page
header('Location: finalll.php');
exit();
?>