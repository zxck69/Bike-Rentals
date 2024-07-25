<?php
session_start();

// Check if the admin_id session variable is set
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>Update Vehicle</title>
  <style>
    .container {
      margin-top: 30px;
    }
    .card {
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-group label {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php
  // Database connection parameters
  $servername = "localhost";
  $username = "root";
  $dbpassword = "";
  $dbname = "bike";

  // Create a new PDO instance
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

  // Check if the vehicle ID is provided in the URL
  if (isset($_GET['vehicle_id'])) {
    // Retrieve the vehicle ID from the URL
    $vehicleId = $_GET['vehicle_id'];

    // Fetch vehicle data from the database based on the vehicle ID
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :id");
    $stmt->bindParam(':id', $vehicleId);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the vehicle with the provided ID exists
    if (!$vehicle) {
      echo "Vehicle not found";
      exit;
    }
  } else {
    echo "Vehicle ID not provided";
    exit;
  }

  // Fetch all distinct vehicle types from the database
  $typesStmt = $conn->prepare("SELECT DISTINCT type FROM vehicles");
  $typesStmt->execute();
  $types = $typesStmt->fetchAll(PDO::FETCH_COLUMN);
  
  // Handle the form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and update the vehicle data
    $type = $_POST["type"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $color = $_POST["color"];
    $year = $_POST["year"];
    $price = $_POST["price"];
    $description = $_POST["description"];
  
    // Check if a new image was uploaded
    if ($_FILES['image']['name']) {
      // Directory where uploaded images will be saved
      $uploadDirectory = './uploads/vehicles/';
  
      // Get the name of the uploaded image
      $imageName = $_FILES['image']['name'];
  
      // Get the temporary location of the uploaded image
      $imageTmpPath = $_FILES['image']['tmp_name'];
  
      // Generate a unique name for the image to avoid overwriting existing images
      $imageUniqueName = uniqid() . '_' . $imageName;
  
      // Create the full path to the new image file
      $newImagePath = $uploadDirectory . $imageUniqueName;
  
      // Move the uploaded image to the new location
      if (move_uploaded_file($imageTmpPath, $newImagePath)) {
        // Delete the previous image if it exists
        if (file_exists($uploadDirectory . $vehicle['image'])) {
          unlink($uploadDirectory . $vehicle['image']);
        }
  
        // Update the vehicle's image path in the database
        $imagePath = $imageUniqueName;
      } else {
        echo "Error uploading image.";
        exit;
      }
    } else {
      // If no new image was uploaded, use the existing image path
      $imagePath = $vehicle['image'];
    }
  
    // Perform the update query
    $updateStmt = $conn->prepare("UPDATE vehicles SET type = :type, brand = :brand, model = :model, color = :color, year = :year, price = :price, description = :description, image = :image WHERE id = :id");
    $updateStmt->bindParam(':type', $type);
    $updateStmt->bindParam(':brand', $brand);
    $updateStmt->bindParam(':model', $model);
    $updateStmt->bindParam(':color', $color);
    $updateStmt->bindParam(':year', $year);
    $updateStmt->bindParam(':price', $price);
    $updateStmt->bindParam(':description', $description);
    $updateStmt->bindParam(':image', $imagePath); // Use the new image path
    $updateStmt->bindParam(':id', $vehicleId);
  
    if ($updateStmt->execute()) {
      // Redirect to the view_all_vehicle.php page after successful update
      header('Location: view_all_vehicle.php');
      exit;
    } else {
      echo "Error updating vehicle: " . $conn->errorInfo()[2];
    }
  }
  ?>

  <div class="container">
    <div class="card">
      <h1>Update Vehicle</h1>
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="type">Vehicle Type:</label>
          <select class="form-control" id="type" name="type" required>
            <?php
              foreach ($types as $typeOption) {
                $selected = ($typeOption === $vehicle['type']) ? 'selected' : '';
                echo "<option value='$typeOption' $selected>$typeOption</option>";
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="brand">Brand:</label>
          <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $vehicle['brand']; ?>" required>
        </div>
        <div class="form-group">
          <label for="model">Model:</label>
          <input type="text" class="form-control" id="model" name="model" value="<?php echo $vehicle['model']; ?>" required>
        </div>
        <div class="form-group">
          <label for="color">Color:</label>
          <input type="text" class="form-control" id="color" name="color" value="<?php echo $vehicle['color']; ?>" required>
        </div>
        <div class="form-group">
          <label for="year">Year:</label>
          <input type="number" class="form-control" id="year" name="year" value="<?php echo $vehicle['year']; ?>" required>
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="number" class="form-control" id="price" name="price" value="<?php echo $vehicle['price']; ?>" required>
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" id="description" name="description" required><?php echo $vehicle['description']; ?></textarea>
        </div>
        <div class="form-group">
          <label for="image">New Image Upload:</label>
          <input type="file" class="form-control-file" id="image" name="image">
          <br>
          <img src="./uploads/vehicles/<?php echo $vehicle['image']; ?>" alt="Vehicle Image" style="max-height: 200px; max-width: 200px;">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="view_all_vehicle.php" class="btn btn-danger">Cancel</a>
      </form>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
