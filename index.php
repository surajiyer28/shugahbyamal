<?php

//Start Session
session_start();

//session_destroy();

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
    <title>Shugah-Home</title>
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>


      /* SlideShow */
.swiper-container {
    margin-top: 20px;   
    padding-bottom: 140px;
}

.swiper-slide {
    background-position: center;
    background-size: cover;
    width: 480px;
    height: 300px; 
    -webkit-box-reflect: below 5px linear-gradient(transparent,transparent,rgba(0, 0, 0, 0.308));
    
}


.page-content .wrapper ul{
     position:absolute;
     left:49%;
     transform: translate(-50%,-50%);
        display: flex;
        text-align:center:
   }

   .page-content .wrapper ul li{
     list-style: none;
     margin:0px 20px;
     margin-bottom: 120px;
     
     
   }
   .page-content .wrapper ul li .fa{
        font-size: 25px;
        line-height: 60px;
        transition: .6s;
        color: #000;
        
      }

      .page-content .wrapper ul li .fa:hover
      {
        color: #fff;
      }
      .page-content .wrapper ul li a{
           position: relative;
           border-radius: 50%;
           display: block;
           width: 60px;
           height: 60px;
           
           transition: .6s;
           box-shadow: 0 5px 4px rgba(0,0,0,.5);
           text-align: center;
           background-color:#d4c460;
         }

         .page-content .wrapper ul li a:hover
            {
              transform: translate(0,-10px);
            }
            .page-content .wrapper ul li:nth-child(1) a:hover
            {
              background-color: #3b5999;
            }

            .page-content .wrapper ul li:nth-child(2) a:hover
            {
              background-color: #55acee;
            }
            .page-content .wrapper ul li:nth-child(3) a:hover
            {
              background-color: #e4405f;
            }
            .page-content .wrapper ul li:nth-child(4) a:hover
            {
              background-color: #25D366;
            }
            .page-content p{
              padding:10px 150px;
              
            }

    </style>
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
    <br>
    <div class="page-content">
        <br>
        <div class="welc" style= "color:#d4c460; margin-left:20px">
        <?php
           if(isset($_SESSION['email'])){
            $nameee=$_SESSION['name'];
             echo "<h5><a href='logout.php'  style= 'color:#d4c460;'>Hello, $nameee</a></h5>";
           }    
          
           ?>
        
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
           <i class="fa fa-shopping-basket fa-2x"></i> 
          </a>
        </div>
        </div>
        <div class="swiper-container">

            <!-- SlideShow -->

            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/cookies.jpg" alt=""></div>
                <div class="swiper-slide"><img src="img/cupcake.jpg" alt=""></div>
                <div class="swiper-slide"><img src="img/cookies2.jpg" alt=""></div>
                <div class="swiper-slide"><img src="img/cupcake2.jpg" alt=""></div>
            </div>

            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <h1 class="text-center">SHUGAH</h1>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <p class="text-center-justified ">
        SHUGAH takes pride in serving bakery products that offer "Health & Happiness in Every Bite". 
        Our products are made from recipes that use the finest quality flours, the world's best margarines and finest butter. 
        The taste & Quality of our products will make you crave for more. Go ahead & share with everyone.
        
        </p>
        <p class="text-center-justified ">
        Our mission is to ensure an wholesome feeling when you dig into our treats . Our uncompromising standards for high quality ingredients, perfection in product creation and an artistic touch to each dessert will leave you very satisfied and wanting for more ! Each product Is handmade with utmost care and love so that every bite feels like a big warm hug.
        </p>
        <hr style="height:2px;border-width:0;color:gray;background-color: #d4c460 ">
        <br>
        <h6 class="text-center">Follow our social media handles:</h6  >
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="wrapper">
          <ul>
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.instagram.com/shugahbyamal/"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
          </ul>
    
    
          </div>
     



      
        </div>
</div>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
  var swiper = new Swiper('.swiper-container', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 200,
          modifier: 1,
          slideShadows: true,
          
      },
      loop:true,
      autoplay: {
          delay: 2500,
          disableOnInteraction: false,
          
      }

    
  });
</script>

</body>
</html>