<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
		$sql ="UPDATE admin set adminname='$_POST[adminname]', loginid='$_POST[loginid]', password='$_POST[password]', usertype='$_POST[usertype]', status='$_POST[status]'  WHERE adminid='$_SESSION[adminid]'";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('admin record updated successfully..');</script>";
		}
}
if(isset($_SESSION['adminid']))
{
	$sql ="SELECT * FROM admin where adminid='$_SESSION[adminid]'";
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
        <h1>Admin Profile<img src="images/adminprofile.png" width="150" height="150" alt=""/></h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
        <table width="560" height="215" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" height="67" scope="row">Admin name</th>
              <td width="287"><input class="form-control" type="text" name="adminname" id="adminname" value="<?php echo $rsedit['adminname']; ?>" /></td>
            </tr>
            <tr>
              <th height="64" scope="row">Login ID</th>
              <td><input class="form-control" type="text" name="loginid" id="loginid" value="<?php echo $rsedit['loginid']; ?>" /></td>
            </tr>
            <tr>
              <th height="70" scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" /></td>
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