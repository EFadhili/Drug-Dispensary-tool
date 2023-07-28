<?php
require_once "session_util.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | By Code Info</title>
  <link rel="stylesheet" href="admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="../Homepage/Homepage.html">ELT Dispensary</a>
      <div class="search_box">
        <input type="text" placeholder="Search username">
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
        <a href="#">Application</a>
        <a href="#">My Account</a>
        <a href="#">Documnets</a>

        <div class="links">
          <span>Quick Link</span>
          <a href="#">Paypal</a>
          <a href="#">EasyPay</a>
          <a href="#">SadaPay</a>
        </div>
      </div>
    </nav>

    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="promo_card">
        <h1>Welcome to ELT Admin Page</h1>
        <span>Polite reminder! Our patient's privacy is to be governed by your life.</span>
      </div>

      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>Users</h4>
            <a href="#">See all</a>
          </div>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "logins";

              $conn = new mysqli($servername, $username, $password, $dbname);
              
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $sql = "SELECT * FROM members";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["id"] . "</td>";
                  echo "<td><a href='editusers.php?id=" . $row["id"] . "'>" . $row["username"] . "</a></td>";
                  echo "<td>" . $row["email"] . "</td>";
                  echo "<td>" . $row["role"] . "</td>";
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

        <div class="list2">
          <div class="row">
            <h4>Drugs Available</h4>
          </div>
          <table>
            <thead>
              <tr>
                <th>Drug</th>
                <th>Unit Quantity</th>
                <th>Unit</th>
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
                  echo "<td><a href='editdrugs.php?drug_name=" . $row["drug_name"] . "'>" . $row["drug_name"] . "</a></td>";
                  echo "<td>" . $row["unit_quantity"] . "</td>";
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

  </div>
</body>
</html>
