<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from consignment where consignment_id='$_GET[deleteid]'";
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
      <div class="right-column-heading"><h2>Consignment</h2>
        <h1>View Consignment Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <div style='overflow:auto;;width:100%'>
        <table width="200" border="1"  class="tftable">
          <tr>
            <th scope="col">Consignment ID</th>
            <th scope="col">Customer</th>
            <th scope="col">Item detail</th>
            <th scope="col">From address</th>
            <th scope="col">From pincode</th>
            <th scope="col">To address</th>
            <th scope="col">To pincode</th>
            <th scope="col">From mobile no</th>
            <th scope="col">Delivery date</th>
            <th scope="col">To mobile no</th>
            <th scope="col">Cost</th>
            <th scope="col">Consignment type</th>
            <th scope="col">Note</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from consignment where status='Active' ";
		  if(isset($_SESSION['customerid']))
		  {
			  $sql = $sql . " AND customerid='" . $_SESSION['customerid'] . "'";
		  }
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  $sql1 = "SELECT * FROM customer WHERE customerid='$rs[customerid]'";
			  $qsql1=mysqli_query($con,$sql1);
			  $rs1=mysqli_fetch_array($qsql1);
          echo "<tr>
		  <td>&nbsp;$rs[consignment_id]</td>
            <td>&nbsp;$rs1[customername]</td>
            <td>&nbsp;$rs[itemdetail]</td>
            <td>&nbsp;$rs[fromaddr]</td>
            <td>&nbsp;$rs[frompin]</td>
            <td>&nbsp;$rs[toaddr]</td>
            <td>&nbsp;$rs[topin]</td>
            <td>&nbsp;$rs[frommobno]</td>
            <td>&nbsp;$rs[date]</td>
            <td>&nbsp;$rs[tomobno]</td>
            <td>&nbsp;$rs[cost]</td>
            <td>&nbsp;$rs[consignmenttype]</td>
            <td>&nbsp;$rs[note]</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp; <a href='consignment.php?editid=$rs[consignment_id]' > Edit</a>| <a href='viewconsignment.php?deleteid=$rs[consignment_id]' > Delete</a><hr />
<a href='viewadmintrackingrecord.php?consignment_id=$rs[consignment_id]' > View Tracking</a></td>
          </tr>";
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