<?php
include("header.php");
include("dbconnection.php");
	$sql="select * from transaction where transactionid='$_GET[payid]'";
	$qsql=mysqli_query($con,$sql);
	$editrs=mysqli_fetch_array($qsql);
if(isset($_GET['editid']))
{
	$sql="select * from insurance_payment where insurance_payment_id='$_GET[editid]'";
	$qsql=mysqli_query($con,$sql);
	$rsedit=mysqli_fetch_array($qsql);
}

$sqlinsurance_payment = "SELECT * FROM insurance_payment WHERE insurance_payment_id='$_GET[payid]'";
$qsqlinsurance_payment = mysqli_query($con,$sqlinsurance_payment);
$rsinsurance_payment=mysqli_fetch_array($qsqlinsurance_payment);

?>
</div>
<div class="panels-container"></div>
<div class="columns-container">
  <div class="columns-wrapper">
    <?php
	include("leftside.php");
	?>
    <div class="right-column">
      <div class="right-column-heading"><h2>Insurance Payment</h2>
        <h1>Insurance Payment Receipt</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsurancepay" onsubmit="return validateform()">
        <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th scope="row">Transaction</th>
              <td>Insurance Payment</td>
            </tr>
            <tr>
              <th width="253" scope="row">Insurance Policy Number</th>
              <td width="287"><?php echo $rsinsurance_payment['insuranceid']; ?></td>
            </tr>
            <tr>
              <th scope="row">Payment term</th>
              <td>
              <?php
			   $sqlinsurance_payment = "SELECT * FROM insurance_payment WHERE insuranceid='$rsinsurance_payment[insuranceid]'";
			  $qsqlinsurance_payment = mysqli_query($con,$sqlinsurance_payment);
			  echo mysqli_num_rows($qsqlinsurance_payment);
			  ?>
              </td>
            </tr>
            <tr>
              <th scope="row">Paid Amount</th>
              <td><?php echo $rsinsurance_payment['paidamount']; ?></td>
            </tr>
            <tr>
              <th scope="row">Payment Type</th>
              <td><?php echo $rsinsurance_payment['paymenttype']; ?></td>
            </tr>
            <th scope="row">Paid Date</th>
              <td><?php echo $rsinsurance_payment['paiddate']; ?>
            </table>
            <table width="560" height="70" border="3" class="tftable">
           <tbody>
             <tr>
               <th height="60" colspan="2" scope="row"><div align="center">
                 <input class="form-control" type="button" name="submit2" id="submit2" value="Print" onclick="printme('printarea')"/>                </div></th>
             </tr>
           </tbody>
         </table>
            
            <tr>
              <th scope="row">&nbsp;</th>
              
              
        
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
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frminsurancepay.insuranceaccountnumber.value == "" && document.frminsurancepay.paidamount.value == "" &&  document.frminsurancepay.cardnumber== ""  && document.frminsurancepay.accountno2 == "" && document.frminsurancepay.accountopendate == "" && document.frminsurancepay.paiddate.value == "" && document.frminsurancepay.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frminsurancepay.insuranceaccountnumber.focus();
		return false;	
		
	}
	else if(document.frminsurancepay.insuranceaccountnumber.value == "")
	{
		alert("Please enter Account Number");
		document.frminsurancepay.insuranceaccountnumber.focus();
		return false;	
	}
	else if(!document.frminsurancepay.insuranceaccountnumber.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frminsurancepay.insuranceaccountnumber.focus();
		return false;			
	}
	else if(document.frminsurancepay.paidamount.value == "") 
	{
		alert("Please enter the Amount");
		document.frminsurancepay.paidamount.focus();
		return false;
	}
	else if(!document.frminsurancepay.paidamount.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frminsurancepay.paidamount.focus();
		return false;			
	}
	else if(document.frminsurancepay.cardnumber.value == "")
		{
			alert("Please enter Card Number ");
			document.frminsurancepay.cardnumber.focus();
			return false;	
		}
		else if(!document.frminsurancepay.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frminsurancepay.cardnumber.focus();
		return false;			
	}
	else if(document.frminsurancepay.cardnumber.value.length != 16)
		{
			alert("Kindly enter 16 digit Card Number..");
			document.frminsurancepay.cardnumber.focus();
			return false;
		}
		else if(document.frminsurancepay.accountno2.value == "")
		{
			alert("Please enter CVV Number ");
			document.frminsurancepay.accountno2.focus();
			return false;	
		}
		else if(!document.frminsurancepay.accountno2.value.match(numericExpression))
	{
		alert("CVV Number is not valid");
		document.frminsurancepay.accountno2.focus();
		return false;			
	}
		
		else if(document.frminsurancepay.accountno2.value.length != 3)
		{
			alert("Kindly enter 3 digit CVV number..");
			document.frminsurancepay.accountno2.focus();
			return false;
		}
		else if(document.frminsurancepay.accountno3.value > document.frmdeposittd.minbalamt.value)
	{
		alert("The SB Account does not have sufficient amount ");
		document.frminsurancepay.accountno3.focus();
		return false;	
	}
	
	else if(document.frminsurancepay.accountopendate.value == "")
	{
		alert("Please select date");
		document.frminsurancepay.accountopendate.focus();
		return false;	
	}
	else if(document.frminsurancepay.paiddate.value == "") 
	{
		alert("Please enter the Date");
		document.frminsurancepay.paiddate.focus();
		return false;
	}
	else if(document.frminsurancepay.status.value == "") 
	{
		alert("Kindly select Status");
		document.frminsurancepay.status.focus();
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


