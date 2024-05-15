<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="Update insurance set customerid='$_POST[customer]', insurancetypid='$_POST[insurancetype]', amount='$_POST[amount]', premiumtype='$_POST[premium]', maturityyear='$_POST[maturity]', accountopened='$_POST[accountopeneddate]', accountclosedate='$_POST[accountclosedate]', note='$_POST[note]', status='Active' where insuranceid='$_GET[editid]'";
		if(!$qsql = mysqli_query($con,$sql))
	{
		echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Insuranceaccount Record Inserted Successfully..');</script>";
	}	
}
		
	else
	{
	$sql ="Insert into insurance(customerid, insurancetypid, amount,premiumtype,maturityyear, accountopened, accountclosedate,note, status) VALUES ('$_POST[customer]','$_POST[insurancetype]','$_POST[amount]','$_POST[premium]','$_POST[maturityage]','$_POST[policystartdate]','$_POST[policyclosedate]','$_POST[note]','Active')";
	if(!$qsql = mysqli_query($con,$sql))
	{
		echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Insuranceaccount Record Inserted Successfully..');</script>";
	}	
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
      <div class="right-column-heading"><h2>View Insurance Account</h2>
        <h1>Insurance accounts</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsuranceacc" onsubmit="return validateform()">
<?php
	$sql="select * from insurance WHERE status='Active'";
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
  <?php
  if($rsedit['insurancetypid'] != 3)
  {
	 ?>
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
	$totmaturityyear =  $matyr;
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
  <?php
  }
  ?>
  <tr>
    <th width="203" scope="col">Total Payble Amount</th>
    <td width="362" scope="col">Rs. <?php echo $rsedit['amount']; ?></td>
  </tr>
   <?php
  if($rsedit['insurancetypid'] != 3)
  {
?>
  <tr>
    <th width="203" scope="col">Bonus</th>
    <td width="362" scope="col">Rs. <?php echo (($rsedit['amount'] * $rsedit2['bonus']) /100 ) * $matyr; ?></td>
  </tr>
  <tr>
    <th width="203" scope="col">Total</th>
    <td width="362" scope="col">Rs. <?php echo ((($rsedit['amount'] * $rsedit2['bonus']) /100 ) * $matyr) + $rsedit['amount']; ?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <th>Term</th>
    <td><?php echo $rsedit['note']; ?></td>
  </tr>
  <tr>
    <th colspan="2">
      <div align="center">
      <?php
  	$lastdt = strtotime($rsedit['accountclosedate']);
	$dt = strtotime(date("Y-m-d"));
	if($dt < $lastdt)
	{		
		$sqlinsurance_payment="select * from insurance_payment WHERE insuranceid='$rsedit[insuranceid]' order by insurance_payment_id";
		$qsqlinsurance_payment=mysqli_query($con,$sqlinsurance_payment);
		if( mysqli_num_rows($qsqlinsurance_payment) < $payterm)
		{
	?>
      <a href="insurancepayment.php?policyid=<?php echo $rsedit[0]; ?>&payamt=<?php echo $premiumpayment; ?>">Make Payment</a> | 
	<?php
		}
	}
	?>
      <a href="viewinsurancepayment.php?policyid=<?php echo $rsedit[0]; ?>">View Insurance Payment</a> 
      	<?php
      		if( $rsedit2['insurancetype'] == "Convertible Whole Life")
			{
	  	?>
      | <a href='insurancechangeac.php?policyid=<?php echo $rsedit[0]; ?>'>Change to Endowment policy</a>
      	<?php
			}
		?>
		<?php
      		if($dt > $lastdt)
			{
	  	?>
      | <a href='viewinsurancewithdraw.php?policyid=<?php echo $rsedit[0]; ?>'>Withdraw</a>
      	<?php
			}
		?>
      </div>
    </th>
    </tr>
            
          </tbody>
        </table>
        <br><hr>
    <?php
	}
	?>
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
function printme()
{
	window.print();
}
</script>