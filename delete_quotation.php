<?php
include("connection.php");

if (!isset($_GET['id'])) {
    die("Quotation ID missing.");
}

$id = (int)$_GET['id'];

// Delete all related quotation items first (to avoid orphaned rows)
$conn->query("DELETE FROM quotation_items WHERE quotation_id = $id");

// Then delete the main quotation
if ($conn->query("DELETE FROM quotations WHERE id = $id")) {
    echo "<script>
            alert('Quotation deleted successfully!');
            window.location.href='all_quotation.php';
          </script>";
} else {
    echo "<script>
            alert('Error deleting quotation: " . addslashes($conn->error) . "');
            window.history.back();
          </script>";
}
?>
