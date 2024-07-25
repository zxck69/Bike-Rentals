<?php
// Define variables to hold error messages and user data
$successMessage = '';
$errorMessage = '';

// Connect to the database
$servername = "localhost";
$username = "root";
$dbpassword = "";
$database = "bike";

// Create a new MySQLi instance
$conn = mysqli_connect($servername, $username, $dbpassword, $database);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate and sanitize the user input
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  $profilePicture = $_FILES['profile_picture']['name'];
  $identification = $_FILES['identification']['name'];
  $license = $_FILES['license']['name'];

  // Validate the form inputs
  $isValid = true;
  $errors = [];

  if (empty($name)) {
    $isValid = false;
    $errors['name'] = 'Name is required.';
  }

  if (empty($email)) {
    $isValid = false;
    $errors['email'] = 'Email is required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $isValid = false;
    $errors['email'] = 'Invalid email format.';
  }

  if (empty($phone)) {
    $isValid = false;
    $errors['phone'] = 'Phone number is required.';
  } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
    $isValid = false;
    $errors['phone'] = 'Invalid phone number. Please enter a 10-digit phone number.';
  }

  if (empty($password)) {
    $isValid = false;
    $errors['password'] = 'Password is required.';
  }

  if (empty($confirmPassword)) {
    $isValid = false;
    $errors['confirm_password'] = 'Confirm password is required.';
  } elseif ($password !== $confirmPassword) {
    $isValid = false;
    $errors['confirm_password'] = 'Passwords do not match.';
  }

  if (empty($address)) {
    $isValid = false;
    $errors['address'] = 'Address is required.';
  }

  if (empty($profilePicture)) {
    $isValid = false;
    $errors['profile_picture'] = 'Profile picture is required.';
  }

  if (empty($identification)) {
    $isValid = false;
    $errors['identification'] = 'Identification document is required.';
  }

  if (empty($license)) {
    $isValid = false;
    $errors['license'] = "Driver's license is required.";
  }

  if (!empty($email)) {
    $sqlCheckEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sqlCheckEmail);
    if (mysqli_num_rows($result) > 0) {
      $isValid = false;
      $errors['email'] = 'Email already exists. Please use a different email.';
    }
  }

// If all inputs are valid, proceed with database operations

