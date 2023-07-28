<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doctor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $phone_number = $_POST["phone_number"];
  $gender = $_POST["gender"];
  $appointment_date = $_POST["appointment_date"];

  $sql = "INSERT INTO doctor.appointments (first_name, last_name, phone_number, gender, appointment_date) VALUES ('$first_name', '$last_name', '$phone_number', '$gender', '$appointment_date')";

  if ($conn->query($sql) === TRUE) {
    echo "Appointment successfully created";
    header("Location: patdash.php");
    exit();
  } else {
    echo "Error creating appointment: " . $conn->error;
  }
}

$conn->close();
?>
