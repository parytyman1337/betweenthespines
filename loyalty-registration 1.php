<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Registration - Between the Spines</title>
    <link rel="stylesheet" href="https://betweenthespines.fun/css/styles.css">
</head>
<body>

    <header>
        <h1>Loyalty Program Registration</h1>
    </header>

    <nav>
        <a href="/index.php">Home</a>
        <a href="/Books-for-sale/books-for-sale.php">Books for Sale</a>
        <a href="/loyalty-registration/loyalty-registration.php">Loyalty Registration</a>
        <a href="/Contact-us/contact.php">Contact Us</a>
    </nav>

    <section class="content">
        <h2>Join Our Loyalty Program!</h2>
        <p>Sign up for the Between the Spines Loyalty Program to earn rewards for every purchase!</p>

        <!-- Loyalty Registration Form -->
        <form action="" method="POST" class="registration-form">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required placeholder="Your full name">

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required placeholder="Your email">

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required placeholder="Your phone number">

            <label for="address">Mailing Address:</label>
            <textarea id="address" name="address" rows="4" required placeholder="Your mailing address"></textarea>

            <input type="submit" value="Sign Up">
        </form>

        <?php
        // Start the session for loyalty user tracking
        session_start();

        // This part of the code runs when the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Capture form data and sanitize inputs
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $address = htmlspecialchars($_POST['address']);

            // Database connection details
            $servername = "127.0.0.1"; // Or "localhost"
            $username = "u755075142_root"; // Your MySQL username
            $password = "DiaMond24!"; // Your MySQL password
            $dbname = "u755075142_bookstore"; // Your database name

            // Create a connection to MySQL
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check if the connection was successful
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Check if the email already exists
            $checkEmail = "SELECT * FROM registrations WHERE email = '$email'";
            $result = $conn->query($checkEmail);

            if ($result->num_rows > 0) {
                echo "<p>This email is already registered. Please use a different email.</p>";
            } else {
                // Prepare the SQL query to insert data into the `registrations` table
                $stmt = $conn->prepare("INSERT INTO registrations (name, email, phone, address) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $phone, $address);

                // Execute the query and check if it was successful
                if ($stmt->execute() === TRUE) {
                    echo "<p>Thank you, " . htmlspecialchars($name) . "! You have successfully signed up for our Loyalty Program.</p>";

                    // Set a session variable for the newly registered loyalty user
                    $_SESSION['loyalty_id'] = $conn->insert_id; // Assuming 'id' is the primary key in your `registrations` table
                    $_SESSION['loyalty_name'] = $name;
                } else {
                    echo "Error: " . $conn->error;
                }

                // Close the statement
                $stmt->close();
            }

            // Close the database connection
            $conn->close();
        }
        ?>

    </section>

    <footer>
        <p>&copy; 2024 Between the Spines</p>
    </footer>

</body>
</html>
