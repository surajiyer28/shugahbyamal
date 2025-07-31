<?php
// Start secure session
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

// Include required files with error handling
if(file_exists('component.php')) {
    require_once('component.php');
}

if(file_exists('createdb.php')) {
    require_once('createdb.php');
    $database = new CreateDb();
} else {
    $database = null;
}

// Handle add to cart
if(isset($_POST['add']) && $database){
    $product_id = (int)$_POST['product_id'];
    
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'],"product_id");
        
        if(in_array($product_id, $item_array_id)){
            echo "<script>alert('Product is already added to Basket!');</script>";
            echo "<script>window.location='about.php';</script>";
        } else {
            $count = count($_SESSION['cart']);
            $item_array = array('product_id' => $product_id);
            $_SESSION['cart'][$count] = $item_array;
        }
    } else {
        $item_array = array('product_id' => $product_id);
        $_SESSION['cart'][0] = $item_array;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shugah-About</title>
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="style.css">
    
    <style>
        /* About section styles */
        .about-section {
            margin: 20px;
            background: url('aboutimg.jpg') no-repeat left;
            background-size: 55%;
            background-color: white;
            overflow: hidden;
            padding: 100px 0;
            min-height: 500px;
        }

        .inner-container {
            width: 55%;
            float: right;
            background-color: #fdfdfd;
            padding: 40px;
            margin-right: 150px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .inner-container h1 {
            margin-bottom: 30px;
            font-size: 30px;
            font-weight: 900;
            color: #d4c460;
        }

        .inner-container p {
            text-align: left !important;
        }

        .text {
            font-size: 16px;
            color: #545454;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 40px;
        }

        .skills {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 14px;
            flex-wrap: wrap;
        }

        .skills span, .skills a {
            margin: 5px;
            padding: 8px 12px;
            border: 2px solid #d4c460;
            border-radius: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
        }

        .skills span:hover, .skills a:hover {
            background-color: #d4c460;
            color: white;
            text-decoration: none;
        }

        /* Responsive design */
        @media screen and (max-width: 1200px) {
            .inner-container {
                padding: 30px;
                margin-right: 50px;
            }
        }

        @media screen and (max-width: 1000px) {
            .about-section {
                background-size: 100%;
                padding: 50px 20px;
            }
            .inner-container {
                width: 100%;
                float: none;
                margin-right: 0;
            }
        }

        @media screen and (max-width: 600px) {
            .about-section {
                padding: 20px 10px;
            }
            .inner-container {
                padding: 20px;
            }
            .skills {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
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
        <br>
        
        <div class="page-content">
            <div class="about-section">
                <div class="inner-container">
                    <h1>ABOUT US</h1>
                    <p class="text">
                        Welcome to Shugah by Amal!<br><br>
                        We offer cupcakes, cookies, brownies, donuts, muffins and much more - baked fresh right here in Navi Mumbai.
                        <br><br>
                        Our mission is to ensure a wholesome feeling when you dig into our treats. Our uncompromising standards for high quality ingredients, perfection in product creation and an artistic touch to each dessert will leave you very satisfied and wanting for more!
                        <br><br>
                        Each product is handmade with utmost care and love so that every bite feels like a big warm hug.
                    </p>
                    
                    <div class="skills">
                        <span>TEA CAKES</span>
                        <span>COOKIES</span>
                        <a href="menu.php">CUPCAKES</a>
                        <span>CHEESECAKES</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>