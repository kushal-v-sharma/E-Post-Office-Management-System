<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="DELETE from moneyorder where moneyorderid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<script>alert('Record Deleted');</script>";
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
        <h2>Customer Money Transfer </h2>
       
        <h1>View Customer Money Transfer  Record</h1>
        <p>&nbsp;</p>
      </div>
      <div class="right-column-content">
      <form method="post" action="" >
      <div style='overflow:auto;width:100%'>
         <table width="959" height="107" border="1" class="tftable">
           <tr>
             <th width="65" scope="col">Customer</th>
             <th width="54" scope="col">From Address</th>
             <th width="38" scope="col">From Pin Code</th>
             <th width="54" scope="col">From Mobile Number</th>
             <th width="52" scope="col">To Address</th>
             <th width="52" scope="col">To Pincode</th>
             <th width="54" scope="col">To Mobile Number</th>
             <th width="52" scope="col">Money Transfer  Date</th>
             <th width="52" scope="col">Amount</th>
             <th width="81" scope="col">Commission</th>
             <th width="33" scope="col">Note</th>
             <th width="42" scope="col">Status</th>
            </tr>
           <?php
		  $sql="select * from moneyorder";
		  if(isset($_SESSION['customerid']))
		  {
			  $sql= $sql . " WHERE customerid='$_SESSION[customerid]'";
		  }
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  $sql1 = "SELECT * FROM customer WHERE customerid='$rs[customerid]'";
			  $qsql1=mysqli_query($con,$sql1);
			  $rs1=mysqli_fetch_array($qsql1);
			echo "<tr>
			<td>&nbsp;$rs[customerid]</td>
			<td>&nbsp;$rs[fromaddr]</td>
			<td>&nbsp;$rs[frompin]</td>
			<td>&nbsp;$rs[frommobno]</td>
			<td>&nbsp;$rs[toaddr]</td>
			<td>&nbsp;$rs[topin]</td>
			<td>&nbsp;$rs[tomobno]</td>
			<td>&nbsp;$rs[modate]</td>
			<td>&nbsp;$rs[amount]</td>
			<td>&nbsp;$rs[commission]</td>
			<td>&nbsp;$rs[note]</td>
			<td>&nbsp;$rs[status]</td>
			</tr>";
			}
			?>
         </table>
         </div>
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
</script>