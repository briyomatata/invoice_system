<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name  = $conn->real_escape_string($_POST['client_name']);
    $client_email = $conn->real_escape_string($_POST['client_email']);
    $due_date     = $conn->real_escape_string($_POST['due_date']);
    $subtotal     = floatval($_POST['subtotal']);
    $vat          = floatval($_POST['vat']);
    $total        = floatval($_POST['total']);

    $sql = "INSERT INTO quotations (client_name, client_email, subtotal, vat, total, valid_until, status, created_at)
            VALUES ('$client_name', '$client_email', '$subtotal', '$vat', '$total', '$due_date', 'PENDING', NOW())";

    if ($conn->query($sql) === TRUE) {
        $quotation_id = $conn->insert_id;

        foreach ($_POST['description'] as $i => $desc) {
            $desc     = $conn->real_escape_string($desc);
            $quantity = (int) $_POST['quantity'][$i];
            $price    = (float) $_POST['price'][$i];
            $amount   = $quantity * $price;

            $conn->query("INSERT INTO quotation_items (quotation_id, description, quantity, price, amount) 
                          VALUES ($quotation_id, '$desc', $quantity, $price, $amount)");
        }

        echo "<script>
                alert('✅ Quotation created successfully!');
                window.location.href='all_quotations.php';
              </script>";
    } else {
        echo '❌ Error: ' . $conn->error;
    }
}
?>
