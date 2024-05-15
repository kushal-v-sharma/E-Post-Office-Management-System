<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from ssaaccount where ssaccountid='$_GET[deleteid]'";
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
        <p><h2>SSA Account</h2></p>
        <h1>View SSA Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
       <p>&nbsp; <a href="ssaaccount.php" class="more-button" style="width:250px;">Add New</a></p><div style='overflow:auto;width:100%'>
      
        <table width="200" border="1" class="tftable">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Minimum  Deposit</th>
            <th scope="col">Deposit Year</th>
            <th scope="col">Maturity Year</th>
            <th scope="col">Interest</th>
            <th scope="col">Minimum Deposit Per Year</th>
            <th scope="col">Maximum Deposit per year</th>
            <th scope="col">Yearly Penalty</th>
            <th scope="col">Eighteen Year Withdrawal Percentage</th>
            <th scope="col">Documents Required</th>
            <th scope="col">Account Procedure</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from ssaaccount order by ssaccountid desc";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
          echo "<tr>
            <td>&nbsp;$rs[title]</td>
            <td>&nbsp;$rs[mindeposit]</td>
            <td>&nbsp;$rs[deposityr]</td>
            <td>&nbsp;$rs[maturityyr]</td>
            <td>&nbsp;$rs[interest]</td>
            <td>&nbsp;$rs[minyrdeposityr]</td>
            <td>&nbsp;$rs[maxyrdepyr]</td>
            <td>&nbsp;$rs[yrpenalty]</td>
            <td>&nbsp;$rs[eighteenyrwithdrawpercent]</td>
            <td>&nbsp;$rs[docsreqd]</td>
            <td>&nbsp;$rs[acprocedure]</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp; <a href='displayssaaccount.php?editid=$rs[ssaccountid]' > View</a></td>
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