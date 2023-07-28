<?php
require_once "session_util.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Doctors Dashboard</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="../Homepage/Homepage.html">ELT Dispensary</a>
      <div class="search_box">
        <input type="text" id="searchInput" placeholder="Search Patients">
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
        <a href="#">History</a>
        <a href="#">Appointments</a>
        <a href="#"> </a>
        <a href="#"> </a>

      </div>
    </nav>

    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="promo_card">
        <h1>Welcome to Doctors Page</h1>
        <span>We strive make our patients lives better in the best way we can.</span>
      </div>

      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>Prescribed History</h4>
            <a href="#">See all</a>
          </div>
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Drug</th>
                <th>Quantity</th>
                <th>Units</th>
                <th>Time Prescribed</th>
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

            $sql = "SELECT a.id AS appointment_id, a.first_name, p.drug_name, p.total_quantity,p.medication_type,p.time_prescribed
                    FROM appointments AS a
                    RIGHT JOIN prescriptions AS p ON a.id = p.appointment_id";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $previousAppointmentId = null;
                while ($row = $result->fetch_assoc()) {
                    if ($row["appointment_id"]) {
                        echo "<tr>";
                        echo "<td><a href='display.php?id=" . $row["appointment_id"] . "'>" . $row["first_name"] . "</a></td>";
                        echo "<td>" . $row["drug_name"] . "</td>";
                        echo "<td>" . $row["total_quantity"] . "</td>";
                        echo "<td>" . $row["medication_type"] . "</td>";
                        echo "<td>" . $row["time_prescribed"] . "</td>";
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

        <div class="list2">
          <div class="row">
            <h4>Drugs Available</h4>
          </div>
          <table>
            <thead>
              <tr>
                <th>Drug</th>
                <th>Unit Quantity</th>
                <th>Units</th>
                <th>Unit Cost</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "pharmacist";

              $conn = new mysqli($servername, $username, $password, $dbname);
              
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $sql = "SELECT * FROM drugs";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["drug_name"] . "</td>";
                  echo "<td>"  . $row["unit_quantity"] . "</td>";
                  echo "<td>" . $row["units"] . "</td>";
                  echo "<td>" . $row["unit_price"] . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "0 results";
              }

              $conn->close();
            ?> 
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="sidebar">
      <h4>Appointments</h4>      
      <div class="balance">
        <table id="appointmentsTable">
        <thead>
              <tr>
                <th>ID</th>
                <th>FName</th>
                <th>LName</th>
                <th>Date</th>                             
              </tr>
            </thead>
            <tbody>
            <?php
              $servername = "localhost";
              $username = "root";
              $password = "";

              $conn = new mysqli($servername, $username, $password, $dbname);
              
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $sql = "SELECT * FROM doctor.appointments";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["id"] . "</td>";
                  echo "<td><a href='prescribe.php?id=" . $row["id"] . "'>" . $row["first_name"] . "</a></td>";
                  echo "<td>" . $row["last_name"] . "</td>";  
                  echo "<td>" . $row["appointment_date"] . "</td>";                 
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
            table = document.getElementById("appointmentsTable");
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
</body>
</html>
