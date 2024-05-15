<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE sbaccount set title='$_POST[title]', mindeposit='$_POST[minimumdeposit]', interestperyear='$_POST[interestperyear]', minbal='$_POST[minimumbalance]', documentsreqd='$_POST[documentsrequired]', acprocedure='$_POST[accountprocedure]', status='$_POST[status]' WHERE sbaccountid='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Saving Bank Account Updated Successfully..');</script>";
		}
	}
	else
	{
		$sql = "UPDATE sbaccount SET status='Inactive'";			
		$qsql = mysqli_query($con,$sql);
		$sql ="INSERT INTO sbaccount(title, mindeposit, interestperyear, minbal, documentsreqd, acprocedure, status) VALUES ('$_POST[title]','$_POST[minimumdeposit]','$_POST[interestperyear]','$_POST[minimumbalance]','$_POST[documentsrequired]','$_POST[accountprocedure]','Active')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Saving Bank Account Record Inserted Successfully..');</script>";
		}	
	}
}
if(isset($_GET['editid']))
{
	$sql="select * from sbaccount where sbaccountid='$_GET[editid]'";
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
      <div class="right-column-heading"><h2>Saving Bank Account</h2>
        <h1>Add SB Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmsb" onsubmit="return validateform()"> 
        <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Title</th>
              <td width="287"><input class="form-control" type="text" name="title" id="title" value="<?php echo $rsedit['title']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Minimum deposit</th>
              <td><input class="form-control" type="text" name="minimumdeposit" id="minimumdeposit" value="<?php echo $rsedit['mindeposit']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest per year</th>
              <td><input class="form-control" type="text" name="interestperyear" id="interestperyear" value="<?php echo $rsedit['interestperyear']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Minimum balance</th>
              <td><input class="form-control" type="text" name="minimumbalance" id="minimumbalance" value="<?php echo $rsedit['minbal']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><textarea class="form-control"  name="documentsrequired" id="documentsrequired" cols="45" rows="5"><?php echo $rsedit['documentsreqd']; ?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Account Procedure</th>
              <td><textarea class="form-control"  name="accountprocedure" id="accountprocedure" cols="45" rows="5"><?php echo $rsedit['acprocedure']; ?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr=array("Active","Inactive");
				foreach($arr as $val)
				{
					if($val == $rsedit['status'])
					{
					echo "<option value='$val' selected>$val</option>";
					}
					else
					{
					echo "<option value='$val'>$val</option>";
					}
				}
				?>
              </select></td>
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
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9.]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frmsb.title.value == "" && document.frmsb.minimumdeposit.value == "" && document.frmsb.interestperyear.value == ""  && document.frmsb.minimumbalance.value == ""  && document.frmsb.documentsrequired.value == "" && document.frmsb.accountprocedure.value == ""  && document.frmsb.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmsb.title.focus();
		return false;	
		
	}
	else if(document.frmsb.title.value == "")
	{
		alert("Please enter Title");
		document.frmsb.title.focus();
		return false;	
	}
	else if(!document.frmsb.title.value.match(alphaspaceExp))
	{
		alert("Title is not valid");
		document.frmsb.title.focus();
		return false;			
	}
	else if(document.frmsb.minimumdeposit.value == "")
	{
		alert("Please enter Miniimum Deposit Amount");
		document.frmsb.minimumdeposit.focus();
		return false;	
	}
	else if(!document.frmsb.minimumdeposit.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmsb.minimumdeposit.focus();
		return false;			
	}
	else if(document.frmsb.interestperyear.value == "")
	{
		alert("Please enter Interest");
		document.frmsb.interestperyear.focus();
		return false;	
	}
	else if(!document.frmsb.interestperyear.value.match(numericExpression))
	{
		alert("Interst is not valid");
		document.frmsb.interestperyear.focus();
		return false;			
	}
	else if(document.frmsb.minimumbalance.value == "")
	{
		alert("Please enter Minimum Balance");
		document.frmsb.minimumbalance.focus();
		return false;	
	}
	else if(!document.frmsb.minimumbalance.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmsb.minimumbalance.focus();
		return false;			
	}
	else if(document.frmsb.status.value == "")
	{
		alert("Please select Status");
		document.frmsb.status.focus();
		return false;	
	}
	else
	{
		return true;
	}
}
</script>



