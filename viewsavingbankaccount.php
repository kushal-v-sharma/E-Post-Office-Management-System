<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from sbaccount where sbaccountid='$_GET[deleteid]'";
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
      <div class="right-column-heading"><h2>Saving Bank Account</h2>
        <h1>View SB Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <p>&nbsp; <a href="savingbankaccount.php" class="more-button" style="width:250px;">Add New</a></p><div style='overflow:auto;width:100%'>
        <table width="200" border="1"  class="tftable">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Minimum deposit</th>
            <th scope="col">Interest per year</th>
            <th scope="col">Minimum balance</th>
            <th scope="col">Documents Required</th>
            <th scope="col">Account Procedure</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from sbaccount order by sbaccountid desc ";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
          echo "<tr>
            <td>&nbsp;$rs[title]</td>
            <td>&nbsp;Rs. $rs[mindeposit]</td>
            <td>&nbsp;$rs[interestperyear]%</td>
            <td>&nbsp;Rs. $rs[minbal]</td>
            <td>&nbsp;$rs[documentsreqd]</td>
            <td>&nbsp;$rs[acprocedure]</td>
            <td>&nbsp;
			<a href='displaysavingbankaccount.php?editid=$rs[sbaccountid]'>View</a> </td>
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