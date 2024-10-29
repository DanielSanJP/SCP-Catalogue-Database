<?php
session_start(); // Start the session

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login if the user is not an admin
    header("Location: login.php");
    exit();
}

include 'connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $item = $_POST['item'];
    $name = $_POST['name'];
    $containment = $_POST['containment'];
    $disruption = $_POST['disruption'];
    $risk = $_POST['risk'];
    $clearance = $_POST['clearance'];
    $containmentInfo = $_POST['containmentInfo'];
    $summary = $_POST['summary'];

    // Prepare image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Insert new SCP record into the database
    $query = "INSERT INTO scp_catalogue 
              (item, name, containment, disruption, risk, clearance, containmentInfo, summary, image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
              
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param(
        'ssssisssb', 
        $item, $name, $containment, $disruption, $risk, $clearance, 
        $containmentInfo, $summary, $image
    );

    if ($stmt->execute()) {
        // Redirect to the catalogue with a success message
        header("Location: catalogue.php?message=created");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the connection
} else {
    echo "Invalid request method.";
}
?>
