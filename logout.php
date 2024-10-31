<?php
session_start(); // Start the session
session_destroy(); // Destroy all sessions
echo "<script>
alert('Logged out!');
window.location.href = 'index.php';
</script>";
exit();
?>
