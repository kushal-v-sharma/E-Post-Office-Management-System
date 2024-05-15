<?php
include("header.php");
include("dbconnection.php");
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
        <h1>Consignment Tracking</h1>
      </div>
      <div class="right-column-content">
      <form method="get" action="" name="frmcon" onSubmit="return validateform()">
        <table width="560" height="79" border="3" class="tftable">
          <tbody>
            <tr>
              <th width="253" height="36" scope="row">Consignment Number</th>
              <td width="287"><input class="form-control" type="text" name="consignmentnumber" id="consignmentnumber" value="<?php echo $_GET['consignmentnumber']; ?>" /></td>
            </tr>
            <tr>
              <th height="31" scope="row">&nbsp;</th>
              <td> <input class="btn btn-info" type="submit" name="submit" id="submit" value="Track" /></td>
            </tr>
          </tbody>
        </table>
        <script type="application/javascript">
		var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphaNumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 
var decimalExpression= /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;  
		function validateform()
		{
			if(document.frmcon.consignmentnumber.value == "")
			{
				alert("Kindly enter the consignment number..");
				document.frmcon.consignmentnumber.focus();
				return false;
			}
			else if(!document.frmcon.consignmentnumber.value.match(numericExpression))
			{
				alert("Consignement number must be in digits.");
				document.frmcon.consignmentnumber.focus();
				return false;
			}
			else
			{
				return true;
			}
		}
        </script>
        <p>&nbsp;</p>
        <?php
		if(isset($_GET['consignmentnumber']))
		{
			 $sql = "SELECT * FROM consignment where consignment_id='$_GET[consignmentnumber]'";
			 $qsql = mysqli_query($con,$sql);
			 $rs = mysqli_fetch_array($qsql);	
			 if(mysqli_num_rows($qsql) == 1)
			 {
			 ?>
        <table width="560" height="33" border="3" class="tftable">
          <tbody>
            <tr>
              <th height="23" scope="row">Consignment details</th>
              <td><?php
				 echo "<strong>Consignment number -</strong> " . $_GET['consignmentnumber'];
				 echo "<br /><strong>Item detail -</strong> " . $rs['itemdetail'];		 
				 echo "<br /><strong>From address -</strong> " . $rs['fromaddr']. ",<br />" . $rs['frompin']. ",<br /><strong>Mob No.</strong>" . $rs['frommobno'];				 
				 echo "<br /><strong>To address - </strong>" . $rs['toaddr']. ",<br />" . $rs['topin']. ",<br /><strong>Mob No.</strong>" . $rs['tomobno'];					 				 				
			  ?>            
              </td>
            </tr>
            </tbody>
          </table>
        <table width="200" border="1" class="tftable">
          <tr>
            <th scope="col">Location</th>
            <th scope="col">Date</th>
            <th scope="col">Note</th>
            <?php
		  $sql="select * from tracking  where consignment_id='$_GET[consignmentnumber]' and status='Active'";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
			  echo "<tr>
			  <td>&nbsp;$rs[location]</td>
			 <td>&nbsp;$rs[date]</td>
			 <td>&nbsp;$rs[note]</td>
          </tr>";
		  }?>
        </table>
        <?php
			 }
			 else
			 {
				 echo "<center><strong>You have entered invalid consignment number..</strong></center>";
			 }
		}
		?>
        <p>&nbsp;</p>
        </form>
        <h1>&nbsp;</h1>
        <p>
        
        </p>
      </div>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>