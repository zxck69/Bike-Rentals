<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $dbpassword = ""; // Replace with your database password
    $dbname = "bike";

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

    // Validate and sanitize the user input
    $email = $_POST['email']; // Corrected variable name
    $password = $_POST['password'];

    // Check the email and password in the admin table
    $query = "SELECT * FROM admin WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email); // Corrected variable name
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Admin login successful, redirect to home.php
        $_SESSION['id'] = $result['id'];
        header("Location: home.php");
        exit();
    } else {
        $errorMessage = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
    }

    .container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: 500;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }

    .text-danger {
      color: red;
      text-align: center; /* Center the text horizontally */
    }
    .register-link {
      text-align: center;
      margin-top: 10px;
    }

    .register-link a {
      color: #007bff;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center mb-4">Admin Login</h2>
    <span class="text-danger">
        <?php echo isset($errorMessage) ? $errorMessage : ''; ?>
      </span>
    <form action="" method="POST">
      <div class="form-group">
        <label for="username">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Login</button>
      
    </form>
    <div class="register-link">
      Don't have an account? <a href="admin_registration.php">Register here</a>
    </div>
  </div>
</body>

</html>
