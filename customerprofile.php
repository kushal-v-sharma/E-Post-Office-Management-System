<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{

		$sql="UPDATE customer set customername='$_POST[customername]', dateofbirth='$_POST[date]', customeraddr='$_POST[customeraddress]', mobileno='$_POST[mobilenumber]', loginid='$_POST[loginid]', password='$_POST[password]', emailid='$_POST[emailid]', status='$_POST[status]' WHERE customerid='$_SESSION[customerid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Customer Record Updated Successfully..');</script>";
		}
	}

		
	if(isset($_SESSION['customerid']))
	{
		$sql="SELECT * from customer where customerid='$_SESSION[customerid]'";
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
        <h1>Customer Profile<img src="images/customerprofile.jpe" width="150" height="150" alt=""/></h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Customer Name</th>
              <td width="287"><input class="form-control" type="text" name="customername" id="customername" value="<?php echo $rsedit['customername']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Date of birth</th>
              <td><input class="form-control" type="date" name="date" id="date" value="<?php echo $rsedit['dateofbirth']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Customer Address</th>
              <td><textarea class="form-control" name="customeraddress" id="customeraddress" cols="45" rows="5"><?php echo $rsedit['customeraddr']; ?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Mobile Number</th>
              <td><input class="form-control" type="text" name="mobilenumber" id="mobilenumber" value="<?php echo $rsedit['mobileno']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Login ID</th>
              <td><input class="form-control" type="text" name="loginid" id="loginid" value="<?php echo $rsedit['loginid']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Email ID</th>
              <td><input class="form-control" type="text" name="emailid" id="emailid" value="<?php echo $rsedit['emailid']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
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