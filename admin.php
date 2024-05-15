<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE admin set adminname='$_POST[adminname]', loginid='$_POST[loginid]', password='$_POST[password]', usertype='$_POST[usertype]', status='$_POST[status]'  WHERE adminid='$_GET[editid]'";
				if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Admin Record Updated Successfully..');</script>";
		}
	}
	else
	{
		$sql ="INSERT INTO admin(adminname, loginid, password, usertype, status) VALUES ('$_POST[adminname]','$_POST[loginid]','$_POST[password]','$_POST[usertype]','$_POST[status]')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Admin Record Inserted Successfully..');</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	$sql ="SELECT * FROM admin where adminid='$_GET[editid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
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
      <form method="post" action="" name="frmadmin" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable"> 
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
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" />
           
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
function seselecttypelecttype(select)
{
	window.location="account.php?actype="+select;
}
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frmadmin.adminname.value == "" && document.frmadmin.loginid.value == "" && document.frmadmin.password.value == ""  && document.frmadmin.confirmpassword.value == ""  && document.frmadmin.usertype.value == "" && document.frmadmin.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmadmin.adminname.focus();
		return false;	
		
	}
	else if(document.frmadmin.adminname.value == "")
	{
		alert("Please enter Admin Name");
		document.frmadmin.adminname.focus();
		return false;	
	}
	else if(!document.frmadmin.adminname.value.match(alphaspaceExp))
	{
		alert("Admin Name is not valid");
		document.frmadmin.adminname.focus();
		return false;			
	}
	else if(document.frmadmin.loginid.value == "")
	{
		alert("Kindly provide Login ID");
		document.frmadmin.loginid.focus();
		return false;
	}
	else if(document.frmadmin.password.value == "")
	{
		alert("Please enter Password");
		document.frmadmin.password.focus();
		return false;
	}
	else if(document.frmadmin.password.value.length < 8) 
	{
		alert("Password should be more than 8 characters..");
		document.frmadmin.password.focus();
		return false;
	}
	else if(document.frmadmin.confirmpassword.value != document.frmadmin.password.value) 
	{
		alert("Password and Confirm password should be same..");
		document.frmadmin.confirmpassword.focus();
		return false;
	}
	
	else if(document.frmadmin.usertype.value == "") 
	{
		alert("Kindly select Usertype");
		document.frmadmin.usertype.focus();
		return false;
	}
	else if(document.frmadmin.status.value == "") 
	{
		alert("Kindly select Status");
		document.frmadmin.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
