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
				echo "<script>window.location='withdrawssaaccountreceipt.php?payid=" .  $insid . "';</script>";
			}	
			
	}
}
if(isset($_GET['accountid']))
{
				$sqlssaaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
				$qsqlssaaccountdet=mysqli_query($con,$sqlssaaccountdet);
				$rsssaaccountdet=mysqli_fetch_array($qsqlssaaccountdet);
				
				$sqlssaaccount="select * from ssaaccount WHERE status='Active' AND ssaccountid='$rsssaaccountdet[actypeid]'";
				$qsqlssaaccount=mysqli_query($con,$sqlssaaccount);
				$rsssaaccount=mysqli_fetch_array($qsqlssaaccount);
		
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$_GET[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				$balamt = $totcredit - $totdebit;
				
				$dt = date("Y-m-d");
				$d1 = new DateTime($rsssaaccountdet['acopendate']);
				$d2 = new DateTime($dt);
				$diff = $d2->diff($d1);
				$noyr= $diff->y;

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
<h2>Withdraw SSA Account</h2>
        <h1>Add Transaction Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmdeposit" onsubmit="return validation()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $balamt; ?>" />
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
              <th scope="row">Withdarwlable Amount (<?php
			  if($noyr >= 18)
			  {
			   ?> 
              You can withdraw only 50% from this account..
              <?php
			  }
			  if($noyr >=21)
			  {
			?>
              You are eligible to withdraw full amount..
              <?php
			  }
			  ?>)</th>
              <td><?php
			  if($noyr >= 18)
			  {
			   ?> 
              <input class="form-control" type="text" name="withdralablewamount" id="withdralablewamount" readonly value="<?php echo $balamt/2; ?>" />
              <?php
			  }
			  if($noyr >=21)
			  {
			?>
              <input class="form-control" type="text" name="withdralablewamount" id="withdralablewamount" readonly value="<?php echo $balamt; ?>" />
              <?php
			  }
			  ?>
              </td>
            </tr>
            <tr>
              <th scope="row">Withdraw Amount</th>
              <td><input class="form-control" type="text" name="withdrawamount" id="withdrawamount" /></td>
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
	var mindeposit = parseFloat(document.frmdeposit.mindeposit.value);
	var withdrawamount = parseFloat(document.frmdeposit.withdrawamount.value);
	var withdralablewamount = parseFloat(document.frmdeposit.withdralablewamount.value);
	
	var withdrawalamt = balamt- mindeposit;

	if( withdrawamount > withdralablewamount)
	{
		alert("You can withdraw only " + withdralablewamount);
		return false;
	}
	else
	{
		return true;
	}
}
</script>