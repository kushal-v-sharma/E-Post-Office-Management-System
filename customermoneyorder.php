<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE moneyorder set customerid='$_POST[customerid]', fromaddr='$_POST[fromaddress]', frompin='$_POST[frompincode]', toaddr='$_POST[toaddress]', topin='$_POST[topincode]', frommobno='$_POST[frommobilenumber]', tomobno='$_POST[tomobilenumber]', modate='$_POST[moneyorderdate]', amount='$_POST[amount]', commission='$_POST[commission]', note='$_POST[note]', status='$_POST[status]' where moneyorderid='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Moneyorder Record Updated Successfully..');</script>";
		}
	}
	else
	{
			if($_POST['transcationtype3'] == "SB Account")
			{
				$totdedamt = $_POST['amount'] + $_POST['commission'];
				$paymentcredentials = $_POST['transcationtype3'] . "  Account number -  " . $_POST['transcationtype'];
				$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[transcationtype]','$_SESSION[customerid]','Debit','$totdedamt','$dt','Online','Money transfer','Active')";
				$qsql = mysqli_query($con,$sql);
			}
			else
			{
				$paymentcredentials =  $_POST['transcationtype3'] ." - Card number" . $_POST['cardnumber'];
			}
	
				$sql ="INSERT INTO moneyorder(customerid, fromaddr, frompin, toaddr, topin,frommobno, tomobno, modate, amount, commission, note, status) VALUES ('$_SESSION[customerid]','$_POST[fromaddress]','$_POST[frompincode]', '$_POST[toaddress]','$_POST[topincode]', '$_POST[frommobilenumber]','$_POST[tomobilenumber]','$dt','$_POST[amount]','$_POST[commission]','$paymentcredentials',
				'Active')";
				if(!$qsql = mysqli_query($con,$sql))
				{
					echo mysqli_error($con);
				}
				else
				{
					echo "<script>alert('Money Order Record Inserted Successfully...');</script>";
					$insid = mysqli_insert_id($con);
					echo "<script>window.location='customermoneyorderreceipt.php?payid=" .  $insid . "';</script>";
				}	
			
	}
 }
