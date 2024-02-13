<?php

define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/task_manager/');

// Set up database credentials
return [
    'db' => [
        'host' => 'localhost',
        'database' => 'audrius_db',
        'username' => 'root',
        'password' => '',
    ],
    'db_charset' => 'utf8mb4'
];

?>