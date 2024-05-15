<?php
error_reporting(0);
session_start();
if(isset($_SESSION['customerid']) || isset($_SESSION['adminid']))
{
?>
<div class="left-column">
<div class="left-column-panel">
<div class="left-column-panel-middle">
        <?php
        if(isset($_SESSION['adminid']))
		{
			?>
          <h1>Admin Menu</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="admindashboard.php">Dashboard</a></li>
              <li><a href="adminprofile.php">Admin Profile</a></li>
              <li><a href="adminchangepassword.php">Change Password</a></li>
              <li><a href="admin.php">Add Admin</a></li>
              <li><a href="viewadmin.php">View Admin</a></li>
               <li><hr></li>
               </ul>
          </div>
          
          <h1>Money Order</h1>
          <div class="sub-menu">
            <ul>
               <li><a href="moneyorder.php">Add Money Transfer </a></li>
               <li><a href="viewmoneyorder.php">View Money Transfer </a></li>
               <li><hr></li>
               </ul>
          </div>
		  
          <h1>Account Master</h1>
          <div class="sub-menu">
            <ul>
				<li><a href="viewrdaccount.php">RD Settings</a></li>               
				<li><a href="viewsavingbankaccount.php">SB Settings</a></li>              
				<li><a href="viewssaaccount.php">SSA Settings</a></li>               
				<li><a href="viewtdaccount.php">TD Settings</a></li>
               <li><hr></li>
            </ul>
          </div> 

          <h1>Insuarance</h1>
          <div class="sub-menu">
            <ul>
               <li><a href="insurancetype.php">Add Insurance Type</a></li>
               <li><a href="viewinsurancetype.php">View Insurance Type</a></li>
              <li><a href="insuranceaccount.php">Add Insurance</a></li>
              <li><a href="viewinsuranceaccount.php">View Insurance</a></li>
               <li><a href="insurancepayment.php">Add Insurance Payment</a></li>
               <li><a href="viewinsurancepayment.php">View Insurance Payment</a></li>
               <li><hr></li>
               </ul>
          </div> 
          
          <h1>Report</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="customer.php">Add Customer</a></li>
              <li><a href="viewcustomer.php">View Customer</a></li>              
              <li><a href="account.php">Add Account </a></li>
              <li><a href="viewaccount.php">View Account</a></li>
              <li><a href="adminbillpayment.php">Add Bill Payment</a></li>
              <li><a href="viewbillpayment.php">View Bill Payment</a></li>
              <li><a href="consignment.php">Add Consignment</a></li>
              <li><a href="viewconsignment.php">View Consignment</a></li>
               <li><a href="transaction.php">Add Transaction</a></li>
               <li><a href="viewtransaction.php">View Transaction</a></li>
               <li><hr></li>
                </ul>
          </div>
          <?php
		}
        if(isset($_SESSION['customerid']))
		{
			?>
          <h1>Customer Menu </h1>
          <div class="sub-menu">
            <ul>
              <li><a href="customerdashboard.php">Dashboard</a></li>
              <li><a href="customerprofile.php">Customer Profile</a></li>
              <li><a href="customerchangepassword.php">Change Password</a></li>
               <li><hr></li>
               </ul>
          </div>
           <h1>Accounts</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="createcustomeraccount.php">Create New Account</a></li>
              <li><a href="customerviewaccount.php">View Accounts</a></li>
              <li><a href="viewtransaction.php">View Transaction</a></li>
               <li><hr></li>
              </ul>
          </div>
          
          <h1>Bill Payment</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="billpayment.php">Add Bill Payment</a></li>
              <li><a href="viewbillpayment.php">View Bill Payment</a></li>
               <li><hr></li>
              </ul>
          </div>
          <h1>Money Order</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="customermoneyorder.php">Add Money Transfer </a></li>
              <li><a href="viewcustomermoneyorder.php">View Money Transfer </a></li>
               <li><hr></li>
              </ul>
          </div>
          <h1>Order Product</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="product.php">products </a></li>
               <li><hr></li>
              </ul>
          </div>
           <h1>Consignment</h1>
          <div class="sub-menu">
            <ul>
             <li><a href="consignmenttracking.php">Consignment tracking</a></li>
               <li><hr></li>
         </ul>
          </div>
          <h1>Insurance</h1>
          <div class="sub-menu">
            <ul>
              <li><a href="insuranceaccount.php">Add Insurance</a></li>
              <li><a href="viewinsuranceaccount.php">View Insurance</a></li>
               <li><hr></li>
               </ul>
          </div>
          <?php
		}
		?>
         </div>
        <div class="left-column-panel-bottom"></div>
      </div>
    </div>
<?php
}
else
{
?>
<div class="left-column">
<div class="left-column-panel">
<div class="left-column-panel-middle">
<img src="images/postofficerec.jpg" style="width: 100%;" align="left" ><hr>
<img src="images/postal-banking-USPS-alternative-finances.jpg" style="width: 100%;" align="left" ><hr>
<img src="images/Aadhar_post_office_0.jpg" style="width: 100%;" align="left" ><hr>
<img src="images/posstoffideimages.jpg" style="width: 100%;" align="left" ><hr>
<img src="images/postofficesimages.jpg" style="width: 100%;" align="left" ><hr>
<img src="images/India-Post-Office-jobs.png" style="width: 100%;" align="left" ><hr>
</div>
</div>
</div>
<?php
}
?>