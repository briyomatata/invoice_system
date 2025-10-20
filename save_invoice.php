<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name  = $_POST['client_name'];
    $client_email = $_POST['client_email'];
    $Descriptions = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total = $_POST['total'];
    $due_date     = $_POST['due_date'];

    // Insert invoice header
    $sql = "INSERT INTO invoices (client_name, client_email, description, quantity, price, total, due_date) 
            VALUES ('$client_name', '$client_email', '$Description', '$quantity', '$price', '$total', '$due_date')";
    if ($conn->query($sql) === TRUE) {
        $invoice_id = $conn->insert_id;

        // Insert line items
        foreach ($_POST['description'] as $i => $desc) {
            $quantity = (int) $_POST['quantity'][$i];
            $price    = (float) $_POST['price'][$i];
            $amount   = $quantity * $price;

            $conn->query("INSERT INTO invoice_items (invoice_id, description, quantity, price, amount) 
                          VALUES ($invoice_id, '$desc', $quantity, $price, $amount)");
        }

        echo "<script>alert('Invoice saved successfully!'); window.location.href='invoices.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
