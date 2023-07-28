<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Prescription Form</title>
  <link rel="stylesheet" href="prescription.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  
  <script>
    // Function to add a new row for prescription
    function addRow() {
      var prescriptionTable = document.getElementById("prescription-table");
      var newRow = prescriptionTable.insertRow();

      var cell1 = newRow.insertCell();
      var cell2 = newRow.insertCell();
      var cell3 = newRow.insertCell();
      var cell4 = newRow.insertCell();
      var cell5 = newRow.insertCell();
      var cell6 = newRow.insertCell();

      cell1.innerHTML = '<input type="text" name="drug_name[]" required>';
      cell2.innerHTML = '<input type="number" name="quantity_per_dose[]" required>';
      cell3.innerHTML = '<input type="number" name="times_per_day[]" required>';
      cell4.innerHTML = '<input type="number" name="total_quantity[]" required>';
      cell5.innerHTML = '<select name="medication_type[]"><option value="Tablets">Tablets</option><option value="Mg">Mg</option><option value="Injections">Injections</option></select>';
      cell6.innerHTML = '<span class="remove-row" onclick="removeRow(this)">-</span>';
    }

    // Function to remove a row from prescription
    function removeRow(row) {
      var prescriptionTable = document.getElementById("prescription-table");
      var rowIndex = row.parentNode.parentNode.rowIndex;
      prescriptionTable.deleteRow(rowIndex);
    }
  </script>
</head>
<body>
  <form method="POST" action="prescription.php">
    <div class="history_lists">
      <div class="list1">
        <div class="row">
          <h1>Prescription Form</h1>
        </div>
        <div class="row">
          <label for="patient_id">Select Patient ID:</label>
          <select id="patient_id" name="patient_id" required>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "doctor";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id FROM appointments";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["id"] . '">' . $row["id"] . '</option>';
              }
            }

            $conn->close();
            ?>
          </select>
        </div>
        <table id="prescription-table">
          <thead>
            <tr>
              <th>Drug Name</th>
              <th>Quantity per Dose</th>
              <th>Dose per Day</th>
              <th>Total Quantity</th>
              <th>Medication Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr class="row">
              <td><input type="text" name="drug_name[]" required></td>
              <td><input type="number" name="quantity_per_dose[]" required></td>
              <td><input type="number" name="times_per_day[]" required></td>
              <td><input type="number" name="total_quantity[]" required></td>
              <td>
                <select name="medication_type[]">
                  <option value="Tablets">Tablets</option>
                  <option value="Mg">mg</option>
                  <option value="Injections">Injections</option>
                </select>
              </td>
              <td><span class="remove-row" onclick="removeRow(this)">-</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <input type="button" value="+" onclick="addRow()">
    <input type="submit" value="Prescribe" onclick="return confirm('Are you sure you are done prescribing for this Patient?');">
  </form>
</body>
</html>
