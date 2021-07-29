
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pwd'];
    $phno = $_POST['phone'];
    $conn = mysqli_connect("localhost","root","","proj");
    if(isset($_POST['signup'])){
        
        $signup = "insert into signup(name,email,password,phone) values('$name','$email','$pass','$phno');";
       mysqli_query($conn,$signup);
       header("Location:login.php");
            echo "<script>alert('Sign up successful ! Log in to continue')</script>";
            
        

    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shugah-Sign up</title>
    
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
 
        
        <form action="" method="post">
        <div class="col-md-9 col-sh-12 bg-light border rounded mt-5 p-3 ml-2 mb-4">
<h5>Sign up</h5>
    <hr>
<div class="row">
    <div class="col-md-6">
    <div class="form-group">
<label for="name">Name</label>
<input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
</div>
<div class="form-group">
<label for="email">Email address</label>
<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
</div>

<div class="form-group">
<label for="phone">Phone number</label>
<input type="tel" id="phone" name="phone" class="form-control"   placeholder="Enter phone number">
</div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name ="pwd" class="form-control" id="p1" placeholder="Enter Password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
    <input type="password" name ="cpwd" class="form-control" id="p2" placeholder="Confirm Password">
  </div>

    </div>


<br>
<a class="pl-3" href="login.php">Already have an account? Log in.</a>
<button type="submit" class="btn btn-success form-control mx-3" name="signup">Sign up</button>
</div>
</div>
</form>  


    </div>

</div>
        
</body>
</html>