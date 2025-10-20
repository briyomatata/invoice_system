<?php
include("connection.php");

if (!isset($_GET['id'])) {
    die("LPO ID missing.");
}

$id = (int)$_GET['id'];

// Delete related LPO items first
$conn->query("DELETE FROM lpo_items WHERE lpo_id = $id");

// Then delete the LPO itself
if ($conn->query("DELETE FROM lpos WHERE id = $id")) {
    echo "<script>
            alert('LPO deleted successfully!');
            window.location.href='all_lpo.php';
          </script>";
} else {
    echo "<script>
            alert('Error deleting LPO: " . addslashes($conn->error) . "');
            window.history.back();
          </script>";
}
?>
