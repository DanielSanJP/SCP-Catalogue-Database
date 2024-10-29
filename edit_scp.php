<?php
session_start(); // Start the session
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If admin is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>


<?php
include 'connection.php'; // Include the database connection

// Check if 'id' is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $scp_id = $_GET['id']; // Get SCP ID from URL

    // Query to fetch SCP data by ID
    $query = "SELECT * FROM scp_catalogue WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $scp_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch SCP data
    } else {
        echo "<p>Error: SCP not found.</p>";
        exit();
    }
    $stmt->close(); // Close the statement
} else {
    echo "<p>Invalid SCP ID provided.</p>";
    exit();
}
$conn->close(); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit SCP - <?php echo htmlspecialchars($row['name']); ?></title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/page.css">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
</head>

<body>

    <!-- HEADER LOCATION -->
    <div id="header"></div>

    <div class="arrows">
    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <form action="delete_scp.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this SCP?');" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $scp_id; ?>">
                <button type="submit" class="arrowBtn deleteBtn">Delete</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="form-box">
        <h1>Edit SCP - <?php echo htmlspecialchars($row['item']); ?></h1>
    </div>

    <!-- Edit SCP Form -->
    <form class="form-container" action="update_scp.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $scp_id; ?>">

        <div class="form-box">
            <label for="item">Item Number:</label>
            <input type="text" id="item" name="item" value="<?php echo htmlspecialchars($row['item']); ?>" required>
        </div>

        <div class="form-box">
            <label for="name">SCP Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        </div>

        <div class="form-box">
            <label for="containmentInfo">Containment Info:</label>
            <textarea id="containmentInfo" name="containmentInfo" rows="4" required><?php echo htmlspecialchars($row['containmentInfo']); ?></textarea>
        </div>

        <div class="form-box">
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" rows="4" required><?php echo htmlspecialchars($row['summary']); ?></textarea>
        </div>

        <div class="form-box">
            <label for="image">Update Main Image:</label>
            <input type="file" name="image">
        </div>

        <div class="form-box">
            <button type="submit">Save Changes</button>
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
