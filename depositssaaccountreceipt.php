<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
	$sql="select * from transaction where transactionid='$_GET[payid]'";
	$qsql=mysqli_query($con,$sql);
	$editrs=mysqli_fetch_array($qsql);
if(isset($_GET['accountid']))
{
	$sqlssaaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqlssaaccountdet=mysqli_query($con,$sqlssaaccountdet);
	$rsrssaccountdet=mysqli_fetch_array($qsqlssaaccountdet);
	
	$sqlssaaccount="select * from ssaaccount WHERE status='Active' AND ssaccountid='$rsrssaccountdet[actypeid]'";
	$qsqlssaaccount=mysqli_query($con,$sqlssaaccount);
	$rsssaaccount=mysqli_fetch_array($qsqlssaaccount);
		
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
<h1>Deposit SSA Account Receipt</h1>
  
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdepositssa" >     
      <div id="printarea" >
         <table width="560" height="254" border="3" class="tftable">
          <tbody>
            <tr>
              <th height="52" scope="row">Account Type</th>
              <td>SSA Account</td>
            </tr>
            <tr>
              <th width="253" height="52" scope="row"> Account Number</th>
              <td width="287"><?php echo $editrs['accountid']; ?></td>
            </tr>
            <tr>
              <th height="40" scope="row">Transaction Type</th>
              <td><?php echo $editrs['transactiontype']; ?></td>
            </tr>
            <tr>
              <th height="40" scope="row">Date of Transaction</th>
              <td><?php echo $editrs['transdate']; ?></td>
            </tr>
            <tr>
              <th height="29" scope="row">Deposited Amount</th>
              <td height="29" scope="row"><?php echo $editrs['amount']; ?></td>
            </tr>
            <tr>
              </tr>
            <tr>
              <th height="51" scope="row">Payment Type</th>
              <td height="51" scope="row"><?php echo $editrs['paymenttype']; ?></td>
            </tbody>
        </table></div>
        <table width="561" height="80" border="3" class="tftable">
           <tbody>
             <tr>
               <th width="547" height="70" colspan="2" scope="row"><div align="center">
                 <input class="form-control" type="button" name="submit" id="submit" value="Print" onclick="printme('printarea')" />
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
if(document.frmdepositssa.accountno.value == "" && document.frmdepositssa.transcationtype2.value == "" && document.frmdepositssa.accountno3.value == ""  && document.frmdepositssa.transcationtype.value == ""  && document.frmdepositssa.cardnumber.value == "" && document.frmdepositssa.accountno2.value == ""  && document.frmdepositssa.accountopendate.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmdepositssa.accountno.focus();
		return false;	
		}
	else if(document.frmdepositssa.accountno.value == "")
	{
		alert("Please enter Account Number ");
		document.frmdepositssa.accountno.focus();
		return false;	
	}
	else if(!document.frmdepositssa.accountno.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frmdepositssa.accountno.focus();
		return false;			
	}
	else if(document.frmdepositssa.transcationtype2.value == "")
	{
		alert("Please select Transaction Type ");
		document.frmdepositssa.transcationtype2.focus();
		return false;	
	}
	else if(document.frmdepositssa.accountno3.value == "")
	{
		alert("Please enter Paid Amount ");
		document.frmdepositssa.accountno3.focus();
		return false;	
	}
	else if(!document.frmdepositssa.accountno3.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmdepositssa.accountno3.focus();
		return false;			
	}
	else if(document.frmdepositssa.transcationtype.value == "")
	{
		alert("Please select Payment Type ");
		document.frmdepositssa.transcationtype.focus();
		return false;	
	}
	else if(document.frmdepositssa.cardnumber.value == "")
	{
		alert("Please enter Card Number ");
		document.frmdepositssa.cardnumber.focus();
		return false;	
	}
	else if(!document.frmdepositssa.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frmdepositssa.cardnumber.focus();
		return false;			
	}
	else if(document.frmdepositssa.accountno2.value == "")
	{
		alert("Please enter CVV Number ");
		document.frmdepositssa.accountno2.focus();
		return false;	
	}
	else if(!document.frmdepositssa.accountno2.value.match(numericExpression))
	{
		alert("CVV Number is not valid");
		document.frmdepositssa.accountno2.focus();
		return false;			
	}
	else if(document.frmdepositssa.accountopendate.value == "")
	{
		alert("Please enter Date ");
		document.frmdepositssa.accountopendate.focus();
		return false;	
	}
}
function printme(divID)
{
	//Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body><center><img src='images/postofficeicon.png' width='300' height='150'></center><br>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
}
</script>