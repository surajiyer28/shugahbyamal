<?php
session_start();

foreach($_SESSION['cart'] as $key => $value){
    if($value['product_id'] == $_POST['id']){
    $value['quantity'] == $_POST['qty'];
    }
}
    print_r($_SESSION['cart']);
?>