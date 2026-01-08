
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .lists {
            display: flex;
            justify-content: space-between;
            gap: 2%;
            margin-top: 40px;
        }
        .lists > div {
            width: 48%;
        }
        .list-title {
            font-size: 1.2em;
            color: #2980b9;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
        }
        .list-table {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
            width: 100%;
            margin: 0 auto 30px auto;
        }
        .list-table th, .list-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e1e1e1;
            text-align: center;
        }
        .list-table th {
            background: #2980b9;
            color: #fff;
        }
        .list-table tr:last-child td {
            border-bottom: none;
        }
        .click-view a {
            font-size: 2em;
            color: #e51212ff;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.2s;
        }
        .click-view a:hover {
            color: rgba(214, 21, 49, 1);
            text-decoration: underline;
        }
        @media (max-width: 900px) {
            .lists {
                flex-direction: column;
                gap: 20px;
            }
            .lists > div {
                width: 100%;
            }
        }
    </style>
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
    <div class="lists">
        <div>
            <div class="list-title">List of Depositors</div>
            <table class="list-table">
                <tr>
                    <th>Name</th>
                    <th>Account No.</th>
                    <th>Details</th>
                </tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "bank");
                $sql = "SELECT d.customer_name, d.account_number FROM depositor d";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $name = urlencode($row['customer_name']);
                        echo "<tr>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['account_number']}</td>
                            <td class='click-view'><a href='customer_detail.php?customer_name=$name'>Click to View</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No Depositors Found</td></tr>";
                }
                ?>
            </table>
        </div>
        <div>
            <div class="list-title">List of Borrowers</div>
            <table class="list-table">
                <tr>
                    <th>Name</th>
                    <th>Loan No.</th>
                    <th>Details</th>
                </tr>
                <?php
                $sql = "SELECT b.customer_name, b.loan_number FROM borrower b";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $name = urlencode($row['customer_name']);
                        echo "<tr>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['loan_number']}</td>
                            <td class='click-view'><a href='customer_detail.php?customer_name=$name'>Click to View</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No Borrowers Found</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 National Bank of India. All rights reserved.</p>
        <p>Made with Love by Deepak Chaudhary</p>
        <p>Contact: support@nbi.com | 1045 (24/7)</p>
    </footer>
</body>
</html>