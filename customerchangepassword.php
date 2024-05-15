<?php
error_reporting(0);session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	$sql ="UPDATE customer set password='" . $_POST['newpassword'] . "' WHERE customerid='" . $_SESSION['customerid'] . "' AND password='" . $_POST['oldpassword'] . "'";
	if(!$qsql = mysqli_query($con,$sql))
	{
		echo mysqli_error($con);
	}
	if(mysqli_affected_rows($con) ==1)
	{
		echo "<script>alert('Customer Password updated successfully..');</script>";
		echo "<script>window.location='customerchangepassword.php';</script>";
	}
	else
	{
		echo "<script>alert('Failed to update password..');</script>";
	}
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
      <p>	<h1>&nbsp;</h1>
        <h1>Change Customer Password  </h1>
        </p>
        <h1><img src="images/images(7).jpg" width="193" height="154" alt=""/> </h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmchangepass" onSubmit="return validateform()">
        <table width="560" height="243" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" height="56" scope="row">Old Password</th>
              <td width="287"><input class="form-control" type="password" name="oldpassword" id="oldpassword" /></td>
            </tr>
            <tr>
              <th height="57" scope="row">New Password</th>
              <td><input class="form-control" type="password" name="newpassword" id="newpassword" /></td>
            </tr>
            <tr>
              <th height="60" scope="row">Confirm Password</th>
              <td><input class="form-control" type="password" name="confirmpassword" id="confirmpassword" /></td>
            </tr>
            <tr>
              <th height="54" scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Change Password" /></td>
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
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   
function validateform()
{
	if(document.frmchangepass.oldpassword.value == "")
	{
		alert("Old Password should not be empty..");
		document.frmchangepass.oldpassword.focus();
		return false;
	}
	else if(document.frmchangepass.newpassword.value == "")
	{
		alert("Password should not be empty..");
		document.frmchangepass.newpassword.focus();
		return false;
	}
	else if(!document.frmchangepass.newpassword.value.match(alphaNumericExp))
	{
		alert("Password should contain only alpha numeric characters...");
		document.frmchangepass.newpassword.focus();
		return false;
	}
	else if(document.frmchangepass.newpassword.value.length < 6)
	{
		alert("Password should be more than 6 characters..");
		document.frmchangepass.newpassword.focus();
		return false;
	}
	else if(document.frmchangepass.newpassword.value != document.frmchangepass.confirmpassword.value)
	{
		alert("New Password and Confirm password not matching...");
		document.frmchangepass.confirmpassword.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>