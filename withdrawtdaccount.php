<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_GET['accountid']))
{
	$sqltdaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqltdaccountdet=mysqli_query($con,$sqltdaccountdet);
	$rstdaccountdet=mysqli_fetch_array($qsqltdaccountdet);
	
	$sqltdaccount="select * from tdaccount WHERE status='Active' AND tdaccount_id='$rstdaccountdet[actypeid]'";
	$qsqltdaccount=mysqli_query($con,$sqltdaccount);
	$rstdaccount=mysqli_fetch_array($qsqltdaccount);

	$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Credit'";
	$qsqltransaction =mysqli_query($con,$sqltransaction);
	$rstransaction =mysqli_fetch_array($qsqltransaction);
	$totcredit = $rstransaction[0];

	$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Debit'";
	$qsqltransaction =mysqli_query($con,$sqltransaction);
	$rstransaction =mysqli_fetch_array($qsqltransaction);
	$totdebit = $rstransaction[0];
	
	$balamt = $totcredit - $totdebit;
	

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
<h2>Withdraw TD Account</h2>
        <h1>Add Transaction Record</h1>
      </div>
      <div class="right-column-content">
<?php
$sql="SELECT * FROM account WHERE acctype= 'Time deposit' and accountid='$_GET[accountid]'";
$qsql=mysqli_query($con,$sql);
$rsarr =mysqli_fetch_array($qsql);


		
$now = time(); // or your date as well
$acopendt = $rsarr["acopendate"];
$your_date = strtotime($acopendt);
$datediff = $now - $your_date;
$nodays = floor($datediff/(60*60*24));
$noyear = $nodays/366;
		
$totnodays = $rsarr['numofyrs']*366;
$widraweligibledays = $totnodays/2;
$yrs = $rsarr['numofyrs']/2;

$widraweligibledate =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($acopendt)) . " + $widraweligibledays day"));

// $totnodays - Total number of days to withdraw full amount
// $nodays - Total number of days account created
// $widraweligibledays - half withdrawable days

//Coding to check half year
$now = strtotime(date("Y-m-d")); // or your date as well
$acopendt = $widraweligibledate;
$your_date = strtotime($acopendt);
$datediff = $now - $your_date;
$nohalfdays = floor($datediff/(60*60*24));

if($rsarr['numofyrs'] == 1)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int1yr']; 		
  }
  else if($nodays >= $widraweligibledays )
  {					  
 $intyrly = $rstdaccount['int1yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  }
}
else if($rsarr['numofyrs'] == 2)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int2yr']; 		
  }
  else if($nodays >= $widraweligibledays)
  {					  
 $intyrly = $rstdaccount['int2yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  }
}
else if($rsarr['numofyrs'] == 3)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int3yr']; 		
  }
  else if($nodays >= $widraweligibledays)
  {					  
 $intyrly = $rstdaccount['int3yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  } 
}
else if($rsarr['numofyrs'] == 5)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int5yr']; 		
  }
  else if($nodays >= $widraweligibledays)
  {					  
 $intyrly = $rstdaccount['int5yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  }
}			
}

