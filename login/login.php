<?php
session_start();

// Check if the user submitted the login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the username and password (you can replace this with your own validation logic)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are correct (this is just an example, replace it with your authentication logic)
    if ($username === 'admin' && $password === 'password') {
        // Credentials are valid, set the logged_in session variable
        $_SESSION['logged_in'] = true;

        // Redirect to the application page
        header("Location: application.php");
        exit;
    } else {
        // Credentials are invalid, display an error message
        $error = "Invalid username or password";
    }
}

// If the user is not logged in or login failed, display the login form
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
