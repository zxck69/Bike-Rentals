<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirect the user to the success page
    header('Location: handle_booking.php');
    exit;
}
// Define variables to hold error messages and user data
$emailError = $passwordError = '';
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate and sanitize the user input
  $email = $_POST['email'];
  $password = $_POST['password'];
  

  
  // Perform basic validation
  if (empty($email)) {
    $emailError = "Email is required.";
  }

  if (empty($password)) {
    $passwordError = "Password is required.";
  }

  // If there are no errors, perform database operations (matching email and password) here
  if (empty($emailError) && empty($passwordError)) {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $dbpassword = ""; // Changed the variable name to avoid conflict
    $database = "bike";

    // Create a new MySQLi instance
    $conn = mysqli_connect($servername, $username, $dbpassword, $database);

    // Check connection
    if (!$conn) {
      die("Failed to connect to the database: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if a matching user is found
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
      
      // Login successful
      mysqli_close($conn);
      $_SESSION['loggedin'] = true;
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['name'] = $row['name'];
      header("Location: index.php");
      exit();
    } else {
      // Login failed
      $errorMessage = "Invalid email or password.";
    }

    // Close the database connection
    mysqli_close($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>User Login</title>
 
   
  <style> 
    .container {
      max-width: 400px;
      margin-top: 100px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">User Login</h2>
        <?php if ($errorMessage !== ''): ?>
          <div class="alert alert-danger">
            <?php echo $errorMessage; ?>
          </div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <span class="text-danger">
              <?php echo $emailError; ?>
            </span>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <span class="text-danger">
              <?php echo $passwordError; ?>
            </span>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center mt-2">Don't have an account?<a href="userregistration.php"> Register here</a></p>
      </div>
    </div>
  </div>
</body>

</html>