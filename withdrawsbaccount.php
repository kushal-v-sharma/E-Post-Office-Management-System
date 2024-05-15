<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	$dt = date("Y-m-d");
	if(isset($_GET['editid']))
	{
		$sql="UPDATE transaction set accountid='$_POST[fromaccountno]', customerid='$_POST[toaccountno]', transactiontype='$_POST[transcationtype]', amount='$_POST[amount]', transdate='$_POST[transactiondate]', note='$_POST[note]', status='$_POST[status]' WHERE transactionid='$_GET[editid]'";
		if(!$qsql=mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Transaction record updated successfully..');</script>";
		}
	}
	else
	{
				$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Debit','$_POST[withdrawamount]','$dt','Online','Bank Account Number $_POST[bankaccountnumber]','Active')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
			
				echo "<script>alert('Transcation amount withdrawn successfully..');</script>";
				$insid = mysqli_insert_id($con);
				echo "<script>window.location='withdrawsbaccountreceipt.php?payid=" .  $insid . "';</script>";
			}	
			
	}
}
if(isset($_GET['accountid']))
{
	$sqlsbaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqlsbaccountdet=mysqli_query($con,$sqlsbaccountdet);
	$rssbaccountdet=mysqli_fetch_array($qsqlsbaccountdet);
	
	$sqlsbaccount="select * from sbaccount WHERE status='Active' AND sbaccountid='$rssbaccountdet[actypeid]'";
	$qsqlsbaccount=mysqli_query($con,$sqlsbaccount);
	$rssbaccount=mysqli_fetch_array($qsqlsbaccount);
		
	
					$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				$balamt = $totcredit - $totdebit;
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
      <div class="right-column-heading"><br />
<h2>Withdraw SB Account</h2>
        <h1>Add Transaction Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdeposit" onsubmit="return validation()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
         <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287"><input class="form-control" type="text" name="accountno" id="accountno" value="<?php echo $_GET['accountid']; ?>"/></td>
            </tr>
            
            <tr>
              <th scope="row">Bank Account Number</th>
              <td><input class="form-control" type="text" name="bankaccountnumber" id="bankaccountnumber" /></td>
            </tr>
            <tr>
              <th scope="row">Bank Name</th>
              <td><input class="form-control" type="text" name="bankname" id="bankname" /></td>
            </tr>
            <tr>
              <th scope="row">Branch</th>
              <td><input class="form-control" type="text" name="Branch" id="Branch" /></td>
            </tr>
            <tr>
              <th scope="row">IFSC Number</th>
              <td><input class="form-control" type="text" name="ifsc" id="ifsc" /></td>
            </tr>
            <tr>
              <th scope="row">Available balance</th>
              <td><input class="form-control" type="text" name="balamt"  readonly id="balamt" value="<?php echo $balamt; ?>" /></td>
            </tr>            
            <tr>
              <th scope="row">Minimum balance required</th>
              <td><input class="form-control" type="text" name="minbalanceamt"  readonly id="minbalanceamt" value="<?php echo $rssbaccount['minbal']; ?>" /></td>
            </tr>
            <tr>
              <th scope="row">Withdarw Amount</th>
              <td>
              <input class="form-control" type="text" name="withdrawamount" id="withdrawamount" /></td>
            </tr>
            <tr>
              <th scope="row">Withdraw Date</th>
              <td><input class="form-control" type="date" name="paiddate" id="paiddate" value="<?php echo $editrs['paiddate'];?><?php echo date("Y-m-d"); ?>" readonly /></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Withdraw" /></td>
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
<script type="application/javascript" >
function validation()
{
	var balamt = parseFloat(document.frmdeposit.balamt.value);
	var withdrawamount = parseFloat(document.frmdeposit.withdrawamount.value);
	var minbal =  parseFloat(document.frmdeposit.minbalanceamt.value);
	var withdrawalamt = balamt- minbal;
	if( withdrawamount > withdrawalamt)
	{
		alert("You can withdraw only " + withdrawalamt);
		return false;
	}
	else
	{
		return true;
	}
}
</script>