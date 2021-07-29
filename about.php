<?php

//Start Session
session_start();

require_once('component.php');
require_once('createdb.php');
//create instances of CreateDb class
$database = new CreateDb("Proj","Products");

if(isset($_POST['add'])){
    //print_r($_POST['product_id']);
    if(isset($_SESSION['cart'])){

       $item_array_id = array_column($_SESSION['cart'],"product_id");
        //print_r($item_array_id);
        if(in_array($_POST['product_id'],$item_array_id)){
            echo "<script>alert('Product is already added to Basket !')</script>";
            echo "<script>window.location='index.php'</script>";
        }
        else{
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id'=>$_POST['product_id']
            );
            $_SESSION['cart'][$count] = $item_array;
           // print_r($_SESSION['cart']);
        }
    }
    else{
        $item_array = array(
            'product_id'=>$_POST['product_id']
        );

        //Create Session variable
        $_SESSION['cart'][0]=$item_array;
        //print_r($_SESSION['cart']);
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
    <link rel="stylesheet" href="styling.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
    <div class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="index.php">HOME</a>
        <a class="navbar-brand" href="about.php">ABOUT</a>
        <img src="logo.png" width=220px height=220px  alt="" >
        <a class="navbar-brand" href="menu.php">THE MENU</a>
        
        <a class="navbar-brand" href="login.php">LOGIN</a>
    </div>
    <br>
    <div class="page-content">
    <div class="about-section">
        <div class="inner-container">
          <h1>ABOUT US</h1>
          <p class="text">
            Welcome to Shugah by Amal !
  We offer cupcakes , cookies, brownies , donuts , muffins and much more -baked fresh right here in Navi Mumbai.

  Our mission is to ensure an wholesome feeling when you dig into our treats . Our uncompromising standards for high quality ingredients, perfection in product creation and an artistic touch to each dessert will leave  you very satisfied and wanting for more !
  Each product Is handmade with utmost care and love so that every bite feels like a big warm hug .
          </p>
          <div class="skills">
            <span onMouseOver="this.style.color=' #d4c460'"  onMouseOut="this.style.color='black'">TEA CAKES</span>
            <span onMouseOver="this.style.color=' #d4c460'"  onMouseOut="this.style.color='black'">COOKIES</span>
            <a href="menu.php" style= "color:black; text-decoration:none !important;" onMouseOver="this.style.color=' #d4c460'"  onMouseOut="this.style.color='black'">CUPCAKES</a>
            <span onMouseOver="this.style.color=' #d4c460'"  onMouseOut="this.style.color='black'">CHEESECAKES</span>

          </div>

        </div>

    </div>
    </div>

</div>
        
</body>
</html>