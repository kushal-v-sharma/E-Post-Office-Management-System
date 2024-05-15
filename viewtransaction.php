<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from transaction where transactionid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<script>alert('Record deleted');</script>";
	echo "<script>window.location='viewtransaction.php';</script>";
}


	$sql1="SELECT * FROM account WHERE acctype= 'Savings account'";
	$qsql1=mysqli_query($con,$sql1);
	while($rsarr =mysqli_fetch_array($qsql1))
	{
	
		$sqlsbaccounttype="SELECT *, ifnull(interestperyear,0) as intperyr FROM sbaccount WHERE sbaccountid = '$rsarr[actypeid]'";
		$qsqlsbaccounttype=mysqli_query($con,$sqlsbaccounttype);
		$rsarrsbaccounttype =mysqli_fetch_array($qsqlsbaccounttype);
	
		$now = time(); // or your date as well
		$acopendt = $rsarr["acopendate"];
     	$your_date = strtotime($acopendt);
    	$datediff = $now - $your_date;
     	$nodays = floor($datediff/(60*60*24));
		$noyear = $nodays/366;
			if($noyear > 21)
			{
				$noyear =21;
			}
			for($yr=1;$yr<=$noyear;$yr++)
			{
				$sqltransaction ="select ifnull(SUM(amount),0) from transaction where accountid='$rsarr[accountid]' AND transactiontype='Credit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totcredit = $rstransaction[0];
				
				$sqltransaction ="select ifnull(SUM(amount),0) from transaction where accountid='$rsarr[accountid]' AND transactiontype='Debit'";
				$qsqltransaction =mysqli_query($con,$sqltransaction);
				$rstransaction =mysqli_fetch_array($qsqltransaction);
				$totdebit = $rstransaction[0];
				
				 $totamt = $totcredit - $totdebit;
				$interest = ($totamt * ($rsarrsbaccounttype['intperyr'] ?? 0))/100;
				
				 $sqltransaction1 ="select * from transaction where paymenttype='Interest' AND accountid='$rsarr[accountid]'";
				$qsqltransaction1 =mysqli_query($con,$sqltransaction1);

				if(mysqli_num_rows($qsqltransaction1) < $yr)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','$rsarrsbaccounttype[intperyr]% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
				}
			}
			
	}
	$sql="SELECT * FROM account WHERE acctype='SSA Account'";
	$qsql=mysqli_query($con,$sql);
	while($rsarr =mysqli_fetch_array($qsql))
	{
		$sqlsbaccounttype="SELECT * FROM ssaaccount WHERE ssaccountid = '$rsarr[actypeid]'";
		$qsqlsbaccounttype=mysqli_query($con,$sqlsbaccounttype);
		$rsarrsbaccounttype =mysqli_fetch_array($qsqlsbaccounttype);
		
		$now = time(); // or your date as well
		$acopendt = $rsarr["acopendate"];
     	$your_date = strtotime($acopendt);
    	$datediff = $now - $your_date;
     	$nodays = floor($datediff/(60*60*24));
			$noyear = $nodays/366;
			if($noyear > 21)
			{
				$noyear =21;
			}
			for($yr=1;$yr<=$noyear;$yr++)
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

				$interest = ($totamt * ($rsarrsbaccounttype['interest'] ?? 0))/100;
				
				 $sqltransaction1 ="select * from transaction where paymenttype='Interest' AND accountid='$rsarr[accountid]'";
				$qsqltransaction1 =mysqli_query($con,$sqltransaction1);

				if(mysqli_num_rows($qsqltransaction1) < $yr)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','" . ($rsarrsbaccounttype['interest'] ?? 0) . "% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
				}
			}
			
	}
	$sql2="SELECT * FROM account WHERE acctype='Time deposit'";
	$qsql2=mysqli_query($con,$sql2);
	echo mysqli_error($con);
	while($rsarr =mysqli_fetch_array($qsql2))
	{
		$sqlsbaccounttype="SELECT * FROM tdaccount WHERE tdaccount_id = '$rsarr[actypeid]'";
		$qsqlsbaccounttype=mysqli_query($con,$sqlsbaccounttype);
		$rsarrsbaccounttype =mysqli_fetch_array($qsqlsbaccounttype);
		
		$tdnoyears = $rsarr['numofyrs'];
		if($tdnoyears == 1)
		{
			$intpercentage = ($rsarrsbaccounttype['int1yr'] ?? 0);
		}
		else if($tdnoyears == 2)
		{
			$intpercentage = ($rsarrsbaccounttype['int2yr'] ?? 0);
		}
		else if($tdnoyears == 3)
		{
			$intpercentage = ($rsarrsbaccounttype['int3yr'] ?? 0);
		}
		else if($tdnoyears == 5)
		{
			$intpercentage = ($rsarrsbaccounttype['int5yr'] ?? 0);
		}
		
		$now = time(); // or your date as well
		$acopendt = $rsarr["acopendate"];
     	$your_date = strtotime($acopendt);
    	$datediff = $now - $your_date;
     	$nodays = floor($datediff/(60*60*24));
			
			if($nodays >=366 )
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

				$interest = ($totamt * ($intpercentage ?? 0))/100;
				
				 $sqltransaction1 ="select * from transaction where paymenttype='Interest' AND accountid='$rsarr[accountid]'";
				$qsqltransaction1 =mysqli_query($con,$sqltransaction1);

				if(mysqli_num_rows($qsqltransaction1) == 0)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','" . ($intpercentage ?? 0) ."% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
				}
			}
			if($nodays >=732 )
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

				$interest = ($totamt * ($intpercentage ?? 0))/100;
				
				 $sqltransaction1 ="select * from transaction where paymenttype='Interest' AND accountid='$rsarr[accountid]'";
				$qsqltransaction1 =mysqli_query($con,$sqltransaction1);

				if(mysqli_num_rows($qsqltransaction1) == 1)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','" . ($intpercentage ?? 0) ."% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
				}
			}
			
			if($nodays >=1098 || $nodays >=1464)
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
				$interest = ($totamt * ($intpercentage ?? 0))/100;
				
				 $sqltransaction1 ="select * from transaction where paymenttype='Interest' AND accountid='$rsarr[accountid]'";
				$qsqltransaction1 =mysqli_query($con,$sqltransaction1);

				if(mysqli_num_rows($qsqltransaction1) == 2)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','" . ($intpercentage ?? 0) ."% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
				}
				if(mysqli_num_rows($qsqltransaction1) == 3)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','" . ($intpercentage ?? 0) . "% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
				}
			}
			
			if($nodays >=1830)
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

				$interest = ($totamt * ($intpercentage ?? 0))/100;
				
				 $sqltransaction1 ="select * from transaction where paymenttype='Interest' AND accountid='$rsarr[accountid]'";
				$qsqltransaction1 =mysqli_query($con,$sqltransaction1);

				if(mysqli_num_rows($qsqltransaction1) == 4)
				{
					$sql ="INSERT INTO transaction(accountid, customerid, transactiontype, amount, transdate,paymenttype, note, status) VALUES ('$rsarr[accountid]','$rsarr[customerid]','Credit','$interest','$dt','Interest','" . ($intpercentage ?? 0) . "% Interest for $totamt','Active')";
					if(!$qsql = mysqli_query($con,$sql))
					{
						echo mysqli_error($con); 
					}
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
      <div class="right-column-heading"><h2>Transaction</h2>
        <h1>View Transaction Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <div style='overflow:auto;width:100%'>
        <p>&nbsp;</p>
        <label for="accountno"></label>
        <label for="transactiontype"></label>
        <table width="200" border="1" class="tftable">
          <tr>
            <th scope="col">Account No</th>
            <th scope="col"><select class="form-control" name="accountno" id="accountno">
                         <option value="All">All</option> 
                <?php
				$sqlcust = "SELECT * FROM account WHERE status='Active'";
				if(isset($_SESSION['customerid']))
				{
					$sqlcust=$sqlcust. " AND customerid='$_SESSION[customerid]'";
				}
				$qsqlcust = mysqli_query($con,$sqlcust);
				while($rscust = mysqli_fetch_array($qsqlcust))
					{
						if($rscust['accountid'] == $_POST['accountno'])
						{
						echo "<option value='$rscust[accountid]' selected>$rscust[accountid] - $rscust[acctype]</option>";
						}
						else
						{
						echo "<option value='$rscust[accountid]'>$rscust[accountid] -  $rscust[acctype]</option>";						
						}
					}
				?>
                </select>
            </select></th>
            <th scope="col"><p> Transaction Type</p></th>
            <th scope="col"><select class="form-control" name="transactiontype" id="transactiontype">
            <option value="All">All</option> 
             <?php
				$arr=array("Credit", "Debit");
				foreach($arr as $val)
				{
					if($val == $_POST['transactiontype'])
					{
					echo "<option value='$val' selected>$val</option>";
					}
					else
					{
					echo "<option value='$val'>$val</option>";
					}
				}
				?>
            </select></th>
            <th scope="col"><input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" /></th>
          </tr>
      </table>
        <p>&nbsp;</p>
        <table width="488" border="1" class="tftable" >
          <tr>
          <?php
		  if(!isset($_SESSION['customerid']))
		  {
            echo ' <th scope="col">Customer</th>';
		  }
		    ?>
            <th scope="col">Transaction Date</th>
            <th scope="col">Transaction Type</th>
            <th scope="col">Account No</th>
            <th scope="col">Particulars</th>
            <th scope="col">Amount</th>
			<?php
			if(isset($_SESSION['adminid']))
			{
			?>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
			<?php
			}
			?>
          </tr>
          <?php
		  $sql="select * from transaction WHERE status='Active' AND transdate!='0000-00-00'";
		  if(isset($_SESSION['customerid']))
		 {
		   $sql = $sql . " AND customerid='$_SESSION[customerid]'";
		 }
		 if($_POST['accountno'] != "All")
		 {
		  $sql = $sql . " AND accountid='$_POST[accountno]' ";
		 }
		 if($_POST['transactiontype'] != "All")
		 {
			 $sql = $sql . " AND transactiontype='$_POST[transactiontype]'";
		 }
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			 $sql3="SELECT * FROM customer WHERE customerid='$rs[customerid]'";
			 $qsql3=mysqli_query($con,$sql3);
			  $rs3=mysqli_fetch_array($qsql3);
			echo "<tr>";
            if(!isset($_SESSION['customerid']))
			{
			echo "<td>&nbsp;$rs3[customername]</td>";
			}
			echo "<td>&nbsp;" . date("d-M-Y",strtotime($rs['transdate'])) . "</td>
            <td>&nbsp;$rs[transactiontype]</td>
            <td>&nbsp;$rs[accountid]</td>
			<td>&nbsp;$rs[note]</td>
            <td>&nbsp;Rs. $rs[amount]</td>
            ";
			if(isset($_SESSION['adminid']))
			{
            echo "
            <td>&nbsp;$rs[status]</td><td>&nbsp; <a href='viewtransaction.php?deleteid=$rs[transactionid]' > Delete</a></td>";
			}
			echo "</tr>";
		  }
		  ?>
      </table>
        </div>
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