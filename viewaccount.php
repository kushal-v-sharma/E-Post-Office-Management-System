<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from account where accountid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<script>alert('Record deleted');</script>";
}
?>
</div>
<div class="panels-container"></div>
<div class="columns-container">
  <div class="columns-wrapper">
    <?php
	include("leftside.php");
	?>
    <div class="right-column">
      <div class="right-column-heading">
      <p><h2>Account</h2>
      <h1>View Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
     <div style='overflow:auto;width:100%'>
        <table width="200" height="52" border="1"  class="tftable">
          <tr>
          <th scope="col">Account Type </th>
            <th scope="col">Customer</th>
            <th scope="col">Account Open Date</th>
            <th scope="col">Account Close Date</th>
            <th scope="col">Nominee</th>
            <th scope="col">Relationship With The Nominee</th>
            <th scope="col">Balance</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from account";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$rs[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$rs[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				$balamt = $totcredit - $totdebit;
				
				$sql5="SELECT * from customer where customerid='$rs[customerid]'";
		   $qsql4=mysqli_query($con,$sql5);
		   $rs5=mysqli_fetch_array($qsql4);
				
	
				
				
         echo " <tr>
		 <td>&nbsp;$rs[acctype]</td>
           <td>&nbsp;$rs5[customername]</td>
            <td>&nbsp;$rs[acopendate]</td>
            <td>&nbsp;$rs[acclosedate]</td>
			<td>&nbsp;$rs[nominee]</td>
			<td>&nbsp;$rs[relationshipwithnominee]</td>
			<td>&nbsp;" . $balamt . "</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp;<a href='viewaccount.php?deleteid=$rs[accountid]'> Delete</a></td>
          </tr>";
		  }
		  ?>
        </table>
        </div>
         </form>
        <h1>&nbsp;</h1>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>