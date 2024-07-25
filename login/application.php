<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit;
}

// If the user is logged in, display the application page
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application</title>
</head>
<body>
    <h1>Application</h1>
    <p>Welcome! You can fill out the job application form here.</p>
</body>
</html>
