<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: register.html");
    exit();
}

$customer_name = trim($_POST['customer_name'] ?? '');
$amount = trim($_POST['amount'] ?? '');

if ($customer_name && $amount) {
    $conn = new mysqli("localhost", "root", "", "bank");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if customer exists in account_opening
    $stmt = $conn->prepare("SELECT opening_id FROM account_opening WHERE customer_name = ?");
    $stmt->bind_param("s", $customer_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Check if already a depositor
        $stmt2 = $conn->prepare("SELECT amount FROM depositor WHERE customer_name = ?");
        $stmt2->bind_param("s", $customer_name);
        $stmt2->execute();
        $stmt2->store_result();

        if ($stmt2->num_rows > 0) {
            // Update existing deposit
            $stmt2->bind_result($existing_amount);
            $stmt2->fetch();
            $new_amount = $existing_amount + $amount;
            $update = $conn->prepare("UPDATE depositor SET amount = ? WHERE customer_name = ?");
            $update->bind_param("ds", $new_amount, $customer_name);
            $update->execute();
            echo "<h2>Deposit Successful! New Balance: $new_amount</h2>";
            $update->close();
        } else {
            // Insert new deposit
            $insert = $conn->prepare("INSERT INTO depositor (customer_name, amount) VALUES (?, ?)");
            $insert->bind_param("sd", $customer_name, $amount);
            $insert->execute();
            echo "<h2>Deposit Successful!</h2>";
            $insert->close();
        }
        $stmt2->close();
    } else {
        // No such account
        echo "<h2>No such account exists.</h2>";
        echo "<a href='AccountOpening.php'>Open Account</a>";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "<h2>All fields are required.</h2>";
    echo "<a href='Depositor.php'>Go Back</a>";
}
?>