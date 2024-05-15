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
			echo "<script>alert('Transaction Record Updated Successfully..');</script>";
		}
	}
	else
	{
		if($_POST['transcationtype3'] == "SB Account")
		{
			$paymentcredentials = $_POST['transcationtype3'] . "  Account number -  " . $_POST['transcationtype'];
		$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[transcationtype]','$_SESSION[customerid]','Debit','$_POST[accountno3]','$dt','Transaction','RD Deposit $_POST[accountid]','Active')";
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
			
				echo "<script>alert('Transcation Record Inserted Successfully..');</script>";
				
				echo "<script>window.location='depositrdaccountreceipt.php?payid=" . $insid ."';</script>";
			}	
			
	}
}
if(isset($_GET['accountid']))
{
	$sqlrdaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqlrdaccountdet=mysqli_query($con,$sqlrdaccountdet);
	$rsrdaccountdet=mysqli_fetch_array($qsqlrdaccountdet);
	
	$sqlrdaccount="select * from rdaccount WHERE status='Active' AND rdaccountid='$rsrdaccountdet[actypeid]'";
	$qsqlrdaccount=mysqli_query($con,$sqlrdaccount);
	$rsrdaccount=mysqli_fetch_array($qsqlrdaccount);
		
	$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]'";
	$qsqltransaction =mysqli_query($con,$sqltransaction);
	$rstransaction =mysqli_fetch_array($qsqltransaction);

	$sqltransactionrec ="select amount from transaction where accountid='$_GET[accountid]'";
	$qsqltransactionrec =mysqli_query($con,$sqltransactionrec);
	$rstransactionrec =mysqli_fetch_array($qsqltransactionrec);
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
		<h1>Deposit RD Account </h1>
       
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdepositrd" onsubmit="return validateform()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $rstransaction[0]; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
         <table width="560" height="249" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" height="44" scope="row"> Account Number</th>
              <td width="287"><input class="form-control" type="text" name="accountno" id="accountno" value="<?php echo $_GET['accountid']; ?>"/></td>
            </tr><tr>
              <th width="253" height="30" scope="row">Minimum</th>
            <td>&nbsp; <?php
			  if(mysqli_num_rows($qsqltransactionrec) == 0)
			  {
              echo " Rs. " . $rsrdaccount['mindeposit'];
			  }
			  ?></td></tr>
            <tr>
              <th height="44" scope="row">&nbsp;Payable Amount</th>
              <!-- $rstransaction $rsrdaccount -->
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
              <th height="31" scope="row">Transaction Type</th>
              <td><select class="form-control" name="transcationtype3" id="transcationtype3" onChange="loadpaymenttype(this.value)">
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
if(document.frmdepositrd.accountno.value == "" && document.frmdepositrd.accountno3.value == "" && document.frmdepositrd.transcationtype3.value == ""  && document.frmdepositrd.transcationtype2.value == ""  && document.frmdepositrd.cardnumber.value == "" && document.frmdepositrd.accountno2.value == ""  && document.frmdepositrd.accountopendate.value == "")
		{
			alert("Kindly enter all mandatory details..");
			document.frmdepositrd.accountno.focus();
			return false;	
		}
		else if(document.frmdepositrd.accountno.value == "")
		{
			alert("Please enter Account Number ");
			document.frmdepositrd.accountno.focus();
			return false;	
		}
		else if(!document.frmdepositrd.accountno.value.match(numericExpression))
		{
			alert("Account Number is not valid");
			document.frmdepositrd.accountno.focus();
			return false;			
		}
		else if(document.frmdepositrd.accountno3.value == "")
		{
			alert("Please enter the Amount ");
			document.frmdepositrd.accountno3.focus();
			return false;	
		}
		else if(!document.frmdepositrd.accountno3.value.match(decimalExpression))
		{
			alert("Amount is not valid");
			document.frmdepositrd.accountno3.focus();
			return false;			
		}
		else if(document.frmdepositrd.transcationtype3.value == "")
		{
			alert("Please select the Transaction Type ");
			document.frmdepositrd.transcationtype3.focus();
			return false;	
		}
		else if(document.frmdepositrd.cardnumber.value == "")
		{
			alert("Please enter the Card Number ");
			document.frmdepositrd.cardnumber.focus();
			return false;	
		}
		else if(!document.frmdepositrd.cardnumber.value.match(numericExpression))
		{
			alert("Card Number is not valid");
			document.frmdepositrd.cardnumber.focus();
			return false;			
		}
		else if(document.frmdepositrd.cardnumber.value.length != 16)
		{
			alert("Kindly enter 16 digit Card Number..");
			document.frmdepositrd.cardnumber.focus();
			return false;
		}
		else if(document.frmdepositrd.accountno2.value == "")
		{
			alert("Please enter the CVV Number ");
			document.frmdepositrd.accountno2.focus();
			return false;	
		}
		else if(!document.frmdepositrd.accountno2.value.match(numericExpression))
		{
			alert("CVV Number is not valid");
			document.frmdepositrd.accountno2.focus();
			return false;			
		}
		else if(document.frmdepositrd.accountno2.value.length != 3)
		{
		alert("Kindly enter 3 digit CVV number..");
		document.frmdepositrd.accountno2.focus();
		return false;
		}
		else if(document.frmdepositrd.accountno3.value > document.frmdepositrd.minbalamt.value)
	{
		alert("The SB Account does not have sufficient amount ");
		document.frmdepositrd.accountno3.focus();
		return false;	
	}
	else if(document.frmdepositrd.accountopendate.value == "")
	{
		alert("Please select date");
		document.frmdepositrd.accountopendate.focus();
		return false;	
	}
}
</script>