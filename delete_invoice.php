<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM invoices WHERE id = $id");
    echo "<script>alert('🗑️ Invoice deleted successfully!'); window.location.href='all_invoices.php';</script>";
}
?>
