<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from account where accountid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<script>alert('Record Deleted');</script>";
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
      <p><h2>Account</h2></p>
      <h1>View Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
     <div style='overflow:auto;width:100%'>
        <table width="200" height="52" border="1" class="tftable">
          <tr>
          <th scope="col">Account number </th>
          <th scope="col">Account Type </th>
      <th scope="col">Account Open Date</th>
            <th scope="col">Account Close Date</th>
            <th scope="col">Balance</th>
            <th scope="col">Account Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from account where customerid='$_SESSION[customerid]'";
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
				
				 			echo " <tr>
				  			<td>&nbsp;$rs[accountid]</td>
				 			<td>&nbsp;$rs[acctype]<br />";
							if($rs['acctype'] == "Time deposit")
							{
								echo $rs['numofyrs'] . " years";
							}
							echo "</td>
							<td>&nbsp;$rs[acopendate]</td>
							<td>&nbsp;";
							if($rs['acctype']=="SSA Account")
							{
								echo $widraweligibledate1 =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($rs['acopendate'])) . " + 21 year"));
							}
							else
							{
								echo $rs['acclosedate'];
							}
							echo " </td>
					 		<td>&nbsp;Rs." . $balamt . "</td>
							<td>&nbsp;$rs[status]</td>
							<td>&nbsp; ";
								if($rs['acctype'] == "Savings account")
								{
								echo "<a href='displaysavingbankaccount.php?editid=$rs[actypeid]'> View plan </a> | <a href='depositsbaccount.php?accountid=$rs[accountid]'> Deposit</a> <a href='withdrawsbaccount.php?accountid=$rs[accountid]'> Withdraw </a>";
								}
								else if($rs['acctype'] == "Time deposit")
								{
									echo "<a href='displaytdaccount.php?editid=$rs[actypeid]'>View plan</a> ";
									if($balamt == 0)
									{
									echo "| <a href='deposittdaccount.php?accountid=$rs[accountid]'> Deposit</a> ";
									}
									echo "<a href='withdrawtdaccount.php?accountid=$rs[accountid]'> Withdraw </a>";
								}
								else if($rs['acctype']=="Recurring deposit")
								{
									echo "<a href='displayrdaccount.php?editid=$rs[actypeid]'>View plan</a> |<a href='depositrdaccount.php?accountid=$rs[accountid]'> Deposit</a> <a href='withdrawrdaccount.php?accountid=$rs[accountid]'> Withdraw </a>";
								}
								else if($rs['acctype']=="SSA Account")
								{
									
$widraweligibledate =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($rs['acopendate'])) . " + 18 year"));
$now = strtotime(date("Y-m-d")); // or your date as well
$acopendt = $widraweligibledate;
$your_date = strtotime($acopendt);
$datediff = $now - $your_date;
$nohalfdays = floor($datediff/(60*60*24));

									echo "<a href='displayssaaccount.php?editid=$rs[actypeid]'>View plan</a> |<a href='depositssaaccount.php?accountid=$rs[accountid]'> Deposit</a> ";
									if($nohalfdays >= 1)
									{
									echo "<hr /><a href='withdrawssaaccount.php?accountid=$rs[accountid]'> Withdraw </a>";
									}
								}
							echo "</td></tr>";
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