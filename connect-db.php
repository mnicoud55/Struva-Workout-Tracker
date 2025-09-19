<?php
// connect-db.php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASS');

// Detect Cloud Run by presence of K_SERVICE
$isCloudRun = getenv('K_SERVICE') !== false;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

if ($isCloudRun) {
    // Get SSL cert contents from Secret Manager 
    $ssl_ca_content = getenv('SSL_CA');
    if ($ssl_ca_content) {
        $ssl_ca_path = '/tmp/db-ca.pem';
        file_put_contents($ssl_ca_path, $ssl_ca_content);

        $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl_ca_path;
    }
}

try {
    $db = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        $options
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}