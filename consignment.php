<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql="UPDATE consignment set customerid='$_POST[customer]', itemdetail='$_POST[itemdetail]', fromaddr='$_POST[fromaddress]', frompin='$_POST[frompincode]', toaddr='$_POST[toaddresss]', topin='$_POST[topincode]', frommobno='$_POST[frommobileno]', date='$_POST[date]', tomobno='$_POST[tomobileno]', cost='$_POST[cost]', consignmenttype='$_POST[consignmenttype]', note='$_POST[note]', status='$_POST[status]' WHERE consignment_id='$_GET[editid]'";
		if(!$qsql = mysqli_query($con,$sql))
	{
		echo mysqli_error($con);
	}
	else
	{
		echo "<script>alert('Consignment Record Updated Successfully..');</script>";
	}	
}
		else
		{
			$sql ="INSERT INTO consignment(customerid, itemdetail, fromaddr, frompin, toaddr, topin, frommobno, date, tomobno, cost, consignmenttype, note, status) VALUES ('$_POST[customer]','$_POST[itemdetail]','$_POST[fromaddress]','$_POST[frompincode]','$_POST[toaddresss]','$_POST[topincode]','$_POST[frommobileno]','$_POST[date]','$_POST[tomobileno]','$_POST[cost]','$_POST[consignmenttype]','$_POST[note]','$_POST[status]')";
			if(!$qsql = mysqli_query($con,$sql))
			{
				echo mysqli_error($con);
			}
			else
			{
				echo "<script>alert('Consignment Record Inserted Successfully..');</script>";
			}	
		}				
	}
	if(isset($_GET['editid']))
	{
		$sql="select * from consignment where consignment_id='$_GET[editid]'";
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
      <div class="right-column-heading"><h2>Consignment</h2>
       <h1> Add Consignment Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmconsignment" onsubmit="return validateform()">
        <table width="560" height="326" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" scope="row">Customer</th>
              <td width="287"><select class="form-control" name="customer" id="customer">
                <option value="">Select</option>
                <?php
				$sqlcust="SELECT * from customer where status='Active'";
				$qsqlcust=mysqli_query($con,$sqlcust);
				while($rscust=mysqli_fetch_array($qsqlcust))
				{
					if($rscust['customerid']==$rscust['customerid'])
					{
						echo "<option value='$rscust[customerid]' selected>$rscust[customername]</option>";
					}
					else
					{
						echo "<option value='$rs[customerid]'>$rscust[customername]</option>";
					}
				}
				?>
              </select></td>
            </tr>
            <tr>
              <th scope="row">Item detail</th>
              <td><input class="form-control" type="text" name="itemdetail" id="itemdetail" value="<?php echo $rsedit['itemdetail'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">From address</th>
              <td><textarea class="form-control"  name="fromaddress" id="fromaddress" cols="45" rows="5"><?php echo $rsedit['fromaddr'];?></textarea></td>
            </tr>
            <tr>
              <th scope="row">From pincode</th>
              <td><input class="form-control" type="text" name="frompincode" id="frompincode" value="<?php echo $rsedit['frompin'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">To address</th>
              <td><textarea class="form-control"  name="toaddresss" id="toaddresss" cols="45" rows="5"><?php echo $rsedit['toaddr'];?></textarea></td>
            </tr>
            <tr>
              <th scope="row">To pincode</th>
              <td><input class="form-control" type="text" name="topincode" id="topincode" value="<?php echo $rsedit['topin'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">From mobile no</th>
              <td><input class="form-control" type="text" name="frommobileno" id="frommobileno" value="<?php echo $rsedit['frommobno'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Delivery date</th>
              <td><input class="form-control" type="date" name="date" id="date" value="<?php echo $rsedit['date'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">To mobile no</th>
              <td><input class="form-control" type="text" name="tomobileno" id="tomobileno" value="<?php echo $rsedit['tomobno'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Cost</th>
              <td><input class="form-control" type="text" name="cost" id="cost" value="<?php echo $rsedit['cost'];?>" /></td>
            </tr>
            <tr>
              <th scope="row">Consignment type</th>
              <td><select class="form-control" name="consignmenttype" id="consignmenttype">
                <option value="">Select</option>
                <?php
				$arr=array("Ordinary letters", "Registers", "Speed Post");
				foreach($arr as $val)
				{
					if($val==$rsedit['consignmenttype'])
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
              <th scope="row">Note</th>
              <td><textarea class="form-control"  name="note" id="note" cols="45" rows="5"><?php echo $rsedit['note'];?></textarea></td>
            </tr>
            <tr>
              <th scope="row">Status</th>
              <td><select class="form-control" name="status" id="status">
                <option value="">Select</option>
                <?php
				$arr=array("Active", "Inactive");
				{
					foreach($arr as $val)
					{
						echo "<option value='$val'>$val</option>";
					}
				}
				?>
			 </select></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input class="btn btn-info" type="submit" name="submit" id="submit" value="Submit" /></td>
            </tr>
          </tbody>
        </table></form>        
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
	if(document.frmconsignment.customer.value == "" && document.frmconsignment.itemdetail.value == "" && document.frmconsignment.fromaddress.value == ""  && document.frmconsignment.frompincode.value == ""  && document.frmconsignment.toaddresss.value == "" && document.frmconsignment.topincode.value == ""  && document.frmconsignment.frommobileno.value == ""  && document.frmconsignment.date.value == "" && document.frmconsignment.tomobileno.value == "" && document.frmconsignment.cost.value == "" && document.frmconsignment.consignmenttype.value == "" && document.frmconsignment.note.value == ""  && document.frmconsignment.status.value == "")
	{
		alert("Kindly enter all mandatory details..");
		document.frmconsignment.customer.focus();
		return false;	
		
	}
	else if(document.frmconsignment.customer.value == "")
	{
		alert("Please select Customer Name");
		document.frmconsignment.customer.focus();
		return false;	
	}
	else if(document.frmconsignment.itemdetail.value == "")
	{
		alert("Please enter Item Detail");
		document.frmconsignment.itemdetail.focus();
		return false;
	}
	else if(document.frmconsignment.fromaddress.value == "")
	{
		alert("Please enter Address");
		document.frmconsignment.fromaddress.focus();
		return false;
	}
	else if(document.frmconsignment.frompincode.value == "") 
	{
		alert("Please enter the Pin Code");
		document.frmconsignment.frompincode.focus();
		return false;
	}
	else if(!document.frmconsignment.frompincode.value.match(numericExpression)) 
	{
		alert("Please enter valid Pin Code");
		document.frmconsignment.frompincode.focus();
		return false;
	}
	else if(document.frmconsignment.toaddresss.value == "")
	{
		alert("Please enter Address");
		document.frmconsignment.toaddresss.focus();
		return false;
	}
	else if(document.frmconsignment.topincode.value == "") 
	{
		alert("Please enter the Pin Code");
		document.frmconsignment.topincode.focus();
		return false;
	}
	else if(!document.frmconsignment.topincode.value.match(numericExpression)) 
	{
		alert("Please enter valid Pin Code");
		document.frmconsignment.topincode.focus();
		return false;
	}
	else if(document.frmconsignment.frommobileno.value == "") 
	{
		alert("Please enter Mobile Number");
		document.frmconsignment.frommobileno.focus();
		return false;
	}
	else if(!document.frmconsignment.frommobileno.value.match(numericExpression)) 
	{
		alert("Please enter valid Mobile Number");
		document.frmconsignment.frommobileno.focus();
		return false;
	}
	else if(document.frmconsignment.date.value == "") 
	{
		alert("Please enter Date");
		document.frmconsignment.date.focus();
		return false;
	}
	else if(document.frmconsignment.tomobileno.value == "") 
	{
		alert("Please enter Mobile Number");
		document.frmconsignment.tomobileno.focus();
		return false;
	}
	else if(!document.frmconsignment.tomobileno.value.match(numericExpression)) 
	{
		alert("Please enter valid Mobile Number");
		document.frmconsignment.tomobileno.focus();
		return false;
	}
	else if(document.frmconsignment.cost.value == "") 
	{
		alert("please enter the Cost");
		document.frmconsignment.cost.focus();
		return false;
	}
	else if(!document.frmconsignment.cost.value.match(numericExpression)) 
	{
		alert("Please enter valid Cost");
		document.frmconsignment.cost.focus();
		return false;
	}
	else if(document.frmconsignment.consignmenttype.value == "") 
	{
		alert("Please select Consignment Type");
		document.frmconsignment.consignmenttype.focus();
		return false;
	}
	else if(document.frmconsignment.status.value == "") 
	{
		alert("Kindly select Status");
		document.frmconsignment.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>

