<?php
require_once "session_util.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Pharmacist Dashboard</title>
  <link rel="stylesheet" href="admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="../Homepage/Homepage.html">ELT Dispensary</a>
      <div class="search_box">
        <input type="text" placeholder="Search EasyPay">
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
      </div>
    </div>

    <div class="header-icons">
      <i class="fas fa-bell"></i>
      <div class="account">
        <img src="profile.jpg" alt="">
        <h4><span><?php echo $role; ?> <?php echo $username; ?></span></h4>
      </div>
    </div>
  </header>
  <div class="container">
    <nav>
      <div class="side_navbar">
        <span>Main Menu</span>
        <a href="#" class="active">Dashboard</a>
        <a href="#">Profile</a>
        <a href="phamhistory.php">History</a>
        <a href="phamdrugs.php">Drugs</a>
        <a href="#">My Account</a>
        <a href="#">Documnets</a>

        
      </div>
    </nav>

    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="promo_card">
        <h1>Welcome to Phamacist's Page</h1>
        <span>All drugs are to be dispensed as prescribed.</span>
        <a href ="adddrugs.html"><button>Add Drugs to system</button></a>        
      </div>

      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>Prescribed Patients</h4>
            <a href="#">See all</a>
          </div>
          <table id="prescription">
            <thead>
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
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

            $sql = "SELECT a.id AS appointment_id, a.first_name, a.last_name
                    FROM appointments AS a
                    RIGHT JOIN prescriptions AS p ON a.id = p.appointment_id";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $previousAppointmentId = null;
                while ($row = $result->fetch_assoc()) {
                    if ($row["appointment_id"] !== $previousAppointmentId) {
                        echo "<tr>";
                        echo "<td>" . $row["appointment_id"] . "</td>";
                        echo "<td><a href='dispense_drugs.php?appointment_id=" . $row["appointment_id"] . "'>" . $row["first_name"] . "</a></td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "</tr>";
                        $previousAppointmentId = $row["appointment_id"];
                    }
                }
            } else {
                echo "No results found.";
            }

            $conn->close();
            ?>

            </tbody>
          </table>
        </div>

        <div class="list1">
          <div class="row">
            <h4>Prescriptions</h4>
          </div>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Drug Name</th>
                <th>Total Quantity</th>
                <th>Medication Type</th>              
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

              $sql = "SELECT * FROM prescriptions";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["appointment_id"] . "</td>";
                  echo "<td><a href='display.php?id=" . $row["appointment_id"] . "'>" . $row["drug_name"] . "</a></td>";
                  echo "<td>" . $row["total_quantity"] . "</td>";
                  echo "<td>" . $row["medication_type"] . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "0 results";
              }

              $conn->close();
            ?>
            </tbody>
          </table>
          <script>
            function searchPatients() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("prescription");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
              var match = false;
              td = tr[i].getElementsByTagName("td");

              for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                  txtValue = td[j].textContent || td[j].innerText;

                  if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                  }
                }
              }

              if (match) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
          }

          document.getElementById("searchInput").addEventListener("input", searchPatients);
        </script>
        </div>
      </div>
    </div>

    
  </div>
</body>
</html>
