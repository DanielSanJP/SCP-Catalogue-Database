<?php
session_start(); // Start the session to track admin login state
include 'connection.php'; // Include the database connection

// Check if 'id' is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $scp_id = $_GET['id']; // Get SCP ID from the URL

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
    <title><?php echo htmlspecialchars($row['name']); ?> - SCP Detail</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/page.css">
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
</head>

<body>

    <div id="header"></div>

    <div class="arrows">
        <a class="arrowBtn" href="catalogue.php">Back to Catalogue</a>

        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <!-- Edit and Delete Buttons Visible Only to Admins -->
            <a class="arrowBtn" href="edit_scp.php?id=<?php echo $scp_id; ?>">Edit</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="nickName"><?php echo htmlspecialchars($row['name']); ?></div>

        <!-- Display Main SCP Image -->
        <img class="scpObject" 
             src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" 
             alt="<?php echo htmlspecialchars($row['name']); ?>">

        <div class="main">
            <div class="specialCont">
                <h2>Special Containment Procedures</h2>
                <p><?php echo nl2br(htmlspecialchars($row['containmentInfo'])); ?></p>
            </div>

            <div class="description">
                <h2>Description</h2>
                <p><?php echo nl2br(htmlspecialchars($row['summary'])); ?></p>
            </div>
        </div>
    </div>

    <script src="./scripts/responsiveImage.js"></script>

    <script type="module">
        import { headerTemplate } from './scripts/header.js';
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('header').innerHTML = headerTemplate;
        });
    </script>

</body>

</html>
