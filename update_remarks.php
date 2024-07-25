<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "bike";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the selected status and the user's ID
  $status = $_POST['status'];
  $userId = $_POST['user_id'];

  // Update the status for the user in the database
  $stmt = $conn->prepare("UPDATE users SET status = :status WHERE id = :id");
  $stmt->bindParam(':status', $status);
  $stmt->bindParam(':id', $userId);
  $stmt->execute();

  // Check if the "remarks" key exists in the $_POST array
  if (isset($_POST['remarks'])) {
    $remarks = $_POST['remarks'];
  } else {
    // Set a default value for remarks if it doesn't exist in the $_POST array
    $remarks = '';
  }

  // Update the remarks for the user in the database
  $stmt = $conn->prepare("UPDATE users SET remarks = :remarks WHERE id = :id");
  $stmt->bindParam(':remarks', $remarks);
  $stmt->bindParam(':id', $userId);
  $stmt->execute();

  // Send a response back to the client
//   echo "Remarks updated successfully.";
header("Location: customer_details.php");
}