if ($isValid) {
    // Check connection
    if (!$conn) {
      die("Failed to connect to the database: " . mysqli_connect_error());
    }

    // Generate unique names for images
    $profilePictureExtension = pathinfo($profilePicture, PATHINFO_EXTENSION);
    $identificationExtension = pathinfo($identification, PATHINFO_EXTENSION);
    $licenseExtension = pathinfo($license, PATHINFO_EXTENSION);

    $uniqueProfilePictureName = uniqid() . '.' . $profilePictureExtension;
    $uniqueIdentificationName = uniqid() . '.' . $identificationExtension;
    $uniqueLicenseName = uniqid() . '.' . $licenseExtension;

    // Prepare the SQL statement
    $sql = "INSERT INTO users (name, email, phone, address, password, profile_picture, identification, license) VALUES ('$name', '$email', '$phone', '$address', '$password', '$uniqueProfilePictureName', '$uniqueIdentificationName', '$uniqueLicenseName')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
      // Registration successful
      $successMessage = "Registration successful. You can now <a href='login.php'>login</a>.";

      // Move uploaded files to the server
      $targetDirectory = "uploads/";

      // Move profile picture
      $targetFilePathProfile = $targetDirectory . "profile/" . $uniqueProfilePictureName;
      move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePathProfile);

      // Move identification document
      $targetFilePathIdentification = $targetDirectory . "identification/" . $uniqueIdentificationName;
      move_uploaded_file($_FILES["identification"]["tmp_name"], $targetFilePathIdentification);

      // Move driver's license
      $targetFilePathLicense = $targetDirectory . "license/" . $uniqueLicenseName;
      move_uploaded_file($_FILES["license"]["tmp_name"], $targetFilePathLicense);
    } else {
      // Handle database error
      $errorMessage = "Error: " . mysqli_error($conn);
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
  <title>User Registration</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    html,
    body {
      height: 100%;
      margin-top: 55px;
    }
  </style>
  <script>
    function validatePhoneNumber() {
      var phoneNumberInput = document.getElementById("phone");
      var phoneNumber = phoneNumberInput.value.trim();

      // Regular expression for validating a phone number
      var phoneRegex = /^[0-9]{10}$/;

      if (!phoneRegex.test(phoneNumber)) {
        phoneNumberInput.setCustomValidity("Invalid phone number. Please enter a 10-digit phone number.");
      } else {
        phoneNumberInput.setCustomValidity("");
      }
    }
  </script>
</head>

<body>
  <div class="container">
  <div class="row justify-content-center">
      <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">User Registration</h2>
        <?php if ($successMessage === ''): ?>
          <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
              <?php if (isset($errors['name'])): ?>
                <div class="text-danger"><?php echo $errors['name']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
              <?php if (isset($errors['email'])): ?>
                <div class="text-danger"><?php echo $errors['email']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number:</label>
              <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" oninput="validatePhoneNumber()" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
              <small class="form-text text-muted">Please enter a 10-digit phone number.</small>
              <?php if (isset($errors['phone'])): ?>
                <div class="text-danger"><?php echo $errors['phone']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="address">Present Address:</label>
              <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
              <?php if (isset($errors['address'])): ?>
                <div class="text-danger"><?php echo $errors['address']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password">
              <?php if (isset($errors['password'])): ?>
                <div class="text-danger"><?php echo $errors['password']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password">
              <?php if (isset($errors['confirm_password'])): ?>
                <div class="text-danger"><?php echo $errors['confirm_password']; ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="profile_picture">Profile Picture:</label>
              <input type="file" class="form-control" id="profile_picture" name="profile_picture">
              <?php if (isset($errors['profile_picture'])): ?>
                <div class="text-danger"><?php echo $errors['profile_picture']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="identification">Identification Document:</label>
              <label for="identification">(eg: Adhar Card/PAN Card/ Any Other Document) </label>
              <input type="file" class="form-control" id="identification" name="identification">
              <?php if (isset($errors['identification'])): ?>
                <div class="text-danger"><?php echo $errors['identification']; ?></div>
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="license">Driver's License:</label>
              <input type="file" class="form-control" id="license" name="license">
              <?php if (isset($errors['license'])): ?>
                <div class="text-danger"><?php echo $errors['license']; ?></div>
              <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <p class="card-text text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
          </form>
        <?php else: ?>
          <p class="text-success text-center">
            <?php echo $successMessage; ?>
          </p>
          <p class="card-text text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
  </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    function validateForm() {
      var nameInput = document.getElementById("name");
      var emailInput = document.getElementById("email");
      var phoneInput = document.getElementById("phone");
      var passwordInput = document.getElementById("password");
      var confirmPasswordInput = document.getElementById("confirm_password");
      var addressInput = document.getElementById("address");
      var profilePictureInput = document.getElementById("profile_picture");
      var identificationInput = document.getElementById("identification");
      var licenseInput = document.getElementById("license");

      // Reset error messages
      document.getElementById("nameError").innerHTML = "";
      document.getElementById("emailError").innerHTML = "";
      document.getElementById("phoneError").innerHTML = "";
      document.getElementById("passwordError").innerHTML = "";
      document.getElementById("confirmPasswordError").innerHTML = "";
      document.getElementById("addressError").innerHTML = "";
      document.getElementById("profilePictureError").innerHTML = "";
      document.getElementById("identificationError").innerHTML = "";
      document.getElementById("licenseError").innerHTML = "";

      // Validate inputs
      var isValid = true;

      if (nameInput.value.trim() === "") {
        document.getElementById("nameError").innerHTML = "Name is required.";
        isValid = false;
      }

      if (emailInput.value.trim() === "") {
        document.getElementById("emailError").innerHTML = "Email is required.";
        isValid = false;
      } else if (!isValidEmail(emailInput.value.trim())) {
        document.getElementById("emailError").innerHTML = "Invalid email format.";
        isValid = false;
      }

      if (phoneInput.value.trim() === "") {
        document.getElementById("phoneError").innerHTML = "Phone number is required.";
        isValid = false;
      } else if (!isValidPhoneNumber(phoneInput.value.trim())) {
        document.getElementById("phoneError").innerHTML = "Invalid phone number. Please enter a 10-digit phone number.";
        isValid = false;
      }

      if (passwordInput.value.trim() === "") {
        document.getElementById("passwordError").innerHTML = "Password is required.";
        isValid = false;
      }

      if (confirmPasswordInput.value.trim() === "") {
        document.getElementById("confirmPasswordError").innerHTML = "Confirm password is required.";
        isValid = false;
      } else if (confirmPasswordInput.value.trim() !== passwordInput.value.trim()) {
        document.getElementById("confirmPasswordError").innerHTML = "Passwords do not match.";
        isValid = false;
      }

      if (addressInput.value.trim() === "") {
        document.getElementById("addressError").innerHTML = "Address is required.";
        isValid = false;
      }

      if (profilePictureInput.value.trim() === "") {
        document.getElementById("profilePictureError").innerHTML = "Profile picture is required.";
        isValid = false;
      }

      if (identificationInput.value.trim() === "") {
        document.getElementById("identificationError").innerHTML = "Identification document is required.";
        isValid = false;
      }

      if (licenseInput.value.trim() === "") {
        document.getElementById("licenseError").innerHTML = "Driver's license is required.";
        isValid = false;
      }

      return isValid;
    }

    function isValidEmail(email) {
      var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      return emailRegex.test(email);
    }

    function isValidPhoneNumber(phone) {
      var phoneRegex = /^[0-9]{10}$/;
      return phoneRegex.test(phone);
    }
  </script>
</body>

</html>
