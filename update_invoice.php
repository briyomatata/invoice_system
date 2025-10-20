<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $client_email = $conn->real_escape_string($_POST['client_email']);
    $due_date = $conn->real_escape_string($_POST['due_date']);
    $status = $conn->real_escape_string($_POST['status']);

    $conn->query("UPDATE invoices 
                  SET client_name='$client_name', client_email='$client_email', due_date='$due_date', status='$status' 
                  WHERE id=$id");

    echo "<script>alert('✅ Invoice updated successfully!'); window.location.href='all_invoices.php';</script>";
}
?>
