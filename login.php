<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logins";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $conn = new mysqli($servername, $username, $password, $dbname);

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["login-email"];
    $password = $_POST["login-password"];

    $sql = "SELECT * FROM members WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];
            header("Location: profile.php");
            exit();
        } else {
            echo "Wrong password.";
        }
    } else {
        echo "Wrong email or password.";
    }

    $conn->close();
}
?>

