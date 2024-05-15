<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");

	$sql="select * from transaction where transactionid='$_GET[payid]'";
	$qsql=mysqli_query($con,$sql);
	$editrs=mysqli_fetch_array($qsql);
	
	$sqltdaccountdet="select * from account WHERE accountid='$_GET[accountid]'";
	$qsqltdaccountdet=mysqli_query($con,$sqltdaccountdet);
	$rstdaccountdet=mysqli_fetch_array($qsqltdaccountdet);
	
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
<h2>Withdraw TD Account</h2>
        <h1>Withdraw TD Account  Receipt</h1>
      </div>
      <div class="right-column-content">
<?php
$sql="SELECT * FROM account WHERE acctype= 'Time deposit' and accountid='$_GET[accountid]'";
$qsql=mysqli_query($con,$sql);
$rsarr =mysqli_fetch_array($qsql);


		
$now = time(); // or your date as well
$acopendt = $rsarr["acopendate"];
$your_date = strtotime($acopendt);
$datediff = $now - $your_date;
$nodays = floor($datediff/(60*60*24));
$noyear = $nodays/366;
		
$totnodays = $rsarr['numofyrs']*366;
$widraweligibledays = $totnodays/2;
$yrs = $rsarr['numofyrs']/2;

$widraweligibledate =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($acopendt)) . " + $widraweligibledays day"));

// $totnodays - Total number of days to withdraw full amount
// $nodays - Total number of days account created
// $widraweligibledays - half withdrawable days

//Coding to check half year
$now = strtotime(date("Y-m-d")); // or your date as well
$acopendt = $widraweligibledate;
$your_date = strtotime($acopendt);
$datediff = $now - $your_date;
$nohalfdays = floor($datediff/(60*60*24));

if($rsarr['numofyrs'] == 1)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int1yr']; 		
  }
  else if($nodays >= $widraweligibledays )
  {					  
 $intyrly = $rstdaccount['int1yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  }
}
else if($rsarr['numofyrs'] == 2)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int2yr']; 		
  }
  else if($nodays >= $widraweligibledays)
  {					  
 $intyrly = $rstdaccount['int2yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  }
}
else if($rsarr['numofyrs'] == 3)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int3yr']; 		
  }
  else if($nodays >= $widraweligibledays)
  {					  
 $intyrly = $rstdaccount['int3yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  } 
}
else if($rsarr['numofyrs'] == 5)
{
  if($nodays >= $totnodays)
  {
 $intyrly = $rstdaccount['int5yr']; 		
  }
  else if($nodays >= $widraweligibledays)
  {					  
 $intyrly = $rstdaccount['int5yr']/2; 
  }
  else
  {
 $intyrly = 0;	  
  }
}			


//if($noyear > $yrs)	
{
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$rsarr[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select COALESCE(SUM(amount),0) from transaction where accountid='$rsarr[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				 $totamt = $totcredit - $totdebit;
				 
				 $interestamt=0;

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
			$intrestamt = 0;
		  for($yer = 0; $yer < $rsarr['numofyrs']; $yer++)
		  {
			  $intrestamt = (($intyrly * $totamt /100));
			  	$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Credit','$intrestamt','$dt','Online','$intyrly% interest for TD','Active')";
				mysqli_query($con,$sql);
		  }
		$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$_POST[accountid]','$_SESSION[customerid]','Debit','$_POST[totwithdrawamount]','$dt','Online','Bank Account Number $_POST[bankaccountnumber]','Active')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Transcation amount withdrawn successfully..');</script>";
		}
		$sql ="UPDATE account SET acclosedate='$dt',status='Closed' WHERE accountid='$_POST[accountid]'";
		$qsql = mysqli_query($con,$sql);
	}
}
?>      
      <form method="post" action="" name="frmdeposit" onsubmit="return validation()">     
       <input class="form-control" type="hidden" name="accountid" value="<?php echo $_GET['accountid']; ?>" />
      <input class="form-control" type="hidden" name="mindeposit" value="<?php echo $rssbaccount['mindeposit']; ?>" />
      <input class="form-control" type="hidden" name="balamt" value="<?php echo $balamt; ?>" />
         <div id="printarea" >
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th scope="row">Transaction </th>
              <td>Withdraw TD Account</td>
            </tr>
            <tr>
              <th width="253" scope="row"> Account Number</th>
              <td width="287"><?php echo $editrs['accountid']; ?></td>
            </tr>
            <tr>
              <th scope="row">Withdraw Amount</th>
              <td><?php echo $editrs['amount']; ?> </td>
            </tr>
            <tr>
              <th scope="row">Withdraw Date</th>
              <td><?php echo $editrs['transdate']; ?></td>
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
        </form>
<?php
}
//else
{
?>
<?php
}
?>
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