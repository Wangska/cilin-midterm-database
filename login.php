<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesApp - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">
                    <i class="fas fa-sticky-note"></i>
                    <h1>NotesApp</h1>
                </div>
                <h2>Welcome Back</h2>
                <p>Sign in to your account</p>
            </div>
            
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            
            <form class="auth-form" action="auth/login_process.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
            </form>
            
            <div class="auth-footer">
                <p>Don't have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
