<?php
session_start();
//session_destroy();
require_once("createdb.php");
require_once("component.php");

$db = new CreateDb("Proj","Products");

if(isset($_POST['remove'])){
    // print_r($_GET['id']);
    if($_GET['action'] == 'remove'){
      echo "<script>$('.remove-item button').click(function() {
        removeItem(this);
      });
   </script>";
        foreach($_SESSION['cart'] as $key => $value){
            if($value['product_id'] == $_GET['id']){
              $id = $_GET['id'];
                unset($_SESSION['cart'][$key]);
                $conn = mysqli_connect("localhost", "root", "", "proj");
               $show = "delete from cart where id = '$id';";
                mysqli_query($conn,$show);
                echo "<script>alert('Item has been removed.')</script>";
                echo "<script>window.location = 'shopcart.php'</script>";
        
            }
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="style.css">
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    

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
    <div class="page-content mt-5">
        <div class="col-md-12 border rounded  bg-white pt-4">
            <div class="shopping-cart">
                
                <h4>My Basket</h4>
                <hr>
                <br>
                
            
 <div class="container mb-5">

<div class="row">




    <div class="col-lg-8 col-xl-8 col-md-12 col-sh-12 mb-2">
      <div class="border border-gainsboro p-3">
      <?php
                        if(!isset($_SESSION['cart'])){
                            echo "<h6>Price(0 items)</h6>";
                            echo "<h5>Your basket is empty.<br></h5>";
                        }
                            if(isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']);
                                echo "<h6>Price($count items)</h6>";
                                echo "<i class='fa fa-inr' aria-hidden='true'></i><strong class='cart-total'></strong>";
                            }
                            
                        ?>
       
      </div>
      
      <?php
              
                
              if (isset($_SESSION['cart'])) {
                  $product_id = array_column($_SESSION['cart'],'product_id');
                  $result = $db->getData();
                  while($row = mysqli_fetch_assoc($result)){
                      foreach($product_id as $id){
                          if($row['id'] == $id){
                              cart_item($row['product_image'],$row['product_name'],$row['product_price'],$row['id']); 
                            
                          }
                      }
                  }
              }
                   
               
               
               
          ?> 

     <!-- item -->
    </div>
               
    <div class="col-xl-4 col-lg-4 col-md-12 col-sh-12 totals">
      <div class="border border-gainsboro px-3">
        <div class="border-bottom border-gainsboro">
          <p class="text-uppercase mb-0 py-3"><strong>Order Summary</strong></p>
        </div>
        <div class="totals-item d-flex align-items-center justify-content-between mt-3">
          <h6 class="text-uppercase">Subtotal</h6>
         <h6 class="totals-value" id="cart-subtotal"> </h6>
        </div>
        <div class="totals-item d-flex align-items-center justify-content-between">
          <p class="text-uppercase">Estimated Tax</p>
          <p class="totals-value" id="cart-tax">3.60</p>
        </div>
        <div class="totals-item totals-item-total d-flex align-items-center justify-content-between mt-3 pt-3 border-top border-gainsboro">
          <p class="text-uppercase"><strong>Total</strong></p>
          <p  class="totals-value font-weight-bold cart-total" onChange>98.60</p>
        </div>
        <form action="checkout.php" method="post">
        
        <button class="btn btn-success w-100 mb-3" name="proceed">Proceed to Checkout  </button>
               <input type="hidden" id="hidden-in" name="thetotal">
        </form>
      </div>
    </div>
    
    </div>

  
</div><!-- container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {

   /* Set rates */
   var taxRate = 0.05;
   var fadeTime = 0;

   var subtotal = 0;

/* Sum up row totals */
$('.item').each(function() {
  subtotal += parseFloat($(this).children('.one-item').children('.product-line-price').text());
});

/* Calculate totals */
var tax = subtotal * taxRate;
var total = subtotal + tax;
$('#hidden-in').val(total);

/* Update totals display */
$('.totals-value').fadeOut(fadeTime, function() {
  $('#cart-subtotal').html(subtotal.toFixed(2));
  $('#cart-tax').html(tax.toFixed(2));
  $('.cart-total').html(total.toFixed(2));
  if (total == 0) {
    $('.checkout').fadeOut(fadeTime);
  } else {
    $('.checkout').fadeIn(fadeTime);
  }
  $('.totals-value').fadeIn(fadeTime);
});

   /* Assign actions */
   $('.pass-quantity input').change(function() {
     updateQuantity(this);
   });

   

   /* Recalculate cart */
   function recalculateCart() {
     var subtotal = 0;

     /* Sum up row totals */
     $('.item').each(function() {
       subtotal += parseFloat($(this).children('.one-item').children('.product-line-price').text());
     });

     /* Calculate totals */
     var tax = subtotal * taxRate;
     var total = subtotal + tax;
     $('#hidden-in').val(total);

     /* Update totals display */
     $('.totals-value').fadeOut(fadeTime, function() {
       $('#cart-subtotal').html(subtotal.toFixed(2));
       $('#cart-tax').html(tax.toFixed(2));
       $('.cart-total').html(total.toFixed(2));
       if (total == 0) {
         $('.checkout').fadeOut(fadeTime);
       } else {
         $('.checkout').fadeIn(fadeTime);
       }
       $('.totals-value').fadeIn(fadeTime);
     });
   }


   /* Update quantity */
   function updateQuantity(quantityInput) {
     /* Calculate line price */
     var productRow = $(quantityInput).parent().parent();
     var price = parseFloat(productRow.children('.product-price').text());
     var quantity = $(quantityInput).val();
     var linePrice = price * quantity;
     var id = parseInt(productRow.children('.pass-quantity').children('.prodid').val());
     var data ={};
     data['a']=id;
     data['b']=quantity;

     var jsondata = JSON.stringify(data);

     $.ajax({
            url:"updqty.php",
            type:"post",
            data:{data:jsondata},
            success:function(response){
              console.log(response);
            }
     });
     /* Update line price display and recalc cart totals */
     productRow.children('.product-line-price').each(function() {
       $(this).fadeOut(fadeTime, function() {
         $(this).text(linePrice.toFixed(2));
         recalculateCart();
         $(this).fadeIn(fadeTime);
       });
     });
   }

   /* Remove item from cart */
   function removeItem(removeButton) {
     /* Remove row from DOM and recalc cart total */
     var productRow = $(removeButton).parent().parent().parent();
     productRow.slideUp(fadeTime, function() {
       productRow.remove();
       recalculateCart();
     });
     
   }

 });
</script>

    
   
</body>
</html>