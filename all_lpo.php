<?php
session_start();
include("connection.php");

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM lpos WHERE id=$id");
    echo "<script>alert('LPO deleted successfully!'); window.location='all_lpos.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All LPOs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("admin_navbar.php"); ?>

<div class="container mt-5 pt-4">
  <h2 class="mb-4">All Local Purchase Orders (LPOs)</h2>
  <a href="create_lpo.php" class="btn btn-success btn-sm mb-3">+ New LPO</a>
  
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Supplier</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Delivery Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM lpos ORDER BY id ASC");
      while ($row = $result->fetch_assoc()):
   
      ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo ($row['supplier_name']); ?></td>
          <td><?php echo ($row['supplier_email']); ?></td>
          <td><?php echo $row['created_at']; ?></td>
          <td><?php echo $row['delivery_date']; ?></td>
          <td>
            <a href="lpo_pdf.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn btn-primary btn-sm">PDF</a>
            <a href="edit_lpo.php?id=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>

            <a href="delete_lpo.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Delete this LPO?')" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
