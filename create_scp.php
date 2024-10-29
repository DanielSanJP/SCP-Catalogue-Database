<?php
session_start(); // Start session
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

include 'connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $item = $_POST['item'];
    $name = $_POST['name'];
    $containment = $_POST['containment'];
    $disruption = $_POST['disruption'];
    $risk = $_POST['risk'];
    $clearance = $_POST['clearance'];
    $containmentInfo = $_POST['containmentInfo'];
    $summary = $_POST['summary'];

    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Prepare the SQL query
    $query = "INSERT INTO scp_catalogue 
              (item, name, containment, disruption, risk, clearance, containmentInfo, summary, image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        'ssssisssb',
        $item, $name, $containment, $disruption, $risk,
        $clearance, $containmentInfo, $summary, $image
    );

    // Send long data for the image (if provided)
    if ($image !== null) {
        $stmt->send_long_data(8, $image); // '8' is the zero-based index of the 'image' parameter
    }

    // Execute and handle errors
    if ($stmt->execute()) {
        echo "SCP entry created successfully!<br>";
        header("Location: catalogue.php?message=created");
        exit();
    } else {
        echo "Error executing statement: " . $stmt->error;
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
    <title>Create New SCP</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/form.css">
</head>

<body>
    <div id="header"></div>

    <div class="form-box">
        <h1>Create New SCP Entry</h1>
    </div>

    <form class="form-container" action="create_scp.php" method="POST" enctype="multipart/form-data">
        <div class="form-box">
            <label for="item">Item Number:</label>
            <input type="text" id="item" name="item" required>
        </div>

        <div class="form-box">
            <label for="name">SCP Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-box">
            <label for="containment">Containment Class:</label>
            <select id="containment" name="containment" required>
                <option value="Safe">Safe</option>
                <option value="Euclid">Euclid</option>
                <option value="Keter">Keter</option>
                <option value="Thaumiel">Thaumiel</option>
                <option value="Neutralized">Neutralized</option>
            </select>
        </div>

        <div class="form-box">
            <label for="disruption">Disruption Class:</label>
            <select id="disruption" name="disruption" required>
                <option value="Dark">Dark</option>
                <option value="Vlam">Vlam</option>
                <option value="Keneq">Keneq</option>
                <option value="Ekhi">Ekhi</option>
            </select>
        </div>

        <div class="form-box">
            <label for="risk">Risk Class:</label>
            <select id="risk" name="risk" required>
                <option value="Notice">Notice</option>
                <option value="Caution">Caution</option>
                <option value="Warning">Warning</option>
                <option value="Danger">Danger</option>
                <option value="Critical">Critical</option>
            </select>
        </div>

        <div class="form-box">
            <label for="clearance">Clearance Level:</label>
            <select id="clearance" name="clearance" required>
                <option value="1">Level 1 - Confidential</option>
                <option value="2">Level 2 - Restricted</option>
                <option value="3">Level 3 - Secret</option>
                <option value="4">Level 4 - Top Secret</option>
                <option value="5">Level 5 - Cosmic Top Secret</option>
            </select>
        </div>

        <div class="form-box">
            <label for="containmentInfo">Containment Info:</label>
            <textarea id="containmentInfo" name="containmentInfo" rows="4" required></textarea>
        </div>

        <div class="form-box">
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" rows="4" required></textarea>
        </div>

        <div class="form-box">
            <label for="image">Main SCP Image:</label>
            <input type="file" id="image" name="image">
        </div>

        <div class="form-box">
            <button type="submit">Create SCP</button>
        </div>
    </form>

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
