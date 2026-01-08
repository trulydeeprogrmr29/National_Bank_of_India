<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: register.html");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = htmlspecialchars(trim($_POST["Customer_name"] ?? '));
    $address = htmlspecialchars(trim($_POST["Address"] ?? '));
    $city = htmlspecialchars(trim($_POST["City"] ?? ''));

    if ($customer_name && $address && $city) {
        $conn = new mysqli("localhost", "root", "", "bank");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Insert into account_opening table
        $stmt = $conn->prepare("INSERT INTO account_opening (customer_name, city, address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $customer_name, $city, $address);
        if ($stmt->execute()) {
            echo "<h2>Account Opening Request Received</h2>";
            echo "<p><strong>Name:</strong> " . $customer_name . "</p>";
            echo "<p><strong>City:</strong> " . $city . "</p>";
            echo "<p><strong>Address:</strong> " . $address . "</p>";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Opening</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
         <h1><b><center> National Bank Of India</center></b></h1>
        <div class="logo-container"><img src="logo.png" alt="National Bank of India Logo" style="position: absolute; top: 10px; left: 10px; height: 100px;" ></div>
         <div class="nav-container" style="text-align: right; font-weight: bold; margin-top: 20px;">
    <a href="/Bank/BankWebpage.html">Home</a>
    <a href="/Bank/AccountOpening.php">Open A/C</a>
    <a href="/Bank/login.html">Login</a>
    <a href="/Bank/Dashboard.php">Dashboard</a>
</div>
        <form style="text-align: center;" action="account_opening_submit.php" method="post">
            <fieldset>
                <legend>
                   <h1>Account Opening</h1> 
                </legend>
                <label>Customer Name : <br/>
                <input type="text" name="Customer_name" /></label><br />
                <br/>
                <label>Address :<br/>
                <input type="text" name="Address" /></label><br />
                <label>City:<br />
                <input type="text" name="City" /></label><br/>
                <br/>
                <button type="submit" value="submit">Submit</button>
                <button type="reset" value="Reset">Reset</button>
            </fieldset>
        </form>
        <footer >
        <p>&copy; 2025 National Bank of India. All rights reserved.</p>
        <p>Made with Love by Deepak Chaudhary</p>
        <p>Contact: support@nbi.com | 1045 (24/7)</p>
     </footer>
</body>
</html>