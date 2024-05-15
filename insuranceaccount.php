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
			echo "<script>alert('Insuranceaccount Record updated Successfully..');</script>";
		}	
	}	
	else
	{  
		$sql ="Insert into insurance(customerid, insurancetypid, amount,premiumtype,maturityyear, accountopened, accountclosedate,note, status,nominee,relationship) VALUES ('$_POST[customer]','$_POST[insurancetype]','$_POST[amount]','$_POST[premium]','$_POST[maturityage]','$_POST[policystartdate]','$_POST[policyclosedate]','$_POST[note]','Active','$_POST[nominee]','$_POST[relation]')";
		if(!$qsql = mysqli_query($con,$sql))
		{
		echo "Error Found" . mysqli_error($con);
		}
		else
		{
		$insid = mysqli_insert_id($con);
		echo "<script>alert('Insurance account created Successfully..');</script>";
		echo "<script>window.location='insuranceaccountprint.php?insid=" . $insid . "';</script>"; 
		}
	}
}
if(isset($_GET['editid']))
{
	$sql="select * from insurance where insuranceid='$_GET[editid]'";
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
        <h1>Add Insurance Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsuranceacc" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
          </tbody>
<?php
if(isset($_SESSION['adminid']))
{
?>         
			 <tr>
              <th width="253" scope="row">Customer</th>
              <td width="287"><select class="form-control" name="customer" id="customer" onChange="loadcustomer(this.value)"  >
                <option value="">Select</option>
                <?php
				$sqlcust = "SELECT * FROM customer WHERE status='Active'";
				$qsqlcust = mysqli_query($con,$sqlcust);
				while($rscust = mysqli_fetch_array($qsqlcust))
					{
						if($rscust['customerid'] == $_GET['cstid'])
						{
						echo "<option value='$rscust[customerid]' selected>$rscust[customername]</option>";
						}
						else
						{
						echo "<option value='$rscust[customerid]'>$rscust[customername]</option>";						
						}
					}
				?>
              </select>
              <input class="form-control" type="hidden" name="customersession" value="0"  />
              </td>
            </tr>
<?php
}
else
{
?>
<input class="form-control" type="hidden" name="customer" value="<?php echo $_SESSION['customerid']; ?>"  />
<input class="form-control" type="hidden" name="customersession" value="1"  />
<?php
}
?>
            <tr>
              <th colspan="2" scope="row"><div id="ajaxcust"><?php
              include("ajaxcustomer.php");
			  ?></div></th>
            </tr>
<?php            
if($custage > 19 && $custage < 49)
{
?>            
            <tr>
              <th scope="row">Insurance Type</th>
              <td><select class="form-control" name="insurancetype" id="insurancetype" onchange="loadinsurancetype(this.value)">
                <option value="">Select</option>
                <?php
				$sqlins = "SELECT * FROM insurancetype WHERE status='Active'";
				$qsqlins = mysqli_query($con,$sqlins);
				while($rsins = mysqli_fetch_array($qsqlins))
					{
						if($rsins['insurancetypeid'] == $rsedit['insurancetypeid'])
						{
						echo "<option value='$rsins[insurancetypeid]' selected>$rsins[insurancetype]</option>";
						}
						else
						{
						echo "<option value='$rsins[insurancetypeid]'>$rsins[insurancetype]</option>";						
						}
					}
				?>
              </select></td>
            </tr>
            <tr>
              <th colspan="2" scope="row">
              <div id="loadinsurance"><input class="form-control" type="hidden" name="minamt" value="0"  />
<input class="form-control" type="hidden" name="maxamt" value="0"  /></div>
              </th>
            </tr>
            <tr>
              <th scope="row">Amount</th>
              <td><input class="form-control" type="text" name="amount" id="amount"  value="<?php echo $rsedit['amount'];?>"  onkeyup="loadpolicycalculation(this.value,maturityage.value,amount.value,insurancetype.value,custage.value)" /></td>
            </tr>
            <tr>
              <th scope="row">Maturity Age</th>
              <td><span id="divmatage"><input class="form-control" type="number" min="<?php
              if($custage > 35)
			  {
				  echo $custage;
			  }
			  else
			  {
				  echo "35";
			  }
			  ?>"  name="maturityage" id="maturityage" value="<?php echo $rsedit['accountopened'];?>" onkeyup="loadpolicycalculation(premium.value,maturityage.value,amount.value,insurancetype.value,custage.value)" /></span></td>
            </tr>
            <tr>
              <th scope="row">Premium Type</th>
              <td><select class="form-control" name="premium" id="premium" onchange="loadpolicycalculation(this.value,maturityage.value,amount.value,insurancetype.value,custage.value)">
              <option value="">Select</option>
                <?php
				$arr=array("Monthly", "3 Months", "6 Months", "Yearly");
				foreach($arr as $val)
				{
				if($val==$rsedit['premium'])
				{
					echo "<option value='$val' selected>$val</option>";
					}
					else if($val==$_GET['premium'])
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
                    <th height="26" scope="row">Nominee</th>
                    <td><input name="nominee" id="nominee" value="<?php echo $rsedit['nominee']; ?>"/></td>
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
            <tr>
              <th colspan="2" scope="row"><div id="divpolicy"></div></th>
            </tr>
            
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Create Policy" /></td>
    </tr>
    <?php
}
else
{
	echo " <tr>
              <th scope='row' colspan='2'>&nbsp; You are not eligible to create policy..</th>
              </tr>";
}
?>
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
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
var amt = parseFloat(document.frminsuranceacc.amount.value);
var minamt = parseFloat(document.frminsuranceacc.minamt.value);
var maxamt = parseFloat(document.frminsuranceacc.maxamt.value);
	if(document.frminsuranceacc.customersession.value == 1)
	{
		if(document.frminsuranceacc.insurancetype.value == "" && document.frminsuranceacc.amount.value == "" && document.frminsuranceacc.maturityage.value == "" && document.frminsuranceacc.premium.value == "")
		{
			alert("Kindly enter all mandatory details..");
			document.frminsuranceacc.customer.focus();
			return false;	
			
		}
		else if(document.frminsuranceacc.insurancetype.value == "") 
		{
			alert("Please select Insurance Type");
			document.frminsuranceacc.insurancetype.focus();
			return false;
		}
		else if(amt <= minamt) 
		{
			alert("Entered insurance amount is lesser than Minimum amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(amt > maxamt) 
		{
			alert("Entered insurance amount is greater than Maximum amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(document.frminsuranceacc.amount.value == "") 
		{
			alert("Please enter Amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(!document.frminsuranceacc.amount.value.match(numericExpression))
		{
			alert("Amount is not valid");
			document.frminsuranceacc.amount.focus();
			return false;			
		}
		else if(amt < minamt) 
		{
			alert("Entered insurance amount is lesser than Minimum amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(amt > maxamt)
		{
			alert("Entered insurance amount is greater than Maximum amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(document.frminsuranceacc.maturityage.value == "") 
		{
			alert("Please enter maturity age");
			document.frminsuranceacc.maturityage.focus();
			return false;
		}
		else if(document.frminsuranceacc.premium.value == "") 
		{
			alert("Please select Premium Type");
			document.frminsuranceacc.premium.focus();
			return false;
		}
		else if(document.frminsuranceacc.accountopeneddate.value == "") 
		{
			alert("Please enter Date");
			document.frminsuranceacc.accountopeneddate.focus();
			return false;
		}
		else if(document.frminsuranceacc.accountclosedate.value == "") 
		{
			alert("Please enter Date");
			document.frminsuranceacc.accountclosedate.focus();
			return false;
		}
		else if(document.frminsuranceacc.maturity.value == "") 
		{
			alert("Please enter Maturity Year");
			document.frminsuranceacc.maturity.focus();
			return false;
		}
		else if(!document.frminsuranceacc.maturity.value.match(numericExpression))
		{
			alert("Year is not valid");
			document.frminsuranceacc.maturity.focus();
			return false;			
		}
		else if(document.frminsuranceacc.status.value == "") 
		{
			alert("Kindly select status");
			document.frminsuranceacc.status.focus();
			return false;
		}
		else
		{
			return true;
		}	
	}
	else
	{
		if(document.frminsuranceacc.customer.value == "" && document.frminsuranceacc.insurancetype.value == "" && document.frminsuranceacc.amount.value == ""  && document.frminsuranceacc.maturityage.value == "" && document.frminsuranceacc.premium.value == "")
		{
			alert("Kindly enter all mandatory details..");
			document.frminsuranceacc.customer.focus();
			return false;	
			
		}
		else if(document.frminsuranceacc.customer.value == "")
		{
			alert("Please enter Customer Name");
			document.frminsuranceacc.customer.focus();
			return false;	
		}
		else if(document.frminsuranceacc.insurancetype.value == "") 
		{
			alert("Please select Insurance Type");
			document.frminsuranceacc.insurancetype.focus();
			return false;
		}
		else if(document.frminsuranceacc.amount.value == "") 
		{
			alert("Please enter Amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(!document.frminsuranceacc.amount.value.match(numericExpression))
		{
			alert("Amount is not valid");
			document.frminsuranceacc.amount.focus();
			return false;			
		}
		else if(amt <= minamt) 
		{
			alert("Entered insurance amount is lesser than Minimum amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(amt > maxamt) 
		{
			alert("Entered insurance amount is greater than Maximum amount");
			document.frminsuranceacc.amount.focus();
			return false;
		}
		else if(document.frminsuranceacc.maturityage.value == "") 
		{
			alert("Please enter maturity age");
			document.frminsuranceacc.maturityage.focus();
			return false;
		}
		else if(document.frminsuranceacc.premium.value == "") 
		{
			alert("Please select Premium Type");
			document.frminsuranceacc.premium.focus();
			return false;
		}
		
		/*
		else if(document.frminsuranceacc.accountopeneddate.value == "") 
		{
			alert("Please enter Date");
			document.frminsuranceacc.accountopeneddate.focus();
			return false;
		}
		else if(document.frminsuranceacc.accountclosedate.value == "") 
		{
			alert("Please enter Date");
			document.frminsuranceacc.accountclosedate.focus();
			return false;
		}
		else if(document.frminsuranceacc.maturity.value == "") 
		{
			alert("Please enter Maturity Year");
			document.frminsuranceacc.maturity.focus();
			return false;
		}
		else if(!document.frminsuranceacc.maturity.value.match(numericExpression))
		{
			alert("Year is not valid");
			document.frminsuranceacc.maturity.focus();
			return false;			
		}
		else if(document.frminsuranceacc.status.value == "") 
		{
			alert("Kindly select status");
			document.frminsuranceacc.status.focus();
			return false;
		}
		*/
		else
		{
			return true;
		}
	}
}
function loadinsurancetype(instype)
{
	if (instype == "")
	{
        document.getElementById("loadsavingsdetail").innerHTML = "";
        return;
    }
	else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("loadinsurance").innerHTML = xmlhttp.responseText;
				if(instype == 3)
				{
					document.getElementById("divmatage").innerHTML = "<input class='form-control' type='text' readonly name='maturityage' id='maturityage' value='Not Applicable' />";
				}
				else
				{
					document.getElementById("divmatage").innerHTML = '<input class="form-control" type="number" min="<?php
              if($custage > 35)
			  {
				  echo $custage;
			  }
			  else
			  {
				  echo "35";
			  }
			  ?>"  name="maturityage" id="maturityage" value="<?php echo $rsedit['accountopened'];?>" onkeyup="premium.value,maturityage.value,amount.value,insurancetype.value,custage.value)" />';
				}
            }
        };
        xmlhttp.open("GET","ajaxinsurancedetails.php?instype="+instype,true);
        xmlhttp.send();
    }

}

function loadpolicycalculation(premiumtype,maturityage,amount,insurancetype,custage)
{
	if (premiumtype == "" && premiumtype=="")
	{
        document.getElementById("divpolicy").innerHTML = "";
        return;
    }
	else 
	{ 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("divpolicy").innerHTML = xmlhttp.responseText;
				
            }
        };
        xmlhttp.open("GET","ajaxpolicycalculation.php?premiumtype="+premiumtype+"&maturityage="+maturityage+"&amount="+amount+"&insurancetype="+insurancetype+"&custage="+custage,true);
        xmlhttp.send();
    }

}

function loadcustomer(cstid)
{
	window.location="insuranceaccount.php?cstid="+cstid;
}

function loadcustomerdetail(customerid)
{
	if (customerid == "")
	{
        document.getElementById("ajaxcustomer").innerHTML = "";
        return;
    }
	else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("ajaxcustomer").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxcustomer.php?customerid="+customerid,true);
        xmlhttp.send();
    }

}


</script>

