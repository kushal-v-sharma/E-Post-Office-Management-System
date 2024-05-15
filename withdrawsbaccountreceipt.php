<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");

	$sql="select * from transaction where transactionid='$_GET[payid]'";
	$qsql=mysqli_query($con,$sql);
	$editrs=mysqli_fetch_array($qsql);
	
	$sqlsbaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqlsbaccountdet=mysqli_query($con,$sqlsbaccountdet);
	$rstdaccountdet=mysqli_fetch_array($qsqlsbaccountdet);
	
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
        <h2>Withdraw SB Account</h2>
        <h1>Withdraw SB Account  Receipt</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frombill" onsubmit="return validateform()">
      <div id="printarea" >
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th scope="row">Transaction</th>
              <td>Withdraw SB Account</td>
            </tr>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287">
                <?php echo $editrs['accountid']; ?></td>
            </tr>
            
            <tr>
              <th scope="row">Withdarw Amount</th>
              <td>Rs. <?php echo $editrs['amount']; ?></td>
            </tr>
            <tr>
              <th scope="row">Withdraw Date</th>
              <td><?php echo $editrs['transdate'];?></td>
            </tr>
            <tr>
              <th scope="row">Note</th>
              <td><?php echo $editrs['note'];?>
                </td>
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
        <h1>&nbsp;</h1>
        </form>
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
	
	var withdrawalamt = balamt- mindeposit;

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