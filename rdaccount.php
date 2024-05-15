 <?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE rdaccount set title='$_POST[title]', docsreqd='$_POST[documentsrequired]', mindeposit='$_POST[minimumdeposit]', acprocedure='$_POST[accountprocedure]', threeyearinterest='$_POST[threeyearsinterest]', after5yearinterest='$_POST[fiveyearsinterest]', maximumyear='$_POST[maximumyear]', penaltypermonth='$_POST[penaltypermonth]', status='$_POST[status]' WHERE rdaccountid='$_GET[editid]'";
				if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('RD Account Record Updated Successfully..');</script>";
		}
	}
	else
	{
		$sql = "UPDATE rdaccount SET status='Inactive'";			
		$qsql = mysqli_query($con,$sql);
		$sql ="INSERT INTO rdaccount(title, docsreqd, mindeposit, acprocedure, threeyearinterest, after5yearinterest, maximumyear, penaltypermonth, status) VALUES ('$_POST[title]','$_POST[documentsrequired]','$_POST[minimumdeposit]','$_POST[accountprocedure]','$_POST[threeyearsinterest]','$_POST[fiveyearsinterest]','$_POST[maximumyear]','$_POST[penaltypermonth]','Active')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('RD Account Record Inserted Successfully..');</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	$sql ="SELECT * FROM rdaccount where rdaccountid='$_GET[editid]'";
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
        <p><h2>RD Account</h2></p>
        <h1>Add RD Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action"" name="frmrd" onsubmit="return validateform()">
        <table width="560" height="422" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Title</th>
              <td width="287"><input class="form-control" type="text" name="title" id="title" value="<?php echo $rsedit['title']; ?>" /></td>
            </tr>
            <tr>
              <th height="36" scope="row">Minimum  Deposit</th>
              <td><input class="form-control" type="text" name="minimumdeposit" id="minimumdeposit" value="<?php echo $rsedit['mindeposit']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Three Years Interest</th>
              <td><input class="form-control" type="text" name="threeyearsinterest" id="threeyearsinterest"  value="<?php echo $rsedit['threeyearinterest']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Five Years Interest</th>
              <td><input class="form-control" type="text" name="fiveyearsinterest" id="fiveyearsinterest"  value="<?php echo $rsedit['after5yearinterest']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><textarea class="form-control"  name="documentsrequired" id="documentsrequired" cols="45" rows="5"><?php echo $rsedit['docsreqd']; ?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Account Procedure</th>
              <td><textarea class="form-control"  name="accountprocedure" id="accountprocedure" cols="45" rows="5"><?php echo $rsedit['acprocedure']; ?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Maximum Year</th>
              <td><input class="form-control" type="text" name="maximumyear" id="maximumyear"  value="<?php echo $rsedit['maximumyear']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Penalty per month</th>
              <td><input class="form-control" type="text" name="penaltypermonth" id="penaltypermonth" value="<?php echo $rsedit['penaltypermonth']; ?>" /></td>
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
	if(document.frmrd.title.value == "" && document.frmrd.minimumdeposit.value == "" && document.frmrd.threeyearsinterest.value == ""  && document.frmrd.fiveyearsinterest.value == ""  && document.frmrd.documentsrequired.value == "" && document.frmrd.accountprocedure.value == ""  && document.frmrd.maximumyear.value == ""  && document.frmrd.penaltypermonth.value == "" && document.frmrd.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmrd.title.focus();
		return false;	
		
	}
	else if(document.frmrd.title.value == "")
	{
		alert("Please enter Title");
		document.frmrd.title.focus();
		return false;	
	}
	else if(!document.frmrd.title.value.match(alphaspaceExp))
	{
		alert("Title is not valid");
		document.frmrd.title.focus();
		return false;			
	}
	else if(document.frmrd.minimumdeposit.value == "")
	{
		alert("Please enter Miniimum Deposit Amount");
		document.frmrd.minimumdeposit.focus();
		return false;	
	}
	else if(!document.frmrd.minimumdeposit.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmrd.minimumdeposit.focus();
		return false;			
	}
	else if(document.frmrd.threeyearsinterest.value == "")
	{
		alert("Please enter Interest");
		document.frmrd.threeyearsinterest.focus();
		return false;	
	}
	else if(!document.frmrd.threeyearsinterest.value.match(numericExpression))
	{
		alert("Interst is not valid");
		document.frmrd.threeyearsinterest.focus();
		return false;			
	}
	else if(document.frmrd.fiveyearsinterest.value == "")
	{
		alert("Please enter Interest");
		document.frmrd.fiveyearsinterest.focus();
		return false;	
	}
	else if(!document.frmrd.fiveyearsinterest.value.match(numericExpression))
	{
		alert("Interst is not valid");
		document.frmrd.fiveyearsinterest.focus();
		return false;			
	}
	else if(document.frmrd.maximumyear.value == "")
	{
		alert("Please enter year");
		document.frmrd.maximumyear.focus();
		return false;	
	}
	else if(!document.frmrd.maximumyear.value.match(numericExpression))
	{
		alert("Year is not valid");
		document.frmrd.maximumyear.focus();
		return false;			
	}
	else if(document.frmrd.penaltypermonth.value == "")
	{
		alert("Please enter Penalty Amount");
		document.frmrd.penaltypermonth.focus();
		return false;	
	}
	else if(!document.frmrd.penaltypermonth.value.match(numericExpression))
	{
		alert("Penalty Amount is not valid");
		document.frmrd.penaltypermonth.focus();
		return false;			
	}
	else if(document.frmrd.status.value == "")
	{
		alert("Please select Status");
		document.frmrd.status.focus();
		return false;	
	}
}
</script>



