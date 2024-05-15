<?php
error_reporting(0); session_start();
include("dbconnection.php");

$sql = "SELECT * FROM  insurancetype WHERE insurancetypeid='$_GET[instype]'";
$qsql = mysqli_query($con,$sql);
$rsedit=mysqli_fetch_array($qsql);
?>	
<table width="458" border="1">
  <tr>
    <td width="203" height="24" scope="col">Inusrance Type</td>
    
    <td width="239" scope="col"><?php echo $rsedit['insurancetype']; ?></td>
  </tr>
<?php
if($_GET['instype'] == 4 )
{
?>  
  <tr>
    <td>Minimum maturity year</td>
    <td>35</td>
  </tr>

<?php
}
?>
  <tr>
    <td> Bonus</td>
    <td><?php echo $rsedit['bonus']; ?>%</td>
  </tr>
  <tr>
    <td>Minimum Age</td>
    <td><?php echo $rsedit['minage']; ?></td>
  </tr>
  <tr>
    <td>Maximum Age</td>
    <td><?php echo $rsedit['maxage']; ?></td>
  </tr>
  <tr>
    <td>Minimum Amount</td>
    <td>Rs. <?php echo $rsedit['minamt']; ?></td>
  </tr>
  <tr>
    <td>Maximum Amount</td>
    <td>Rs. <?php echo $rsedit['maxamt']; ?></td>
  </tr>
</table>
<input class="form-control" type="hidden" name="minamt" value="<?php echo $rsedit['minamt']; ?>"  />
<input class="form-control" type="hidden" name="maxamt" value="<?php echo $rsedit['maxamt']; ?>"  />