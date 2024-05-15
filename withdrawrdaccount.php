<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	$dt = date("Y-m-d");
	if(isset($_GET['editid']))
	{
		$sql="UPDATE transaction set accountid='$_POST[fromaccountno]', customerid='$_POST[toaccountno]', transactiontype='$_POST[transcationtype]', amount='$_POST[amount]', transdate='$_POST[transactiondate]', note='$_POST[note]', status='$_POST[status]' WHERE transactionid='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Transaction record updated successfully..');</script>";
		}
	}
	else
	{
				$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Debit','$_POST[withdrawamount]','$dt','Online','Bank Account Number $_POST[bankaccountnumber]','Active')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
			
				echo "<script>alert('Transcation amount withdrawn successfully..');</script>";
				$insid = mysqli_insert_id($con);
				echo "<script>window.location='withdrawrdaccountreceipt.php?payid=" .  $insid . "';</script>";
			}	
			
	}
}
if(isset($_GET['accountid']))
{
	$sqlrdaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqlrdaccountdet=mysqli_query($con,$sqlrdaccountdet);
	$rsrdaccountdet=mysqli_fetch_array($qsqlrdaccountdet);
	
	$sqlrdaccount="select * from tdaccount WHERE status='Active' AND tdaccount_id='$rstdaccountdet[actypeid]'";
	$qsqlrdaccount=mysqli_query($con,$sqlrdaccount);
	$rsrdaccount=mysqli_fetch_array($qsqlrdaccount);
		
	
					$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				$balamt = $totcredit - $totdebit;
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
      <div class="right-column-heading"><br />
<h2>Withdraw RD Account</h2>
        <h1>Add Transaction Record</h1>
      </div>
      <div class="right-column-content">
      <?php
      	$sql="SELECT * FROM account WHERE acctype='Recurring deposit' AND accountid='$_GET[accountid]'";
		$qsql=mysqli_query($con,$sql);
		$rsarr =mysqli_fetch_array($qsql);		
		
		$now = time(); // or your date as well
		$acopendt = $rsarr["acopendate"];
     	$your_date = strtotime($acopendt);
    	$datediff = $now - $your_date;
     	$nodays = floor($datediff/(60*60*24));
		if($nodays > 1098)
		{
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$rsarr[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$rsarr[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				 $totamt = $totcredit - $totdebit;
				 
				 if($nodays < 1830)
				 {
				 $interstamt = 4;
				 $interest = ($interstamt*$totamt / 100);
				 }
				 if($nodays >= 1830)
				 {
				 $interstamt = 8.5;
				 $interest = ($interstamt*$totamt / 100);
				 }
      ?>
      <form method="post" action="" name="frmwithdrawrd" onsubmit="return validation()">   
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $balamt; ?>" />
         <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287"><input class="form-control" type="text" name="accountno" id="accountno" value="<?php echo $_GET['accountid']; ?>"/></td>
            </tr>
            
            <tr>
              <th scope="row">Bank Account Number</th>
              <td><input class="form-control" type="text" name="bankaccountnumber" id="bankaccountnumber" /></td>
            </tr>
            <tr>
              <th scope="row">Bank Name</th>
              <td><input class="form-control" type="text" name="bankname" id="bankname" /></td>
            </tr>
            <tr>
              <th scope="row">Branch</th>
              <td><input class="form-control" type="text" name="branch" id="branch" /></td>
            </tr>
            <tr>
              <th scope="row">IFSC Number</th>
              <td><input class="form-control" type="text" name="ifsc" id="ifsc" /></td>
            </tr>
            <tr>
              <th scope="row">Withdarw Amount</th>
              <td><input class="form-control" type="text" name="withdraw" id="withdraw"  value="<?php echo $totamt; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Interest Amount</th>
              <td><input class="form-control" type="text" name="intersetamount" id="intersetamount"  value="<?php echo $interest; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Total withdrawalable amount</th>
              <td><input class="form-control" type="text" name="withdrawamount" id="withdrawamount"  value="<?php echo $totamt + $interest; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Withdraw" /></td>
            </tr>
          </tbody>
        </table>
        </form>
        <?php
		}
		else
		{
			?>
            <table width="560" height="140" border="3" class="tftable">
          <tbody>
            <tr>
              <th height="46" colspan="2" scope="row"><div align="center">You have not completed 3 years..</div></th>
            </tr>
            
            <tr>
              <th width="253" height="40" scope="row">Account Number</th>
              <td width="287"><?php echo $_GET['accountid']; ?></td>
            </tr>
            <tr>
              <th height="40" scope="row">Account open date</th>
              <td>&nbsp;<?php echo $rsarr['acopendate']; ?></td>
            </tr>
            </tbody>
        </table>
        <?php
		}
		?>
        <h1>&nbsp;</h1>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>
<script type="application/javascript" >
function validation()
{
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   
	var balamt = parseFloat(document.frmdeposit.balamt.value);
	var mindeposit = parseFloat(document.frmdeposit.mindeposit.value);
	var withdrawamount = parseFloat(document.frmdeposit.withdrawamount.value);
	
	var withdrawalamt = balamt- mindeposit;

	if( withdrawamount > withdrawalamt)
	{
		alert("You can withdraw only " + withdrawalamt);
		return false;
	}
	
	else if(document.frmwithdrawrd.bankaccountnumber.value == "" && document.frmwithdrawrd.bankname.value == ""  && document.frmwithdrawrd.branch.value == ""  && document.frmwithdrawrd.ifsc.value == "")
	{
		alert("Kindly enter all the details...");
		document.frmwithdrawrd.bankaccountnumber.focus();
		return false;
	}
	else if(document.frmwithdrawrd.bankaccountnumber.value == "")
	{
		alert("Please enter Bank Account Number");
		document.frmwithdrawrd.bankaccountnumber.focus();
		return false;
	}
	else if(!document.frmwithdrawrd.bankaccountnumber.value.match(numericExpression))
	{
		alert("Bank Account is not valid");
		document.frmwithdrawrd.bankaccountnumber.focus();
		return false;
	}
	else if(document.frmwithdrawrd.bankname.value == "")
	{
		alert("Please enter Bank Name");
		document.frmwithdrawrd.bankname.focus();
		return false;
	}
	else if(document.frmwithdrawrd.bankname.value.match(alphaExp))
	{
		alert("Bank Name is not valid");
		document.frmwithdrawrd.bankname.focus();
		return false;
	}
	else if(document.frmwithdrawrd.branch.value == "")
	{
		alert("Please enter Branch Name");
		document.frmwithdrawrd.branch.focus();
		return false;
	}
	else if(!document.frmwithdrawrd.branch.value.match(alphaExp))
	{
		alert("Branch Name is not valid");
		document.rmwithdrawrd.branch.focus();
		return false;
	}
	else if(document.frmwithdrawrd.ifsc.value == "")
	{
		alert("Please provide IFSC number");
		document.frmwithdrawrd.ifsc.focus();
		return false;
	}
	else if(!document.frmwithdrawrd.ifsc.value.match(alphaNumericExp))
	{
		alert("IFSC number is not valid");
		document.frmwithdrawrd.ifsc.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>