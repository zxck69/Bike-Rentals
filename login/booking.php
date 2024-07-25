<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Process the booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Perform the necessary booking logic
  // ...
  // Redirect to another page (e.g., confirmation.php)
  header("Location: confirmation.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Form</title>
  <!-- Include your CSS stylesheets -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center">Booking Form</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <!-- Input fields for the booking form -->
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
      </div>

      <!-- Other input fields for the booking form -->
      <!-- ... -->

      <!-- "Book Now" button -->
      <button type="submit" class="btn btn-primary">Book Now</button>
    </form>
  </div>
</body>
</html>
