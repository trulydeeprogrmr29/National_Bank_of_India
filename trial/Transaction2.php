<?php
if($_POST['customer_name'])
{
$connect = mysql_connect("localhost", "root", "") or
die ("Unable to connect the server.");
mysql_select_db("bank");
mysql_query("BEGIN");

$customer_name = $_POST['customer_name'] ;
$query = mysql_query("select Distinct D.account_number from depositor D, account A where D.customer_name = '$customer_name'");
$row = mysql_fetch_array($query);
$account_number = $row[0];

$result = mysql_query("SELECT SUM(A.balance) FROM depositor D,account A WHERE D.customer_name = '$customer_name' and D.account_number = A.account_number;");
$i = 0;
while($row = mysql_fetch_array($result))
{
if($row[0] < 500)
{
mysql_query("delete from depositor where customer_name = '$customer_name'");

$i = 1;
}
}
$result = mysql_query("SELECT COUNT(*) FROM account WHERE year(DATE) < 2010 and account_number = '$account_number'");
while($row = mysql_fetch_array($result))
{
if($row[0]==0 && $i == 1)
{
mysql_query("ROLLBACK");
echo "<br>Your account balance is lower than 500, but your account is not older than 2010 so account will not be deleted.";
}
else if($i == 1)
{
mysql_query("COMMIT");
echo "Your account balance is lower than 500 and your account is older than 2010, thus, the account will be deleted.";
mysql_query("delete from account where account_number = '$account_number'");
}
else
{
mysql_query("ROLLBACK");
echo "<br>Your balance is higher than 500.";
}
}
}
else
{
include("transactionPage.php");
echo "<hr> Customer Name is missing.";
}
?>