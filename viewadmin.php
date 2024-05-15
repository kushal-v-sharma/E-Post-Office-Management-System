<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from admin where adminid='$_GET[deleteid]'";
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
        <h2>Admin</h2>
        <h1>View Admin Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
        <table width="200" border="1"  class="tftable">
          <tr>
            <th scope="col">Admin name</th>
            <th scope="col">Login ID</th>
            <th scope="col">User type</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          
          <?php
          $sql="select * from admin";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  
			echo " <tr>
            <td>&nbsp;$rs[adminname]</td>
          <td>&nbsp;$rs[loginid]</td>
            <td>&nbsp;$rs[usertype]</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp; <a href='admin.php?editid=$rs[adminid]'>Edit</a> | <a href='viewadmin.php?deleteid=$rs[adminid]'> Delete</a></td>
          </tr>";
		  }
		  ?>
        </table>
        </form>
        <h1>&nbsp;</h1>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>