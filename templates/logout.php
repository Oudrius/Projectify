<?php

// Log user out
session_start();
$_SESSION = array();
session_destroy();

header('Location: ../'); // Redirect to index page
die;
?>