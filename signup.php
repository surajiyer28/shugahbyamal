<?php
// Start secure session
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) { 
    // Get form data safely
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pass = isset($_POST['pwd']) ? $_POST['pwd'] : '';
    $cpass = isset($_POST['cpwd']) ? $_POST['cpwd'] : '';
    $phno = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    
    // Validate input
    if(empty($name) || empty($email) || empty($pass) || empty($cpass) || empty($phno)) {
        $error = "Please fill in all fields.";
    } elseif($pass !== $cpass) {
        $error = "Passwords do not match.";
    } elseif(strlen($pass) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Try to connect to database
        $conn = @mysqli_connect("sql210.infinityfree.com", "if0_39606139", "Edith283", "if0_39606139_sugah");
        
        if (!$conn) {
            $error = "Database connection failed. Please try again later.";
        } else {
            // First, ensure the signup table exists
            $create_table = "CREATE TABLE IF NOT EXISTS signup (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(150) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(20),
                address TEXT,
                custid INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            if(!mysqli_query($conn, $create_table)) {
                $error = "Database setup failed. Please try again.";
            } else {
                // Check if email already exists
                $check_stmt = mysqli_prepare($conn, "SELECT id FROM signup WHERE email = ?");
                
                if($check_stmt) {
                    mysqli_stmt_bind_param($check_stmt, "s", $email);
                    mysqli_stmt_execute($check_stmt);
                    $check_result = mysqli_stmt_get_result($check_stmt);
                    
                    if(mysqli_num_rows($check_result) > 0) {
                        $error = "Email address already exists. Please use a different email.";
                    } else {
                        // Hash the password securely
                        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                        
                        // Insert new user
                        $insert_stmt = mysqli_prepare($conn, "INSERT INTO signup (name, email, password, phone) VALUES (?, ?, ?, ?)");
                        
                        if($insert_stmt) {
                            mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $email, $hashed_password, $phno);
                            
                            if(mysqli_stmt_execute($insert_stmt)) {
                                $success = "Registration successful! You can now log in.";
                                // Clear form data on success
                                $name = $email = $phno = "";
                            } else {
                                $error = "Registration failed: " . mysqli_error($conn);
                            }
                            
                            mysqli_stmt_close($insert_stmt);
                        } else {
                            $error = "Database error occurred. Please try again.";
                        }
                    }
                    
                    mysqli_stmt_close($check_stmt);
                } else {
                    $error = "Database query failed. Please try again.";
                }
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
    <title>Shugah-Sign up</title>
    
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
            <form action="signup.php" method="post">
                <div class="col-md-9 col-sh-12 bg-light border rounded mt-5 p-3 ml-2 mb-4">
                    <h5>Sign up</h5>
                    <hr>
                    
                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success); ?>
                            <a href="login.php" class="alert-link">Click here to log in</a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" 
                                       placeholder="Enter name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" 
                                       placeholder="Enter email" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" 
                                       value="<?php echo isset($phno) ? htmlspecialchars($phno) : ''; ?>" 
                                       placeholder="Enter phone number" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p1" class="form-label">Password</label>
                                <input type="password" name="pwd" class="form-control" id="p1" 
                                       placeholder="Enter Password (min 6 characters)" required>
                                <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="p2" class="form-label">Confirm Password</label>
                                <input type="password" name="cpwd" class="form-control" id="p2" 
                                       placeholder="Confirm Password" required>
                            </div>
                        </div>
                    </div>

                    <br>
                    <a class="pl-3" href="login.php">Already have an account? Log in.</a>
                    <button type="submit" class="btn btn-success form-control mx-3" name="signup">Sign up</button>
                </div>
            </form>  
        </div>
    </div>
</body>
</html>