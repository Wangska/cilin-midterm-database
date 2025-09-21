<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../config/database.php';

$note_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

if (!$note_id) {
    $_SESSION['error'] = 'Invalid note ID.';
    header('Location: ../dashboard.php');
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$note_id, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = 'Note deleted successfully!';
    } else {
        $_SESSION['error'] = 'Note not found or you do not have permission to delete it.';
    }
} catch(PDOException $e) {
    $_SESSION['error'] = 'Failed to delete note. Please try again.';
}

header('Location: ../dashboard.php');
exit();
?>
