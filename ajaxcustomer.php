<?php
error_reporting(0); session_start();
include("dbconnection.php");
if(isset($_GET['cstid']))
{
$sql = "SELECT * FROM  customer WHERE customerid='$_GET[cstid]'";
}
else
{
$sql = "SELECT * FROM  customer WHERE customerid='$_SESSION[customerid]'";
}
$qsql = mysqli_query($con,$sql);
$rsedit=mysqli_fetch_array($qsql);
?>
<table  border="1">
  <tr>
    <td width="178" scope="col">Customer Name</td>
    <td width="362" scope="col"><?php echo $rsedit['customername']; ?></td>
  </tr>
  <tr>
    <td>Date Of Birth</td>
    <td><?php echo $rsedit['dateofbirth']; ?></td>
  </tr>
  <tr>
    <td>Mobile Number</td>
    <td><?php echo $rsedit['mobileno']; ?></td>
  </tr>
  <tr>
    <td>Customer Age</td>
    <td><?php echo $custage = date_diff(date_create($rsedit['dateofbirth']), date_create('today'))->y; ?>
    <input class="form-control" type="hidden" name="custage" value="<?php echo $custage; ?>"  />
    </td>
  </tr>
</table>