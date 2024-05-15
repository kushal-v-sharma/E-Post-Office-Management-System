<?php
include("header.php");
include("dbconnection.php");

	$sql="select * from billpayment where billpaymentid='$_GET[payid]'";
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
      <div class="right-column-heading"><h2>Bill Payment</h2>
        <h1>Bill Payment Receipt</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frombill" onsubmit="return validateform()">
      <div id="printarea" >
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Bill type</th>
              <td width="287">
              <?php echo   $editrs['billtype']; ?></td>
            </tr>
            <tr>
              <th scope="row">Account Number</th>
              <td><?php echo $editrs['accountnumber'];?></td>
            </tr>
            <tr>
              <th scope="row">Name</th>
              <td><?php echo $editrs['name'];?></td>
            </tr>
            <tr>
              <th scope="row">Bill Amount</th>
              <td><?php echo $editrs['billamt'];?></td>
            </tr>
            <tr>
              <th scope="row">Paid Date</th>
              <td><?php echo $editrs['paiddate'];?></td>
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
	if(document.frombill.billtype.value == "" && document.frombill.accountnumber.value == "" && document.frombill.name.value == ""  && document.frombill.billamount.value == ""  && document.frombill.note.value == "" && document.frombill.paiddate.value == "" && document.frombill.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frombill.billtype.focus();
		return false;	
		
	}
	else if(document.frombill.billtype.value == "")
	{
		alert("Please select Bill Type");
		document.frombill.billtype.focus();
		return false;	
	}
	else if(document.frombill.accountnumber.value == "")
	{
		alert("Please enter account number");
		document.frombill.accountnumber.focus();
		return false;	
	}
	else if(!document.frombill.accountnumber.value.match(numericExpression))
	{
		alert("Account number is not valid");
		document.frombill.accountnumber.focus();
		return false;			
	}
	else if(document.frombill.name.value == "")
	{
		alert("Please enter the name");
		document.frombill.name.focus();
		return false;
	}
	else if(!document.frmcustomer.name.value.match(alphaspaceExp))
	{
		alert("Name is not valid");
		document.frombill.name.focus();
		return false;			
	}
	else if(document.frombill.billamount.value == "")
	{
		alert("please enter amount");
		document.frombill.billamount.focus();
		return false;
	}
	else if(!document.frmcustomer.billamount.value.match(numericExpression))
	{
		alert("Bill amount is not valid");
		document.frombill.name.focus();
		return false;			
	}
	else if(document.frombill.paiddate.value == "") 
	{
		alert("Please enter date");
		document.frombill.paiddate.focus();
		return false;
	}
	else if(document.frombill.status.value == "") 
	{
		alert("Kindly select status");
		document.frombill.status.focus();
		return false;
	}
	else
	{
		return true;
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

