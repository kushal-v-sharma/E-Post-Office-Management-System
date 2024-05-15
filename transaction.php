<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE transaction set accountid='$_POST[fromaccountno]', transactiontype='$_POST[transcationtype]', amount='$_POST[amount]', transdate='$_POST[transactiondate]', note='$_POST[note]', status='$_POST[status]' WHERE transactionid='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Transaction Record Updated Successfully..');</script>";
		}
	}
	else
	{
		$sql ="INSERT INTO transaction(accountid, transactiontype, amount, transdate, paymenttype , note, status) VALUES ('$_POST[fromaccountno]','$_POST[transcationtype]','$_POST[amount]','$_POST[transactiondate]','Offline','$_POST[note]','Active')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
				echo "<script>alert('Transcation Record Inserted Successfully..');</script>";
			}	
		}
}
if(isset($_GET['editid']))
{
	$sql="select * from transaction where transactionid='$_GET[editid]'";
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
      <div class="right-column-heading"><h2>Transaction</h2>
        <h1>Add Transaction Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmtransaction" onsubmit="return validateform()">
         <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Account No</th>
              <td width="287">
              <input class="form-control" type="text" name="fromaccountno" id="fromaccountno" value="<?php echo $rsedit['accountid']; ?>" onKeyUp="loadsavingsacrec(this.value)" />
              <div id="loadaccrec"></div>
              </td>
            </tr>
            <tr>
              <th scope="row">Transaction Type</th>
              <td><select class="form-control" name="transcationtype" id="transcationtype">
                <option value="">select</option>
                <?php
				$arr=array("Credit", "Debit");
				foreach($arr as $val)
				{
					if($val == $rsedit['transcationtype'])
					{
					echo "<option value='$val' selected>$val</option>";
					}
					else if($val==$_GET['transcationtype'])
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
              <th scope="row">Amount</th>
              <td><input class="form-control" type="text" name="amount" id="amount" value="<?php echo $rsedit['amount']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Transaction Date</th>
              <td><input class="form-control" type="date" name="transactiondate" id="transactiondate" value="<?php echo $rsedit['transdate']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Note</th>
              <td><textarea class="form-control"  name="note" id="note" cols="45" rows="5"><?php echo $rsedit['note']; ?></textarea></td>
            </tr>
           
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" /></td>
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
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
if(document.frmtransaction.fromaccountno.value == "" && document.frmtransaction.transcationtype.value == ""  && document.frmtransaction.amount.value == ""  && document.frmtransaction.transactiondate.value == "" && document.frmtransaction.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmtransaction.fromaccountno.focus();
		return false;	
	}
	else if(document.frmtransaction.fromaccountno.value == "")
	{
		alert("Please enter From Account Number");
		document.frmtransaction.fromaccountno.focus();
		return false;	
	}
	else if(!document.frmtransaction.fromaccountno.value.match(numericExpression))
	{
		alert("Account Number is not valid");
		document.frmtransaction.fromaccountno.focus();
		return false;			
	}
	else if(document.frmtransaction.transcationtype.value == "")
	{
		alert("Please select Transaction Type");
		document.frmtransaction.transcationtype.focus();
		return false;	
	}
	else if(document.frmtransaction.amount.value == "")
	{
		alert("Please enter Amount");
		document.frmtransaction.amount.focus();
		return false;	
	}
	else if(!document.frmtransaction.amount.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frmtransaction.amount.focus();
		return false;			
	}
	else if(document.frmtransaction.transactiondate.value == "")
	{
		alert("Please enter Date");
		document.frmtransaction.transactiondate.focus();
		return false;	
	}
	else if(document.frmtransaction.status.value == "") 
	{
		alert("Kindly select Status");
		document.frmtransaction.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}

function loadsavingsacrec(acid) {
    if (acid.length == 0) { 
        document.getElementById("loadaccrec").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("loadaccrec").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "ajaxsavingsacdetail.php?acid=" + acid, true);
        xmlhttp.send();
    }
}
</script>