//if($noyear > $yrs)	
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
				 
				 $interestamt=0;

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
			$intrestamt = 0;
		  for($yer = 0; $yer < $rsarr['numofyrs']; $yer++)
		  {
			  $intrestamt = (($intyrly * $totamt /100));
			  	$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Credit','$intrestamt','$dt','Online','$intyrly% interest for TD','Active')";
				mysqli_query($con,$sql);
		  }
		$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Debit','$_POST[totwithdrawamount]','$dt','Online','Bank Account Number $_POST[bankaccountnumber]','Active')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Transcation amount withdrawn successfully..');</script>";
				$insid = mysqli_insert_id($con);
				echo "<script>window.location='withdrawtdaccountreceipt.php?payid=" .  $insid . "';</script>";
		}
		$sql ="UPDATE account SET acclosedate='$dt',status='Closed' WHERE accountid='$_POST[accountid]'";
		$qsql = mysqli_query($con,$sql);
	}
}
?>      
      <form method="post" action="" name="frmwithdrawtd" onsubmit="return validation()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $balamt; ?>" />
         <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287"><input class="form-control" type="text" name="accountno" id="accountno" value="<?php echo $_GET['accountid']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <th scope="row">Account opened date</th>
              <td><input class="form-control" type="text" name="acopendate" id="acopendate" value="<?php echo $acopendt; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <th scope="row">Account close date</th>
              <td><input class="form-control" type="text" name="acclosedate" id="acclosedate" value="<?php  echo date("Y-m-d", strtotime(date("Y-m-d", strtotime($acopendt)) . " + $rsarr[numofyrs] year")); ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <th scope="row">Interest per year (in Percentage)</th>
              <td><input class="form-control" type="text" name="yearintrst" id="yearintrst" value="<?php echo $intyrly; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <th scope="row">Number of  years</th>
              <td><input class="form-control" type="text" name="maturityyear" id="maturityyear" value="<?php echo $rsarr['numofyrs']; ?>" readonly="readonly" /></td>
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
              <td><input class="form-control" type="text" name="Branch" id="Branch" /></td>
            </tr>
            <tr>
              <th scope="row">IFSC Number</th>
              <td><input class="form-control" type="text" name="ifsc" id="ifsc" /></td>
            </tr>
            <tr>
              <th scope="row"> Amount</th>
              <td><input class="form-control" type="text" name="amt" id="amt" readonly="readonly" value="<?php echo $totamt; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Interest  Amount - <?php echo $intyrly; ?> %</th>
              <td><input class="form-control" type="text" name="interestamt" id="interestamt" readonly="readonly" value="<?php 
			 // $intyrly 			
			  $intrestamt = 0;
			  for($yer = 0; $yer < $rsarr['numofyrs']; $yer++)
			  {
				  $intrestamt = $intrestamt +  (($intyrly * $totamt /100));
			  }
			  echo $intrestamt; 
			  ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Total Withdrawlable Amount</th>
              <td><input class="form-control" type="text" name="totwithdrawamount" id="totwithdrawamount" readonly="readonly" value="<?php echo $totamt+$intrestamt; ?>" /></td>
            </tr>
            <tr>
              <th colspan="2" scope="row">
                <div align="center">
                <?php
				if($intyrly == 0)
				{
					echo "You have not completed half period to withdraw amount";
				}
				else
				{
				?>
                  <input class="btn btn-info" type="submit" name="submit" id="submit" value="Withdraw" />
                  <?php
				}
				?>
                </div></th>
              </tr>
          </tbody>
        </table>
        </form>
<?php
}
//else
{
?>
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
	else if(document.frmwithdrawtd.bankaccountnumber.value == "" && document.frmwithdrawtd.bankname.value == ""  && document.frmwithdrawtd.branch.value == ""  && document.frmwithdrawtd.ifsc.value == "")
	{
		alert("Kindly enter all the details...");
		document.frmwithdrawtd.bankaccountnumber.focus();
		return false;
	}
	else if(document.frmwithdrawtd.bankaccountnumber.value == "")
	{
		alert("Please enter Bank Account Number");
		document.frmwithdrawtd.bankaccountnumber.focus();
		return false;
	}
	else if(!document.frmwithdrawtd.bankaccountnumber.value.match(numericExpression))
	{
		alert("Bank Account is not valid");
		document.frmwithdrawtd.bankaccountnumber.focus();
		return false;
	}
	else if(document.frmwithdrawtd.bankname.value == "")
	{
		alert("Please enter Bank Name");
		document.frmwithdrawtd.bankname.focus();
		return false;
	}
	else if(document.frmwithdrawtd.bankname.value.match(alphaExp))
	{
		alert("Bank Name is not valid");
		document.frmwithdrawtd.bankname.focus();
		return false;
	}
	else if(document.frmwithdrawtd.branch.value == "")
	{
		alert("Please enter Branch Name");
		document.frmwithdrawtd.branch.focus();
		return false;
	}
	else if(!document.frmwithdrawtd.branch.value.match(alphaExp))
	{
		alert("Branch Name is not valid");
		document.frmwithdrawtd.branch.focus();
		return false;
	}
	else if(document.frmwithdrawtd.ifsc.value == "")
	{
		alert("Please provide IFSC number");
		document.frmwithdrawtd.ifsc.focus();
		return false;
	}
	else if(!document.frmwithdrawtd.ifsc.value.match(alphaNumericExp))
	{
		alert("IFSC number is not valid");
		document.frmwithdrawtd.ifsc.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>