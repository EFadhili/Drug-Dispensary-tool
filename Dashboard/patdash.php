<?php
require_once "session_util.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Patients Dashboard </title>
  <link rel="stylesheet" href="admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="../Homepage/Homepage.html">ELT Dispensary</a>
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
        <a href="#">Prescriptions</a>
        <a href="#">Payments</a>
        <a href="#">Documnets</a>

        <div class="links">
          <span>Quick Link</span>
          <a href="#">Appointment</a>
          <a href="#">About us</a>
          <a href="#">Homepage</a>
        </div>
      </div>
    </nav>

    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="promo_card">
        <h1>Welcome to ELT</h1>
        <span>In ELT we value our patients lives above all. Make an appointment and have our best doctors take care of your health.</span>
        <a href="appointment.html"><button>Book an appointment</button></a> 
      </div>

      </div>
    </div>

    
  </div>
</body>
</html>
