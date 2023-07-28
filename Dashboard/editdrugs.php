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
  if (isset($_POST["delete"])) {
    $DrugId = $_POST["drug_id"];
    // Sanitize user input to prevent SQL injection
    $DrugId = $conn->real_escape_string($DrugId);

    $sql = "DELETE FROM drugs WHERE drug_id='$DrugId'";

    if ($conn->query($sql) === TRUE) {
      echo "Drug deleted successfully";
      header("Location: admindash.php");
      exit();
    } else {
      echo "Error deleting drug: " . $conn->error;
    }
  } else {
    $DrugId = $_POST["drug_id"];
    $Drug = $_POST["drug_name"];
    $Quantity = $_POST["unit_quantity"];
    $Units = $_POST["units"];
    $Price = $_POST["unit_price"];

    // Sanitize user inputs to prevent SQL injection
    $DrugId = $conn->real_escape_string($DrugId);
    $Drug = $conn->real_escape_string($Drug);
    $Quantity = $conn->real_escape_string($Quantity);
    $Units = $conn->real_escape_string($Units);
    $Price = $conn->real_escape_string($Price);

    $sql = "UPDATE drugs SET drug_name='$Drug', unit_quantity='$Quantity', units='$Units', unit_price='$Price' WHERE drug_id='$DrugId'";

    if ($conn->query($sql) === TRUE) {
      echo "Update complete";
      header("Location: phamdrugs.php");
      exit();
    } else {
      echo "Error updating drug: " . $conn->error;
    }
  }
} else {
  // The code to view drug details should be executed only when not submitting the form.
  // If you are using $_POST for viewing drug details, change it to $_GET or $_REQUEST here.
  if (isset($_GET["drug_id"])) {
    $DrugId = $_GET["drug_id"];
    // Sanitize user input to prevent SQL injection
    $DrugId = $conn->real_escape_string($DrugId);

    $sql = "SELECT * FROM drugs WHERE drug_id='$DrugId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $DrugId = $row["drug_id"];
      $Drug = $row["drug_name"];
      $Quantity = $row["unit_quantity"];
      $Units = $row["units"];
      $Price = $row["unit_price"];
    } else {
      echo "Invalid drug ID";
      exit();
    }
  } else {
    // If the drug_id is not set in the URL (when not viewing), set default empty values.
    $DrugId = "";
    $Drug = "";
    $Quantity = "";
    $Units = "";
    $Price = "";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="edit.css">
  <title>Edit Drug</title>
</head>
<body>
<div class="container">
    <h1>Edit Drug</h1>
    <form method="POST" action="editdrugs.php">
      <div class="form-group">
        <label for="drug_id">Drug ID:</label>
        <input type="text" id="drug_id" name="drug_id" value="<?php echo $DrugId; ?>" required>
      </div>
      <div class="form-group">
        <label for="drug_name">Drug Name:</label>
        <input type="text" id="drug_name" name="drug_name" value="<?php echo $Drug; ?>" required>
        <!-- Add a hidden input field to store the original drug_name -->
        <input type="hidden" name="original_drug_name" value="<?php echo $Drug; ?>">
      </div>
      <div class="form-group">
        <label for="unit_quantity">Unit Quantity:</label>
        <input type="text" id="unit_quantity" name="unit_quantity" value="<?php echo $Quantity; ?>" required>
      </div>
      <div class="form-group">
        <label for="units">Units:</label>
        <input type="text" id="units" name="units" value="<?php echo $Units; ?>" required>
      </div>
      <div class="form-group">
        <label for="unit_price">Unit Price:</label>
        <input type="text" id="unit_price" name="unit_price" value="<?php echo $Price; ?>" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Update">
        <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this drug?');">
      </div>
    </form>
</div>
</body>
</html>
