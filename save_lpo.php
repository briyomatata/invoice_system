<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $supplier_name  = $conn->real_escape_string($_POST['supplier_name']);
    $supplier_email = $conn->real_escape_string($_POST['supplier_email']);
    $due_date       = $conn->real_escape_string($_POST['due_date']);
    $vat            = floatval($_POST['vat']);
    $total          = floatval($_POST['total']);

    // Insert into LPO table
    $sql = "INSERT INTO lpos (supplier_name, supplier_email, delivery_date, status, created_at)
            VALUES ('$supplier_name', '$supplier_email',  '$due_date', 'PENDING', NOW())";

    if ($conn->query($sql) === TRUE) {
        $lpo_id = $conn->insert_id;

        // Insert line items
        foreach ($_POST['description'] as $i => $desc) {
            $desc     = $conn->real_escape_string($_POST['description'][$i]);
            $quantity = (int) $_POST['quantity'][$i];
            $price    = (float) $_POST['price'][$i];
            $amount   = $quantity * $price;

            $conn->query("INSERT INTO lpo_items (lpo_id, description, quantity, price, amount)
                          VALUES ($lpo_id, '$desc', $quantity, $price, $amount)");
        }

        echo "<script>
                alert('✅ LPO created successfully!');
                window.location.href='all_lpo.php';
              </script>";
    } else {
        echo '❌ Error: ' . $conn->error;
    }
}
?>
