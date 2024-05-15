<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE tracking set location='$_POST[location]', date='$_POST[date]', note='$_POST[note]', status='$_POST[status]'  WHERE trackingid='$_GET[editid]'";
				if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Consignmenttracking record updated successfully..');</script>";
		}
	}
	else
	{
		$sql ="INSERT INTO tracking(consignment_id, location, date, note, status) VALUES ('$_POST[consignment_id]','$_POST[location]','$_POST[date]','$_POST[note]','$_POST[status]')";
		if(!$qsql = mysqli_query($con,$sql))
		{
			echo mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Consignment tracking record inserted successfully..');</script>";
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
      <div class="right-column-heading"><h2>Consignment Tracking</h2>
        <h1>Add Consignment Tracking Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="" name="frmtrack" onsubmit="return validateform()">
        <table width="560" height="277" border="3" class="tftable">
          <tbody>
            <tr>
              <th height="42" scope="row">Consignment details</th>
              <td>&nbsp;
              <?php
			 $sql = "SELECT * FROM consignment where consignment_id='$_GET[consignment_id]'";
			 $qsql = mysqli_query($con,$sql);
			 while($rs = mysqli_fetch_array($qsql))
			 {
				 echo "<strong>Item detail -</strong> " . $rs['itemdetail'];
				 echo "<br /><strong>Item detail - </strong>" . $rs['itemdetail'];				 
				 echo "<br /><strong>From address -</strong> " . $rs['fromaddr']. ",<br />" . $rs['frompin']. ",<br />Mob No." . $rs['frommobno'];				 
				 echo "<br /><strong>To address - </strong>" . $rs['toaddr']. ",<br />" . $rs['topin']. ",<br />Mob No." . $rs['tomobno'];					 				 				 
			 }
			  ?>              
              </td>
            </tr>
            <tr>
              <th width="253" height="42" scope="row">Location</th>
              <td width="287"><input class="form-control" type="text" name="location" id="location" value="<?php echo $rsedit['location']; ?>" /></td>
            </tr>
            <tr>
              <th height="42" scope="row">Date</th>
              <td><input class="form-control" type="date" name="date" id="date" value="<?php echo $rsedit['date']; ?>"/></td>
            </tr>
            <tr>
              <th height="44" scope="row">Note</th>
  
              <td><input class="form-control" type="text" name="note" id="note"value="<?php echo $rsedit['note']; ?>" /></td>
            </tr>
            <tr>
              <th height="49" scope="row">Status</th>
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
              <th height="38" scope="row">&nbsp;</th>
              <td> <input class="btn btn-info" type="submit" name="submit" id="submit" value="Track" /></td>
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
<script>
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;   

function validateform()
{	
	if(document.frmtrack.location.value == "" && document.frmtrack.date.value == "" && document.frmtrack.note.value == ""  && document.frmtrack.status.value == "" )
	{
		alert("Kindly enter all mandatory details..");
		document.frmtrack.location.focus();
		return false;	
		
	}
	else if(document.frmtrack.location.value == "")
	{
		alert("Please enter the Current Location");
		document.frmtrack.location.focus();
		return false;	
	}
	else if(document.frmtrack.date.value == "")
	{
		alert("Please enter the Date");
		document.frmtrack.date.focus();
		return false;	
	}
	else if(document.frmtrack.status.value == "")
	{
		alert("Please select Status");
		document.frmtrack.status.focus();
		return false;	
	}
	else
	{
		return true;
	}
}
</script>