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

// Start session for cart functionality
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize SQL query
$sql = "SELECT id, title, author, thumbnail, genre FROM inventory WHERE 1";

// Handle search filter
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " AND (title LIKE '%$search%' OR author LIKE '%$search%')";
}

// Handle genre filter
if (isset($_GET['genre']) && $_GET['genre'] !== '') {
    $genre = $conn->real_escape_string($_GET['genre']);
    $sql .= " AND genre = '$genre'";
}

// Fetch genres for the dropdown
$genresQuery = "SELECT DISTINCT genre FROM inventory";
$genresResult = $conn->query($genresQuery);

// Execute the main query
$result = $conn->query($sql);

// Handle adding items to the cart
if (isset($_POST['add_to_cart'])) {
    $bookId = $_POST['book_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!in_array($bookId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $bookId;
    }
    header("Location: books-for-sale.php");
    exit();
}

// Handle checkout (clears the cart)
if (isset($_POST['checkout'])) {
    $_SESSION['cart'] = []; // Empty the cart
    $checkoutMessage = "Thank you for your purchase!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books for Sale - Between the Spines</title>
    <link rel="stylesheet" href="https://betweenthespines.fun/css/styles.css">
</head>
<body>
    <header>
        <h1>Books for Sale</h1>
    </header>

    <nav>
        <a href="/index.php">Home</a>
        <a href="/Books-for-sale/books-for-sale.php">Books for Sale</a>
        <a href="/loyalty-registration/loyalty-registration.php">Loyalty Registration</a>
        <a href="/Contact-us/contact.php">Contact Us</a>
    </nav>

    <section class="content">
        <h2>Our Available Books</h2>
        <form method="GET" action="books-for-sale.php" class="filter-form">
            <input type="text" name="search" placeholder="Search by title or author" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <select name="genre">
                <option value="">All Genres</option>
                <?php
                if ($genresResult->num_rows > 0) {
                    while ($row = $genresResult->fetch_assoc()) {
                        $selected = (isset($_GET['genre']) && $_GET['genre'] === $row['genre']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['genre']) . "' $selected>" . htmlspecialchars($row['genre']) . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <div class="book-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='book-item'>";
                    echo "<img src='" . htmlspecialchars($row['thumbnail']) . "' alt='" . htmlspecialchars($row['title']) . "' style='width:150px;height:200px;'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p>Author: " . htmlspecialchars($row['author']) . "</p>";
                    echo "<p>Genre: " . htmlspecialchars($row['genre']) . "</p>";
                    echo "<form method='POST' action='books-for-sale.php'>";
                    echo "<input type='hidden' name='book_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No books found matching your criteria.</p>";
            }
            ?>
        </div>
    </section>

   <section class="cart">
    <h2>Your Cart</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php
            $cartIds = implode(',', array_map('intval', $_SESSION['cart']));
            $cartQuery = "SELECT title, author FROM inventory WHERE id IN ($cartIds)";
            $cartResult = $conn->query($cartQuery);
            while ($cartRow = $cartResult->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($cartRow['title']) . " by " . htmlspecialchars($cartRow['author']) . "</li>";
            }
            ?>
        </ul>
        <form method="POST" action="/checkout.php">
            <button type="submit">Checkout</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty. Add some books to your cart to checkout.</p>
    <?php endif; ?>
</section>


    <footer>
        <p>&copy; 2024 Between the Spines</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
