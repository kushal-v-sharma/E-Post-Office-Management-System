<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from insurance where insuranceid='$_GET[deleteid]'";
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
      <div class="right-column-heading"><h2>Insurance</h2>
        <h1>View Insurance Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <div style='overflow:auto;width:100%'>
        <table width="545" border="1"  class="tftable">
          <tr>
            <th width="65" scope="col">Customer</th>
            <th width="70" scope="col">Insurance Type</th>
            <th width="52" scope="col">Amount</th>
            <th width="58" scope="col">Premium Type</th>
            <th width="58" scope="col">Policy create on</th>
            <th width="33" scope="col">Policy Close Date</th>
            <th width="33" scope="col">Maturity Year</th>
            <th width="33" scope="col">Note</th>
            <th width="42" scope="col">Status</th>
            <th width="37" scope="col">Action</th>
          </tr>
         <?php
		  $sql="select * from 	insurance";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  $sql2="SELECT * FROM customer WHERE customerid='$rs[customerid]'";
			  $qsql2=mysqli_query($con,$sql2);
			  $rs2=mysqli_fetch_array($qsql2);
			 echo " <tr>
            <td>&nbsp;$rs2[customername]</td>
            <td>&nbsp;$rs[insurancetypid]</td>
            <td>&nbsp;$rs[amount]</td>
			<td>&nbsp;$rs[premiumtype]</td>
            <td>&nbsp;$rs[accountopened]</td>
			<td>&nbsp;$rs[accountclosedate]</td>
			<td>&nbsp;$rs[maturityyear]</td>
            <td>&nbsp;$rs[note]</td>
			<td>&nbsp;$rs[status]</td>
			<td>&nbsp;<a href='insuranceaccount.php?id=$rs[insuranceid]'> Edit</a> |<a href='viewinsuranceaccount.php?deleteid=$rs[insuranceid]'> Delete </a></td>
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