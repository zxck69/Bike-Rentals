<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Host = 'smtp.gmail.com'; // Change this to your SMTP server if not using Gmail
  $mail->SMTPAuth = true;
  $mail->Username = 'bikerentals2023@gmail.com'; // Replace with your Gmail username
  $mail->Password = 'mgzohuyyqyoowuyt'; // Replace with your Gmail password
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587; // If using Gmail, use 587 for TLS or 465 for SSL

  $mail->setFrom($email, $name);
  $mail->addAddress('bikerentals2023@gmail.com'); // Replace with your email address to receive messages

  $mail->isHTML(false);
  $mail->Subject = 'Contact Us Message';
  $mail->Body = "Name: $name\nEmail: $email\nMessage: $message";

  if ($mail->send()) {
    // If the message is sent successfully via email, store it in the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bike";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $message = mysqli_real_escape_string($conn, $message);

    // SQL query to insert the form data into the database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
      // Data successfully inserted into the database
    //   echo 'Message sent successfully and stored in the database!';
      header('Location: contact.php?status=success');
    exit();
    } else {
      // Error occurred while inserting data into the database
    //   echo 'Message sent successfully, but there was an error storing it in the database.';
      header('Location: contact.php?status=error');
    
    }

    // Close the database connection
    $conn->close();
  } else {
    // Error occurred while sending the message via email
    // echo 'Sorry, there was an error sending your message. Please try again later.';
    header('Location: contact.php?status=error');
  }
}
?>
