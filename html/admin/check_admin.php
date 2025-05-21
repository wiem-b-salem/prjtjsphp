<?php
require_once '../../config/database.php';
//khtr el admin kasrli kraymi w mrjni w tbh allahou aalm aleha chtaaml hethy nsitha 
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/admin_check.log');

try {
    $pdo = getDBConnection();
    
    $stmt = $pdo->prepare("SELECT id, email, password FROM admins WHERE email = ?");
    $stmt->execute(['admin@petitsgenies.fr']);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$admin) {
        $password = 'Admin@123';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO admins (email, password, first_name, last_name) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin@petitsgenies.fr', $hashed_password, 'Admin', 'System']);
        
        echo "Admin account created successfully.<br>";
        echo "Email: admin@petitsgenies.fr<br>";
        echo "Password: Admin@123<br>";
    } else {
        $password = 'Admin@123';
        if (!password_verify($password, $admin['password'])) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $admin['id']]);
            
            echo "Admin password updated successfully.<br>";
            echo "Email: admin@petitsgenies.fr<br>";
            echo "Password: Admin@123<br>";
        } else {
            echo "Admin account exists and password is correct.<br>";
            echo "Email: admin@petitsgenies.fr<br>";
            echo "Password: Admin@123<br>";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 