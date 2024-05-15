<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from rdaccount where rdaccountid='$_GET[deleteid]'";
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
        <p><h2>RD Account</h2></p>
        <h1>View RD Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
     <p>&nbsp; <a href="rdaccount.php" class="more-button" style="width:250px;">Add New</a></p><div style='overflow:auto;width:100%'>
        
        <table width="200" border="1"  class="tftable">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Minimum  Deposit</th>
            <th scope="col">Three Years Interest</th>
            <th scope="col">Five Years Interest</th>
            <th scope="col">Documents Required</th>
            <th scope="col">Account Procedure</th>
            <th scope="col">Maximum Year</th>
            <th scope="col">Penalty per month</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from rdaccount order by rdaccountid desc";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
		  echo "<tr>
            <td>&nbsp;$rs[title]</td>
            <td>&nbsp;Rs. $rs[mindeposit]</td>
            <td>&nbsp;$rs[threeyearinterest]%</td>
            <td>&nbsp;$rs[after5yearinterest]%</td>
            <td>&nbsp;$rs[docsreqd]</td>
            <td>&nbsp;$rs[acprocedure]</td>
            <td>&nbsp;$rs[maximumyear]</td>
            <td>&nbsp;$rs[penaltypermonth]%</td>
            <td>&nbsp;
			<a href='displayrdaccount.php?editid=$rs[rdaccountid]'>View</a>
			
			</td>
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