<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacist";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $drugs = $_POST["drug"];
  $quantities = $_POST["quantity"];
  $units = $_POST["units"];

  $totalPrice = 0;

  for ($i = 0; $i < count($drugs); $i++) {
    $drugName = $drugs[$i];
    $quantity = $quantities[$i];
    $unit = $units[$i];

    // Fetch the unit price from the database
    $stmt = $conn->prepare("SELECT unit_price, unit_quantity FROM drugs WHERE drug_name = ?");
    $stmt->bind_param("s", $drugName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $unitPrice = $row["unit_price"];
    $unitQuantity = $row["unit_quantity"];
    $stmt->close();

    // Calculate the price for this drug
    $price = ($quantity * $unitPrice) / $unitQuantity;
    $totalPrice += $price;

    // Insert data into the "dispensed" table
    $appointmentId = $_POST["appointment_id"];
    $stmt = $conn->prepare("INSERT INTO dispensed (appointment_id, drug_name, quantity, units, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $appointmentId, $drugName, $quantity, $unit, $price);
    $stmt->execute();
    $stmt->close();
  }

  header("Location: phamdash.php");
}

$conn->close();
?>
