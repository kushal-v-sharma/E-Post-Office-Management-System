<?php
error_reporting(0); session_start();
if(isset($_SESSION['customerid']))
{
	header("Location: customerdashboard.php");
}
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	$sql = "SELECT * FROM customer WHERE loginid='$_POST[loginid]' AND password='$_POST[password]' AND status='Active'";
	$qsql = mysqli_query($con,$sql);
if(mysqli_num_rows($qsql)== 1)
{
	$rslogin = mysqli_fetch_array($qsql);
	$_SESSION['customerid'] = $rslogin['customerid'];
	header("Location: customerdashboard.php");
}
else
{
	echo "<script>alert('Invalid login details entered');</script>";
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
        <h1>Customer Login<img src="images/images (5).jpg" width="150" height="150" alt=""/></h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
        <table width="560" height="221" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" height="72" scope="row">Login ID</th>
              <td width="287"><input class="form-control" type="text" name="loginid" id="loginid" /></td>
            </tr>
            <tr>
              <th height="58" scope="row">Password</th>
              <td><input class="form-control" type="password" name="password" id="password" /></td>
            </tr>
            <tr>
              <th height="77" scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Login" /></td>
            </tr>
          </tbody>
        </table>
        <td><a href='forgotpassword.php'>Forgot Password</a></td>
        <p>&nbsp;	 </p>
        </form>
        <h1>&nbsp;</h1>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>