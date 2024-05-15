<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['editid']))
{
	$sql="select * from sbaccount where sbaccountid='" . $_GET['editid'] . "'";
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
        <h1>View SB Account record</h1>
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
              <th scope="row">Minimum deposit</th>
              <td><?php echo $rsedit['mindeposit']; ?></td>
            </tr>
            <tr>
              <th scope="row">Interest per year</th>
              <td><?php echo $rsedit['interestperyear']; ?></td>
            </tr>
            <tr>
              <th scope="row">Minimum balance</th>
              <td><?php echo $rsedit['minbal']; ?></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><?php echo $rsedit['documentsreqd']; ?></td>
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