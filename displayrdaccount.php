<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['editid']))
{
	$sql ="SELECT * FROM rdaccount where rdaccountid='$_GET[editid]'";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
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
        <h1>&nbsp;</h1>
        <h1>View RD Account</h1>
      </div>
      <div class="right-column-content">
        <table width="560" height="422" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Title</th>
              <td width="287"><?php echo $rsedit['title']; ?></td>
            </tr>
            <tr>
              <th height="36" scope="row">Minimum  Deposit</th>
              <td><?php echo $rsedit['mindeposit']; ?></td>
            </tr>
            <tr>
              <th scope="row">Three Years Interest</th>
              <td><?php echo $rsedit['threeyearinterest']; ?></td>
            </tr>
            <tr>
              <th scope="row">Five Years Interest</th>
              <td><?php echo $rsedit['after5yearinterest']; ?></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><?php echo $rsedit['docsreqd']; ?></td>
            </tr>
            <tr>
              <th scope="row">Account Procedure</th>
              <td><?php echo $rsedit['acprocedure']; ?></td>
            </tr>
            <tr>
              <th scope="row">Maximum Year</th>
              <td> <?php echo $rsedit['maximumyear']; ?></td>
            </tr>
            <tr>
              <th scope="row">Penalty per month</th>
              <td> <?php echo $rsedit['penaltypermonth']; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>