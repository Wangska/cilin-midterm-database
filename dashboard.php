<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';

// Get user's notes
try {
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $notes = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error fetching notes: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesApp - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="dashboard">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <i class="fas fa-sticky-note"></i>
                <h1>NotesApp</h1>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
                <a href="auth/logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Your Notes</h1>
            <p>Keep track of your thoughts and ideas</p>
        </div>

        <div class="notes-container">
            <!-- Add Note Form -->
            <div class="note-form-card">
                <h3><i class="fas fa-plus"></i> Add New Note</h3>
                
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-error">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }
                ?>
                
                <form action="notes/add_note.php" method="POST">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <div class="input-wrapper">
                            <i class="fas fa-heading"></i>
                            <input type="text" id="title" name="title" placeholder="Enter note title" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Content</label>
                        <div class="input-wrapper">
                            <i class="fas fa-edit"></i>
                            <textarea id="content" name="content" placeholder="Write your note here..." required></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save Note
                    </button>
                </form>
            </div>

            <!-- Notes Display -->
            <?php if (empty($notes)): ?>
                <div class="empty-state">
                    <i class="fas fa-sticky-note"></i>
                    <h3>No notes yet</h3>
                    <p>Create your first note using the form above</p>
                </div>
            <?php else: ?>
                <div class="notes-grid">
                    <?php foreach ($notes as $note): ?>
                        <div class="note-card">
                            <div class="note-header">
                                <h4 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h4>
                                <div class="note-actions">
                                    <a href="notes/edit_note.php?id=<?php echo $note['id']; ?>" class="btn btn-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="notes/delete_note.php?id=<?php echo $note['id']; ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this note?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="note-content">
                                <?php echo nl2br(htmlspecialchars($note['content'])); ?>
                            </div>
                            <div class="note-footer">
                                <i class="fas fa-calendar-alt"></i>
                                Created: <?php echo date('M j, Y \a\t g:i A', strtotime($note['created_at'])); ?>
                                <?php if ($note['updated_at'] != $note['created_at']): ?>
                                    <br><i class="fas fa-edit"></i>
                                    Updated: <?php echo date('M j, Y \a\t g:i A', strtotime($note['updated_at'])); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
