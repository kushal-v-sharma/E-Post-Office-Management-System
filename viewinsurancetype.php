<?php
include("header.php");
include("dbconnection.php");
if(isset($_GET['deleteid']))
{
	$sql="Delete from insurancetype where insurancetypeid='$_GET[deleteid]'";
	$qsql=mysqli_query($con,$sql);
	echo "<script>alert('Record deleted');</script>";
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
        <h1>View Insurance Type</h1>
      </div>
      <div class="right-column-content">
      <form method="post" action="">
      <div style='overflow:auto;width:100%'>
        <table width="558" border="1"  class="tftable">
          <tr>
            <th scope="col">Insurance type</th>
            <th scope="col">Bonus</th>
            <th scope="col">Minimum Age</th>
            <th scope="col">Maximum Age</th>
            <th scope="col">Minimum Amount</th>
            <th scope="col">Maximum Amount</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
          <?php
		  $sql="select * from insurancetype";
		  $qsql=mysqli_query($con,$sql);
		  while($rs=mysqli_fetch_array($qsql))
		  {
          echo "<tr>
            <td>&nbsp;$rs[insurancetype]</td>
            <td>&nbsp;$rs[bonus]%</td>
            <td>&nbsp;$rs[minage]</td>
			<td>&nbsp;$rs[maxage]</td>
			<td>&nbsp;$rs[minamt]</td>
			<td>&nbsp;$rs[maxamt]</td>
            <td>&nbsp;$rs[status]</td>
            <td>&nbsp; <a href='insurancetype.php?editid=$rs[insurancetypeid]'> Edit</a> |
			<a href='viewinsurancetype.php?deleteid=$rs[insurancetypeid]' >  Delete</a></td>
          </tr>";
		  }
		  ?>
      </table>
        </div>
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