<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['editid']))
{
	$sql="select * from ssaaccount where ssaccountid='$_GET[editid]'";
	$qsql=mysqli_query($con,$sql);
	$rsedit=mysqli_fetch_array($qsql);
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
        <p>&nbsp;</p>
        <h1>View SSA Account record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Title</th>
              <td width="287"><?php echo $rsedit['title']; ?></td>
            </tr>
            <tr>
              <th scope="row">Minimum  Deposit</th>
              <td><?php echo $rsedit['mindeposit']; ?></td>
            </tr>
            <tr>
              <th scope="row">Deposit Year</th>
              <td><?php echo $rsedit['deposityr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Maturity Year</th>
              <td><?php echo $rsedit['maturityyr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Deposit Year</th>
              <td><?php echo $rsedit['deposityr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Interest</th>
              <td><?php echo $rsedit['interest']; ?></td>
            </tr>
            <tr>
              <th scope="row">Minimum Deposit Per Year</th>
              <td><?php echo $rsedit['minyrdeposityr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Maximum Deposit per year</th>
              <td><?php echo $rsedit['maxyrdepyr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Yearly Penalty</th>
              <td><?php echo $rsedit['yrpenalty']; ?></td>
            </tr>
            <tr>
              <th scope="row">Eighteen  Year Withdrawal Percentage</th>
              <td><?php echo $rsedit['eighteenyrwithdrawpercent']; ?></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><?php echo $rsedit['docsreqd']; ?></td>
            </tr>
            <tr>
              <th scope="row">Account Procedure</th>
              <td><?php echo $rsedit['acprocedure']; ?></td>
            </tr>
          </tbody>
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