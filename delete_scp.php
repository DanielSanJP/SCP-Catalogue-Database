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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Get the SCP ID from the form

    // Prepare the DELETE query
    $query = "DELETE FROM scp_catalogue WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    // Execute the query and handle redirection
    if ($stmt->execute()) {
        header("Location: catalogue.php?message=deleted");
        exit();
    } else {
        echo "Error deleting SCP: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
