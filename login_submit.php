<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_name = trim($_POST['user_name'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($user_name && $password) {
    $stmt = $conn->prepare("SELECT password FROM login WHERE user_name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password_db);
        $stmt->fetch();

        if ($password === $password_db) {
            $_SESSION['user_name'] = $user_name;
            header("Location: AccountOpening.php");
            exit();
        } else {
            echo "<h2>Invalid password.</h2>";
            echo "<a href='login.html'>Try Again</a>";
        }
    } else {
        header("Location: register.html");
        exit();
    }
    $stmt->close();
} else {
    echo "<h2>Please fill in all fields.</h2>";
    echo "<a href='login.html'>Go Back</a>";
}
$conn->close();
?>