if(isset($_GET['editid']))
{
	$sql="select * from moneyorder where moneyorderid='$_GET[editid]'";
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
      <div class="right-column-heading"><h2>Money Transfer </h2>
        <h1>Add Money Transfer Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmmoney" onsubmit="return validateform()">
         <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th scope="row">Customer</th>
              <td><select class="form-control" name="customerid" id="customerid" >
                <option value="">Select</option>
                <?php
				$sqlcust = "SELECT * FROM customer WHERE status='Active'";
				$qsqlcust = mysqli_query($con,$sqlcust);
				while($rscust = mysqli_fetch_array($qsqlcust))
					{
						if($rscust['customerid'] == $rscust['customerid'])
						{
						echo "<option value='$rscust[customerid]' selected>$rscust[customername]</option>";
						}
						else
						{
						echo "<option value='$rscust[customerid]'>$rscust[customername]</option>";						
						}
					}
				?>
              </select></td>
            </tr>
            <tr>
              <th width="253" scope="row">From Address</th>
              <td width="287"><textarea class="form-control"  name="fromaddress" id="fromaddress" cols="45" rows="5"><?php echo $rsedit['fromaddr'];?></textarea></td>
            </tr>
            <tr>
              <th scope="row">From Pin Code</th>
              <td><input class="form-control" type="text" name="frompincode" id="frompincode" value="<?php echo $rsedit['frompin'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">From Mobile Number</th>
              <td><input class="form-control" type="text" name="frommobilenumber" id="frommobilenumber" value="<?php echo $rsedit['frommobno'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">To Address</th>
              <td><textarea class="form-control"  name="toaddress" id="toaddress" cols="45" rows="5"><?php echo $rsedit['toaddr'];?></textarea></td>
            </tr>
            <tr>
              <th scope="row">To Pincode</th>
              <td><input class="form-control" type="text" name="topincode" id="topincode" value="<?php echo $rsedit['topin'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">To Mobile Number</th>
              <td><input class="form-control" type="text" name="tomobilenumber" id="tomobilenumber" value="<?php echo $rsedit['tomobno'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Money Transfer  Date</th>
              <td><input class="form-control" type="date" name="moneyorderdate" min="<?php echo date("Y-m-d"); ?>" id="moneyorderdate" value="<?php echo $rsedit['modate'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Amount</th>
              <td><input class="form-control" type="text" name="amount" id="amount"  value="<?php echo $rsedit['amount'];?>" onkeyup="calcommission(this.value)" /></td>
            </tr>
            <tr>
              <th scope="row">Commission</th>
              <td><input class="form-control" type="text" name="commission" id="commission" value="<?php echo $rsedit['commission'];?>" readonly /></td>
            </tr>
            <tr>
              <th scope="row">Note</th>
              <td><textarea class="form-control"  name="note" id="note" cols="45" rows="5"><?php echo $rsedit['note'];?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr=array("Active","Inactive");
				foreach($arr as $val)
				{
					echo "<option value='$val' >$val</option>";
				}
				?>
              </select></td>
            </tr>
            <tr>
              <th scope="row">Transaction Type</th>
              <td><select class="form-control" name="transcationtype3" id="transcationtype3" onchange="loadpaymenttype(this.value)" >
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
               <tr>
                <th height="51" colspan="2" scope="row"><div align="center">
             <input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" />
             </div>
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
function calcommission(rupees)
{
	document.getElementById("commission").value=rupees*5/100;
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
	if(document.frmmoney.customerid.value == "" && document.frmmoney.fromaddress.value == "" && document.frmmoney.frompincode.value == ""  && document.frmmoney.frommobilenumber.value == ""  && document.frmmoney.toaddress.value == "" && document.frmmoney.topincode.value == "" && document.frmmoney.tomobilenumber.value == "" && document.frmmoney.moneyorderdate.value == "" && document.frmmoney.amount.value == "" && document.frmmoney.commission.value == "" && document.frmmoney.note.value == "" && document.frmmoney.status.value == "" )
	{
		alert("Kindly enter all mandatory details..");
		document.frmmoney.customerid.focus();
		return false;	
		
	}
	else if(document.frmmoney.customerid.value == "")
	{
		alert("Please select the Customer");
		document.frmmoney.customerid.focus();
		return false;	
	}
	else if(document.frmmoney.fromaddress.value == "")
	{
		alert("Please enter the Address");
		document.frmmoney.fromaddress.focus();
		return false;	
	}
	else if(document.frmmoney.frompincode.value == "")
	{
		alert("Please enter the Pincode");
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
		alert("Please enter the Mobile Number");
		document.frmmoney.frommobilenumber.focus();
		return false;	
	}
	else if(!document.frmmoney.frommobilenumber.value.match(numericExpression))
	{
		alert("Mobile Number is not valid");
		document.frmmoney.frommobilenumber.focus();
		return false;			
	}
	else if(document.frmmoney.frommobilenumber.value.length != 10)
		{
			alert("Mobile Number should be of 10 digit Card Number..");
			document.frmmoney.frommobilenumber.focus();
			return false;
		}
	else if(document.frmmoney.toaddress.value == "")
	{
		alert("Please enter the Address");
		document.frmmoney.toaddress.focus();
		return false;	
	}
	else if(document.frmmoney.topincode.value == "")
	{
		alert("Please enter the Pincode");
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
		alert("Please enter the Mobile Number");
		document.frmmoney.tomobilenumber.focus();
		return false;	
	}
	else if(!document.frmmoney.tomobilenumber.value.match(numericExpression))
	{
		alert("Mobile Number is not valid");
		document.frmmoney.tomobilenumber.focus();
		return false;			
	}
	else if(document.frmmoney.tomobilenumber.value.length != 10)
		{
			alert("Mobile Number should be of 10 digit Card Number..");
			document.frmmoney.tomobilenumber.focus();
			return false;
		}
	else if(document.frmmoney.moneyorderdate.value == "")
	{
		alert("Please enter the Date");
		document.frmmoney.moneyorderdate.focus();
		return false;	
	}
	else if(document.frmmoney.amount.value == "")
	{
		alert("Please enter the Amount");
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
		alert("Kindly select Status");
		document.frmmoney.status.focus();
		return false;
	}
	else if(document.frmmoney.transcationtype3.value == "")
		{
			alert("Please select the Transaction Type ");
			document.frmmoney.transcationtype3.focus();
			return false;	
		}
		else if(document.frmmoney.cardnumber.value == "")
		{
			alert("Please enter the Card Number ");
			document.frmmoney.cardnumber.focus();
			return false;	
		}
		else if(!document.frmmoney.cardnumber.value.match(numericExpression))
		{
			alert("Card Number is not valid");
			document.frmmoney.cardnumber.focus();
			return false;			
		}
		else if(document.frmmoney.cardnumber.value.length != 16)
		{
			alert("Kindly enter 16 digit Card Number..");
			document.frmmoney.cardnumber.focus();
			return false;
		}
		else if(document.frmmoney.accountno2.value == "")
		{
			alert("Please enter the CVV Number ");
			document.frmmoney.accountno2.focus();
			return false;	
		}
		else if(!document.frmmoney.accountno2.value.match(numericExpression))
		{
			alert("CVV Number is not valid");
			document.frmmoney.accountno2.focus();
			return false;			
		}
		else if(document.frmmoney.accountno2.value.length != 3)
		{
		alert("Kindly enter 3 digit CVV number..");
		document.frmmoney.accountno2.focus();
		return false;
		}
	else
	{
		return true;
	}
}
</script>