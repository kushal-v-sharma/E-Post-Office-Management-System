<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE insurance_payment set insuranceid='$_POST[insuranceaccountnumber]', paidamount='$_POST[paidamount]', paiddate='$_POST[paiddate]', paymenttype='$_POST[transcationtype3]', status='$_POST[status]' WHERE insurance_payment_id='$_GET[editid]'";
		if(!$qsql= mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Insurance Payment Record Updated Successfully..');</script>";
		}
	}
	else
	{
		if($_POST['transcationtype3'] == "SB Account")
		{
			$paymentcredentials = $_POST['transcationtype3'] . "  Account number -  " . $_POST['transcationtype'];
		$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[transcationtype]','$_SESSION[customerid]','Debit','$_POST[paidamount]','$dt','Transaction','Insurance payment A/c $_POST[insuranceaccountnumber]','Active')";
		$qsql = mysqli_query($con,$sql);
		}
		else
		{
			$paymentcredentials =  $_POST['transcationtype3'] ." - Card number" . $_POST['cardnumber'];
		}

		$sql ="INSERT INTO insurance_payment(insuranceid, paidamount, paiddate, paymenttype, status) VALUES ('$_POST[insuranceaccountnumber]','$_POST[paidamount]','$_POST[paiddate]', '$paymentcredentials', 'Active')";
						if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con);
					}
					else
					{
						$insid=mysqli_insert_id($con);
						echo "<script>alert('Insurancepayment Record Inserted Successfully..');</script>";						
						echo "<script> window.location='insurancepaymentreceipt.php?payid=". $insid ."';</script>";
						
					}
				}
}
if(isset($_GET['editid']))
{
	$sql="select * from insurance_payment where insurance_payment_id='$_GET[editid]'";
	$qsql=mysqli_query($con,$sql);
	$rsedit=mysqli_fetch_array($qsql);
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
      <div class="right-column-heading"><h2>Insurance Payment</h2>
        <h1>Add Insurance Payment Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsurancepay" onsubmit="return validateform()">
        <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Insurance Policy Number</th>
              <td width="287"><input class="form-control" type="text" readonly name="insuranceaccountnumber" id="insuranceaccountnumber" value="<?php echo $_GET['policyid']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Payment term</th>
              <td>
              <?php
			  $sqlinsurance_payment = "SELECT * FROM insurance_payment WHERE insuranceid='$_GET[policyid]'";
			  $qsqlinsurance_payment = mysqli_query($con,$sqlinsurance_payment);
			  ?>
              <input class="form-control" type="text" name="paymentterm" id="paymentterm" value="<?php echo mysqli_num_rows($qsqlinsurance_payment) + 1; ?>" readonly />
              
              </td>
            </tr>
            <tr>
              <th scope="row">Paid Amount</th>
              <td><input class="form-control" type="text" name="paidamount" id="paidamount"  value="<?php echo $_GET['payamt']; ?>" readonly/></td>
            </tr>
            <tr>
              <th scope="row">Transaction Type</th>
              <td><select class="form-control" name="transcationtype3" id="transcationtype3" onchange="loadpaymenttype(this.value)">
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
              <th scope="row">Paid Date</th>
              <td><input class="form-control" type="date" name="paiddate" id="paiddate" value="<?php echo date("Y-m-d"); ?>" readonly /></td>
            </tr>
            
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Make Payment" />
              
        
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
</script>


