<?php
error_reporting(0); session_start();
include("dbconnection.php");

$sqlaccount ="select * from account where accountid='$_GET[acid]'";
$qsqlaccount =mysqli_query($con,$sqlaccount);
$rsaccount =mysqli_fetch_array($qsqlaccount);

$sqlcustomer ="select * from customer where customerid ='$rsaccount[customerid]'";
$qsqlcustomer =mysqli_query($con,$sqlcustomer);
$rscustomer =mysqli_fetch_array($qsqlcustomer);

$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[acid]' AND transactiontype='Credit'";
$qsqltransaction =mysqli_query($con,$sqltransaction);
$rstransaction =mysqli_fetch_array($qsqltransaction);
$totcredit = $rstransaction[0];

$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[acid]' AND transactiontype='Debit'";
$qsqltransaction =mysqli_query($con,$sqltransaction);
$rstransaction =mysqli_fetch_array($qsqltransaction);
$totdebit = $rstransaction[0];

$balamt = $totcredit - $totdebit;
if(mysqli_num_rows($qsqlcustomer) >= 1)
{
	echo "Customer name - " . $rscustomer['customername'];
	echo "<br>Account type - "  . $rsaccount['acctype'];
	echo "<br>Balance Amount - Rs. ".$balamt. "<br>";
	echo "<input class='form-control' type='hidden' name='balamt' value='$balamt'>";
	$bamount=$balamt-50 ;
	echo "<input class='form-control' type='hidden' name='minbalamt' value='$bamount'>";
}
else
{
	echo "<strong>Account number not found</strong>";
}
?>