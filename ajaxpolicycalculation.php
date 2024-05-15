<?php
error_reporting(0); session_start();
include("dbconnection.php");
$totmaturityyear = $_GET['maturityage'] - $_GET['custage'];
$sqlinstype = "SELECT * FROM  insurancetype WHERE insurancetypeid='$_GET[insurancetype]'";
$qsqlinstype = mysqli_query($con,$sqlinstype);
$rsinstype=mysqli_fetch_array($qsqlinstype);
?>
<table width="437" border="1">
  <tr>
    <td>Insurance type</td>
    <td>&nbsp;<?php echo $rsinstype['insurancetype']; ?></td>
  </tr>
  <tr>
    <td>Policy Created On</td>
    <td><?php echo date("Y-m-d"); ?> <?php echo $_GET['insurancetype']; ?></td>
  </tr>
  <?php
if($_GET['insurancetype'] != 3)
{
	?>
  <tr>
    <td>Policy Close Date</td>
    <td><?php
	$yrs = "+ $totmaturityyear years";
	 echo $end = date('Y-m-d', strtotime($yrs)); ?></td>
  </tr>
  <tr>
    <td>Total Maturity Year</td>
    <td><?php echo $totmaturityyear; ?></td>
  </tr>
  <tr>
    <td width="178" scope="col"><?php echo $_GET['premiumtype']; ?> Payble Amount</td>
    <td width="243" scope="col">Rs. 
	<?php
	$totalmonth = $totmaturityyear * 12;
	$termamt = $_GET['amount'] / $totalmonth;
	if($_GET['premiumtype'] == "Monthly")
	{
		$payterm = 12*$totmaturityyear;
	echo $premiumpayment = round($termamt*1); 
	}
	else if($_GET['premiumtype'] == "3 Months")
	{
		$payterm = 3*$totmaturityyear;
	echo $premiumpayment = round($termamt*3);		
	}
	else if($_GET['premiumtype'] == "6 Months")
	{
		$payterm = 2*$totmaturityyear;
	echo $premiumpayment = round($termamt*6);		
	}
	else if($_GET['premiumtype'] == "Yearly")
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
    <td width="178" scope="col">Total Payble Amount</td>
    <td width="243" scope="col">Rs. <?php echo $_GET['amount']; ?></td>
  </tr>
  <?php
if($_GET['insurancetype'] != 3)
{
	?>
  <tr>
    <td width="178" scope="col">Bonus</td>
    <td width="243" scope="col">Rs. <?php echo (($_GET['amount'] * $rsinstype['bonus']) /100 ) * $totmaturityyear; ?></td>
  </tr>
  <tr>
    <td width="178" scope="col">Total</td>
    <td width="243" scope="col">Rs. <?php echo ((($_GET['amount'] * $rsinstype['bonus']) /100 ) * $totmaturityyear) + $_GET['amount']; ?></td>
  </tr>
  <tr>
    <td>Term</td>
    <td><?php echo $payterm; ?></td>
  </tr>
  <?php
}
?>
</table>
<input class="form-control" type="hidden" name="policystartdate" value="<?php echo date("Y-m-d"); ?>"  />
<input class="form-control" type="hidden" name="policyclosedate" value="<?php echo $end; ?>"  />
<input class="form-control" type="hidden" name="totmaturityyear" value="<?php echo $totmaturityyear; ?>"  />
<input class="form-control" type="hidden" name="note" value="Insurance type - <?php echo $rsinstype['insurancetype']; ?> | Premium payment- <?php echo $premiumpayment; ?> /<?php echo $_GET['premiumtype']; ?> | Total Maturity year - <?php echo $totmaturityyear; ?> | Term - <?php echo $payterm; ?>"  />