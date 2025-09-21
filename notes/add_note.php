<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../dashboard.php');
    exit();
}

$title = trim($_POST['title']);
$content = trim($_POST['content']);
$user_id = $_SESSION['user_id'];

// Validation
if (empty($title) || empty($content)) {
    $_SESSION['error'] = 'Title and content are required.';
    header('Location: ../dashboard.php');
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $content]);
    
    $_SESSION['success'] = 'Note added successfully!';
    header('Location: ../dashboard.php');
    exit();
    
} catch(PDOException $e) {
    $_SESSION['error'] = 'Failed to add note. Please try again.';
    header('Location: ../dashboard.php');
    exit();
}
?>
