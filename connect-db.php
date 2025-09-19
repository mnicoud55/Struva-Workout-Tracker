<?php
// db.php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASS');
$ssl_ca_content = getenv('SSL_CA'); // contents of ca.pem

// Write SSL CA to a temporary file
$ssl_ca_path = '/tmp/db-ca.pem';
if ($ssl_ca_content) {
    file_put_contents($ssl_ca_path, $ssl_ca_content);
}

try {
    $db = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => $ssl_ca_path,//__DIR__ . '/ca.pem',
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}