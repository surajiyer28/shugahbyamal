<?php

session_start();
$totalpay = $_POST['thetotal'];
 $_SESSION['total']=$totalpay;
 $name1 = "";
 $email1 = "";
 $phone1 ="";
 if(isset($_SESSION['email'])){

$name1 = $_SESSION['name'];
$email1 = $_SESSION['email'];
$phone1 = $_SESSION['phone'];
 }


function infoelement($name,$qty){

    $element ="<div class='row'>
    <div class='col-8 '>
        <h6>$name</h6>
        

    </div>
    <div class='col-4 '>
        <h6>$qty</h6>
        
    </div>
    </div>";
    echo $element;
}
// if(isset($_POST['order'])){
//     // print_r($_GET['id']);
//     if($_GET['action'] == 'order'){
//         $conn = mysqli_connect("localhost", "root", "", "proj");
//             $show = "insert into orders values";
//             $result = mysqli_query($conn,$show); 
//     }
    
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- Icons -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="row">   
        
     <div class="col-5 bg-light border rounded mx-3 mt-5 pb-4 pt-4">
         <h5>Order Information</h5>
         <hr>
         <div class="row">
         <div class="col-8 ">
             <h5>Item</h5>
             <hr>

         </div>
         <div class="col-4 ">
             <h5>Quantity</h5s>
             <hr>
         </div>
         </div>
         <?php
            $conn = mysqli_connect("localhost", "root", "", "proj");
            $show = "select * from cart;";
            $result = mysqli_query($conn,$show);
            while ($row = mysqli_fetch_assoc($result)){
           infoelement($row['cart_name'],$row['qty']);
            }
         ?>
         <br>
<hr>
         <h5>Total amount payable:  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Rs.<?php echo $totalpay;?></h5>
         
         <hr>
         <div class="row">
         <div class="col-8 ">
            
         </div>
         </div>
     </div>   
    <div class="col-6 bg-light border rounded mx-3 mt-5 my-6 pb-4 pt-4">
        <form action="final.php" method="post">

    <h5>Contact Information</h5>
        <hr>
    <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name1 ?>" placeholder="Enter name">
  </div>
    <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email1 ?>" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
  <label for="phone">Phone number</label>
    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $phone1 ?>"  placeholder="Enter phone number">
  </div>
  <h5>Shipping Address</h5>
        <hr>
    <!-- address-line1 input-->
    <div class="form-group">
     <label >Address Line 1</label>
        <input id="address-line1" name="address-line1" type="text" placeholder="Address line 1" class="form-control">
    </div>
    <!-- address-line2 input-->
    <div class="control-group">
    <label>Address Line 2</label>
    <input id="address-line2" name="address-line2" type="text" placeholder="Address line 2" class="form-control">
    </div>
    <br>
    <button type="submit" class="btn btn-success form-control" name="order">Place Order</button>
</form>    
</div>
    </div>


</div>
</body>
</html>