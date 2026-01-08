<?php
if($_POST['customer_name'])
{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//begin the transaction
$conn->begin_transaction();

$customer_name = $_POST['customer_name'] ;
$result = $conn->query("SELECT SUM(A.balance), A.account_number FROM depositor D, account A WHERE D.customer_name = '$customer_name' and D.account_number = A.account_number;");
$i = 0; //Flag is taken to keep track of delete
while($row = $result->fetch_assoc())
{
if($row["SUM(A.balance)"] < 500)
{
$conn->query("delete from depositor where customer_name = '$customer_name'");
$i = 1;
}
$account_number = $row["account_number"];
} 
//end of while loop
//Check for year condition
$result = $conn->query("SELECT COUNT(*) FROM account WHERE year(DATE) < 2010 and account_number = '$account_number'");
while($row = $result->fetch_assoc())
{
if($row["COUNT(*)"]==0) //No row is resulted from the upper query where year < 2010
{
if($i == 1) //account is set for deletion in the previous while loop
{
echo "<br>Your account balance is lower than 500, but your account is not older than 2010 so account will not be deleted.";
$conn->rollback();
}
else
{
echo "<br>Your balance is higher than 500."; // value of variable i does not change in the previous while loop as balance is > 500. This is just for information.
}
}
else
if($i == 1) // Condition satisfied so commit the transaction (value of count is more than 1 means the account is older than 2010)
{
echo "Your account balance is lower than 500 and your account is older than 2010, thus, the account will be deleted.";
$conn->query("delete from account where account_number = '$account_number'");
$conn->commit();
}
}
$conn->close();
}
else
{
//Show transactionPage webpage along with error.
include("transactionPage.php");
echo "<hr> Customer Name is missing.";
}
?>