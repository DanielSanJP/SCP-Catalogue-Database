<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $item = $_POST['item'];
    $name = $_POST['name'];
    $containmentInfo = $_POST['containmentInfo'];
    $summary = $_POST['summary'];

    // Handle optional image update
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $query = "UPDATE scp_catalogue SET item = ?, name = ?, containmentInfo = ?, summary = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssi', $item, $name, $containmentInfo, $summary, $image, $id);
    } else {
        $query = "UPDATE scp_catalogue SET item = ?, name = ?, containmentInfo = ?, summary = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssi', $item, $name, $containmentInfo, $summary, $id);
    }

    if ($stmt->execute()) {
        echo "<script>
        alert('SCP changes successfully saved!');
        window.location.href = 'catalogue.php';
      </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
