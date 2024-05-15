<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from tdaccount where tdaccount_id='$_GET[deleteid]'";
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
        <p><h2>TD Account</h2></p>
        <h1>View TD Account record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <p>&nbsp; <a href="tdaccount.php" class="more-button" style="width:250px;">Add New</a></p><div style='overflow:auto;width:100%'>
        <table width="200" border="1" class="tftable">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Minimum  Deposit</th>
            <th scope="col">Interest On First Year</th>
            <th scope="col">Interest On Second Year</th>
            <th scope="col">Interest On Third Year</th>
            <th scope="col">Interest On Fifth Year</th>
            <th scope="col">Documents Required</th>
            <th scope="col">Account Procedure</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from tdaccount order by tdaccount_id desc ";
		  $qsql=mysqli_query($con,$sql);
		  while($rs =	mysqli_fetch_array($qsql))
		  {
          echo "<tr>
            <td>&nbsp;$rs[title]</td>
            <td>&nbsp;$rs[mindeposit]</td>
            <td>&nbsp;$rs[int1yr]</td>
            <td>&nbsp;$rs[int2yr]</td>
            <td>&nbsp;$rs[int3yr]</td>
            <td>&nbsp;$rs[int5yr]</td>
            <td>&nbsp;$rs[docsreqrd]</td>
            <td>&nbsp;$rs[acprocedure]</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp; <a href='displaytdaccount.php?editid=$rs[tdaccount_id]' > View</a></td>
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