<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $supplier_name = $conn->real_escape_string($_POST['supplier_name']);
    $supplier_email = $conn->real_escape_string($_POST['supplier_email']);
    $delivery_date = $conn->real_escape_string($_POST['delivery_date']);

    $conn->query("UPDATE lpos 
                  SET supplier_name='$supplier_name', supplier_email='$supplier_email', delivery_date='$delivery_date' 
                  WHERE id=$id");

    foreach ($_POST['description'] as $i => $desc) {
        $item_id = (int)$_POST['item_id'][$i];
        $quantity = (int)$_POST['quantity'][$i];
        $price = (float)$_POST['price'][$i];
        $amount = $quantity * $price;

        if ($item_id > 0) {
            $conn->query("UPDATE lpo_items 
                          SET description='$desc', quantity=$quantity, price=$price, amount=$amount 
                          WHERE id=$item_id");
        } else {
            $conn->query("INSERT INTO lpo_items (lpo_id, description, quantity, price, amount)
                          VALUES ($id, '$desc', $quantity, $price, $amount)");
        }
    }

    echo "<script>alert('LPO updated successfully!'); window.location.href='lpos.php';</script>";
}
?>
