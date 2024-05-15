<?php
error_reporting(0); session_start();
include("dbconnection.php");
if($_GET['paytype'] == "Card Payment")
{
?>
<table width="560" border="3" class="tftable">
  <tbody>
    <tr>
      <th scope="row">Payment Type</th>
      <td><select class="form-control" name="transcationtype2" id="transcationtype2"  required title="Kinldy select payment type.." >
      
        <option value="">select</option>
        <?php
					$arr=array("Debit Card", "Credit Card", "Master Card", "VISA");
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
      <th height="35" scope="row">Card Number</th>
      <td><input class="form-control" type="text" name="cardnumber" id="cardnumber" value="<?php echo $rsedit['amount']; ?>"/></td>
    </tr>
    <tr>
      <th height="36" scope="row">CVV Number</th>
      <td><input class="form-control" type="text" name="accountno2" id="accountno2" value="<?php echo $rsedit['customerid']; ?>"/></td>
    </tr>
    <tr>
      <th height="24" scope="row">Expiry Date</th>
      <td><input class="form-control" type="date" required="required" name="accountopendate" id="accountopendate" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $rsedit['acopendate']; ?>"/></td>
    </tr>
  </tbody>
</table>
<?php
}

if($_GET["paytype"] == "SB Account")
{
?>
    <table width="560" border="3">
      <tbody>
        <tr>
          <th  scope="row">Account Number</th>
          <td><select class="form-control" name="transcationtype" id="transcationtype" onchange="savingsacbal(this.value)">
            <option value="">Select</option>
            <?php
		   		$sql = "SELECT * FROM  account where acctype='Savings account' AND customerid='$_SESSION[customerid]' AND status='Active'";
				$qsql = mysqli_query($con,$sql);
				while($rsacc = mysqli_fetch_array($qsql))				
				{
					echo "<option value='$rsacc[accountid]'>$rsacc[accountid]</option>";					
				}
		   ?>
          </select>            <div id="loadsavingsdetail"></div>
          </td>
        </tr>
      </tbody>
    </table>     
<?php
}
?>
<script type="application/javascript">
function calcommission(rupees)
{
	document.getElementById("commission").value=rupees*5/100;
}
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   
</script>