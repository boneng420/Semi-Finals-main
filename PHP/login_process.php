<?php
session_start();
require_once 'config.php';

if (!isset($pdo)) {
    die("Database connection failed. Check config.php file.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: /SemiFinals-main/HTML/home.html");
            exit();
        } else {
            header("Location: /SemiFinals-main/index.html");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: /SemiFinals-main/index.html");
        exit();
    }
} else {
    header("Location: /SemiFinals-main/index.html");
    exit();
}
?>