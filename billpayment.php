<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE billpayment set billtype='$_POST[billtype]', accountnumber='$_POST[accountnumber]', name='$_POST[name]', billamt='$_POST[billamount]', note='$_POST[note]', paiddate='$_POST[paiddate]', status='$_POST[status]' where billpaymentid='$_GET[editid]'";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Bill payment Record Updated Successfully..');</script>";
		}	
	}
	else
	{
		if($_POST['transcationtype3'] == "SB Account")
		{
			$paymentcredentials = $_POST['transcationtype3'] . "  Account number -  " . $_POST['transcationtype'];
		$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[transcationtype]','$_SESSION[customerid]','Debit','$_POST[billamount]','$dt','Transaction','Bill Payment $_POST[accountid]','Active')";
		$qsql = mysqli_query($con,$sql);
		}
		else
		{
			$paymentcredentials = "Transaction type - ".  $_POST['transcationtype3'] . " <br /> Card number" . $_POST['cardnumber'];
		}
				$sql ="INSERT INTO billpayment(customerid, billtype, accountnumber, name, billamt,  note, paiddate , status) VALUES ('$_SESSION[customerid]','$_POST[billtype]','$_POST[accountnumber]','$_POST[name]','$_POST[billamount]','$paymentcredentials','$dt','Active')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
				echo "<script>alert('Bill Payment Record Inserted Successfully...');</script>";
				$insid = mysqli_insert_id($con);
			echo "<script>window.location='billpaymentreceipt.php?payid=" .  $insid . "';</script>";
			}
	}
}
if(isset($_GET['editid']))
{
	$sql="select * from billpayment where billpaymentid='$_GET[editid]'";
	$qsql=mysqli_query($con,$sql);
	$editrs=mysqli_fetch_array($qsql);
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
      <div class="right-column-heading"><h2>Bill Payment</h2>
        <h1>Add Bill Payment Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frombill" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Bill type</th>
              <td width="287"><select class="form-control" name="billtype" id="billtype">
                <option value="">Select</option>
                <?php
				$arr=array("Electricity Bill","Telephone Bill");
				foreach($arr as $val)
				{
					echo "<option value='$val'>$val</option>";
				}
				?>
              </select></td>
            </tr>
            <tr>
              <th scope="row">Account Number</th>
              <td><input class="form-control" type="text" name="accountnumber" id="accountnumber" value="<?php echo $editrs['accountnumber'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Name</th>
              <td><input class="form-control" type="text" name="name" id="name" value="<?php echo $editrs['name'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Bill Amount</th>
              <td><input class="form-control" type="text" name="billamount" id="billamount" value="<?php echo $editrs['billamt'];?>" /></td>
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
              <th colspan="2" scope="row"><div id='loadpaymenttype'></div></th>
            </tr>
            <tr>
              <th scope="row">Paid Date</th>
              <td><input class="form-control" type="date" name="paiddate" id="paiddate" value="<?php echo $editrs['paiddate'];?><?php echo date("Y-m-d"); ?>" readonly="readonly" /></td>
            </tr>
<?php
if(!isset($_SESSION['customerid']))
{
?>
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr=array("Active","Inactive");
				foreach($arr as $val)
				{
					echo "<option value='$val'>$val</option>";
				}
				?>
              </select></td>
            </tr>
<?php
}
else
{
	echo "<input class='form-control' type='hidden' name='status' value='Active' >";
}
?>
<tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Make Payment" /></td>
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
	if(document.frombill.billtype.value == "" && document.frombill.accountnumber.value == "" && document.frombill.name.value == ""  && document.frombill.billamount.value == ""  && document.frombill.transcationtype3.value == "" && document.frombill.transcationtype2 == "" && document.frombill.cardnumber == "" && document.frombill.accountno2 == "" && document.frombill.accountopendate == "" && document.frombill.paiddate.value == "" && document.frombill.status.value == "")
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
		alert("Please enter Account Number");
		document.frombill.accountnumber.focus();
		return false;	
	}
	else if(!document.frombill.accountnumber.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frombill.accountnumber.focus();
		return false;			
	}
	else if(document.frombill.name.value == "")
	{
		alert("Please enter the Name");
		document.frombill.name.focus();
		return false;
	}
	else if(!document.frombill.name.value.match(alphaspaceExp))
	{
		alert("Name is not valid");
		document.frombill.name.focus();
		return false;			
	}
	else if(document.frombill.billamount.value == "")
	{
		alert("Please enter Amount");
		document.frombill.billamount.focus();
		return false;
	}
	else if(!document.frombill.billamount.value.match(numericExpression))
	{
		alert("Bill Amount is not valid");
		document.frombill.billamount.focus();
		return false;			
	}
	else if(document.frombill.transcationtype3.value == "")
	{
		alert("Please select Transaction Type");
		document.frombill.transcationtype3.focus();
		return false;
	}
	else if(document.frombill.cardnumber.value == "")
	{
		alert("Please enter Card Number");
		document.frombill.cardnumber.focus();
		return false;	
	}
	else if(!document.frombill.cardnumber.value.match(numericExpression))
	{
		alert("Card Number is not valid");
		document.frombill.cardnumber.focus();
		return false;			
	}
	else if(document.frombill.cardnumber.value.length != 16) 
	{
		alert("Card Number should be of 16 digits");
		document.frombill.cardnumber.focus();
		return false;			
	}
	else if(document.frombill.accountno2.value == "")
	{
		alert("Please enter CVV Number");
		document.frombill.accountno2.focus();
		return false;	
	}
	
	else if(!document.frombill.accountno2.value.match(numericExpression))
	{
		alert("CVV Number is not valid");
		document.frombill.accountno2.focus();
		return false;			
	}
	else if(document.frombill.accountno2.value.length !=  3) 
	{
		alert("CVV Number should be of 3 digits");
		document.frombill.accountno2.focus();
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
		alert("Kindly select Status");
		document.frombill.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>

