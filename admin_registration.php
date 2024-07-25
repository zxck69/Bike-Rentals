<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define variables to hold error messages and user data
    $nameError = $emailError = $passwordError = $confirmPasswordError = $errorMessage = $successMessage = '';

    // Validate and sanitize the user input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Perform basic validation
    if (empty($name)) {
        $nameError = "Name is required.";
    }

    if (empty($email)) {
        $emailError = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
    }

    if (empty($password)) {
        $passwordError = "Password is required.";
    } elseif (strlen($password) < 6) {
        $passwordError = "Password must be at least 6 characters long.";
    }

    if (empty($confirmPassword)) {
        $confirmPasswordError = "Confirm Password is required.";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match.";
    }

    // If there are no errors, perform database operations here
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $dbpassword = ""; // Replace with your database password
        $dbname = "bike";

        // Create a new PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

        // Check if the email already exists in the admin table
        $checkEmailQuery = "SELECT * FROM admin WHERE email = :email";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $errorMessage = "Email already exists. Please use a different email.";
        } else {
            // Insert the data into the admin table
            $insertQuery = "INSERT INTO admin (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                // Registration successful
                $successMessage = "Registration successful.";
            } else {
                $errorMessage = "Failed to register. Please try again.<\br>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration</title>
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
    input[type="email"],
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
    }

    .text-success {
      color: green;
    }

    .login-link {
      text-align: center;
      margin-top: 10px;
    }

    .login-link a {
      color: #007bff;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="text-center mb-4">Admin Registration</h2>
    <span class="text-success">
        <?php echo isset($successMessage) ? $successMessage : ''; ?>
      </span>
      <span class="text-danger">
        <?php echo isset($errorMessage) ? $errorMessage : ''; ?>
      </span>
    <form action="" method="POST">
      <div class="form-group">
        <br>
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
        <span class="text-danger">
          <?php echo isset($nameError) ? $nameError : ''; ?>
        </span>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <span class="text-danger">
          <?php echo isset($emailError) ? $emailError : ''; ?>
        </span>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <span class="text-danger">
          <?php echo isset($passwordError) ? $passwordError : ''; ?>
        </span>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        <span class="text-danger">
          <?php echo isset($confirmPasswordError) ? $confirmPasswordError : ''; ?>
        </span>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Register</button>
      
    </form>
    <div class="login-link">
      Already have an account? <a href="admin_login.php">Login here</a>
    </div>
  </div>
</body>

</html>
