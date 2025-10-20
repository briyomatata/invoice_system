<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoices</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("admin_navbar.php"); ?>

<div class="container py-5">
  <h2 class="py-4">All Invoices</h2>
  <a href="invoice_form.php" class="btn btn-success mb-3">+ Create New Invoice</a>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Email</th>
        <th>Status</th>
        <th>Due Date</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
     $result = $conn->query("SELECT * FROM invoices ORDER BY id ASC");
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['client_name']; ?></td>
        <td><?= $row['client_email']; ?></td>
   
        <td><?= ucfirst($row['status']); ?></td>
        <td><?= $row['due_date']; ?></td>
        <td><?= $row['created_at']; ?></td>
<td>
  <a href="generate_pdf.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">Download PDF</a>
   <a href="edit_invoice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete_invoice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?');">Delete</a>
</td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
