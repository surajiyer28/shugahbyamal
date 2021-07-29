<?php

session_start();
$price = $_SESSION['total'];
$email1 = $_SESSION['email'];
$address = $_POST['address-line1'].", ".$_POST['address-line2'];
$name1 = $_SESSION['name'];



$phone1 = $_SESSION['phone'];
$conn = mysqli_connect("localhost", "root", "", "proj");
$orderid = rand(1,1000);
$custid=rand(1,1000);
// $sql = "CREATE TABLE IF NOT EXISTS customers
//             (id INT(11)NOT NULL PRIMARY KEY,
//             cust_name VARCHAR(35) NOT NULL,
//             cust_email VARCHAR(60),
//             cust_phone varchar(10),
//             cust_addr VARCHAR(60)
//             );";
//     mysqli_query($conn, $sql);

    $insertcust = "update signup set address = '$address' and custid = $custid where email = '$email1';";
    mysqli_query($conn, $insertcust);

 //Get data from cart and put in orders table
 $getcart = "select * from cart;";
 $resultt = mysqli_query($conn,$getcart);
while($row=mysqli_fetch_assoc($resultt)){
    $name = $row['cart_name'];
    $qtty = $row['qty'];
    $sqll = "insert into orders(order_id,item,qty,custid, total_cost) values ( $orderid, '$name', $qtty, $custid ,$price); ";
    mysqli_query($conn,$sqll);
}


    header('location: finalll.php');

   
    
?>

