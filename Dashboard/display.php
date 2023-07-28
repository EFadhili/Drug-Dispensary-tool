<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Drug Dispense</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <div>
    <div class="row">
      <h1>Drug Dispense</h1>
    </div>
    <table id="prescription-table">
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
  <script>
    // Function to handle row click event
    function handleRowClick(appointmentId) {
      window.location.href = "display.php?appointment_id=" + appointmentId;
    }

    // Add event listeners to table rows
    document.addEventListener("DOMContentLoaded", function() {
      const rows = document.querySelectorAll("#prescription-table tbody tr");
      rows.forEach(row => {
        const appointmentId = row.cells[0].textContent.trim(); // Assuming the appointment_id is in the first cell
        row.addEventListener("click", () => handleRowClick(appointmentId));
      });
    });
  </script>
</body>
</html>
