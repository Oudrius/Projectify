<?php

// Report all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Check if config.php exists
if (!file_exists('../config.php')) {
    throw new Exception('Config.php could not be located.');
}

// Set up PDO connection
$config = require '../config.php';

$db_info = $config['db'];
$dsn = "mysql:host={$db_info['host']};
        dbname={$db_info['database']};
        charset={$config['db_charset']}";

// Connect to database
try {
    $pdo = new PDO($dsn, $db_info['username'], $db_info['password'], 
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($pdo) {
        echo "Successfully connected to database.<br>";
    }

} catch (PDOException $e) {
    echo "Oops! Something went wrong. Please try again later.<br>"; // Handle user-friendly error
}

// Create users table if there is none

$query = "SHOW TABLES LIKE 'users'";
$statement = $pdo->query($query);

if ($statement->rowCount() == 0) {
    $statement = 
        'CREATE TABLE users(
        id INT AUTO_INCREMENT,
        username VARCHAR(16) NOT NULL,
        password VARCHAR(256) NOT NULL,
        join_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
        );';
    $pdo->exec($statement);
    echo "Table 'users' created successfully!<br>";
} else {
    echo "Table 'users' already exists.<br>";
}

return $pdo; // Return pdo to be used in other scripts

?>