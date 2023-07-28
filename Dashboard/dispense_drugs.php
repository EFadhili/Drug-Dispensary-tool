<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Drug Dispense</title>
  <link rel="stylesheet" href="dispense.css" />
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
      var rowId = prescriptionTable.rows.length; // Get the current row count as the ID for the new row

      // Create a dropdown for drug selection
      var drugDropdown = document.createElement("select");
      drugDropdown.name = "drug[]";
      drugDropdown.required = true;
      drugDropdown.innerHTML = '<option value="" disabled selected>Select a drug</option>';

      // Use PHP to populate the dropdown with drugs from the database
      <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pharmacist";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT drug_name FROM drugs";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo 'drugDropdown.innerHTML += \'<option value="' . $row["drug_name"] . '">' . $row["drug_name"] . '</option>\';';
          }
        }

        $conn->close();
      ?>

      cell1.appendChild(drugDropdown);
      cell2.innerHTML = '<input type="number" name="quantity[]" required>';
      cell3.innerHTML = '<select name="units[]"><option value="mg">mg</option><option value="tablets">tablets</option><option value="ml">ml</option><option value="injections">injections</option></select>';
      cell4.innerHTML = '<span class="remove-row" onclick="removeRow(' + rowId + ')">-</span>';
    }

    // Function to remove a row from prescription
    function removeRow(rowId) {
      var prescriptionTable = document.getElementById("prescription-table");
      prescriptionTable.deleteRow(rowId);
    }

    // Function to fetch drug_name and quantity based on the selected appointment_id
    function getPrescriptions() {
      var selectedAppointmentId = document.getElementById("appointment-id").value;

      // Use Ajax to fetch data from prescriptions table based on the selected appointment_id
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var prescriptionsData = JSON.parse(xhr.responseText);
          displayPrescriptions(prescriptionsData);
        }
      };
      xhr.open("GET", "get_prescriptions.php?id=" + selectedAppointmentId, true);
      xhr.send();
    }

    // Function to display fetched drug_name and quantity in the table
    function displayPrescriptions(prescriptionsData) {
      var prescriptionsTable = document.getElementById("prescriptions-table");

      // Clear existing data in the table
      prescriptionsTable.innerHTML = "";

      // Populate the table with fetched data
      for (var i = 0; i < prescriptionsData.length; i++) {
        var newRow = prescriptionsTable.insertRow();

        var cell1 = newRow.insertCell();
        var cell2 = newRow.insertCell();

        cell1.innerHTML = prescriptionsData[i].drug_name;
        cell2.innerHTML = prescriptionsData[i].quantity;
      }
    }
  </script>
</head>
<body>
  <form method="POST" action="dispense.php">
  <input type="hidden" name="appointment_id" value="<?php echo $_GET['appointment_id']; ?>">
      <div class="h1">
        <h1>Patient's Prescription</h1>
      </div>
    <div class="history_lists">       
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Drug Name</th>
              <th>Quantity</th>
              <th>Units</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "doctor";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["appointment_id"])) {
              $id = $_GET["appointment_id"];
              $sql = "SELECT a.id AS appointment_id, a.first_name, p.drug_name, p.total_quantity,p.medication_type
                      FROM appointments AS a
                      RIGHT JOIN prescriptions AS p ON a.id = p.appointment_id
                      WHERE a.id = ?";

              $stmt = $conn->prepare($sql);
              $stmt->bind_param("i", $id);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["first_name"] . "</td>";
                  echo "<td><a href='display.php?id=" . $row["appointment_id"] . "'>" . $row["drug_name"] . "</a></td>";
                  echo "<td>" . $row["total_quantity"] . "</td>";
                  echo "<td>" . $row["medication_type"] . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "No results found.";
              }

              $stmt->close();
            }

            $conn->close();
            ?>
          </tbody>
        </table>      
    </div>
    <div>
    <div class="row">
        <h1>Dispense Prescription</h1>
      </div>
      <table id="prescription-table">
        <thead>
          <tr>
            <th>Drug Name</th>
            <th>Quantity</th>
            <th>Units</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
            <select name="drug[]" required>
              <option value="" disabled selected>Select a drug</option>
              <!-- Use PHP to populate the dropdown with drugs from the database -->
              <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "pharmacist";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT drug_name FROM drugs";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["drug_name"] . '">' . $row["drug_name"] . '</option>';
                  }
                }

                $conn->close();
              ?>
            </select>
            </td>
            <td><input type="number" name="quantity[]" required></td>
            <td>
                <select name="units[]">
                    <option value="mg">mg</option>
                    <option value="tablets">tablets</option>
                    <option value="ml">ml</option>
                    <option value="injections">injections</option>
                </select>
              </td>             
            <td><span class="remove-row" onclick="removeRow(0)">-</span></td>
          </tr>
        </tbody>
      </table>
    </div>
      
    </div>
    <label for="drug">Select Drug:</label>
    
    <input type="button" value="+" onclick="addRow()">
    <input type="submit" value="Dispense" onclick="return confirm('Are you sure you are done dispensing drugs for this Patient?');">
  </form>
</body>
</html>
