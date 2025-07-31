<?php
// Start secure session
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) { 
    // Get form data safely
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pass = isset($_POST['pwd']) ? $_POST['pwd'] : '';
   
    // Validate input
    if(empty($email) || empty($pass)) {
        $error = "Please fill in all fields.";
    } else {
        // Connect to database
        $conn = @mysqli_connect("sql210.infinityfree.com", "if0_39606139", "Edith283", "if0_39606139_sugah");
        
        if (!$conn) {
            $error = "Database connection failed. Please try again later.";
        } else {
            // Use prepared statement to prevent SQL injection
            $stmt = mysqli_prepare($conn, "SELECT id, name, email, password, phone FROM signup WHERE email = ?");
            
            if($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if($row = mysqli_fetch_assoc($result)) {
                    // Verify password (handles both old plain text and new hashed passwords)
                    $password_valid = false;
                    
                    // Check if it's a hashed password
                    if(password_verify($pass, $row['password'])) {
                        $password_valid = true;
                    } 
                    // Check if it's plain text password (for backward compatibility)
                    elseif($row['password'] === $pass) {
                        $password_valid = true;
                        // Update to hashed password
                        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                        $update_stmt = mysqli_prepare($conn, "UPDATE signup SET password = ? WHERE id = ?");
                        if($update_stmt) {
                            mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $row['id']);
                            mysqli_stmt_execute($update_stmt);
                            mysqli_stmt_close($update_stmt);
                        }
                    }
                    
                    if($password_valid) {
                        // Login successful
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['phone'] = $row['phone'];
                        
                        // Redirect to homepage
                        header("Location: index.php");
                        exit();
                    } else {
                        $error = "Invalid email or password.";
                    }
                } else {
                    $error = "Invalid email or password.";
                }
                
                mysqli_stmt_close($stmt);
            } else {
                $error = "Database query failed. Please try again.";
            }
            
            mysqli_close($conn);
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
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
        
        .error-message {
            color: #dc3545;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="navbar navbar-expand-sm navbar-light bg-light">
            <a class="navbar-brand" href="index.php">HOME</a>
            <a class="navbar-brand" href="about.php">ABOUT</a>
            <img src="logo.png" width=220px height=220px alt="" >
            <a class="navbar-brand" href="menu.php">THE MENU</a>
            <a class="navbar-brand" href="login.php">LOGIN</a>
        </div>
        <br>
        <div class="page-content">
            <div class="col-md-5 col-sh-12 bg-light border rounded mt-5 p-4 ml-2 mb-4">
                <form action="login.php" method="post">
                    <h5>Log in</h5>
                    <hr>
                    
                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                               placeholder="Enter Email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="pwd" class="form-control" id="password" 
                               placeholder="Enter Password" required>
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