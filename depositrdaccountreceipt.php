<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");

	$sql="select * from transaction where transactionid='$_GET[payid]'";
	$qsql=mysqli_query($con,$sql);
	$editrs=mysqli_fetch_array($qsql);
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
		<h1>Deposit RD Account Receipt</h1>
       
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdepositrd" onsubmit="return validateform()">   
      <div id="printarea" >  
         <table width="560" height="243" border="3" class="tftable">
          <tbody>
            <tr>
              <th scope="row">Account Type</th>
              <td>RD Account</td>
            </tr>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287">
              <?php echo $editrs['accountid']; ?></td>
            </tr>
            <tr>
              <th height="39" scope="row">Transcation Type            
              <td><?php echo $editrs['transactiontype']; ?></td>            
            </tr>
            <tr>
              <th height="39" scope="row">Date of Transaction              
              <td><?php echo $editrs['transdate']; ?></td>
                        
            </tr>
            <tr>
              <th height="39" scope="row">Deposited Amount<td width="287">
			  Rs. <?php echo $editrs['amount']; ?></td>
              
            </tr>
            
            <tr>
              <th height="31" scope="row">Payment Type
                <td width="287"><?php echo $editrs['paymenttype']; ?></td>
            </tr>
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
         <p>&nbsp;</p>
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
if(document.frmdepositrd.accountno.value == "" && document.frmdepositrd.accountno3.value == "" && document.frmdepositrd.transcationtype3.value == ""  && document.frmdepositrd.transcationtype.value == ""  && document.frmdepositrd.cardnumber.value == "" && document.frmdepositrd.accountno2.value == ""  && document.frmdepositrd.accountopendate.value == "")
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
	else if(document.frmdepositrd.transcationtype3.value == "")
	{
		alert("Please select Transaction Type ");
		document.frmdepositrd.transcationtype3.focus();
		return false;	
	}
	else if(document.frmdepositrd.cardnumber.value == "")
	{
		alert("Please enter Card Number ");
		document.frmdepositrd.cardnumber.focus();
		return false;	
	}
	else if(!document.frmdepositrd.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frmdepositrd.accountno3.focus();
		return false;			
	}
	else if(document.frmdepositrd.transcationtype.value == "")
	{
		alert("Please select Payment Type ");
		document.frmdepositrd.transcationtype.focus();
		return false;	
	}
	else if(document.frmdepositrd.cardnumber.value == "")
	{
		alert("Please enter Card Number ");
		document.frmdepositrd.cardnumber.focus();
		return false;	
	}
	else if(!document.frmdepositrd.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frmdepositrd.cardnumber.focus();
		return false;			
	}
	else if(document.frmdepositrd.accountno2.value == "")
	{
		alert("Please enter CVV Number ");
		document.frmdepositrd.accountno2.focus();
		return false;	
	}
	else if(!document.frmdepositrd.accountno2.value.match(numericExpression))
	{
		alert("CVV Number is not valid");
		document.frmdepositrd.accountno2.focus();
		return false;			
	}
	else if(document.frmdepositrd.accountopendate.value == "")
	{
		alert("Please enter Date ");
		document.frmdepositrd.accountopendate.focus();
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