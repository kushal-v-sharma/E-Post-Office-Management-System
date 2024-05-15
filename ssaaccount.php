<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE ssaaccount set title='$_POST[title]', mindeposit='$_POST[minimumdeposit]', deposityr='$_POST[deposityear]', maturityyr='$_POST[maturityyear]', deposityr='$_POST[deposityr]' interest='$_POST[interest]', minyrdeposityr='$_POST[minimumdepositperyear]', maxyrdepyr='$_POST[maximumdepositperyear]', yrpenalty='$_POST[yearlypenalty]',eighteenyrwithdrawpercent='$_POST[eighteenyearwithdrawalpercentage]', docsreqd='$_POST[documentsrequired]', acprocedure='$_POST[accountprocedure]', status='$_POST[status]' WHERE ssaccountid='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('SSA Account Updated Successfully..');</script>";
		}
	}
	else
	{
		$sql = "UPDATE ssaaccount SET status='Inactive'";			
		$qsql = mysqli_query($con,$sql);
		$sql ="INSERT INTO ssaaccount(title, mindeposit, deposityr, maturityyr, deposityr, interest, minyrdeposityr, maxyrdepyr, yrpenalty, eighteenyrwithdrawpercent, docsreqd, acprocedure, status) VALUES ('$_POST[title]','$_POST[minimumdeposit]','$_POST[deposityear]','$_POST[maturityyear]', '$_POST[deposityr]''$_POST[interest]','$_POST[minimumdepositperyear]',	'$_POST[maximumdepositperyear]','$_POST[yearlypenalty]','$_POST[eighteenyearwithdrawalpercentage]','$_POST[documentsrequired]',
		'$_POST[accountprocedure]','Active')";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		echo "<script>alert('SSA Account Record Inserted Successfully..');</script>";
	}
}
if(isset($_GET['editid']))
{
	$sql="select * from ssaaccount where ssaccountid='$_GET[editid]'";
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
        <p><h2>SSA Account</h2></p>
        <h1>Add SSA Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmssa" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
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
              <th scope="row">Deposit Year</th>
              <td><input class="form-control" type="text" name="deposityear" id="deposityear" value="<?php echo $rsedit['deposityr']; ?>"  /></td>
            </tr>
            <tr>
              <th scope="row">Maturity Year</th>
              <td><input class="form-control" type="text" name="maturityyear" id="maturityyear" value="<?php echo $rsedit['maturityyr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Deposit Year</th>
              <td><input class="form-control" type="text" name="deposityr" id="deposityr" value="<?php echo $rsedit['maturityyr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest</th>
              <td><input class="form-control" type="text" name="interest" id="interest" value="<?php echo $rsedit['interest']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Minimum Deposit Per Year</th>
              <td><input class="form-control" type="text" name="minimumdepositperyear" id="minimumdepositperyear" value="<?php echo $rsedit['minyrdeposityr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Maximum Deposit per year</th>
              <td><input class="form-control" type="text" name="maximumdepositperyear" id="maximumdepositperyear" value="<?php echo $rsedit['maxyrdepyr']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Yearly Penalty</th>
              <td><input class="form-control" type="text" name="yearlypenalty" id="yearlypenalty" value="<?php echo $rsedit['yrpenalty']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Eighteen  Year Withdrawal Percentage</th>
              <td><input class="form-control" type="text" name="eighteenyearwithdrawalpercentage" id="EighteenYearWithdrawalPercentage" value="<?php echo $rsedit['eighteenyrwithdrawpercent']; ?>"  /></td>
            </tr>
            <tr>
              <th scope="row">Documents Required</th>
              <td><input class="form-control" type="text" name="documentsrequired" id="documentsrequired" value="<?php echo $rsedit['docsreqd']; ?>"  /></td>
            </tr>
            <tr>
              <th scope="row">Account Procedure</th>
              <td><input class="form-control" type="text" name="accountprocedure" id="accountprocedure" value="<?php echo $rsedit['acprocedure']; ?>" /></td>
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
	if(document.frmssa.title.value == "" && document.frmssa.minimumdeposit.value == "" && document.frmssa.deposityear.value == ""  && document.frmssa.maturityyear.value == ""  && document.frmssa.interest.value == "" && document.frmssa.minimumdepositperyear.value == ""  && document.frmssa.maximumdepositperyear.value == "" && document.frmssa.yearlypenalty.value == "" && document.frmssa.EighteenYearWithdrawalPercentage.value == "" && document.frmssa.documentsrequired.value == "" && document.frmssa.accountprocedure.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmssa.title.focus();
		return false;	
		
	}
	else if(document.frmssa.title.value == "")
	{
		alert("Please enter Title");
		document.frmssa.title.focus();
		return false;	
	}
	else if(!document.frmssa.title.value.match(alphaspaceExp))
	{
		alert("Title is not valid");
		document.frmssa.title.focus();
		return false;			
	}
	else if(document.frmssa.minimumdeposit.value == "")
	{
		alert("Please enter Minimum Deposit");
		document.frmssa.minimumdeposit.focus();
		return false;	
	}
	else if(!document.frmssa.minimumdeposit.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmssa.minimumdeposit.focus();
		return false;			
	}
	else if(document.frmssa.deposityear.value == "")
	{
		alert("Please enter Deposit Year");
		document.frmssa.deposityear.focus();
		return false;	
	}
	else if(!document.frmssa.deposityear.value.match(numericExpression))
	{
		alert("Year is not valid");
		document.frmssa.deposityear.focus();
		return false;			
	}
	else if(document.frmssa.maturityyear.value == "")
	{
		alert("Please enter Maturity Year");
		document.frmssa.maturityyear.focus();
		return false;	
	}
	else if(!document.frmssa.maturityyear.value.match(numericExpression))
	{
		alert("Year is not valid");
		document.frmssa.maturityyear.focus();
		return false;			
	}
	else if(document.frmssa.interest.value == "")
	{
		alert("Please enter Interst");
		document.frmssa.interest.focus();
		return false;	
	}
	else if(!document.frmssa.interest.value.match(numericExpression))
	{
		alert("Interst is not valid");
		document.frmssa.interest.focus();
		return false;			
	}
	else if(document.frmssa.minimumdepositperyear.value == "")
	{
		alert("Please enter Minimum Deposit Amount");
		document.frmssa.minimumdepositperyear.focus();
		return false;	
	}
	else if(!document.frmssa.minimumdepositperyear.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmssa.minimumdepositperyear.focus();
		return false;			
	}
	else if(document.frmssa.maximumdepositperyear.value == "")
	{
		alert("Please enter Maximum Deposit Amount");
		document.frmssa.maximumdepositperyear.focus();
		return false;	
	}
	else if(!document.frmssa.maximumdepositperyear.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmssa.maximumdepositperyear.focus();
		return false;			
	}
	else if(document.frmssa.yearlypenalty.value == "")
	{
		alert("Please enter Yearly Penalty");
		document.frmssa.yearlypenalty.focus();
		return false;	
	}
	else if(!document.frmssa.yearlypenalty.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmssa.yearlypenalty.focus();
		return false;			
	}
	else if(document.frmssa.EighteenYearWithdrawalPercentage.value == "")
	{
		alert("Please enter Withdraw Amount");
		document.frmssa.EighteenYearWithdrawalPercentage.focus();
		return false;	
	}
	else if(!document.frmssa.EighteenYearWithdrawalPercentage.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmssa.EighteenYearWithdrawalPercentage.focus();
		return false;			
	}
	else
	{
		return true;
	}
}
</script>



