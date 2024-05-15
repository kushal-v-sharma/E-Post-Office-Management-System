<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from customer where customerid='$_GET[deleteid]'";
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
      <div class="right-column-heading"><h2>Customer</h2>
        <h1>View customer record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <div style="overflow:auto;width:100%">
        <table width="200" border="1"  class="tftable">
          <tr>
            <th scope="col">Customer Name</th>
            <th scope="col">Date</th>
            <th scope="col">Customer Address</th>
            <th scope="col">Mobile Number</th>
            <th scope="col">Login ID</th>
            <th scope="col">Email ID</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from customer";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
          echo "<tr>
            <td>&nbsp;$rs[customername]</td>
            <td>&nbsp;$rs[dateofbirth]</td>
            <td>&nbsp;$rs[customeraddr]</td>
            <td>&nbsp;$rs[mobileno]</td>
            <td>&nbsp;$rs[loginid]</td>
            <td>&nbsp;$rs[emailid]</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp; <a href='customer.php?editid=$rs[customerid]' > Edit</a> | <a href='viewcustomer.php?deleteid=$rs[customerid]'>Delete</a></td>
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