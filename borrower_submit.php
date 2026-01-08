<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: register.html");
    exit();
}

$customer_name = trim($_POST['customer_name'] ?? '');
$loan_number = trim($_POST['loan_number'] ?? '');

if ($customer_name && $loan_number) {
    $conn = new mysqli("localhost", "root", "", "bank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Optional: Check if customer exists in account_opening
    $stmt = $conn->prepare("SELECT opening_id FROM account_opening WHERE customer_name = ?");
    $stmt->bind_param("s", $customer_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Insert borrower record
        $insert = $conn->prepare("INSERT INTO borrower (customer_name, loan_number) VALUES (?, ?)");
        $insert->bind_param("ss", $customer_name, $loan_number);
        if ($insert->execute()) {
            echo "<h2>Borrower record added successfully!</h2>";
        } else {
            echo "<h2>Error: Could not add borrower record.</h2>";
        }
        $insert->close();
    } else {
        echo "<h2>No such customer exists. Please open an account first.</h2>";
        echo "<a href='AccountOpening.php'>Open Account</a>";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<h2>All fields are required.</h2>";
    echo "<a href='Borrower.php'>Go Back</a>";
}
?>