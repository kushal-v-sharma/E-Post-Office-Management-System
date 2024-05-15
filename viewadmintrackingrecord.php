<?php
error_reporting(0); session_start();
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from tracking where trackingid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<script>alert('Record deleted');</script>";
}
if(isset($_POST['submit']))
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
      <br />
        <h1> Consignment Tracking </h1>
      </div>
       <form method="post" action="" name="frmtracking" onSubmit="return validateform()">
        <table width="560" height="277" border="3" class="tftable">
          <tbody>
            <tr>
              <th height="42" scope="row">Consignment details</th>
              <td><?php
			 $sql = "SELECT * FROM consignment where consignment_id='$_GET[consignment_id]'";
			 $qsql = mysqli_query($con,$sql);
			 while($rs = mysqli_fetch_array($qsql))
			 {
				 echo "<strong>Consignment number -</strong> " . $_GET['consignment_id'];
				 echo "<br /><strong>Item detail -</strong> " . $rs['itemdetail'];				 
				 echo "<br /><strong>From address -</strong> " . $rs['fromaddr']. ",<br />" . $rs['frompin']. ",<br /><strong>Mob No.</strong>" . $rs['frommobno'];				 
				 echo "<br /><strong>To address - </strong>" . $rs['toaddr']. ",<br />" . $rs['topin']. ",<br /><strong>Mob No.</strong>" . $rs['tomobno'];					 				 				 
			 }
			  ?>       
              <input class="form-control" type="hidden" name="consignment_id" value="<?php echo $_GET['consignment_id']; ?>"  />       
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
              <td><textarea class="form-control"  name="note" id="note"><?php echo $rsedit['note']; ?></textarea>
              </td>
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
        </form><br />

      <hr /><br />

      <div class="right-column-heading">
        <h1>View Consignment Tracking Record</h1>
      </div>
      <form method="post" action="">
      <div style='overflow:auto;width:100%'>
              <table width="200" border="1" class="tftable">
          <tr>
            <th scope="col">Location</th>
            <th scope="col">Date</th>
            <th scope="col">Note</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
            <?php
		  $sql="select * from tracking";
		  if(isset($_SESSION['customerid']))
		  {
			 $sql =  $sql . " where trackingid='$_SESSION[trackingid]'";
		  }
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  echo "<tr>
			  <td>&nbsp;$rs[location]</td>
			 <td>&nbsp;$rs[date]</td>
			 <td>&nbsp;$rs[note]</td>
			 <td>&nbsp;$rs[status]</td>
			 <td>&nbsp;<a href='viewadmintrackingrecord.php?deleteid=$rs[trackingid]'>Delete</a></td>
		  </tr>";
		  }
		  ?>
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
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;  
function validateform()
{
	if(document.frmtracking.consignment_id.value== "")
	{
		alert("Consignemnt record not found..");
		document.frmtracking.consignment_id.focus();
		return false;
	}
	else if(document.frmtracking.location.value== "")
	{
		alert("Location should not be empty...");
		document.frmtracking.location.focus();
		return false;
	}
	else if(!document.frmtracking.location.value.match(alphaspaceExp))
	{
		alert("Kindly enter valid location detail..");
		document.frmtracking.location.focus();
		return false;
	}
	else if(document.frmtracking.date.value== "")
	{
		alert("Kindly select the date.");
		document.frmtracking.date.focus();
		return false;
	}
	else if(document.frmtracking.status.value== "")
	{
		alert("Kindly select the status.");
		document.frmtracking.status.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>