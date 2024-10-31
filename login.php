<?php
include 'connection.php';
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to verify admin credentials
    $query = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin_logged_in'] = true; // Set session variable
        echo "<script>
        alert('Admin successfully logged in!');
        window.location.href = 'index.php';
      </script>";
        exit();
    } else {
        echo "<p>Invalid login credentials.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCP Foundation Catalog</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/page.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
</head>

<body>
<?php include "connection.php"; ?>


    <!-- HEADER LOCATION -->
    <div id="header"></div>


    <div>

    <div class="form-box">
    <h1>Admin Login</h1>
    </div>

    <form class="form-container" method="POST" action="login.php">

        <div class="form-box">
        <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="form-box">
        <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="form-box">
        <button type="submit">Login</button>
        </div>
        
    </form>

    </div>

    <!-- FOOTER LOCATION -->
    <div id="footer"></div>

    <script type="module">
        import { headerTemplate } from './scripts/header.js';
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('header').innerHTML = headerTemplate;
            const burger = document.querySelector('.burger');
            const navLinks = document.querySelector('.nav-links');

            burger.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                burger.classList.toggle('toggle');
            });
        });
    </script>

    <script type="module">
        import { footerTemplate } from './scripts/footer.js';
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('footer').innerHTML = footerTemplate;
        });
    </script>

</body>

</html>
