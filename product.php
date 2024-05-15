<?php
error_reporting(0);
session_start();
include("dbconnection.php");
include("header.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Add item to cart session
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    // Automatically set delivery date 3 days from present
    $delivery_date = date('Y-m-d', strtotime('+3 days'));

    // Define rates for each item in rupees
    $rates = [
        "stamps" => 100,         // 1.50 USD -> 100 INR
        "postcards" => 150,      // 2.00 USD -> 150 INR
        "packets" => 250,        // 5.00 USD -> 250 INR
        "cartons" => 500,        // 10.00 USD -> 500 INR
        "mobilecards" => 200     // 3.00 USD -> 200 INR
    ];

    $total_price = $rates[$item] * $quantity;

    $_SESSION['cart'][] = [
        'item' => $item,
        'quantity' => $quantity,
        'rate' => $rates[$item],
        'total_price' => $total_price,
        'delivery_date' => $delivery_date
    ];

    echo "<script>alert('Item added to cart successfully');</script>";
}

// Handle delete button click
if (isset($_POST['delete'])) {
    $index = $_POST['index'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Function to calculate total cost
function calculateTotalCost() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['total_price'];
    }
    return $total;
}
?>

<style>
    .cart td {
        padding: 8px; /* Adjust this value to add the desired space */
    }
</style>

<div class="columns-container">
    <div class="columns-wrapper">
        <?php include("leftside.php"); ?>
        <div class="right-column">
            <div class="right-column-heading">
                <h1>&nbsp;</h1>
                <h1>Shell Items</h1>
            </div>
            <div class="right-column-content">
                <form id="shellForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="item">Item:</label>
                        <select name="item" id="item">
                            <option value="stamps">Stamps (₹100 each)</option>
                            <option value="postcards">Postcards (₹150 each)</option>
                            <option value="packets">Packets (₹250 each)</option>
                            <option value="cartons">Cartons (₹500 each)</option>
                            <option value="mobilecards">Mobile Cards (₹200 each)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" required>
                    </div>
                    <!-- Delivery date field automatically set to 3 days from present -->
                    <div class="form-group">
                        <label for="delivery_date">Delivery Date:</label>
                        <input type="date" id="delivery_date" name="delivery_date" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" readonly>
                    </div>
                    <button type="submit" name="submit">Add to Cart</button>
                </form>
            </div>
            <?php
            // Display cart if it's not empty
            if (!empty($_SESSION['cart'])) {
                echo "<h2>Shopping Cart</h2>";
                echo "<table class='cart'>";
                echo "<tr><th>Item</th><th>Quantity</th><th>Rate</th><th>Total Price</th><th>Delivery Date</th><th>Action</th></tr>";
                foreach ($_SESSION['cart'] as $index => $item) {
                    echo "<tr>";
                    echo "<td>{$item['item']}</td>";
                    echo "<td>{$item['quantity']}</td>"; // Display quantity as static text
                    echo "<td>₹" . number_format($item['rate'], 2) . "</td>";
                    echo "<td class='total_price'>₹" . number_format($item['total_price'], 2) . "</td>"; // Add class for total price
                    echo "<td>{$item['delivery_date']}</td>";
                    echo "<td><form method='post'><input type='hidden' name='index' value='$index'><button type='submit' name='delete'>Delete</button></form></td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='4'><strong>Total:</strong></td><td id='total_cost'>₹" . number_format(calculateTotalCost(), 2) . "</td><td></td></tr>";
                echo "</table>";

                // Add buy option
                echo "<form method='post' action='payment.php'>";
                echo "<input type='hidden' name='total' value='" . calculateTotalCost() . "'>";
                echo "<button type='submit' name='buy'>Buy</button>";
                echo "</form>";
            }
            ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
