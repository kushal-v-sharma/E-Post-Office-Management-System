<?php
error_reporting(0);
session_start();
include("header.php");
include("dbconnection.php");
$sqlcustomer = "SELECT * FROM customer WHERE customerid='$_SESSION[customerid]'";
$qsqlcustomer = mysqli_query($con,$sqlcustomer);
$rslogincustomer = mysqli_fetch_array($qsqlcustomer);
$now = time(); // or your date as well
$acopendt = $rslogincustomer['dateofbirth'];
$your_date = strtotime($acopendt);
$datediff = $now - $your_date;
$nodays = floor($datediff/(60*60*24));
$noyear = $nodays/366;
if(isset($_POST['submit']))
{
	if($_POST['accounttype'] == "Savings account")
		{
	$sqlsbaccount ="SELECT * FROM sbaccount where status='Active'";
	$qsqlsbaccount = mysqli_query($con,$sqlsbaccount);
	$rsactiveid = mysqli_fetch_array($qsqlsbaccount);
		}
		else if($_POST['accounttype'] == "Recurring deposit")
		{
	$sqlrdaccount ="SELECT * FROM rdaccount where status='Active'";
	$qsqlrdaccount = mysqli_query($con,$sqlrdaccount);
	$rsactiveid = mysqli_fetch_array($qsqlrdaccount);
		}
		else if($_POST['accounttype'] == "Time deposit")
		{
	$sqltdaccount ="SELECT * FROM tdaccount where status='Active'";
	$sqltdaccount = mysqli_query($con,$sqltdaccount);
	$rsactiveid = mysqli_fetch_array($sqltdaccount);
		}
		else if($_POST['accounttype'] == "SSA Account")
		{
	$sqlssaaccount ="SELECT * FROM ssaaccount where status='Active'";
	$sqlssaaccount = mysqli_query($con,$sqlssaaccount);
	$rsactiveid = mysqli_fetch_array($sqlssaaccount);
		}
	$dt = date("Y-m-d");
	$sql ="INSERT INTO account(acctype,actypeid, customerid, acopendate,  status, nominee, relationshipwithnominee, numofyrs, dob) VALUES ('$_POST[accounttype]','$rsactiveid[0]','$_SESSION[customerid]','$dt','Pending', '$_POST[nominee]', '$_POST[relation]', '$_POST[relation2]','$_POST[dob]')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo "Erroor - " .mysqli_error($con);
		}
		else
		{
			$lastinsid = mysqli_insert_id($con);
			echo "<script>alert('Account Created Successfully..');</script>";
			
			if($_POST['accounttype'] == "Savings account")
			{
			echo "<script>window.location='depositsbaccount.php?accountid=". $lastinsid . "'; </script>";
			}
			else if($_POST['accounttype']  == "Time deposit")
			{
				echo "<script>window.location='deposittdaccount.php?accountid=". $lastinsid . "'; </script>";		
			}
			else if($_POST['accounttype']=="Recurring deposit")
			{
			echo "<script>window.location='depositrdaccount.php?accountid=". $lastinsid . "';</script>";
			}
			else if($_POST['accounttype']=="SSA Account")
			{			
			echo "<script>window.location='depositssaaccount.php?accountid=". $lastinsid . "';</script>";				
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
      <div class="right-column-heading">
      <p><h2>&nbsp;</p></h2>
     <h1>Add Account Record</h1>
      </div>
      <div class="right-column-content">
 <?php
 if($noyear >=15)
 {
 ?>     
      <form method="post" action="" name="frmacreate" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Account Type</th>
              <td width="287"><select class="form-control"  onchange="selecttype(this.value)" name="accounttype" id="accounttype" >
              
                <option value="">Select</option>
                <?php
				$arr = array("Savings account","Time deposit","Recurring deposit","SSA Account");
				foreach($arr as $val)
				{
					if($val == $rsedit['acctype'])
					{
					echo "<option value='$val' selected>$val</option>";
					}
					else if($val==$_GET['actype'])
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
<?php
	$sqlsbaccount ="SELECT * FROM sbaccount where status='Active'";
	$qsqlsbaccount = mysqli_query($con,$sqlsbaccount);
	$rssbaccount = mysqli_fetch_array($qsqlsbaccount);
		
	$sqlrdaccount ="SELECT * FROM rdaccount where status='Active'";
	$qsqlrdaccount = mysqli_query($con,$sqlrdaccount);
	$rsrdaccount = mysqli_fetch_array($qsqlrdaccount);
		
	$sqltdaccount ="SELECT * FROM tdaccount where status='Active'";
	$sqltdaccount = mysqli_query($con,$sqltdaccount);
	$rstdaccount = mysqli_fetch_array($sqltdaccount);
		
	$sqlssaaccount ="SELECT * FROM ssaaccount where status='Active'";
	$sqlssaaccount = mysqli_query($con,$sqlssaaccount);
	$rsssaaccount = mysqli_fetch_array($sqlssaaccount);
		
?>              
              <?php
			  if($_GET['actype']=="Savings account")
			  {
				  ?>
                <tr>
                  <th colspan="2" scope="col">SB Account</th>
                  </tr>
                <tr>
                  <td width="175">Title</td>
                  <td width="38">&nbsp;<?php echo $rssbaccount['title']; ?></td>
                </tr>
                <tr>
                  <td>Minimum Deposit</td>
                  <td>&nbsp;Rs. <?php echo $rssbaccount['mindeposit']; ?></td>
                </tr>
                <tr>
                  <td>Interest per year</td>
                  <td>&nbsp;<?php echo $rssbaccount['interestperyear']; ?>%</td>
                </tr>
                <tr>
                  <td>Minimum Balance</td>
                  <td>&nbsp;Rs. <?php echo $rssbaccount['minbal']; ?></td>
                </tr>
                <tr>
                  <td>Documents required</td>
                  <td>&nbsp;<?php echo $rssbaccount['documentsreqd']; ?></td>
                </tr>
                <tr>
                  <td>Account Procedure</td>
                  <td>&nbsp;<?php echo $rssbaccount['acprocedure']; ?></td>
                </tr>
              <?php
			  }
			  if($_GET['actype']=="Time deposit")
			  {
				  ?>
                  <tr>
                    <th colspan="2" scope="col">TD Account</th>
                    </tr>
                  <tr>
                    <td width="199">Title</td>
                    <td width="43">&nbsp;<?php echo $rstdaccount['title']; ?></td>
                  </tr>
                  <tr>
                    <td>Minimum Deposit</td>
                    <td>&nbsp;Rs. <?php echo $rstdaccount['mindeposit']; ?></td>
                  </tr>
                  <tr>
                    <td>Fisrt year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int1yr']; ?>%</td>
                  </tr>
                  <tr>
                    <td>Second year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int2yr']; ?>%</td>
                  </tr>
                  <tr>
                    <td>Third year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int3yr']; ?>%</td>
                  </tr>
                  <tr>
                    <td>Fifth year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int5yr']; ?>%</td>
                  </tr>
                  <tr>
                    <td>Documents Required</td>
                    <td>&nbsp;<?php echo $rstdaccount['docsreqrd']; ?></td>
                  </tr>
                  <tr>
                    <td>Account Procedure</td>
                    <td><?php echo $rstdaccount['acprocedure']; ?></td>
                  </tr>
                  <tr>
                    <td>Years</td>
                    <td><label for="textfield">
                      <select class="form-control" name="relation2" id="relation2" >
                        <option value="">Select</option>
                        <?php
				$arr = array("1 Year - 6.00%", "2 Years- 6.5%", "3 Years - 7.0%", "5 Years- 8.0%");
				foreach($arr as $val)
				{
					echo "<option value='$val'>$val</option>";
				}
				?>
                <?php
				}
				?>
               <?php
				if($_GET['actype']!="Time deposit")
				{
					?>
				
                      </select>
                    </label></td>
                  </tr>
                <?php
			  }
			  ?>
         
                <?php
			  if($_GET['actype']=="Recurring deposit")
			  {
				  ?>
                  <tr>
                    <th colspan="2" scope="col">RD Account</th>
                    </tr>
                  <tr>
                    <td width="176">Title</td>
                    <td width="43">&nbsp;<?php echo $rsrdaccount['title']; ?></td>
                  </tr>
                  <tr>
                    <td>Documents Required</td>
                    <td>&nbsp;<?php echo $rsrdaccount['docsreqd']; ?></td>
                  </tr>
                  <tr>
                    <td>Minimum Deposite</td>
                    <td>&nbsp;<?php echo $rsrdaccount['mindeposit']; ?></td>
                  </tr>
                  <tr>
                    <td>Account Procedure</td>
                    <td>&nbsp;<?php echo $rsrdaccount['acprocedure']; ?></td>
                  </tr>
                  <tr>
                    <td>3 years interest</td>
                    <td>&nbsp;<?php echo $rsrdaccount['threeyearinterest']; ?></td>
                  </tr>
                  <tr>
                    <td>After 5 years</td>
                    <td>&nbsp;<?php echo $rsrdaccount['after5yearinterest']; ?></td>
                  </tr>
                  <tr>
                    <td>Maximum year</td>
                    <td>&nbsp;<?php echo $rsrdaccount['maximumyear']; ?></td>
                  </tr>
                  <tr>
                    <td>Penalty per month</td>
                    <td>&nbsp;<?php echo $rsrdaccount['penaltypermonth']; ?></td>
                  </tr>
                <?php
			  }
			  ?>
               
                <?php
				if($_GET['actype']=="SSA Account")
				{
					?>
                  <tr>
                    <th colspan="2" scope="col">SSA Account</th>
                    </tr>
                  <tr>
                    <td width="201">Title</td>
                    <td width="55">&nbsp;<?php echo $rsssaaccount['title']; ?></td>
                  </tr>
                  <tr>
                    <td>Minimum Deposit</td>
                    <td>&nbsp;Rs. <?php echo $rsssaaccount['mindeposit']; ?></td>
                  </tr>
                  <tr>
                    <td>Maturity year</td>
                    <td>&nbsp;<?php echo $rsssaaccount['maturityyr']; ?></td>
                  </tr>
                  <tr>
                    <td>Interest</td>
                    <td>&nbsp;<?php echo $rsssaaccount['interest']; ?>%</td>
                  </tr>
                  <tr>
                    <td>Minimum deposit per year</td>
                    <td>&nbsp;Rs. <?php echo $rsssaaccount['minyrdeposityr']; ?></td>
                  </tr>
                  <tr>
                    <td>Maximum deposit per year</td>
                    <td>&nbsp;Rs. <?php echo $rsssaaccount['maxyrdepyr']; ?></td>
                  </tr>
                  <tr>
                    <td>Yearly penalty</td>
                    <td>&nbsp;Rs. <?php echo $rsssaaccount['yrpenalty']; ?></td>
                  </tr>
                  <tr>
                    <td>18 Years withdraw percent</td>
                    <td>&nbsp;<?php echo $rsssaaccount['eighteenyrwithdrawpercent']; ?>%</td>
                  </tr>
                  <tr>
                    <td>Documents Required</td>
                    <td>&nbsp;<?php echo $rsssaaccount['docsreqd']; ?></td>
                  </tr>
                  <tr>
                    <td>Account procedure</td>
                    <td>&nbsp;<?php echo $rsssaaccount['acprocedure']; ?></td>
                  </tr>
                  <tr>
                    <td>Date Of Birth of the Child</td>
                    <td><label for="dob"></label>
                    <input class="form-control" type="date" name="dob" id="dob" min="<?php echo date("Y-m-d", strtotime(date("Y-m-d", strtotime($dt)) . " - 10 year")); ?>" /></td>
                  </tr>
                <?php
				}
				?>
               <?php
				if($_GET['actype']!="SSA Account")
				{
					?>
            <tr>
                    <th height="26" scope="row">Nominee</th>
                    <td><input  class="form-control" type="text" name="nominee" id="nominee" value="<?php echo $rsedit['nominee']; ?>"/></td>
                  </tr>
                  <tr>
                    <th height="26" scope="row">Relationship With The Nominee</th>
                    <td><select class="form-control" name="relation" id="relation" >
                      <option value="">Select</option>
                      <?php
				$arr = array("Father","Mother","Son","Daughter", "Husband", "Wife", "Brother", "Sister", "Grand Son", "Grand Daughter", "Nephew" ,"Niece", "Son-In-Law", "Daughter-In-Law");
				foreach($arr as $val)
				{
					if($val == $rsedit['acctype'])
					{
					echo "<option value='$val' selected>$val</option>";
					}
					else if($val==$_GET['actype'])
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
                  <?php
				}
				?>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Create Account" /></td>
            </tr>
          </tbody>
        </table>
        <p>&nbsp;</p>
        </form>
<?php
 }
 else
 {
	 echo "<h1>&nbsp;You are not eligible to create new account..</h1>";
 }
 ?>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>
<script type="application/javascript">
function selecttype(select)
{
	window.location="createcustomeraccount.php?actype="+select;
}
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frmacreate.accounttype.value == "" && document.frmacreate.relation2 == "" && document.frmacreate.nominee == "" && document.frmacreate.relation.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmacreate.accounttype.focus();
		return false;	
		}
	else if(document.frmacreate.accounttype.value == "")
	{
		alert("Please Select Account Type ");
		document.frmacreate.accounttype.focus();
		return false;	
	}
	else if(document.frmacreate.nominee.value == "")
	{
		alert("Please enter Nominee Name ");
		document.frmacreate.nominee.focus();
		return false;	
	}
	else if(!document.frmacreate.nominee.value.match(alphaspaceExp))
	{
		alert("Name is not valid");
		document.frmacreate.nominee.focus();
		return false;			
	}
	else if(document.frmacreate.relation.value == "")
	{
		alert("Please select your Relationship With the Nominee ");
		document.frmacreate.relation.focus();
		return false;	
	}
}

</script>
