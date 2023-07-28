<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logins";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["delete"])) {
    $id = $_POST["id"];
    $sql = "DELETE FROM members WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo "User deleted successfully";
      header("Location: admindash.php");
      exit();
    } else {
      echo "Error deleting user: " . $conn->error;
    }
  } else {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $sql = "UPDATE members SET username='$username', email='$email', role='$role' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo "Update complete";
      header("Location: admindash.php");
      exit();
    } else {
      echo "Error updating user: " . $conn->error;
    }
  }
} else {
  $id = $_GET["id"];
  $sql = "SELECT * FROM members WHERE id=$id";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $email = $row["email"];
    $role = $row["role"];
  } else {
    echo "Invalid user ID";
    exit();
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
  <title>Edit User</title>
</head>
<body>
<div class="container">
    <h1>Edit Member</h1>
    <form method="POST" action="editusers.php">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
      </div>
      <div class="form-group">
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo $role; ?>" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Update">
        <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
      </div>
    </form>
</div>
</body>
</html>
