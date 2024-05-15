<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE tdaccount set title='$_POST[title]', mindeposit='$_POST[minimumdeposit]', int1yr='$_POST[interestonfirstyear]', int2yr='$_POST[interestonsecondyear]', int3yr='$_POST[interestonthirdyear]', int5yr='$_POST[interestonfifthyear]', docsreqrd='$_POST[documentsrequired]', acprocedure='$_POST[accountprocedure]', status='$_POST[status]' WHERE tdaccount_id='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('TD Account Updated Successfully..');</script>";
		}
	}
	else
	{
		$sql = "UPDATE tdaccount SET status='Inactive'";			
		$qsql = mysqli_query($con,$sql);
	$sql ="INSERT INTO tdaccount(title, mindeposit, int1yr, int2yr, int3yr, int5yr, docsreqrd, acprocedure, status) VALUES ('$_POST[title]','$_POST[minimumdeposit]','$_POST[interestonfirstyear]','$_POST[interestonsecondyear]','$_POST[interestonthirdyear]','$_POST[interestonfifthyear]','$_POST[documentsrequired]','$_POST[accountprocedure]','Active')";
				if(!$qsql = mysqli_query($con,$sql))
				{
					echo mysqli_error($con);
				}
				else
				{
					echo "<script>alert('TD Account Record Inserted Successfully..');</script>";
				}	
			}
}
if(isset($_GET['editid']))
{
	$sql="select * from tdaccount where tdaccount_id='$_GET[editid]'";
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
        <p><h2>TD Account</h2></p>
        <h1>Add TD Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmtd" onsubmit="return validateform()">
        <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Title</th>
              <td width="287"><input class="form-control" type="text" name="title" id="title" value="<?php echo $rsedit['title']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Minimum  Deposit</th>
              <td><input class="form-control" type="text" name="minimumdeposit" id="minimumdeposit" value="<?php echo $rsedit['mindeposit']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest On First Year</th>
              <td><input class="form-control" type="text" name="interestonfirstyear" id="interestonfirstyear" value="<?php echo $rsedit['int1yr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest On Second Year</th>
              <td><input class="form-control" type="text" name="interestonsecondyear" id="interestonsecondyear" value="<?php echo $rsedit['int2yr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest On Third Year</th>
              <td><input class="form-control" type="text" name="interestonthirdyear" id="interestonthirdyear" value="<?php echo $rsedit['int3yr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest On Fifth Year</th>
              <td><input class="form-control" type="text" name="interestonfifthyear" id="interestonfifthyear" value="<?php echo $rsedit['int5yr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><input class="form-control" type="file" name="documentsrequired" id="documentsrequired" value="<?php echo $rsedit['docsreqrd']; ?>" /></td>
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
				   echo "<option value='$val'>$val</option>";
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
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
if(document.frmtd.title.value == "" && document.frmtd.minimumdeposit.value == "" && document.frmtd.interestonfirstyear.value == ""  && document.frmtd.interestonsecondyear.value == ""  && document.frmtd.interestonthirdyear.value == "" && document.frmtd.interestonfifthyear.value == "" && document.frmtd.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmtd.title.focus();
		return false;	
	}
	else if(document.frmtd.title.value == "")
	{
		alert("Please enter Title");
		document.frmtd.title.focus();
		return false;	
	}
	else if(!document.frmtd.title.value.match(alphaspaceExp))
	{
		alert("Title is not valid");
		document.frmtd.title.focus();
		return false;			
	}
	else if(document.frmtd.minimumdeposit.value == "")
	{
		alert("Please enter Minimum Deposit Amount");
		document.frmtd.minimumdeposit.focus();
		return false;	
	}
	else if(!document.frmtd.minimumdeposit.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmtd.minimumdeposit.focus();
		return false;			
	}
	else if(document.frmtd.interestonfirstyear.value == "")
	{
		alert("Please enter Interst On First Year");
		document.frmtd.interestonfirstyear.focus();
		return false;	
	}
	else if(!document.frmtd.interestonfirstyear.value.match(numericExpression))
	{
		alert("Interest is not valid");
		document.frmtd.interestonfirstyear.focus();
		return false;			
	}
	else if(document.frmtd.interestonsecondyear.value == "")
	{
		alert("Please enter Interst On Second Year");
		document.frmtd.interestonsecondyear.focus();
		return false;	
	}
	else if(!document.frmtd.interestonsecondyear.value.match(numericExpression))
	{
		alert("Interest is not valid");
		document.frmtd.interestonsecondyear.focus();
		return false;			
	}
	else if(document.frmtd.interestonthirdyear.value == "")
	{
		alert("Please enter Interst On Third Year");
		document.frmtd.interestonthirdyear.focus();
		return false;	
	}
	else if(!document.frmtd.interestonthirdyear.value.match(numericExpression))
	{
		alert("Interest is not valid");
		document.frmtd.interestonthirdyear.focus();
		return false;			
	}
	else if(document.frmtd.interestonfifthyear.value == "")
	{
		alert("Please enter Interst On Fifth Year");
		document.frmtd.interestonfifthyear.focus();
		return false;	
	}
	else if(!document.frmtd.interestonfifthyear.value.match(numericExpression))
	{
		alert("Interest is not valid");
		document.frmtd.interestonfifthyear.focus();
		return false;			
	}
	else if(document.frmtd.status.value == "")
	{
		alert("Please select Status");
		document.frmtd.status.focus();
		return false;	
	}
}
</script>



