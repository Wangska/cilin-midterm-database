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
    header('Location: ../dashboard.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    // Validation
    if (empty($title) || empty($content)) {
        $_SESSION['error'] = 'Title and content are required.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$title, $content, $note_id, $user_id]);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = 'Note updated successfully!';
                header('Location: ../dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Note not found or you do not have permission to edit it.';
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = 'Failed to update note. Please try again.';
        }
    }
}

// Get the note for editing
try {
    $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$note_id, $user_id]);
    $note = $stmt->fetch();
    
    if (!$note) {
        $_SESSION['error'] = 'Note not found.';
        header('Location: ../dashboard.php');
        exit();
    }
} catch(PDOException $e) {
    $_SESSION['error'] = 'Error loading note.';
    header('Location: ../dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotesApp - Edit Note</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
                <a href="../dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
                <a href="../auth/logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Edit Note</h1>
            <p>Update your note</p>
        </div>

        <div class="notes-container">
            <div class="note-form-card">
                <h3><i class="fas fa-edit"></i> Edit Note</h3>
                
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-error">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <div class="input-wrapper">
                            <i class="fas fa-heading"></i>
                            <input type="text" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($note['title']); ?>" 
                                   placeholder="Enter note title" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Content</label>
                        <div class="input-wrapper">
                            <i class="fas fa-edit"></i>
                            <textarea id="content" name="content" placeholder="Write your note here..." required><?php echo htmlspecialchars($note['content']); ?></textarea>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Update Note
                        </button>
                        <a href="../dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
