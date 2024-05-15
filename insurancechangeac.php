<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	
	$sql1="select * from insurancetype where insurancetype='Endowment Assurance Policy' AND status='Active'";
	$qsql1=mysqli_query($con,$sql1);
	$rsedit1=mysqli_fetch_array($qsql1);
	
		$sql="Update insurance set insurancetypid='$rsedit1[insurancetypeid]',maturityyear='$_POST[maturityage]'  where insuranceid='$_GET[policyid]'";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Insurance account migrated Successfully..');</script>";
			echo "<script>window.location='viewinsuranceaccount.php';</script>";
		}
}
if(isset($_GET['policyid']))
{
	$sql1="select * from insurance where insuranceid='$_GET[policyid]'";
	$qsql1=mysqli_query($con,$sql1);
	$rsedit1=mysqli_fetch_array($qsql1);
	
	$sql2="select max(insurance_payment_id) from insurance_payment where insuranceid='$_GET[policyid]'";
	$qsql2=mysqli_query($con,$sql2);
	$rsedit2=mysqli_fetch_array($qsql2);
	
	$sql3="select * from insurance_payment where insurance_payment_id='$rsedit2[insurance_payment_id]'";
	$qsql3=mysqli_query($con,$sql3);
	$rsedit3=mysqli_fetch_array($qsql3);

	$datetime1 = new DateTime($rsedit1['accountopened']);
	$datetime2 = new DateTime($rsedit3['paiddate']);
	$interval = $datetime1->diff($datetime2);
	$totdays= $interval->format('%R%a days');
	$totyrs = $totdays / 366;
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
        <h1>Change Insurance Policy</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsuranceacc" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
        <?php
		if($totyrs > 5)
		{
			
$sql = "SELECT * FROM  customer WHERE customerid='$rsedit1[customerid]'";
$qsql = mysqli_query($con,$sql);
$rsedit=mysqli_fetch_array($qsql);
?>
<tr>
    <td width="178" scope="col">Customer Name</td>
    <td width="362" scope="col"><?php echo $rsedit['customername']; ?></td>
  </tr>
  <tr>
    <td>Date Of Birth</td>
    <td><?php echo $rsedit['dateofbirth']; ?></td>
  </tr>
  <tr>
    <td>Mobile Number</td>
    <td><?php echo $rsedit['mobileno']; ?></td>
  </tr>
  <tr>
    <td>Customer Age</td>
    <td><?php echo $custage = date_diff(date_create($rsedit['dateofbirth']), date_create('today'))->y; ?>
    <input class="form-control" type="hidden" name="custage" value="<?php echo $custage; ?>"  />
    </td>
</tr>
            <tr>
              <th scope="row">Current Insurance Type</th>
              <td>
              <input class="form-control" type="text" readonly name="insurancetype" value="Convertible Whole Life">
              </td>
            </tr>
<tr>
              <th scope="row">Policy number</th>
              <td>
			    <input class="form-control" type="text" readonly name="policyno" value="<?php echo $rsedit1['insuranceid']; ?>">          
              </td>
            </tr>

            <tr>
              <th scope="row">Migrating to </th>
              <td>
			    <input class="form-control" type="text" readonly name="policyno" value="<?php echo "Endowment policy"; ?>"> </td>
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
			  ?>"  name="maturityage" id="maturityage" value="<?php echo $rsedit['accountopened'];?>" /></span></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Click here to confirm" /></td>
              </tr>
<?php
		}
		else
		{
			?>
              
            
            <tr>
              <th colspan="2" scope="row" style="text-align:center" >It's just <?php echo $totyrs; ?> year.. Minimum 5 years required to migrate the policy. <br>
<a href="viewinsuranceaccount.php">Click here to View insurance account..</a>
</th>
            </tr>
            <?php
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
	if(document.frminsuranceacc.customer.value == "" && document.frminsuranceacc.insurancetype.value == "" && document.frminsuranceacc.amount.value == "" && document.frminsuranceacc.premium.value == "" && document.frminsuranceacc.accountopeneddate.value == ""  && document.frminsuranceacc.accountclosedate.value == "" && document.frminsuranceacc.maturity.value == ""  && document.frminsuranceacc.note.value == "" && document.frminsuranceacc.status.value == "")
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
                document.getElementById("divpolicy").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxpolicycalculation.php?premiumtype="+premiumtype+"&maturityage="+maturityage+"&amount="+amount+"&insurancetype="+insurancetype+"&custage="+custage,true);
        xmlhttp.send();
    }

}
</script>

