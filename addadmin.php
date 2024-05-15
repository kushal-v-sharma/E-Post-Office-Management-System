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
			echo "<script>alert('Admin Record Updated Successfully..');</script>";
		}
}
if(isset($_GET['editid']))
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
        <h1>Add Admin Record<img src="images/addadmin.jpg" width="150" height="150" alt=""/></h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmaddadmin" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Admin name</th>
              <td width="287"><input class="form-control" type="text" name="adminname" id="adminname" value="<?php echo $rsedit['adminname']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Login ID</th>
              <td><input class="form-control" type="text" name="loginid" id="loginid" value="<?php echo $rsedit['loginid']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Password</th>
              <td><input class="form-control" type="password" name="password" id="password" value="<?php echo $rsedit['password']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Confirm password</th>
              <td><input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value="<?php echo $rsedit['password']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">User type</th>
              <td><select class="form-control" name="usertype" id="usertype" >
                <option value="">Select</option>
                <?php
				$arr=array("Admin","Employee");
				foreach($arr as $val)
				{
					echo "<option value='$val'>$val</option>";
				}
				?>
              </select></td>
            </tr>
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr= array("Active","Inactive");
				foreach($arr as $val)
				{
					echo "<option value='$val'>$val</option>";
				}
				?>
              </select></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Add" /></td>
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
	if(document.frmaddadmin.adminname.value == "" && document.frmaddadmin.loginid.value == "" && document.frmaddadmin.password.value == ""  && document.frmaddadmin.confirmpassword.value == ""  && document.frmaddadmin.usertype.value == "" && document.frmaddadmin.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmaddadmin.adminname.focus();
		return false;	
		
	}
	else if(document.frmaddadmin.adminname.value == "")
	{
		alert("Please enter Admin Name");
		document.frmaddadmin.adminname.focus();
		return false;	
	}
	else if(!document.frmaddadmin.adminname.value.match(alphaspaceExp))
	{
		alert("Admin Name is not valid");
		document.frmaddadmin.adminname.focus();
		return false;			
	}
	else if(document.frmaddadmin.loginid.value == "")
	{
		alert("Kindly provide Login ID");
		document.frmaddadmin.loginid.focus();
		return false;
	}
	else if(document.frmaddadmin.password.value == "")
	{
		alert("Please enter Password");
		document.frmaddadmin.password.focus();
		return false;
	}
	else if(document.frmaddadmin.password.value.length < 8) 
	{
		alert("Password should be more than 8 characters..");
		document.frmaddadmin.password.focus();
		return false;
	}
	else if(document.frmaddadmin.confirmpassword.value != document.frmaddadmin.password.value) 
	{
		alert("Password and Confirm password should be same..");
		document.frmaddadmin.confirmpassword.focus();
		return false;
	}
	
	else if(document.frmaddadmin.usertype.value == "") 
	{
		alert("Kindly select Usertype");
		document.frmaddadmin.usertype.focus();
		return false;
	}
	else if(document.frmaddadmin.status.value == "") 
	{
		alert("Kindly select Status");
		document.frmaddadmin.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
