<?php
include("header.php");
include("dbconnection.php");

	
if(isset($_GET['editid']))
{
	$sql="select * from tdaccount where tdaccount_id='$_GET[editid]'";
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
        <h1>View TD Account record</h1>
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
              <th scope="row">Interest On First Year</th>
              <td><?php echo $rsedit['int1yr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Interest On Second Year</th>
              <td><?php echo $rsedit['int2yr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Interest On Third Year</th>
              <td><?php echo $rsedit['int3yr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Interest On Fifth Year</th>
              <td><?php echo $rsedit['int5yr']; ?></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><?php echo $rsedit['docsreqrd']; ?></td>
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