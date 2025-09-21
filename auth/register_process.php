<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validation
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['error'] = 'All fields are required.';
    header('Location: ../register.php');
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: ../register.php');
    exit();
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'Password must be at least 6 characters long.';
    header('Location: ../register.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    header('Location: ../register.php');
    exit();
}

try {
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Username already exists. Please choose another.';
        header('Location: ../register.php');
        exit();
    }
    
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Email already exists. Please use another email.';
        header('Location: ../register.php');
        exit();
    }
    
    // Hash password and create user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password]);
    
    $_SESSION['success'] = 'Account created successfully! You can now login.';
    header('Location: ../login.php');
    exit();
    
} catch(PDOException $e) {
    $_SESSION['error'] = 'Registration failed. Please try again.';
    header('Location: ../register.php');
    exit();
}
?>
