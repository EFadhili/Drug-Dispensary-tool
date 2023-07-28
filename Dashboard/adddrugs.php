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
    $drugName = $_POST["drug_name"];
    $unitQuantity = $_POST["unit_quantity"];
    $units = $_POST["units"];
    $unitPrice = $_POST["unit_price"];

    $stmt = $conn->prepare("INSERT INTO drugs (drug_name, unit_quantity, units, unit_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $drugName, $unitQuantity, $units, $unitPrice);

    for ($i = 0; $i < count($_POST["drug_name"]); $i++) {
        $drugName = mysqli_real_escape_string($conn, htmlspecialchars($_POST["drug_name"][$i]));
        $unitQuantity = intval($_POST["unit_quantity"][$i]);
        $units = mysqli_real_escape_string($conn, htmlspecialchars($_POST["units"][$i]));
        $unitPrice = floatval($_POST["unit_price"][$i]);

        $stmt->execute();
    }

    
    $stmt->close();

    header("Location: phamdash.php");
    exit();
}

$conn->close();
?>

