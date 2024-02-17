<?php

require 'init.php';

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

$query = "SHOW TABLES LIKE 'projects'";
$statement = $pdo->query($query);

if ($statement->rowCount() == 0) {
    $statement = 
        'CREATE TABLE projects(
        id INT AUTO_INCREMENT,
        title VARCHAR(320) NOT NULL,
        description VARCHAR(2000),
        create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        status ENUM("In progress", "Abandoned", "Finished") NOT NULL DEFAULT "In progress",
        user_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        PRIMARY KEY(id)
        );';
    $pdo->exec($statement);
    echo "Table 'projects' created successfully!";
} else {
    echo "Table 'projects' already exists.";
}

?>