<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Between the Spines</title>
    <link rel="stylesheet" href="https://betweenthespines.fun/css/styles.css"> <!-- Correct CSS Path -->
</head>
<body>

    <header>
        <h1>Contact Us</h1>
    </header>

<nav>
    <a href="/index.php">Home</a>
    <a href="/Books-for-sale/books-for-sale.php">Books for Sale</a>
    <a href="/loyalty-registration/loyalty-registration.php">Loyalty Registration</a>
    <a href="/Contact-us/contact.php">Contact Us</a>
</nav>


    <section class="content">
        <h2>Get in Touch with Us</h2>
        <p>If you have any questions, feel free to reach out to us using the form below.</p>

        <!-- Contact Us Form -->
        <form action="" method="POST" class="contact-form">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required placeholder="Your full name">

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required placeholder="Your email address">

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required placeholder="Subject of your message">

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Type your message here..."></textarea>

            <input type="submit" value="Send Message">
        </form>

            </section>

    <footer>
        <p>&copy; 2024 Between the Spines</p>
    </footer>

</body>
</html>
