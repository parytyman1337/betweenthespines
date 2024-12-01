<?php
// Enable error reporting for troubleshooting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// MySQL connection details
$servername = "127.0.0.1";  // Or "localhost"
$username = "u755075142_root";  // Your MySQL username
$password = "DiaMond24!";  // Your MySQL password
$dbname = "u755075142_bookstore";  // The database name

// Start session to access cart
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$books = [];
if (!empty($cartItems)) {
    $cartIds = implode(',', array_map('intval', $cartItems));
    $sql = "SELECT id, title, author FROM inventory WHERE id IN ($cartIds)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Initialize variables
$orderNumber = '';
$checkoutComplete = false;

// Handle form submission and order processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $orderNumber = "ORD" . rand(1000, 9999);

    // Insert each book in the order into the database
    foreach ($books as $book) {
        $sql = "INSERT INTO orders (order_number, loyalty_id, title, author) VALUES 
                ('$orderNumber', NULL, '" . $conn->real_escape_string($book['title']) . "', '" . $conn->real_escape_string($book['author']) . "')";
        $conn->query($sql);
    }

    // Clear the cart
    $_SESSION['cart'] = [];
    $checkoutComplete = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Between the Spines</title>
    <link rel="stylesheet" href="https://betweenthespines.fun/css/styles.css">
</head>
<body>
    <header>
        <h1>Checkout</h1>
    </header>

    <section class="cart">
        <h2>Your Cart</h2>
        <?php if (!empty($books)): ?>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li><?php echo htmlspecialchars($book['title']) . " by " . htmlspecialchars($book['author']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Your cart is empty. Add some books to your cart to checkout.</p>
            <a href="/index.php" class="btn">Go Back to Home Page</a>
        <?php endif; ?>
    </section>

    <?php if (!empty($books) && !$checkoutComplete): ?>
        <section class="checkout-form">
            <h2>Customer Information</h2>
            <form method="POST" action="checkout.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>
                <button type="submit" name="place_order">Place Order</button>
            </form>
            <a href="/index.php" class="btn">Go Back to Home Page</a>
        </section>
    <?php endif; ?>

    <?php if ($checkoutComplete): ?>
        <section class="order-confirmation">
            <h2>Order Complete</h2>
            <p>Thank you for your order! Your order number is <strong><?php echo $orderNumber; ?></strong>.</p>
            <a href="/index.php" class="btn">Go Back to Home Page</a>
        </section>
    <?php endif; ?>

    <footer>
        <p>&copy; 2024 Between the Spines</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
