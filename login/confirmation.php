<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  // User is not logged in, redirect to the login page
  header("Location: login.php");
  exit();
}

// Retrieve the user's booking information from the session or database
// ...

// Clear the user_id session variable if needed (e.g., after successful booking)
// unset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center">Booking Confirmation</h1>
    <p>Your booking has been confirmed. Thank you!</p>
    <!-- Display the booking details here -->
  </div>
</body>
</html>
