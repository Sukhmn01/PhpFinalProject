<?php
function getConnection() {
    $host = '172.31.22.43';
    $db   = 'Sukhdeep200625266';
    $user = 'Sukhdeep200625266';
    $pass = 'XQ2z-U8vCa';

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>



