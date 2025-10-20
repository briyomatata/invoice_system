<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $client_email = $conn->real_escape_string($_POST['client_email']);
    $valid_until = $conn->real_escape_string($_POST['valid_until']);

    // Update quotation header
    $conn->query("UPDATE quotations 
                  SET client_name='$client_name', client_email='$client_email', valid_until='$valid_until' 
                  WHERE id=$id");

    // Handle items
    foreach ($_POST['description'] as $i => $desc) {
        $item_id = (int)$_POST['item_id'][$i];
        $quantity = (int)$_POST['quantity'][$i];
        $price = (float)$_POST['price'][$i];
        $amount = $quantity * $price;

        if ($item_id > 0) {
            $conn->query("UPDATE quotation_items 
                          SET description='$desc', quantity=$quantity, price=$price, amount=$amount 
                          WHERE id=$item_id");
        } else {
            $conn->query("INSERT INTO quotation_items (quotation_id, description, quantity, price, amount)
                          VALUES ($id, '$desc', $quantity, $price, $amount)");
        }
    }

    echo "<script>alert('Quotation updated successfully!'); window.location.href='quotations.php';</script>";
}
?>
