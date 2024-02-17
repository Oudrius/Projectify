<?php

// Report all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Absolute path for this app
$path = $_SERVER["DOCUMENT_ROOT"] . '/task_manager/';

// Check if config.php exists
if (!file_exists($path . 'config.php')) {
    throw new Exception('config.php could not be located.');
}

// Set up PDO connection
$config = require $path . 'config.php';

$db_info = $config['db'];
$dsn = "mysql:host={$db_info['host']};
        dbname={$db_info['database']};
        charset={$config['db_charset']}";

// Connect to database
try {
    $pdo = new PDO($dsn, $db_info['username'], $db_info['password'], 
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

} catch (PDOException $e) {
    echo "Oops! Something went wrong. Please try again later.<br>"; // Handle user-friendly error
}

return $pdo; // Return pdo to be used in other scripts

?>