<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: register.html");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = htmlspecialchars(trim($_POST["Customer_name"] ?? ''));
    $address = htmlspecialchars(trim($_POST["Address"] ?? ''));
    $city = htmlspecialchars(trim($_POST["City"] ?? ''));

    if ($customer_name && $address && $city) {
        $conn = new mysqli("localhost", "root", "", "bank");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("INSERT INTO account_requests (customer_name, address, city, requested_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $customer_name, $address, $city, $_SESSION['user_name']);
        if ($stmt->execute()) {
            echo "<h2>Account Opening Request Received</h2>";
            echo "<p><strong>Name:</strong> " . $customer_name . "</p>";
            echo "<p><strong>Address:</strong> " . $address . "</p>";
            echo "<p><strong>City:</strong> " . $city . "</p>";
            echo "<p>Thank you for your submission!</p>";
        } else {
            echo "<h2>Error saving request.</h2>";
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "<h2>Error: All fields are required.</h2>";
        echo "<a href='AccountOpening.php'>Go Back</a>";
    }
} else {
    header("Location: AccountOpening.php");
    exit();
}
?>