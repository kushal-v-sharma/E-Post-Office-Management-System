<?php
error_reporting(0);
session_start();
$dt = date("Y-m-d");
include("dbconnection.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>E-Post Office</title>
<!-- #################################### -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- #################################### -->
<link href='http://fonts.googleapis.com/css?family=Trocchi' rel='stylesheet' type='text/css' />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
.tftable {font-size:12px;color:#FF0000;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left;}
.tftable tr {background-color:#d4e3e5;}
.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
.tftable tr:hover {background-color:#ffffff;color:rgba(209,30,33,1.00);}
</style>
</head>
<body>
<div class="wrapper">
  <div class="logo"><a href="index.php" ><img src="images/banner.jpg" width="411" height="111" alt=""/></a></div>
  <div class="menu">
    <ul>
		<li><a href="index.php" class="active">Home</a></li>
		<li><a href="about.php" class="active">About Us</a></li>
      <?php
	  if(!isset($_SESSION['customerid']))
	  {
    	 if(isset($_SESSION['adminid']))	
         {
			 ?>
		<li><a href="admindashboard.php" class="active">Admin Dashboard</a></li>  
		<li><a href="adminlogout.php" class="active">Logout</a></li>  
      <?php
		 }
		 else
		 {
			 ?>
		<li><a href="adminlogin.php" class="active">Admin Login</a></li>
       <?php
		 }
	  }
		 ?>
      <?php
	  if(isset($_SESSION['customerid']))
	  {
	?>
		<li><a href="customerdashboard.php" class="active">Customer Dashboard</a></li> 
		<li><a href="customerlogout.php" class="active">Logout</a></li> 
     <?php
	  }
	  else
	  {
		if(!isset($_SESSION['adminid']))	
		{
		  ?>
		<li><a href="customer.php" class="active">Register</a></li>
		<li><a href="customerlogin.php" class="active">Customer Login</a></li>
      <?php
		}
	  }
	  ?>
		<li><a href="contact.php" class="active">Contact Us</a></li>
    </ul>
</div>