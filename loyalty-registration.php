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

        
    </section>

    <footer>
        <p>&copy; 2024 Between the Spines</p>
    </footer>

</body>
</html>
