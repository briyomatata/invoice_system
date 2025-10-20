<?php include("connection.php");
$descResult = $conn->query("SELECT * FROM descriptions"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("admin_navbar.php"); ?>

<div class="container py-5">
  <h2 class="py-4">Create New Invoice</h2>
  <form action="save_invoice.php" method="POST" class="card p-4 shadow-sm bg-white" id="invoiceForm">

    <div class="mb-3">
      <label class="form-label">Client Name</label>
      <input type="text" class="form-control" name="client_name" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Client Email</label>
      <input type="email" class="form-control" name="client_email" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Due Date</label>
      <input type="date" class="form-control" name="due_date" required>
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
        <tr>
          <td>
            <select name="description[]" class="form-select descSelect" onchange="setPrice(this)" required>
              <option value="">-- Select Item --</option>
              <?php while($row = $descResult->fetch_assoc()): ?>
                <option value="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>">
                  <?php echo $row['name']; ?>
                </option>
              <?php endwhile; ?>
            </select>
          </td>
          <td><input type="number" name="quantity[]" class="form-control qty" value="1" min="1" required></td>
          <td><input type="number" name="price[]" class="form-control rate" step="0.01" required></td>
          <td><input type="number" name="amount[]" class="form-control amount" readonly></td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
        </tr>
      </tbody>
    </table>

    <button type="button" class="btn btn-secondary btn-sm mb-3 d-block mx-auto" style="width:150px;" onclick="addRow()">Add Item</button>

    <!-- Totals Section -->
    <div class="text-end">
      <p><strong>Subtotal:</strong> KES <span id="subtotalText">0.00</span></p>
      <p><strong>VAT (16%):</strong> KES <span id="vatText">0.00</span></p>
      <p><strong>Total:</strong> KES <span id="totalText">0.00</span></p>
    </div>

    <!-- Hidden inputs to send totals to PHP -->
    <input type="hidden" name="subtotal" id="subtotal">
    <input type="hidden" name="vat" id="vat">
    <input type="hidden" name="total" id="total">

    <button type="submit" class="btn btn-primary btn-sm d-block mx-auto" style="width:150px;">Save Invoice</button>
  </form>
</div>

<script>
function addRow() {
  const table = document.querySelector("#itemsTable tbody");
  const newRow = table.rows[0].cloneNode(true);
  newRow.querySelector(".descSelect").selectedIndex = 0;
  newRow.querySelector(".qty").value = 1;
  newRow.querySelector(".rate").value = "";
  newRow.querySelector(".amount").value = "";
  table.appendChild(newRow);
}

function removeRow(btn) {
  const table = document.querySelector("#itemsTable tbody");
  if (table.rows.length > 1) btn.closest("tr").remove();
  calculateTotals();
}

function setPrice(select) {
  const row = select.closest("tr");
  const price = parseFloat(select.options[select.selectedIndex].getAttribute("data-price")) || 0;
  row.querySelector(".rate").value = price;
  updateRowAmount(row);
}

document.addEventListener("input", (e) => {
  if (e.target.classList.contains("qty") || e.target.classList.contains("rate")) {
    const row = e.target.closest("tr");
    updateRowAmount(row);
  }
});

function updateRowAmount(row) {
  const qty = parseFloat(row.querySelector(".qty").value) || 0;
  const rate = parseFloat(row.querySelector(".rate").value) || 0;
  row.querySelector(".amount").value = (qty * rate).toFixed(2);
  calculateTotals();
}

function calculateTotals() {
  let subtotal = 0;
  document.querySelectorAll(".amount").forEach(a => {
    subtotal += parseFloat(a.value) || 0;
  });
  const vat = subtotal * 0.16;
  const total = subtotal + vat;

  document.getElementById("subtotalText").textContent = subtotal.toFixed(2);
  document.getElementById("vatText").textContent = vat.toFixed(2);
  document.getElementById("totalText").textContent = total.toFixed(2);

  document.getElementById("subtotal").value = subtotal.toFixed(2);
  document.getElementById("vat").value = vat.toFixed(2);
  document.getElementById("total").value = total.toFixed(2);
}
</script>

</body>
</html>
