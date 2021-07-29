<?php
if($_SERVER["REQUEST_METHOD"] == "POST") { 
   
    $email = $_POST['email'];
    $pass = $_POST['pwd'];
   
    $conn = mysqli_connect("localhost","root","","proj");

    if(isset($_POST['login'])){
        
      
      
      $sql = "SELECT * FROM signup WHERE email = '$email' and password = '$pass'";
      $resultt = mysqli_query($conn,$sql);
      $row = mysqli_fetch_assoc($resultt);
      session_start();
      if(mysqli_num_rows($resultt) > 0) {
         
         $_SESSION['email'] = $_POST['email'];
         $_SESSION['name'] = $row['name'];
         $_SESSION['phone'] = $row['phone'];
        //  print_r($_SESSION['name']);
         header("Location: index.php");
      }else {
         $error = "Your Login Name or Password is invalid";
         echo $error;
      }

        }

    }
    


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shugah-Login</title>
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="styling.css"> -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        body{
    background-image: repeating-linear-gradient(0deg, #f66f8b2e 0px, rgba(246,111,139, 0.18) 1px,transparent 1px, transparent 21px),repeating-linear-gradient(90deg, rgba(246,111,139, 0.18) 0px, rgba(246,111,139, 0.18) 1px,transparent 1px, transparent 21px),linear-gradient(135deg, rgba(246,111,139, 0.18),rgba(246,111,139, 0.18));
}

        .navbar{
    height: 80px;
    margin-top: 50px;
    border-radius: 10px;
    text-align: center;
}

.navbar a{
    float: left;
    width: 25%;
    color:#d4c460 !important;
    font-weight: 900;
    font-family: 'Times New Roman', Times, serif;
    border: 1px hidden;
    border-radius: 5px; 
}

.navbar a:hover{
    border: 1px solid #d4c460 ;   
}
    </style>
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
    <div class="page-content ">
 
        <div class="col-md-5 col-sh-12 bg-light border rounded mt-5 p-4 ml-2 mb-4">
    <form action="login.php" method="post">
    <h5>Log in</h5>
    <hr>
  <div class="form-group">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name ="pwd" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
  </div>
  
  <br>
  <a href="signup.php">Not a user? Sign up today!</a>
  <button type="submit" class="btn btn-success w-100" name="login">Log in</button>
</form>
</div>

    </div>

</div>
        
</body>
</html>