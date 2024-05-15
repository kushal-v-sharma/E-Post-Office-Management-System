<?php
error_reporting(0); session_start();
if(isset($_SESSION['adminid']))
{
	header("Location: admindashboard.php");
}
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	$sql = "SELECT * FROM admin WHERE loginid='$_POST[loginid]' AND password='$_POST[password]' AND status='Active'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql)== 1)
	{
		$rslogin = mysqli_fetch_array($qsql);
		$_SESSION['adminid'] = $rslogin['adminid'];
		header("Location: admindashboard.php");
	}
	else
	{
		echo "<script>alert('Invalid Login details entered');</script>";
	}
}
?>
</div>
<p>&nbsp;</p>
<div class="panels-container"></div>
<div class="columns-container">
  <div class="columns-wrapper">
    <?php
	include("leftside.php");
	?>
    <div class="right-column">
      <div class="right-column-heading">
        <h1>Admin Login<img src="images/adminlogin.jpe" width="150" height="150" alt=""/></h1>
      </div>
      <div class="right-column-content" >
      <form method="post" action="">
       <center> <table width="447" height="191" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="212" height="54" scope="row">Login ID</th>
              <td width="215"><input class="form-control" type="text" name="loginid" id="loginid" /></td>
            </tr>
            <tr>
              <th height="60" scope="row">Password</th>
              <td><input class="form-control" type="password" name="password" id="password" /></td>
            </tr>
            <tr>
              <th height="63" scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Login" /></td>
            </tr>
          </tbody>
        </table> </center>
        </form>
        <h1>&nbsp;</h1>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>