<?php
error_reporting(0);
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "student";
$database = "postoffice";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

include("header.php");

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Capture form data
    $customer_name = $_POST['customer_name'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $total_amount = $_POST['total'];
    $card_type = $_POST['card_type'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Insert data into MySQL table
    $query = "INSERT INTO orders (customer_name, address, mobile_number, email, total_amount, card_type, card_number, expiry_date, cvv)
              VALUES ('$customer_name', '$address', '$mobile_number', '$email', '$total_amount', '$card_type', '$card_number', '$expiry_date', '$cvv')";
    // Assuming 'orders' is the name of your table
    $result = mysqli_query($connection, $query); // Assuming $connection is your database connection variable

    if ($result) {
        echo "<script>alert('Payment successful. Thank you for your purchase!');</script>";
        // Clear cart after successful purchase
        unset($_SESSION['cart']);
    } else {
        echo "<script>alert('Error processing payment. Please try again.');</script>";
    }
}
?>

<div class="payment-form">
    <h2>Customer Details</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Customer Information -->
        <div class="form-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <!-- Payment Information -->
        <h2>Payment Details</h2>
        <div class="form-group">
            <label for="card_type">Card Type:</label>
            <select name="card_type" id="card_type" required>
                <option value="debit">Debit Card</option>
                <option value="credit">Credit Card</option>
            </select>
        </div>
        <div class="form-group">
    <label for="card_number">Card Number:</label>
    <input type="text" id="card_number" name="card_number" pattern="[0-9]{16}" title="Please enter a 16-digit card number" required>
</div>
        <div class="form-group">
            <label for="expiry_date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YYYY" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" required>
        </div>
        <input type="hidden" name="total" value="<?php echo isset($_POST['total']) ? $_POST['total'] : ''; ?>">
        <button type="submit" name="submit">Submit Payment</button>
    </form>
</div>

<?php include("footer.php"); ?>
