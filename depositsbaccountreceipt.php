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
	<h1>Deposit SB Account Receipt</h1>
        
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdepositsb" onsubmit="return validateform()">  
      <div id="printarea" >

            <table width="560" height="326" border="3" class="tftable">
                <tbody>
                  <tr>
                    <th scope="row">Account Type</th>
                    <td>SB Account</td>
                  </tr>
                  <tr>
                    <th width="253" scope="row"> Account Number</th>
                    <td width="287"><?php echo $editrs['accountid']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Transaction Type</th>
                    <td><?php echo $editrs['transactiontype'];?></td>
                  </tr>
                  <tr>
                    <th scope="row">Date of Transaction</th>
                    <td><?php echo $editrs['transdate']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Deposited Amount</th>
                    <td><?php echo $editrs['amount']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Payment type</th>
                    <td><?php echo $editrs['paymenttype']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Note</th>
                    <td><?php echo $editrs['note']; ?></td>
                  </tr>
                </tbody>
              </table></div>
              <table width="560" height="56" border="3" class="tftable">
                <tbody>
                  <tr>
                    <th height="46" colspan="2" scope="row"><div align="center">
                      <input class="form-control" type="button" name="submit2" id="submit2" value="Print" onclick="printme('printarea')"/>
                    </div>
                    </th>
                  </tr>
                </tbody>
              </table>
              <p>&nbsp;</p>
      </div>
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
		document.frmdepositsb.accountno.focus();
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