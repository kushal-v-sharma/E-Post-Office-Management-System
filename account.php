<?php
include("header.php");
include("dbconnection.php");
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
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE account set acctype='$_POST[accounttype]',actypeid='$rsactiveid[0]', customerid='$_POST[customer]', acopendate='$_POST[accountopendate]', acclosedate='$_POST[accountclosedate]', status='$_POST[status]', nominee='$_POST[nominee], relationshipwithnominee='$_POST[relation] WHERE accountid='$_GET[editid]'";
				if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert(' Account Record Updated Successfully..');</script>";
		}
	}
	
	else
	{
	$sql ="INSERT INTO account(acctype,actypeid, customerid, acopendate, acclosedate, status, nominee, relationshipwithnominee) VALUES ('$_POST[accounttype]','$rsactiveid[0]','$_POST[customer]','$_POST[accountopendate]','$_POST[accountclosedate]','$_POST[status]','$_POST[nominee]', '$_POST[relation]')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Account Record Inserted Successfully..');</script>";
		}
	}
}
if(isset($_GET['editid']))
{
	$sql ="SELECT * FROM account where accountid='$_GET[editid]'";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
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
      <p><h2>Account</h2></p>
      <h1>Add Account Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmaccount" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Account Type</th>
              <td width="287"><select onchange="selecttype(this.value)" name="accounttype" id="accounttype" >
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
              </select></td></tr><tr><td colspan=2>
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
                <table style="width: 100%;" border="1">
                  <tr>
                    <th colspan="2" scope="col">SB Account</th>
                    </tr>
                  <tr>
                    <td style="width: 200px;">Title</td>
                    <td>&nbsp;<?php echo $rssbaccount['title']; ?></td>
                    </tr>
                  <tr>
                    <td>Minimum Deposit</td>
                    <td>&nbsp;<?php echo $rssbaccount['mindeposit']; ?></td>
                    </tr>
                  <tr>
                    <td>Interest per year</td>
                    <td>&nbsp;<?php echo $rssbaccount['interestperyear']; ?></td>
                    </tr>
                  <tr>
                    <td>Minimum Balance</td>
                    <td>&nbsp;<?php echo $rssbaccount['minbal']; ?></td>
                    </tr>
                  <tr>
                    <td>Documents required</td>
                    <td>&nbsp;<?php echo $rssbaccount['documentsreqd']; ?></td>
                    </tr>
                  <tr>
                    <td>Account Procedure</td>
                    <td>&nbsp;<?php echo $rssbaccount['acprocedure']; ?></td>
                    </tr>
                  </table>
                <?php
			  }
			  if($_GET['actype']=="Time deposit")
			  {
				  ?>
                <table  style="width: 100%;" border="1">
                  <tr>
                    <th colspan="2" scope="col">TD Account</th>
                    </tr>
                  <tr>
                    <td style="width: 100px;">Title</td>
                    <td width="43">&nbsp;<?php echo $rstdaccount['title']; ?></td>
                    </tr>
                  <tr>
                    <td>Minimum Deposit</td>
                    <td>&nbsp;<?php echo $rstdaccount['mindeposit']; ?></td>
                    </tr>
                  <tr>
                    <td>Fisrt year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int1yr']; ?></td>
                    </tr>
                  <tr>
                    <td>Second year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int2yr']; ?></td>
                    </tr>
                  <tr>
                    <td>Third year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int3yr']; ?></td>
                    </tr>
                  <tr>
                    <td>Fifth year interest</td>
                    <td>&nbsp;<?php echo $rstdaccount['int5yr']; ?></td>
                    </tr>
                  <tr>
                    <td>Documents Required</td>
                    <td>&nbsp;<?php echo $rstdaccount['docsreqrd']; ?></td>
                    </tr>
                  <tr>
                    <td>Account Procedure</td>
                    <td>&nbsp;<?php echo $rstdaccount['acprocedure']; ?></td>
                    </tr>
                  </table>
                <?php
			  }
			  ?>
                
                <?php
			  if($_GET['actype']=="Recurring deposit")
			  {
				  ?>
                <table style="width: 100%;" border="1">
                  <tr>
                    <th colspan="2" scope="col">RD Account</th>
                    </tr>
                  <tr>
                    <td style="width: 100px;">Title</td>
                    <td>&nbsp;<?php echo $rsrdaccount['title']; ?></td>
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
                  </table>
                <?php
			  }
			  ?>
                
                <?php
				if($_GET['actype']=="SSA Account")
				{
					?>
                <table style="width: 100%;"  border="1">
                  <tr>
                    <th colspan="2" scope="col">SSA Account</th>
                    </tr>
                  <tr>
                    <td style="width: 100px;">Title</td>
                    <td width="55">&nbsp;<?php echo $rsssaaccount['title']; ?></td>
                    </tr>
                  <tr>
                    <td>Minimum Deposit</td>
                    <td>&nbsp;<?php echo $rsssaaccount['mindeposit']; ?></td>
                    </tr>
                  <tr>
                    <td>Maturity year</td>
                    <td>&nbsp;<?php echo $rsssaaccount['maturityyr']; ?></td>
                    </tr>
                  <tr>
                    <td>Interest</td>
                    <td>&nbsp;<?php echo $rsssaaccount['interest']; ?></td>
                    </tr>
                  <tr>
                    <td>Minimum deposit per year</td>
                    <td>&nbsp;<?php echo $rsssaaccount['minyrdeposityr']; ?></td>
                    </tr>
                  <tr>
                    <td>Maximum deposit per year</td>
                    <td>&nbsp;<?php echo $rsssaaccount['maxyrdepyr']; ?></td>
                    </tr>
                  <tr>
                    <td>Yearly penalty</td>
                    <td>&nbsp;<?php echo $rsssaaccount['yrpenalty']; ?></td>
                    </tr>
                  <tr>
                    <td>18 Years withdraw percent</td>
                    <td>&nbsp;<?php echo $rsssaaccount['eighteenyrwithdrawpercent']; ?></td>
                    </tr>
                  <tr>
                    <td>Documents Required</td>
                    <td>&nbsp;<?php echo $rsssaaccount['tidocsreqdtle']; ?></td>
                    </tr>
                  <tr>
                    <td>Account procedure</td>
                    <td>&nbsp;<?php echo $rsssaaccount['acprocedure']; ?></td>
                    </tr>
                  </table>
                <?php
				}
				?>
              </tr>
            <tr>
              <th scope="row">Customer</th>
              <td><select class="form-control" name="customer" id="customer">
                <option value="">Select</option>
                <?php
				$sqlcust = "SELECT * FROM customer WHERE status='Active'";
				$qsqlcust = mysqli_query($con,$sqlcust);
				while($rscust = mysqli_fetch_array($qsqlcust))
					{
						if($rscust['customerid'] == $rsedit['customerid'])
						{
						echo "<option value='$rscust[customerid]' selected>$rscust[customername]</option>";
						}
						else
						{
						echo "<option value='$rscust[customerid]'>$rscust[customername]</option>";						
						}
					}
				?>
                </select></td>
            </tr>
            <tr>
              <th scope="row">Account Open Date</th>
              <td><input class="form-control" type="date" name="accountopendate" id="accountopendate" value="<?php echo $rsedit['acopendate']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Account Close Date</th>
              <td><input class="form-control" type="date" name="accountclosedate" id="accountclosedate" value="<?php echo $rsedit['acclosedate']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Nominee</th>
              <td><input name="nominee" id="nominee" value="<?php echo $rsedit['nominee']; ?>"/></td>
            </tr>
            <tr>
              <th scope="row">Relationship With The Nominee</th>
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
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr = array("Active","Inactive");
				foreach($arr as $val)
				{
					echo "<option value='$val'>$val</option>";
				}
				?>
                </select></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Create" /></td>
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
<script type="application/javascript">
function selecttype(select)
{
	window.location="account.php?actype="+select;
}
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
if(document.frmaccount.accounttype.value == "" && document.frmaccount.customer.value == "" && 
 document.frmaccount.accountopendate.value == ""  && document.frmaccount.accountclosedate.value == "" && document.frmaccount.nominee == "" &&  document.frmaccount.relation == "" && frmaccount.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmaccount.accounttype.focus();
		return false;	
	}
	else if(document.frmaccount.accounttype.value == "")
	{
		alert("Please select Account Type");
		document.frmaccount.accounttype.focus();
		return false;	
	}
	else if(document.frmaccount.customer.value == "")
	{
		alert("Please select Customer");
		document.frmaccount.customer.focus();
		return false;
	}
	else if(document.frmaccount.accountopendate.value == "") 
	{
		alert("Please enter Account Open Date");
		document.frmaccount.accountopendate.focus();
		return false;
	}
	else if(document.frmaccount.accountclosedate.value == "") 
	{
		alert("Please enter Account Close Date");
		document.frmaccount.accountclosedate.focus();
		return false;
	}
	else if(document.frmaccount.nominee.value == "")
	{
		alert("Please enter a Nominee Name");
		document.frmaccount.nominee.focus();
		return false;	
	}
	else if(document.frmaccount.relation.value == "")
	{
		alert("Please select the Relationship with the Nominee");
		document.frmaccount.relation.focus();
		return false;	
	}
	else if(document.frmaccount.status.value == "") 
	{
		alert("Kindly select Status");
		document.frmaccount.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
