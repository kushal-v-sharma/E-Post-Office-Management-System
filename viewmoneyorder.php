<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from moneyorder where moneyorderid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<scipt>alert('Record deleted');</script>";
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
      <div class="right-column-heading"><h2>Money Transfer </h2>
        <h1>View Money Transfer  Record</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <div style='overflow:auto;width:100%'>
        <table width="200" border="1"  class="tftable">
          <tr>
             <th scope="col">Customer</th>
             <th scope="col">From Address</th>
             <th scope="col">From Pin Code</th>
             <th scope="col">From Mobile Number</th>
             <th scope="col">To Address</th>
             <th scope="col">To Pincode</th>
             <th scope="col">To Mobile Number</th>
             <th scope="col">Money Order Date</th>
             <th scope="col">Amount</th>
             <th scope="col">Commission</th>
             <th scope="col">Note</th>
             <th scope="col">Status</th>
             <th scope="col">Action</th>
           </tr>
           <?php
		   $sql="select * from moneyorder";
		   $qsql=mysqli_query($con,$sql);
		   while($rs=mysqli_fetch_array($qsql))
		   { 
		   $sql4="SELECT * from customer where customerid='$rs[customerid]'";
		   $qsql4=mysqli_query($con,$sql4);
		   $rs4=mysqli_fetch_array($qsql4);
           echo "<tr>
		    <td>&nbsp;$rs4[customername]</td>
             <td>&nbsp;$rs[fromaddr]</td>
             <td>&nbsp;$rs[frompin]</td>
             <td>&nbsp;$rs[frommobno]</td>
             <td>&nbsp;$rs[toaddr]</td>
             <td>&nbsp;$rs[topin]</td>
             <td>&nbsp;$rs[tomobno]</td>
             <td>&nbsp;$rs[modate]</td>
             <td>&nbsp;$rs[commission]</td>
             <td>&nbsp;$rs[amount]</td>
             <td>&nbsp;$rs[note]</td>
             <td>&nbsp;$rs[status]</td>
             <td>&nbsp;<a href='viewmoneyorder.php?deleteid=$rs[moneyorderid]' > Delete</a></td>
           </tr>";
		   }
		   ?>
       </table>
         </div>
         <p>&nbsp;</p>
         <p>&nbsp;</p>
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