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

		if($_POST['transcationtype3'] == "SB Account")
		{
			$paymentcredentials = $_POST['transcationtype3'] . "  Account number -  " . $_POST['transcationtype'];
		$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[transcationtype]','$_SESSION[customerid]','Debit','$_POST[accountno3]','$dt','Transaction','TD Deposit $_POST[accountid]','Active')";
		$qsql = mysqli_query($con,$sql);
		}
		else
		{
			$paymentcredentials =  $_POST['transcationtype3'] ." - Card number" . $_POST['cardnumber'];
		}
	
				$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Credit','$_POST[accountno3]','$dt','$_POST[transcationtype3]','$paymentcredentials','Active')";
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
				
				echo "<script> window.location='deposittdaccountreceipt.php?payid=". $insid ."';</script>";
			}	
			
	}
}
if(isset($_GET['accountid']))
{
	$sqltdaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqltdaccountdet=mysqli_query($con,$sqltdaccountdet);
	$rstdaccountdet=mysqli_fetch_array($qsqltdaccountdet);
	
	$sqltdaccount="select * from tdaccount WHERE status='Active' AND tdaccount_id='$rstdaccountdet[actypeid]'";
	$qsqltdaccount=mysqli_query($con,$sqltdaccount);
	$rstdaccount=mysqli_fetch_array($qsqltdaccount);
		
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
<h1>Deposit TD Account </h1>
   
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdeposittd" onsubmit="return validateform()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $rstransaction[0]; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
         <table width="560" height="179" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" height="43" scope="row"> Account Number</th>
              <td width="287"><input class="form-control" type="text" name="accountno" id="accountno" value="<?php echo $_GET['accountid']; ?>"/></td>
            </tr>
            <tr>
              <th height="36" scope="row">Payable Amount</th>
              <td><input class="form-control" type="text" name="accountno3" id="accountno3" 
              <?php
			  if(mysqli_num_rows($qsqltransactionrec) != 0)
			  {
				  echo " value='". $rstransactionrec[0] . "' readonly ";
			  }
			  ?>
              
               /></td>
            </tr>
            <tr>
              <th height="40" scope="row">Transaction Type</th>
              <td><select class="form-control" name="transcationtype3" id="transcationtype3" onChange="loadpaymenttype(this.value)" >
                <option value="">select</option>
                <?php
				$arr=array("SB Account", "Card Payment");
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
              <th height="29" colspan="2" scope="row"><div id='loadpaymenttype'></div></th>
              </tr>
            <tr>
              <th height="51" colspan="2" scope="row"><div align="center">
                <input class="btn btn-info" type="submit" name="submit" id="submit" value="Deposit" />
              </div></th>
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
function loadpaymenttype(paytype) {
    if (paytype == "") {
        document.getElementById("loadpaymenttype").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("loadpaymenttype").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxtransactiontype.php?paytype="+paytype,true);
        xmlhttp.send();
    }
}

function savingsacbal(accountid) {
    if (accountid == "") {
        document.getElementById("loadsavingsdetail").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("loadsavingsdetail").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxsavingsacbalance.php?accountid="+accountid,true);
        xmlhttp.send();
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
if(document.frmdeposittd.accountno.value == "" && document.frmdeposittd.accountno3.value == "" && document.frmdeposittd.transcationtype3.value == ""  && document.frmdeposittd.transcationtype2.value == ""  && document.frmdeposittd.cardnumber.value == "" && document.frmdeposittd.accountno2.value == ""  && document.frmdeposittd.accountopendate.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmdeposittd.accountno.focus();
		return false;	
		}
		else if(document.frmdeposittd.accountno.value == "")
		{
			alert("Please enter Account Number ");
			document.frmdeposittd.accountno.focus();
			return false;	
		}
	else if(!document.frmdeposittd.accountno.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frmdeposittd.accountno.focus();
		return false;			
	}
	else if(document.frmdeposittd.accountno3.value == "")
		{
			alert("Please enter the Amount ");
			document.frmdeposittd.accountno3.focus();
			return false;	
		}
		else if(!document.frmdeposittd.accountno3.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmdeposittd.accountno3.focus();
		return false;			
	}
	else if(document.frmdeposittd.transcationtype3.value == "")
	{
		alert("Please select Transaction Type ");
		document.frmdeposittd.transcationtype3.focus();
		return false;	
	}
		else if(document.frmdeposittd.cardnumber.value == "")
		{
			alert("Please enter Card Number ");
			document.frmdeposittd.cardnumber.focus();
			return false;	
		}
		else if(!document.frmdeposittd.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frmdeposittd.cardnumber.focus();
		return false;			
	}
	else if(document.frmdeposittd.cardnumber.value.length != 16)
		{
			alert("Kindly enter 16 digit Card Number..");
			document.frmdeposittd.cardnumber.focus();
			return false;
		}
		else if(document.frmdeposittd.accountno2.value == "")
		{
			alert("Please enter CVV Number ");
			document.frmdeposittd.accountno2.focus();
			return false;	
		}
		else if(!document.frmdeposittd.accountno2.value.match(numericExpression))
	{
		alert("CVV Number is not valid");
		document.frmdeposittd.accountno2.focus();
		return false;			
	}
		
		else if(document.frmdeposittd.accountno2.value.length != 3)
		{
			alert("Kindly enter 3 digit CVV number..");
			document.frmdeposittd.accountno2.focus();
			return false;
		}
		else if(document.frmdeposittd.accountno3.value > document.frmdeposittd.minbalamt.value)
	{
		alert("The SB Account does not have sufficient amount ");
		document.frmdeposittd.accountno3.focus();
		return false;	
	}
	
	else if(document.frmdeposittd.accountopendate.value == "")
	{
		alert("Please select date");
		document.frmdeposittd.accountopendate.focus();
		return false;	
	}
}
</script>