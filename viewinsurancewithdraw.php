<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['btnwithdraw']))
{
	$sql="UPDATE insurance SET status='Closed' WHERE insuranceid='$_GET[policyid]'";
	$qsql=mysqli_query($con,$sql);
	$dt = date("Y-m-d");
	$sql ="INSERT INTO transaction(accountid, customerid,transactiontype, amount, transdate, paymenttype , note, status) VALUES ('$_POST[transcationtype]','$_SESSION[customerid]','Credit','$_POST[totalamt]','$dt','Online','Insurance amount transaction Policy Number - $_GET[policyid]','Active')";
	if(!$qsql = mysqli_query($con,$sql))
	{
		echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Insurance amount transferred Savings account.');</script>";
	}
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
        <h1>View Insurance Payment Record</h1>
      </div>
      <div class="right-column-content">
      
<?php
	$sql="select * from insurance WHERE status='Active' AND insuranceid='$_GET[policyid]'";
	if(isset($_SESSION['customerid']))
	{
		$sql = $sql . " AND customerid='$_SESSION[customerid]'";
	}
	$qsql=mysqli_query($con,$sql);
	while($rsedit=mysqli_fetch_array($qsql))
	{
?>	
        
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
<?php
$sql1 = "SELECT * FROM  customer WHERE customerid='$rsedit[customerid]'";
$qsql1 = mysqli_query($con,$sql1);
$rsedit1=mysqli_fetch_array($qsql1);
?>
<tr>
    <th width="203" scope="col">Policy Number</th>
    <td width="362" scope="col"><?php echo $rsedit[0]; ?></td>
  </tr>
<tr>
    <th width="203" scope="col">Customer Name</th>
    <td width="362" scope="col"><?php echo $rsedit1['customername']; ?></td>
  </tr>
<tr>
    <th width="203" scope="col">Login ID</th>
    <td width="362" scope="col"><?php echo $rsedit1['loginid']; ?></td>
  </tr>
   <tr>
    <th>Customer Age</th>
    <td><?php echo $custage = date_diff(date_create($rsedit1['dateofbirth']), date_create('today'))->y; ?>
    <input class="form-control" type="hidden" name="custage" value="<?php echo $custage; ?>"  />
    </td>
</tr>
<?php
$sql2 = "SELECT * FROM  insurancetype WHERE insurancetypeid='$rsedit[insurancetypid]'";
$qsql2 = mysqli_query($con,$sql2);
$rsedit2=mysqli_fetch_array($qsql2);
?>	
  <tr>
    <th width="203" height="24" scope="col">Inusrance Type</th>
    
    <td width="362" scope="col"><?php echo $rsedit2['insurancetype']; ?></td>
  </tr>
  <tr>
    <th> Bonus</th>
    <td><?php echo $rsedit2['bonus']; ?>%</td>
  </tr>
  <tr>
    <th>Policy Created On</th>
    <td><?php echo $rsedit['accountopened']; ?></td>
  </tr>
  <tr>
    <th>Policy Close Date</th>
    <td><?php echo $rsedit['accountclosedate']; ?></td>
  </tr>
  <tr>
    <th>Total Maturity Year</th>
    <td><?php echo $matyr = $rsedit['maturityyear'] - $custage; ?></td>
  </tr>
  <tr>
    <th width="203" scope="col"><?php echo $rsedit['premiumtype']; ?> Payble Amount</th>
    <td width="362" scope="col">Rs. 
	<?php
	$totalmonth = $matyr * 12;
	$termamt = $rsedit['amount'] / $totalmonth;
	if($rsedit['premiumtype'] == "Monthly")
	{
		$payterm = 12*$totmaturityyear;
	echo $premiumpayment = round($termamt*1); 
	}
	else if($rsedit['premiumtype'] == "3 Months")
	{
		$payterm = 3*$totmaturityyear;
	echo $premiumpayment = round($termamt*3);		
	}
	else if($rsedit['premiumtype'] == "6 Months")
	{
		$payterm = 2*$totmaturityyear;
	echo $premiumpayment = round($termamt*6);		
	}
	else if($rsedit['premiumtype'] == "Yearly")
	{
		$payterm = 1*$totmaturityyear;
	echo $premiumpayment = round($termamt*12);		
	}
	
	?></td>
  </tr>
  <tr>
    <th width="203" scope="col">Total Payble Amount</th>
    <td width="362" scope="col">Rs. <?php echo $rsedit['amount']; ?></td>
  </tr>
  <tr>
    <th width="203" scope="col">Bonus</th>
    <td width="362" scope="col">Rs. <?php echo (($rsedit['amount'] * $rsedit2['bonus']) /100 ) * $matyr; ?></td>
  </tr>
  <tr>
    <th width="203" scope="col">Total</th>
    <td width="362" scope="col">Rs. <?php echo ((($rsedit['amount'] * $rsedit2['bonus']) /100 ) * $matyr) + $rsedit['amount']; ?></td>
  </tr>
  <tr>
    <th>Term</th>
    <td><?php echo $rsedit['note']; ?></td>
  </tr>
  </tbody>
        </table>
    <?php
	}
	?>
    <br><hr><br>
    <?php
		  $sql="select * from insurance_payment WHERE insuranceid='$_GET[policyid]' order by insurance_payment_id";
		  $qsql=mysqli_query($con,$sql);
		  if(mysqli_num_rows($qsql) >=1)
		  {
	?>
      <form method="post" action="">
      <div style='overflow:auto;width:100%'>
          <?php
		  $i=1;
		  while($rs=mysqli_fetch_array($qsql))
		  {
		  		$i++;
				$totamt = $totamt+ $rs['paidamount'];
		  }
		  ?>
        </div>
        </form>
        <?php
		  }
		  else
		  {
			  echo "<h2>No payment done yet..</h2>";
		  }
		?>
        <p>
<form method="post" action="" >
<input class="form-control" type="hidden" name="insuranceid" value="<?php echo $_GET['policyid']; ?>" >
        <table width="298" border="1" class="tftable">
  <tbody>
    <tr>
      <th width="129" scope="row">Total amount</th>
      <td width="153">&nbsp;Rs. <?php echo $totamt; ?></td>
      </tr>
    <tr>    
    <tr>
      <th width="129" scope="row">Interest</th>
      <td width="153">&nbsp;Rs. <?php echo $interest =  ($totamt * $rsedit2['bonus']) / 100; ?></td>
      </tr>
    <tr>  
    <tr>
      <th width="129" scope="row">Withdrawlable Amount</th>
      <td width="153">&nbsp;Rs. <?php echo $withamt = $totamt + $interest; ?>
<input class="form-control" type="hidden" name="totalamt" value="<?php echo $withamt; ?>" >
      </td>
      </tr>
    <tr>
      <th scope="row">&nbsp;Select SB Account</th>
      <td>&nbsp;
      <select class="form-control" name="transcationtype" id="transcationtype" onchange="savingsacbal(this.value)">
            <option value="">Select</option>
            <?php
		   		$sql = "SELECT * FROM  account where acctype='Savings account' AND customerid='$_SESSION[customerid]' AND status='Active'";
				$qsql = mysqli_query($con,$sql);
				while($rsacc = mysqli_fetch_array($qsql))				
				{
					echo "<option value='$rsacc[accountid]'>$rsacc[accountid]</option>";					
				}
		   ?>
          </select>
      </td>
      </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;<input class="btn btn-info" type="submit" name="btnwithdraw" value="Withdraw Amount" ></td>
      </tr>
  </tbody>
</table>
</form>
        </p>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>