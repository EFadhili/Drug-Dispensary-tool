<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dispensed Drugs</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <div class="h1">
    <h1>Dispensed Drugs</h1>
  </div>
  <table>
    <thead>
      <tr>
        <th>Patient Name</th>
        <th>Drug Name</th>
        <th>Quantity</th>
        <th>Units</th>
        <th>Price(Ksh)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $doctorServername = "localhost";
      $doctorUsername = "root";
      $doctorPassword = "";
      $doctorDbname = "doctor";

      $doctorConn = new mysqli($doctorServername, $doctorUsername, $doctorPassword, $doctorDbname);

      if ($doctorConn->connect_error) {
        die("Connection to doctor database failed: " . $doctorConn->connect_error);
      }

      $pharmacistServername = "localhost";
      $pharmacistUsername = "root";
      $pharmacistPassword = "";
      $pharmacistDbname = "pharmacist";

      $pharmacistConn = new mysqli($pharmacistServername, $pharmacistUsername, $pharmacistPassword, $pharmacistDbname);

      if ($pharmacistConn->connect_error) {
        die("Connection to pharmacist database failed: " . $pharmacistConn->connect_error);
      }

      if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["appointment_id"])) {
        $id = $_GET["appointment_id"];
        $sql = "SELECT d.drug_name, d.quantity, d.units, d.price, a.first_name 
                FROM pharmacist.dispensed AS d
                INNER JOIN doctor.appointments AS a ON d.appointment_id = a.id
                WHERE a.id = ?";

        $stmt = $pharmacistConn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          $totalPrice = 0; // Initialize total price outside the loop
  
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["drug_name"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["units"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            echo "</tr>";
  
            // Add the price to the total
            $totalPrice += $row["price"];
          }
  
          echo "<tr>";
          echo "<td colspan='4'>Total Price:</td>";
          echo "<td>$totalPrice</td>";
          echo "</tr>";
        } else {
          echo "<tr><td colspan='5'>No dispensed drugs found for this patient.</td></tr>";
        }
        $stmt->close();
      }

      $doctorConn->close();
      $pharmacistConn->close();
      ?>
    </tbody>
  </table>
  <form action="phamhistory.php">
    <input type="submit" value="Done">
  </form>
</body>
</html>
