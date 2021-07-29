<?php

//Start Session
session_start();
//session_destroy();
require_once('component.php');
require_once('createdb.php');
//create instances of CreateDb class
$database = new CreateDb("Proj","Products");

if(isset($_POST['add'])){
    $qty = 1;
    $id = $_POST['product_id'];
   
    //print_r($_POST['product_id']);
    if(isset($_SESSION['cart'])){

       $item_array_id = array_column($_SESSION['cart'],"product_id");
        // print_r($item_array_id);
        if(in_array($_POST['product_id'],$item_array_id)){
            echo "<script>alert('Product is already added to Basket !')</script>";
            echo "<script>window.location='menu.php'</script>";
        }
        else{
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id'=>$_POST['product_id'],
                'quantity'=>$qty
            );
            $_SESSION['cart'][$count] = $item_array;
        //    print_r($_SESSION['cart']);
        $conn = mysqli_connect("localhost", "root", "", "proj");

        $show = "select * from products where id = '$id';";
            $result = mysqli_query($conn,$show);
            $row = mysqli_fetch_assoc($result);
            $name=$row['product_name'];
            $price=$row['product_price'];

        $sql = "insert into cart values('$id','$name','$price','$qty');";
        mysqli_query($conn,$sql);
        }
    }
    else{
        $item_array = array(
            'product_id'=>$_POST['product_id'],
            'quantity'=>$qty
        );

        //Create Session variable
        $_SESSION['cart'][0]=$item_array;
        // print_r($_SESSION['cart']);
        $conn = mysqli_connect("localhost", "root", "", "proj");
        $show = "select * from products where id = '$id';";
        $result = mysqli_query($conn,$show);
        $row = mysqli_fetch_assoc($result);
        $name=$row['product_name'];
        $price=$row['product_price'];
        $sql = "insert into cart values('$id','$name','$price','$qty');";
        mysqli_query($conn,$sql);
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
        <img src="logo.png" width=220px height=220px  alt="" >
        <a class="navbar-brand" href="menu.php">THE MENU</a>
        
        <a class="navbar-brand" href="login.php">LOGIN</a>
    </div>
    <br><br>
    <div class="page-content">
        <br>
        <div class="shop_cart">
           <a href="shopcart.php">
           <?php
           if(isset($_SESSION['cart'])){
               $count = count($_SESSION['cart']);
               echo "<span id='cart_count'>$count</span>";
           }
           else{
            echo "<span id='cart_count'>0 </span>";
           }
           ?>
           <i class="fa fa-shopping-basket fa-2x"></i></a>
        </div>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <h1 class="text-center">
            CUPCAKES
        </h1>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <div class="row text-center py-3">
            <?php
            $result = $database->getDataCupcake();
            while ($row = mysqli_fetch_assoc($result)){
                item_card($row['product_name'],$row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
            }
            ?>
        </div>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <h1 class="text-center">
            COOKIES
        </h1>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <div class="row text-center py-2">

            <?php
            $result = $database->getDataCookie();
            while ($row = mysqli_fetch_assoc($result)){
                item_card($row['product_name'],$row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
            }
            ?>
        </div>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <h1 class="text-center">
            TEA CAKES
        </h1>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <div class="row text-center py-2">
            <?php
            $result = $database->getDataTeacake();
            while ($row = mysqli_fetch_assoc($result)){
                item_card($row['product_name'],$row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
            }
            ?>
        </div>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <h1 class="text-center">
            CHEESECAKES
        </h1>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <div class="row text-center py-2">
            <?php
            $result = $database->getDataCheese();
            while ($row = mysqli_fetch_assoc($result)){
                item_card($row['product_name'],$row['product_desc'], $row['product_price'], $row['product_image'], $row['id']);
            }
            ?>
        </div>
    </div>


    </div>
</body>
</html>





