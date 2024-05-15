<?php
error_reporting(0); session_start();
include("dbconnection.php");

$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Credit'";
$qsqltransaction =mysqli_query($con,$sqltransaction);
$rstransaction =mysqli_fetch_array($qsqltransaction);
$totcredit = $rstransaction[0];

$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Debit'";
$qsqltransaction =mysqli_query($con,$sqltransaction);
$rstransaction =mysqli_fetch_array($qsqltransaction);
$totdebit = $rstransaction[0];

$balamt = $totcredit - $totdebit;

echo "Balance Amount - ".$balamt. "<br>";
echo "<input class='form-control' type='hidden' name='balamt' value='$balamt'>";
$bamount=$balamt-50 ;
echo "<input class='form-control' type='hidden' name='minbalamt' value='$bamount'>";
?>