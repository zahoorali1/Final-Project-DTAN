<?php

require_once "config/database.php";

$pageTitle = "Checkout | Elegance Boutique";

$productId = intval($_GET["id"] ?? 0);

if ($productId <= 0) {
    die("Invalid product.");
}


// Get product
$sql = "
    SELECT *
    FROM products
    WHERE id = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $productId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

include "includes/header.php";

?>

<section class="section">

    <div class="checkout-container">

        <div class="checkout-product">

            <h2>Order Summary</h2>

            <h3>
                <?= htmlspecialchars($product["name"]) ?>
            </h3>

            <p class="price">
                Price per item:
                <strong>
                    Rs. <?= number_format($product["price"], 2) ?>
                </strong>
            </p>

            <div class="checkout-order-summary">
                <h4>Order Details</h4>
                <div class="order-row">
                    <span>Quantity:</span>
                    <span id="summary-quantity">1</span>
                </div>
                <div class="order-row">
                    <span>Unit Price:</span>
                    <span>Rs. <?= number_format($product["price"], 2) ?></span>
                </div>
                <div class="order-row total">
                    <span>Total:</span>
                    <span class="amount" id="summary-total">Rs. <?= number_format($product["price"], 2) ?></span>
                </div>
            </div>

        </div>


        <div class="checkout-form-wrapper">

            <h2>Customer Information</h2>

            <form action="place_order.php" method="POST" class="checkout-form">

                <!-- Product ID -->
                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $product["id"] ?>"
                >

                <div class="form-group">

                    <label for="customer_name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        placeholder="Enter your full name"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="03XX-XXXXXXX"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="address">
                        Delivery Address
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="2"
                        placeholder="Enter your complete delivery address..."
                        required
                    ></textarea>

                </div>

                <div class="form-group">

                    <label for="quantity">
                        Quantity
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="1"
                        min="1"
                        max="100"
                        placeholder="1"
                        required
                        onchange="updateTotal()"
                        oninput="updateTotal()"
                    >

                </div>

                <button
                    type="submit"
                    class="btn order-btn"
                >
                    Place Order
                </button>

            </form>

        </div>

    </div>

</section>

<script>
    const productPrice = <?= $product["price"] ?>;
    
    function updateTotal() {
        const quantity = document.getElementById('quantity').value || 1;
        const total = (productPrice * quantity).toFixed(2);
        
        // Format the total with Rs. prefix
        const formattedTotal = 'Rs. ' + parseFloat(total).toLocaleString('en-PK', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        document.getElementById('summary-quantity').textContent = quantity;
        document.getElementById('summary-total').textContent = formattedTotal;
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', updateTotal);
</script>

<?php include "includes/footer.php"; ?>