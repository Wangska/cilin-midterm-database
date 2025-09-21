<?php
// Database configuration for Coolify deployment
// Use environment variables or fallback to local development values

$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
$dbname = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?: 'notes_app';
$username = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: 'root';
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
$port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '3306';

// For debugging (remove in production)
// error_log("DB Config: $host:$port/$dbname with user $username");

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    
} catch(PDOException $e) {
    // Log the error instead of displaying it in production
    error_log("Database Connection Error: " . $e->getMessage());
    
    // Show user-friendly message
    if ($_ENV['APP_ENV'] === 'production' || getenv('APP_ENV') === 'production') {
        die("Database connection failed. Please try again later.");
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
