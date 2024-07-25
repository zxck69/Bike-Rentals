<?php
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
  $targetDirectory = 'image/'; // Directory where you want to store the uploaded images
  $targetFile = $targetDirectory . $uniqueImageName; // Path of the uploaded image file

  // Check if the image file is uploaded successfully
  if (!empty($image) && is_uploaded_file($image)) {
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
    if ($stmt->execute() && move_uploaded_file($image, $targetFile)) {
      $message = "Data inserted successfully. Image uploaded successfully";
      $isSuccess = true;
    } else {
      $message = "Failed to insert data or upload the image";
      $isSuccess = false;
    }
  } else {
    $message = "Failed to upload the image";
    $isSuccess = false;
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
  <title>Add Vehicle Form</title>
</head>

<body>
  <?php include 'admin.php'; ?>

  <div class="container">
    <div class="card">
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <h1 class="text-center">Add New Vehicle</h1>
          <!-- Show message -->
          <?php if ($message !== ""): ?>
            <div class="alert <?php echo ($isSuccess) ? "alert-success" : "alert-danger"; ?> text-center">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>
          <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" id="type" name="type" onchange="updateType(this)">
              <option value="Bike">Bike</option>
              <option value="Scooter">Scooter</option>
            </select>
          </div>
          <div class="form-group">
            <label for="selectedType">Selected Type:</label>
            <input type="text" class="form-control" id="selectedType" name="selectedType" readonly>
          </div>
          <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter brand">
          </div>
          <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="Enter model">
          </div>
          <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" class="form-control" id="color" name="color" placeholder="Enter color">
          </div>
          <div class="form-group">
            <label for="year">Year:</label>
            <input type="text" class="form-control" id="year" name="year" placeholder="Enter year">
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Enter price">
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"
              placeholder="Enter description"></textarea>
          </div>
          <div class="form-group">
            <label for="vehicleImage">Vehicle Image Upload:</label>
            <input type="file" class="form-control-file" id="vehicleImage" name="vehicleImage">
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
  </script>
</body>

</html>