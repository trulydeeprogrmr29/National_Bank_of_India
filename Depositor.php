<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: register.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deposit Money</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><b><center>National Bank Of India</center></b></h1>
    <div class="nav-container" style="text-align:right; font-weight: bold;">
        <a href="/Bank/AccountOpening.php">Open A/C</a>
        <a href="/Bank/login.html">Login</a>
        <a href="/Bank/register.html">Register</a>
        <a href="/Bank/Dashboard.php">Dashboard</a>
        <a href="/Bank/BankWebpage.html">Home</a>
    </div>
    <form style="text-align: center;" action="depositor_submit.php" method="post">
        <fieldset>
            <legend><h1>Deposit Money</h1></legend>
            <label>Customer Name:<br/>
                <input type="text" name="customer_name" required />
            </label><br/><br/>
            <label>Amount:<br/>
                <input type="number" name="amount" min="1" required />
            </label><br/><br/>
            <button type="submit">Deposit</button>
            <button type="reset">Reset</button>
        </fieldset>
    </form>
    <footer>
        <p>&copy; 2025 National Bank of India. All rights reserved.</p>
        <p>Made with Love by Deepak Chaudhary</p>
        <p>Contact: support@nbi.com | 1045 (24/7)</p>
    </footer>
</body>
</html>

