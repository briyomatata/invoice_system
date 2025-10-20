<?php
include("connection.php");

if (!isset($_GET['id'])) die("Invoice ID missing.");
$id = (int)$_GET['id'];

// Fetch invoice
$invoice = $conn->query("SELECT * FROM invoices WHERE id = $id")->fetch_assoc();
if (!$invoice) die("Invoice not found.");

// Fetch invoice items
$items = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include("admin_navbar.php"); ?>

<div class="container py-5">
  <h2 class="py-4">Edit Invoice #<?= $id ?></h2>
  <form action="update_invoice.php" method="POST" class="card p-4 shadow-sm bg-white">
    <input type="hidden" name="id" value="<?= $id ?>">

    <div class="mb-3">
      <label class="form-label">Client Name</label>
      <input type="text" name="client_name" value="<?= htmlspecialchars($invoice['client_name']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Client Email</label>
      <input type="email" name="client_email" value="<?= htmlspecialchars($invoice['client_email']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Due Date</label>
      <input type="date" name="due_date" value="<?= $invoice['due_date'] ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="UNPAID" <?= $invoice['status']=='UNPAID'?'selected':'' ?>>Unpaid</option>
        <option value="PAID" <?= $invoice['status']=='PAID'?'selected':'' ?>>Paid</option>
      </select>
    </div>

    <h4>Invoice Items</h4>
    <table class="table table-bordered" id="itemsTable">
      <thead>
        <tr>
          <th>Description</th>
          <th>Qty</th>
          <th>Rate (KES)</th>
          <th>Amount (KES)</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $items->fetch_assoc()): ?>
        <tr>
          <td>
            <input type="hidden" name="item_id[]" value="<?= $row['id'] ?>">
            <input type="text" name="description[]" value="<?= htmlspecialchars($row['description']) ?>" class="form-control" required>
          </td>
          <td><input type="number" name="quantity[]" value="<?= $row['quantity'] ?>" class="form-control qty" required></td>
          <td><input type="number" name="price[]" value="<?= $row['price'] ?>" class="form-control rate" step="0.01" required></td>
          <td><input type="number" name="amount[]" value="<?= $row['amount'] ?>" class="form-control amount" readonly></td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <button type="button" class="btn btn-secondary btn-sm" onclick="addRow()">Add Item</button>
    <button type="submit" class="btn btn-primary float-end">Update Invoice</button>

  </form>
</div>

<script>
function addRow() {
  const table = document.querySelector("#itemsTable tbody");
  const row = document.createElement("tr");
  row.innerHTML = `
    <td><input type="hidden" name="item_id[]" value="0">
        <input type="text" name="description[]" class="form-control" required></td>
    <td><input type="number" name="quantity[]" value="1" class="form-control qty" required></td>
    <td><input type="number" name="price[]" value="0" class="form-control rate" step="0.01" required></td>
    <td><input type="number" name="amount[]" value="0" class="form-control amount" readonly></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
  `;
  table.appendChild(row);
}

function removeRow(btn) {
  const row = btn.closest("tr");
  row.remove();
}

document.addEventListener('input', function(e){
  if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
    const row = e.target.closest('tr');
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const rate = parseFloat(row.querySelector('.rate').value) || 0;
    row.querySelector('.amount').value = (qty * rate).toFixed(2);
  }
});
</script>
</body>
</html>

