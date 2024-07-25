<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  // User is not logged in, redirect to login page
  header("Location: login.php");
  exit;
}else{
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Another Page</title>
  <!-- Include your CSS stylesheets -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center">Welcome to Another Page</h1>
    <p>You have successfully logged in!</p>
    <a href="logout.php" class="btn btn-primary">Logout</a>
  </div>
</body>
</html>
