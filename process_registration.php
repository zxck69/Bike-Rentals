<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define variables to hold error messages and user data
    $nameError = $emailError = $passwordError = $confirmPasswordError = '';
    $errorMessage = '';

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
        $confirmPasswordError = "Please confirm the password.";
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match.";
    }

    // If there are no errors, perform database operations (insert user data) here
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmPasswordError)) {
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $dbpassword = "";
        $dbname = "bike";

        // Create a new PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

        // Prepare the SQL statement to check if the email already exists
        $sql = "SELECT id FROM admin WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Check if the email already exists in the database
        if ($stmt->rowCount() > 0) {
            $errorMessage = "Email already exists. Please use a different email.";
        } else {
            // Insert the new user data into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                // Registration successful
                // You can redirect the user to a success page or login page
                header("Location: login.php");
                exit();
            } else {
                // Registration failed
                $errorMessage = "Registration failed. Please try again later.";
            }
        }

        // Close the database connection
        $conn = null;
    }
}
?>