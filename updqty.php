<?php

$data = json_decode($_POST['data']);
$data = json_decode($_POST['data'],true);
echo $data[a];
echo $data[b];
$conn = mysqli_connect("localhost", "root", "", "proj");
$show = "update cart set qty = '$data[b]' where id = '$data[a]';";
$result = mysqli_query($conn,$show);

?>