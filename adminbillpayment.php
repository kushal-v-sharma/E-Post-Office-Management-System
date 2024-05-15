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
			echo "<script>alert('Bill Payment Record Updated Successfully..');</script>";
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
			echo "<script>window.location='adminbillpaymentreceipt.php?payid=" .  $insid . "';</script>";
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
      <form method="post" action="" name="frmbill" onsubmit="return validateform()">
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
	if(document.frmbill.billtype.value == "" && document.frmbill.accountnumber.value == "" && document.frmbill.name.value == ""  && document.frmbill.billamount.value == "" && document.frmbill.paiddate.value == "" && document.frmbill.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmbill.billtype.focus();
		return false;	
		
	}
	else if(document.frmbill.billtype.value == "")
	{
		alert("Please select Bill Type");
		document.frmbill.billtype.focus();
		return false;	
	}
	else if(document.frmbill.accountnumber.value == "")
	{
		alert("Please enter Account Number");
		document.frmbill.accountnumber.focus();
		return false;	
	}
	else if(!document.frmbill.accountnumber.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frmbill.accountnumber.focus();
		return false;			
	}
	else if(document.frmbill.name.value == "")
	{
		alert("Please enter the Name");
		document.frmbill.name.focus();
		return false;
	}
	else if(!document.frmbill.name.value.match(alphaspaceExp))
	{
		alert("Name is not valid");
		document.frmbill.name.focus();
		return false;			
	}
	else if(document.frmbill.billamount.value == "")
	{
		alert("Please enter Amount");
		document.frmbill.billamount.focus();
		return false;
	}
	else if(!document.frmbill.billamount.value.match(numericExpression))
	{
		alert("Bill Amount is not valid");
		document.frmbill.name.focus();
		return false;			
	}
	else if(document.frmbill.paiddate.value == "") 
	{
		alert("Please enter Date");
		document.frmbill.paiddate.focus();
		return false;
	}
	else if(document.frmbill.status.value == "") 
	{
		alert("Kindly select Status");
		document.frmbill.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>

