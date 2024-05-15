<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
$sql="select * from moneyorder where moneyorderid='$_GET[payid]'";
$qsql=mysqli_query($con,$sql);
$editrs=mysqli_fetch_array($qsql);

$sqlcustomer="select * from customer	 where customerid='$editrs[customerid]'";
$qsqlcustomer=mysqli_query($con,$sqlcustomer);
$editrscustomer=mysqli_fetch_array($qsqlcustomer);


?>
</div>
<div class="panels-container"></div>
<div class="columns-container">
  <div class="columns-wrapper">
    <?php
	include("leftside.php");
	?>
    <div class="right-column">
      <div class="right-column-heading"><h2>&nbsp;</h2>
        <h1> Money Transfer  Receipt</h1>
    </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmmoney" onsubmit="return validateform()" >
      <div id="printarea" >
         <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Transaction</th>
              <td width="287">Money Order</td>
            </tr>
            <tr>
              <th scope="row">Customer Name</th>
              <td><?php echo $editrscustomer['customername']; ?></td>
            </tr>
            <tr>
              <th scope="row">Money Transfer  Date</th>
              <td><?php echo $editrs['modate']; ?></td>
            </tr>
            <tr>
              <th scope="row">Amount </th>
              <td><?php echo $editrs['amount']; ?></td>
            </tr>
            <tr>
              <th scope="row">Commission</th>
              <td><?php echo $editrs['commission']; ?></td>
            </tr>
            </tbody>
        </table>
        </div>
            <table width="560" height="49" border="3" class="tftable">
          <tbody>
            <tr>
              <th height="39" scope="row"><div align="center">
                <input class="form-control" type="button" name="submit" id="submit" value="Print" onclick="printme('printarea')" />
              </div></th>
              </tr>
          </tbody>
        </table>
        <h1>&nbsp;</h1>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>
<script type="application/javascript">
function calcommission(rupees)
{
	document.getElementById("commission").value=rupees*5/100;
}
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frmmoney.customerid.value == "" && document.frmmoney.fromaddress.value == "" && document.frmmoney.frompincode.value == ""  && document.frmmoney.frommobilenumber.value == ""  && document.frmmoney.toaddress.value == "" && document.frmmoney.topincode.value == "" && document.frmmoney.tomobilenumber.value == "" && document.frmmoney.moneyorderdate.value == "" && document.frmmoney.amount.value == "" && document.frmmoney.commission.value == "" && document.frmmoney.note.value == "" && document.frmmoney.status.value == "" )
	{
		alert("Kindly enter all mandatory details..");
		document.frmmoney.customerid.focus();
		return false;	
		
	}
	else if(document.frmmoney.customerid.value == "")
	{
		alert("Please select the customer");
		document.frmmoney.customerid.focus();
		return false;	
	}
	else if(document.frmmoney.fromaddress.value == "")
	{
		alert("Please enter the address");
		document.frmmoney.fromaddress.focus();
		return false;	
	}
	else if(document.frmmoney.frompincode.value == "")
	{
		alert("Please enter the pincode");
		document.frmmoney.frompincode.focus();
		return false;	
	}
	else if(!document.frmmoney.frompincode.value.match(numericExpression))
	{
		alert("Pincode is not valid");
		document.frmmoney.frompincode.focus();
		return false;			
	}
	else if(document.frmmoney.frommobilenumber.value == "")
	{
		alert("Please enter the mobile number");
		document.frmmoney.frommobilenumber.focus();
		return false;	
	}
	else if(!document.frmmoney.frommobilenumber.value.match(numericExpression))
	{
		alert("Mobile Number is not valid");
		document.frmmoney.frommobilenumber.focus();
		return false;			
	}
	else if(document.frmmoney.toaddress.value == "")
	{
		alert("Please enter the address");
		document.frmmoney.toaddress.focus();
		return false;	
	}
	else if(document.frmmoney.topincode.value == "")
	{
		alert("Please enter the pincode");
		document.frmmoney.topincode.focus();
		return false;	
	}
	else if(!document.frmmoney.topincode.value.match(numericExpression))
	{
		alert("Pincode is not valid");
		document.frmmoney.topincode.focus();
		return false;			
	}
	else if(document.frmmoney.tomobilenumber.value == "")
	{
		alert("Please enter the mobile number");
		document.frmmoney.tomobilenumber.focus();
		return false;	
	}
	else if(!document.frmmoney.tomobilenumber.value.match(numericExpression))
	{
		alert("Mobile Number is not valid");
		document.frmmoney.tomobilenumber.focus();
		return false;			
	}
	else if(document.frmmoney.moneyorderdate.value == "")
	{
		alert("Please enter the date");
		document.frmmoney.moneyorderdate.focus();
		return false;	
	}
	else if(document.frmmoney.amount.value == "")
	{
		alert("Please enter the amount");
		document.frmmoney.amount.focus();
		return false;	
	}
	else if(!document.frmmoney.amount.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmmoney.amount.focus();
		return false;			
	}
	else if(document.frmmoney.status.value == "") 
	{
		alert("Kindly select status");
		document.frmmoney.status.focus();
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