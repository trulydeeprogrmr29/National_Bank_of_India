<?php
$conn = new mysqli("localhost", "root", "", "bank");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$customer_name = isset($_GET['customer_name']) ? $conn->real_escape_string($_GET['customer_name']) : '';
$sql = "SELECT customer_name, customer_city, customer_street FROM customer WHERE customer_name='$customer_name'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .center-table-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 70px;
        }
        .list-table {
            width: 400px;
        }
    </style>
</head>
<body>
    <h2>Customer Details</h2>
    <?php
    if ($result && $row = $result->fetch_assoc()) {
        echo "<div class='center-table-wrapper'>
                <table class='list-table'>
                    <tr><th>Name</th><td>{$row['customer_name']}</td></tr>
                    <tr><th>City</th><td>{$row['customer_city']}</td></tr>
                    <tr><th>Street</th><td>{$row['customer_street']}</td></tr>
                </table>
              </div>";
    } else {
        echo "<p style='text-align:center;color:red;'>Customer not found.</p>";
    }
    $conn->close();
    ?>
    <div style="text-align:center;margin-top:20px;">
        <a href="Dashboard.php" style="color:#2980b9;">&larr; Back to Dashboard</a>
    </div>
</body>
</html>