<?php
$conn = new mysqli("localhost", "root", "", "bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_name = trim($_POST['user_name'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($user_name && $password) {
    $check = $conn->prepare("SELECT user_name FROM login WHERE user_name = ?");
    $check->bind_param("s", $user_name);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "<h2>User already exists. Please login.</h2>";
        echo "<a href='login.html'>Go to Login</a>";
    } else {
        $stmt = $conn->prepare("INSERT INTO login (user_name, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user_name, $password);
        if ($stmt->execute()) {
            echo "<h2>Registration successful!</h2>";
            header("refresh:2;url=login.html"); 
        } else {
            echo "<h2>Error saving user.</h2>";
        }
        $stmt->close();
    }
    $check->close();
} else {
    echo "<h2>Please fill in all fields.</h2>";
    echo "<a href='register.html'>Go Back</a>";
}
$conn->close();
?>