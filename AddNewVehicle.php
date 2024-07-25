<?php
session_start();

// Check if the admin_id session variable is set
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
// Initialize the message variable
$message = "";
$isSuccess = false;

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bike";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $type = $_POST['type'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $color = $_POST['color'];
  $year = $_POST['year'];
  $price = $_POST['price'];
  $description = $_POST['description'];

  // Handle file upload
  $image = $_FILES['vehicleImage']['tmp_name']; // Temporary location of the uploaded file
  $imageName = $_FILES['vehicleImage']['name']; // Original name of the uploaded file
  $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION); // Get the file extension

  // Generate a unique name for the image
  $uniqueImageName = uniqid() . '.' . $imageExtension;

  // Set the target file path with the unique image name
  $targetDirectory = 'uploads/vehicles/'; // Directory where you want to store the uploaded images
  $targetFile = $targetDirectory . $uniqueImageName; // Path of the uploaded image file

  // Validate form fields
  $isValid = true;

  if (empty($type)) {
    $message .= "Please select a type.<br>";
    $isValid = false;
  }

  if (empty($brand)) {
    $message .= "Brand field is required.<br>";
    $isValid = false;
  }

  // Add validation for other fields

  // Check if the image file is uploaded successfully
  if (empty($image) || !is_uploaded_file($image)) {
    $message .= "Please upload an image.<br>";
    $isValid = false;
  }

  // Insert data and upload image if the form is valid
  if ($isValid) {
    // Read the file content
    $imageData = file_get_contents($image);

    // Insert the data into the database
    $stmt = $conn->prepare("INSERT INTO vehicles (type, brand, model, color, year, price, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $type);
    $stmt->bindParam(2, $brand);
    $stmt->bindParam(3, $model);
    $stmt->bindParam(4, $color);
    $stmt->bindParam(5, $year);
    $stmt->bindParam(6, $price);
    $stmt->bindParam(7, $description);
    $stmt->bindParam(8, $uniqueImageName); // Save the unique image name in the database instead of image content

    // Check if the data insertion and file upload are successful
    if ($stmt->execute()) {
      // Create the target directory if it doesn't exist
      if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
      }

      // Move the uploaded file to the target directory
      if (move_uploaded_file($image, $targetFile)) {
        $message = "Data inserted successfully. Image uploaded successfully!";
        $isSuccess = true;
      } else {
        $message = "Failed to move the uploaded file!";
        $isSuccess = false;
      }
    } else {
      $message = "Failed to insert data into the database!";
      $isSuccess = false;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
     body {
      /* display: flex; */
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    html,
    body {
      0
      /* margin-top: 55px; */
      font-size: 11px;
    } 
    .card {
      margin-top: 20px;
      /* padding-block: 54px; */
      /* display: flex;  */
    }
    .form-group label {
      /* Increase font size for labels */
      font-size: 12px;
    }
    .form-control {
      /* Increase font size for form fields */
      font-size: 12px;
    }
   
    
  </style>
   
  </style>
  <title>Add New Vehicle Form</title>
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</head>

<body>
  

  <div class="container">
    <div class="card" style="width: 100%; padding-block: 0px;">
      <div class="card-body"> 
        <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()">
          <h1 class="text-center">Add New Vehicle</h1>
          <!-- Show message -->
          <?php if ($message !== ""): ?>
            <div class="alert <?php echo ($isSuccess) ? "alert-success" : "alert-danger"; ?>">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>
          <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" id="type" name="type" onchange="updateType(this)">
              <option value="">Select Type</option>
              <option value="Bike">Bike</option>
              <option value="Scooter">Scooter</option>
            </select>
            <div id="typeError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="selectedType">Selected Type:</label>
            <input type="text" class="form-control" id="selectedType" name="selectedType" readonly>
          </div>
          <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter brand">
            <div id="brandError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="Enter model">
            <div id="modelError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" class="form-control" id="color" name="color" placeholder="Enter color">
            <div id="colorError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" class="form-control" id="year" name="year" placeholder="Enter year">
            <div id="yearError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
            <div id="priceError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"
              placeholder="Enter description"></textarea>
            <div id="descriptionError" class="text-danger"></div>
          </div>
          <div class="form-group">
            <label for="vehicleImage">Vehicle Image Upload:</label>
            <input type="file" class="form-control-file" id="vehicleImage" name="vehicleImage">
            <div id="imageError" class="text-danger"></div>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary center-btn">Add Vehicle</button>
            <button type="reset" class="btn btn-danger center-btn">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    function updateType(selectElement) {
      var selectedType = selectElement.value;
      document.getElementById("selectedType").value = selectedType;
    }

    function validateForm() {
      var type = document.getElementById("type").value;
      var brand = document.getElementById("brand").value;
      var model = document.getElementById("model").value;
      var color = document.getElementById("color").value;
      var year = document.getElementById("year").value;
      var price = document.getElementById("price").value;
      var description = document.getElementById("description").value;
      var image = document.getElementById("vehicleImage").value;

      // Reset error messages
      document.getElementById("typeError").innerHTML = "";
      document.getElementById("brandError").innerHTML = "";
      document.getElementById("modelError").innerHTML = "";
      document.getElementById("colorError").innerHTML = "";
      document.getElementById("yearError").innerHTML = "";
      document.getElementById("priceError").innerHTML = "";
      document.getElementById("descriptionError").innerHTML = "";
      document.getElementById("imageError").innerHTML = "";

      // Perform validation
      var isValid = true;

      if (type === "") {
        document.getElementById("typeError").innerHTML = "Please select a type";
        isValid = false;
      }

      if (brand === "") {
        document.getElementById("brandError").innerHTML = "Brand field is required";
        isValid = false;
      }

      if (model === "") {
        document.getElementById("modelError").innerHTML = "Model field is required";
        isValid = false;
      }

      if (color === "") {
        document.getElementById("colorError").innerHTML = "Color field is required";
        isValid = false;
      }

      if (year === "") {
        document.getElementById("yearError").innerHTML = "Year field is required";
        isValid = false;
      }

      if (price === "") {
        document.getElementById("priceError").innerHTML = "Price field is required";
        isValid = false;
      }

      if (description === "") {
        document.getElementById("descriptionError").innerHTML = "Description field is required";
        isValid = false;
      }

      if (image === "") {
        document.getElementById("imageError").innerHTML = "Please upload an image";
        isValid = false;
      }

      return isValid;
    }
  </script>
</body>

</html>
