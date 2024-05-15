<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="DELETE from billpayment where billpaymentid='$_GET[deleteid]'";
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
      <div class="right-column-heading"><h2>Bill Payment</h2>
        <h1>View Bill Payment Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
       <div style='overflow:auto;width:100%'>
         <table width="200" border="1"  class="tftable">
           <tr>
            <th width="18" scope="col">Bill type</th>
            <th width="18" scope="col">Account Number</th>
            <th width="18" scope="col">Name</th>
            <th width="32" scope="col">Paid Date</th>
            <th width="18" scope="col">Bill Amount</th>
            <th width="18" scope="col">Note</th>
            <?php
			if(isset($_SESSION['adminid']))
			{
            	echo '
            <th width="8" scope="col">Status</th><th width="22" scope="col">Action</th>';
			}
			?>
          </tr>
           <?php
		  $sql="select * from billpayment";
		  if(isset($_SESSION['customerid']))
		  {
			 $sql =  $sql . " where customerid='$_SESSION[customerid]'";
		  }
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  
         echo " <tr>
            <td>&nbsp;$rs[billtype]</td>
            <td>&nbsp;$rs[accountnumber]</td>
            <td>&nbsp;$rs[name]</td>
			<td>&nbsp;$rs[paiddate]</td>
            <td>&nbsp;$rs[billamt]</td>
            <td>&nbsp;$rs[note]</td>
			";
			if(isset($_SESSION['adminid']))
			{
			echo "<td>&nbsp;$rs[status]</td><td>&nbsp; <a href='viewbillpayment.php?deleteid=$rs[billpaymentid]'> Delete</a></td>";
			}
          echo "</tr>";
		  }
		  ?>
      </table>
        </div>
        <p>&nbsp;</p>
        </form>
        <h1>&nbsp;</h1>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>