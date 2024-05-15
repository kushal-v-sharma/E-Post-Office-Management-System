<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE insurancetype set  insurancetype='$_POST[insurancetype]', bonus='$_POST[bonus]', minage='$_POST[minage]', maxage='$_POST[maxage]', minamt='$_POST[minamt]', maxamt='$_POST[maxamt]', status='$_POST[status]' where insurancetypeid='$_GET[editid]'";
		if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
				echo "<script>alert('insurance type  record updated successfully..');</script>";
			}	
		}
		else
		{
			$sql ="INSERT INTO insurancetype( insurancetype, bonus, minage, maxage, minamt, maxamt, status) VALUES ('$_POST[insurancetype]','$_POST[bonus]','$_POST[minage]','$_POST[maxage]','$_POST[minamt]','$_POST[maxamt]', '$_POST[status]')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
				echo "<script>alert('insurance type  record inserted successfully..');</script>";
			}	
		}
}
if(isset($_GET['editid']))
{
	$sql="select * from insurancetype";
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
      <div class="right-column-heading">
        <h2>Insurance type</h2>
        <h1>Add Insurance Type</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frminsurancetype" onsubmit="return validateform()">
        <table width="560" height="326" border="3"  class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Insurance type</th>
              <td width="287"><input class="form-control" type="text" name="insurancetype" id="insurancetype" value="<?php echo $rsedit['insurancetype'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Bonus</th>
              <td><input class="form-control" type="text" name="bonus" id="bonus" value="<?php echo $rsedit['interest'];?>"/></td>
            </tr>
            <tr>
              <th scope="row">Minimum Age</th>
              <td><input class="form-control" type="text" name="minage" id="minage" value="<?php echo $rsedit['interest'];?>"/></td>
            </tr>
            <tr>
              <th scope="row">Maximum Age</th>
              <td><input class="form-control" type="text" name="maxage" id="maxage" value="<?php echo $rsedit['interest'];?>"/></td>
            </tr>
            <tr>
              <th scope="row">Minimum Amount</th>
              <td><input class="form-control" type="text" name="minamt" id="minamt" value="<?php echo $rsedit['interest'];?>"/></td>
            </tr>
            <tr>
              <th scope="row">Maximum Amount</th>
              <td><input class="form-control" type="text" name="maxamt" id="maxamt" value="<?php echo $rsedit['interest'];?>"/></td>
            </tr>
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr=array("Active","Inactive");
				foreach($arr as $val)
				{
					echo "<option value='$val' >$val</option>";
				}
				?>
              </select></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" /></td>
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
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frminsurancetype.insurancetype.value == "" && document.frminsurancetype.bonus.value == "" && document.frminsurancetype.minage.value == "" && document.frminsurancetype.maxage.value == "" && document.frminsurancetype.minamt.value == "" && document.frminsurancetype.maxamt.value == "" && document.frminsurancetype.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frminsurancetype.insurancetype.focus();
		return false;	
		
	}
	else if(document.frminsurancetype.insurancetype.value == "")
	{
		alert("Please enter Insurance Type");
		document.frminsurancetype.insurancetype.focus();
		return false;	
	}
	else if(!document.frminsurancetype.insurancetype.value.match(alphaspaceExp))
	{
		alert("Insurance type is not valid");
		document.frminsurancetype.insurancetype.focus();
		return false;			
	}
	else if(document.frminsurancetype.bonus.value == "") 
	{
		alert("Please enter Bonus");
		document.frminsurancetype.bonus.focus();
		return false;
	}
	else if(!document.frminsurancetype.bonus.value.match(numericExpression))
	{
		alert("Bonus is not valid");
		document.frminsurancetype.bonus.focus();
		return false;			
	}
	else if(document.frminsurancetype.minage.value == "") 
	{
		alert("Please enter Minimum Age");
		document.frminsurancetype.minage.focus();
		return false;
	}
	else if(!document.frminsurancetype.minage.value.match(numericExpression))
	{
		alert("Age is not valid");
		document.frminsurancetype.minage.focus();
		return false;			
	}
	else if(document.frminsurancetype.maxage.value == "") 
	{
		alert("Please enter Maximum Age");
		document.frminsurancetype.maxage.focus();
		return false;
	}
	else if(!document.frminsurancetype.maxage.value.match(numericExpression))
	{
		alert("Age is not valid");
		document.frminsurancetype.maxage.focus();
		return false;			
	}
	else if(document.frminsurancetype.minamt.value == "") 
	{
		alert("Please enter Minimum Amount");
		document.frminsurancetype.minamt.focus();
		return false;
	}
	else if(!document.frminsurancetype.minamt.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frminsurancetype.minamt.focus();
		return false;			
	}
	else if(document.frminsurancetype.maxamt.value == "") 
	{
		alert("Please enter Maximum Amount");
		document.frminsurancetype.maxamt.focus();
		return false;
	}
	else if(!document.frminsurancetype.maxamt.value.match(numericExpression))
	{
		alert("Amount is not valid");
		document.frminsurancetype.maxamt.focus();
		return false;			
	}
	else if(document.frminsurancetype.status.value == "") 
	{
		alert("Kindly select status");
		document.frminsurancetype.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>


