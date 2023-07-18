<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logins";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["signup-username"];
    $email = $_POST["signup-email"];
    $password = $_POST["signup-password"];
    $role = $_POST["signup-role"];

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO members (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully!";
        header("Location: login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
