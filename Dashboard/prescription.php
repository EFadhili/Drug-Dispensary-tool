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
    $drugNames = $_POST["drug_name"];
    $quantitiesPerDose = $_POST["quantity_per_dose"];
    $dosesPerDay = $_POST["times_per_day"];
    $totalQuantities = $_POST["total_quantity"];
    $medicationTypes = $_POST["medication_type"];
    $patientId = $_POST["patient_id"];

    $stmt = $conn->prepare("INSERT INTO prescriptions (appointment_id, drug_name, quantity_per_dose, dose_per_day, total_quantity, medication_type) VALUES (?, ?, ?, ?, ?, ?)");

    // Loop through each prescription entry and insert it into the database
    for ($i = 0; $i < count($drugNames); $i++) {
        $drugName = $drugNames[$i];
        $quantityPerDose = $quantitiesPerDose[$i];
        $dosePerDay = $dosesPerDay[$i];
        $totalQuantity = $totalQuantities[$i];
        $medicationType = $medicationTypes[$i];

        // Bind the parameters to the statement
        $stmt->bind_param("isiiis", $patientId, $drugName, $quantityPerDose, $dosePerDay, $totalQuantity, $medicationType);

        // Execute the statement
        $stmt->execute();
    }

    // Close the statement
    $stmt->close();

    // Redirect to the "docdash.php" page
    header("Location: docdash.php");
    exit();
}

$conn->close();
?>

