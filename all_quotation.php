<?php
include("connection.php");

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM quotations WHERE id=$id");
    echo "<script>alert('Quotation deleted successfully!'); window.location='all_quotations.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Quotations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("admin_navbar.php"); ?>

<div class="container mt-5 pt-4">
  <h2 class="mb-4">All Quotations</h2>
  <a href="create_quotation.php" class="btn btn-success btn-sm mb-3">+ New Quotation</a>
  
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Valid Until</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM quotations ORDER BY id ASC");
      while ($row = $result->fetch_assoc()):
         
      ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo ($row['client_name']); ?></td>
          <td><?php echo ($row['client_email']); ?></td>
          <td><?php echo $row['created_at']; ?></td>
          <td><?php echo $row['valid_until']; ?></td>
          <td><?php echo $row['status']; ?></td>
          <td>
            <a href="quotation.php?id=<?php echo $qid; ?>" target="_blank" class="btn btn-primary btn-sm">PDF</a>
            <a href="edit_quotation.php?id=<?php echo $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>

            <a href="delete_quotation.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Delete this quotation?')" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
