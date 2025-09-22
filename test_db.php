<?php
// Simple database connection test
echo "<h2>Database Connection Test</h2>";
echo "<p>Testing database connection...</p>";

// Include the database config
require_once 'config/database.php';

if (isset($pdo)) {
    echo "<div style='color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px;'>";
    echo "✅ <strong>Success!</strong> Database connected successfully!<br>";
    
    // Test if tables exist
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() > 0) {
            echo "✅ 'users' table exists<br>";
        } else {
            echo "❌ 'users' table does NOT exist - you need to run database.sql<br>";
        }
        
        $stmt = $pdo->query("SHOW TABLES LIKE 'notes'");
        if ($stmt->rowCount() > 0) {
            echo "✅ 'notes' table exists<br>";
        } else {
            echo "❌ 'notes' table does NOT exist - you need to run database.sql<br>";
        }
        
        // Test user count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch();
        echo "📊 Users in database: " . $result['count'] . "<br>";
        
    } catch(PDOException $e) {
        echo "⚠️ Tables might not exist: " . $e->getMessage() . "<br>";
        echo "💡 You may need to import database.sql<br>";
    }
    
    echo "</div>";
} else {
    echo "<div style='color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;'>";
    echo "❌ <strong>Database connection failed!</strong><br>";
    echo "Check the error message above for details.";
    echo "</div>";
}
?>

<hr>
<h3>Troubleshooting Steps:</h3>
<ol>
    <li><strong>Check XAMPP:</strong> Make sure MySQL is running in XAMPP Control Panel</li>
    <li><strong>Check Database:</strong> Open phpMyAdmin and verify 'notes_app' database exists</li>
    <li><strong>Import Tables:</strong> If database exists but tables don't, import database.sql</li>
    <li><strong>Check Credentials:</strong> Verify username/password in config/database.php</li>
</ol>

<p><a href="login.php">← Back to Login</a></p>
