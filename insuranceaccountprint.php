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
if(isset($_GET['insid']))
{
	$sql="select * from insurance where insuranceid='$_GET[insid]'";
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
      <div class="right-column-heading"><h2>Insurance</h2>
        <h1>Insurance Registration Report</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsuranceacc" onsubmit="return validateform()">
      <div id="printableArea">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
<?php
$sql = "SELECT * FROM  customer WHERE customerid='$rsedit[customerid]'";
$qsql = mysqli_query($con,$sql);
$rsedit1=mysqli_fetch_array($qsql);
?><tr>
    <th width="203" scope="col">Policy Number</th>
    <td width="362" scope="col"><?php echo $_GET['insid']; ?></td>
  </tr>
<tr>
    <th width="203" scope="col">Customer Name</th>
    <td width="362" scope="col"><?php echo $rsedit1['customername']; ?></td>
  </tr>
  <tr>
    <th>Date Of Birth</th>
    <td><?php echo $rsedit1['dateofbirth']; ?></td>
  </tr>
  <tr>
    <th>Mobile Number</th>
    <td><?php echo $rsedit1['mobileno']; ?></td>
  </tr>
  <tr>
    <th>Customer Age</th>
    <td><?php echo $custage = date_diff(date_create($rsedit1['dateofbirth']), date_create('today'))->y; ?>
    <input class="form-control" type="hidden" name="custage" value="<?php echo $custage; ?>"  />
    </td>
</tr>
<?php
$sql = "SELECT * FROM  insurancetype WHERE insurancetypeid='$rsedit[insurancetypid]'";
$qsql = mysqli_query($con,$sql);
$rsedit2=mysqli_fetch_array($qsql);
?>	
  <tr>
    <th width="203" height="24" scope="col">Inusrance Type</th>
    
    <td width="362" scope="col"><?php echo $rsedit2['insurancetype']; ?></td>
  </tr>
<?php
if($rsedit2['insurancetypeid'] == 4 )
{
?>  
  <tr>
    <th>Minimum maturity year</th>
    <td>35</td>
  </tr>

<?php
}
?>
  <tr>
    <th> Bonus</th>
    <td><?php echo $rsedit2['bonus']; ?>%</td>
  </tr>
  <tr>
    <th>Minimum Age</th>
    <td><?php echo $rsedit2['minage']; ?></td>
  </tr>
  <tr>
    <th>Maximum Age</th>
    <td><?php echo $rsedit2['maxage']; ?></td>
  </tr>
  <tr>
    <th>Minimum Amount</th>
    <td>Rs. <?php echo $rsedit2['minamt']; ?></td>
  </tr>
  <tr>
    <th>Maximum Amount</th>
    <td>Rs. <?php echo $rsedit2['maxamt']; ?></td>
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
    <th>Nominee</th>
    <td><?php echo $rsedit['nominee']; ?></td>
  </tr>
  <tr>
    <th>Relation</th>
    <td><?php echo $rsedit['relationship']; ?></td>
  </tr>
  <tr>
    <th>Total Maturity Year</th>
    <td><?php  $matyr = $rsedit['maturityyear'] - $custage; 
	if($matyr <=0)
	{
		echo "Not Applicable";
		$matyr = 1;
	}
	else
	{
		echo $matyr;
	}
	
	?></td>
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
        </div>
        <table width="560" height="38" border="3" class="tftable">
          <tbody>
            <?php
$sql = "SELECT * FROM  customer WHERE customerid='$rsedit[customerid]'";
$qsql = mysqli_query($con,$sql);
$rsedit1=mysqli_fetch_array($qsql);
?>
            <?php
$sql = "SELECT * FROM  insurancetype WHERE insurancetypeid='$rsedit[insurancetypid]'";
$qsql = mysqli_query($con,$sql);
$rsedit2=mysqli_fetch_array($qsql);
?>
            <?php
if($rsedit2['insurancetypeid'] == 4 )
{
?>
            <?php
}
?>
            <tr>
              <th height="28" scope="row" align="center"><input class="form-control" type="button" onclick="printDiv('printableArea')" value="Print" /></th>
            </tbody>
        </table>
        <p>&nbsp;</p>
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
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>