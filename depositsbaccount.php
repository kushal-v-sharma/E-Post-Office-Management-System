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
				$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Credit','$_POST[accountno3]','$dt','$_POST[transcationtype]','Card number $_POST[cardnumber]','Active')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con); 
			}
			else
			{
						$insid=mysqli_insert_id($con);
				$sql ="UPDATE account SET status='Active' WHERE accountid='$_POST[accountid]'";
				mysqli_query($con,$sql);
				echo "<script>alert('Transcation record inserted successfully..');</script>";
		
				echo "<script>window.location='depositsbaccountreceipt.php?payid=" . $insid ."';</script>";
			}	
			
	}
}
if(isset($_GET['accountid']))
{
	$sqlsbaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqlsbaccountdet=mysqli_query($con,$sqlsbaccountdet);
	$rssbaccountdet=mysqli_fetch_array($qsqlsbaccountdet);
	
	$sqlsbaccount="select * from sbaccount WHERE status='Active' AND sbaccountid='$rssbaccountdet[actypeid]'";
	$qsqlsbaccount=mysqli_query($con,$sqlsbaccount);
	$rssbaccount=mysqli_fetch_array($qsqlsbaccount);
		
	$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]'";
	$qsqltransaction =mysqli_query($con,$sqltransaction);
	$rstransaction =mysqli_fetch_array($qsqltransaction);
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
	<h1>Deposit SB Account </h1>
        
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdepositsb" onsubmit="return validateform()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $rstransaction[0]; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
         <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287"><input class="form-control" type="text" name="accountno" id="accountno" value="<?php echo $_GET['accountid']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Payment Type</th>
              <td><select class="form-control" name="transcationtype" id="transcationtype">
                <option value="">select</option>
                <?php
				$arr=array("Debit Card", "Credit Card", "Master Card", "VISA");
				foreach($arr as $val)
				{
					if($val == $rsedit['acctype'])
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
              <th scope="row">Card Number</th>
              <td><input class="form-control" type="text" name="cardnumber" id="cardnumber" value="<?php echo $rsedit['amount']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">CVV Number</th>
              <td><input class="form-control" type="text" name="accountno2" id="accountno2" value="<?php echo $rsedit['customerid']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Expiry Date</th>
              <td><input class="form-control" type="date" name="accountopendate" min="<?php echo date("Y-m-d"); ?>" id="accountopendate" value="<?php echo $rsedit['acopendate']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Paid Amount</th>
              <td><input class="form-control" type="text" name="accountno3" id="accountno3" value="<?php echo $rsedit['customerid']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Deposit" /></td>
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
<script type="application/javascript" >
function validation()
{
	var balamt = parseFloat(document.frmdeposit.balamt.value);
	var mindeposit = parseFloat(document.frmdeposit.mindeposit.value);
	var accountno3 = parseFloat(document.frmdeposit.accountno3.value);
	
	var totalamt = balamt + accountno3;

	if( totalamt < mindeposit)
	{
		alert("minimum deposit amount is " + mindeposit);
		return false;
	}
	else
	{
		return true;
	}
}
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
if(document.frmdepositsb.accountno.value == "" && document.frmdepositsb.transcationtype.value == "" && document.frmdepositsb.cardnumber.value == ""  && document.frmdepositsb.accountno2.value == ""  && document.frmdepositsb.accountopendate.value == "" && document.frmdepositsb.accountno3.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmdepositsb.accountno.focus();
		return false;	
		}
	else if(document.frmdepositsb.accountno.value == "")
	{
		alert("Please enter Account Number ");
		document.frmdepositsb.accountno.focus();
		return false;	
	}
	else if(!document.frmdepositsb.accountno.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frmdepositsb.accountno.focus();
		return false;			
	}
	else if(document.frmdepositsb.transcationtype.value == "")
	{
		alert("Please select Payment Type ");
		document.frmdepositsb.transcationtype.focus();
		return false;	
	}
	else if(document.frmdepositsb.cardnumber.value == "")
	{
		alert("Please enter Card Number");
		document.frmdepositsb.cardnumber.focus();
		return false;	
	}
	else if(!document.frmdepositsb.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frmdepositsb.cardnumber.focus();
		return false;			
	}
	else if(document.frmdepositsb.cardnumber.value.length != 16) 
	{
		alert("Card Number should be of 16 digits");
		document.frmdepositsb.cardnumber.focus();
		return false;			
	}
	else if(document.frmdepositsb.accountno2.value == "")
	{
		alert("Please enter CVV Number");
		document.frmdepositsb.accountno2.focus();
		return false;	
	}
	
	else if(!document.frmdepositsb.accountno2.value.match(numericExpression))
	{
		alert("CVV Number is not valid");
		document.frmdepositsb.accountno2.focus();
		return false;			
	}
	else if(document.frmdepositsb.accountno2.value.length !=  3) 
	{
		alert("CVV Number should be of 3 digits");
		document.frmdepositsb.accountno2.focus();
		return false;			
	}
	else if(document.frmdepositsb.accountopendate.value == "")
	{
		alert("Please select date");
		document.frmdepositsb.accountopendate.focus();
		return false;	
	}
	else if(document.frmdepositsb.accountno3.value == "")
	{
		alert("Please enter amount");
		document.frmdepositsb.accountno3.focus();
		return false;	
	}
	else if(!document.frmdepositsb.accountno3.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmdepositsb.accountno3.focus();
		return false;			
	}
}
</script>