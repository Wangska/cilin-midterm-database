<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password'];

// Validation
if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Username and password are required.';
    header('Location: ../login.php');
    exit();
}

try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: ../login.php');
        exit();
    }
} catch(PDOException $e) {
    $_SESSION['error'] = 'Login failed. Please try again.';
    header('Location: ../login.php');
    exit();
}
?>
