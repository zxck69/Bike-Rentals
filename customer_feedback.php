<?php
session_start();

// Check if the admin_id session variable is set
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "bike";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

// Fetch data from the "contact_message" table
$stmt = $conn->prepare("SELECT * FROM contact_messages ORDER BY id DESC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Add the DataTable CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

  <title>Customer Feedback</title>
  <style>
    /* .container {
      margin-top: 30px;
    } */
  </style>
</head>

<body>
  <?php include 'newAdmin.php'; ?>
  <div class="container mt-5">
    <table class="table" id="messagesTable">
            <h1>Customer Feedback </h1>
      <thead>
        <tr>
          <th>Sr No.</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Date and Time</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $index => $message): ?>
          <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo $message['name']; ?></td>
            <td><?php echo $message['email']; ?></td>
            <td><?php echo $message['message']; ?></td>
            <td><?php echo $message['submission_time']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Your footer content goes here -->

  <!-- Add the DataTable JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script>
        $(document).ready(function () {
            $('#messagesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel','print'
                ]
            });
        });
    </script>
</body>
</html>

