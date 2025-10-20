<?php
include("connection.php");
session_start();

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM descriptions WHERE id=$id");
    echo "<script>alert('Description deleted successfully!'); window.location='manage_descriptions.php';</script>";
    exit;
}

// Handle add / update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    
    if (!empty($_POST['id'])) {
        // Update existing description
        $id = (int) $_POST['id'];
        $conn->query("UPDATE descriptions SET name='$name', price=$price WHERE id=$id");
        echo "<script>alert('Description updated successfully!'); window.location='manage_descriptions.php';</script>";
        exit;
    } else {
        // Add new description
        $conn->query("INSERT INTO descriptions (name, price) VALUES ('$name', $price)");
        echo "<script>alert('New description added successfully!'); window.location='manage_descriptions.php';</script>";
        exit;
    }
}

// Fetch descriptions
$descriptions = $conn->query("SELECT * FROM descriptions ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Descriptions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("admin_navbar.php"); ?>

<div class="container mt-5 pt-4">
  <h2 class="mb-4">Manage Descriptions</h2>

  <!-- Add / Edit Form -->
  <form method="POST" class="card p-4 mb-4 shadow-sm">
    <input type="hidden" name="id" id="desc_id">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Description Name</label>
        <input type="text" name="name" id="desc_name" class="form-control" required>
      </div>
      <div class="col-md-4 mb-3">
        <label class="form-label">Price (KES)</label>
        <input type="number" name="price" id="desc_price" class="form-control" step="0.01" required>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100" id="formBtn">Add</button>
      </div>
    </div>
  </form>

  <!-- Descriptions Table -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price (KES)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $descriptions->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= number_format($row['price'], 2) ?></td>
          <td>
            <button class="btn btn-warning btn-sm" onclick="editDescription(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', <?= $row['price'] ?>)">Edit</button>
            <a href="manage_descriptions.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this description?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
function editDescription(id, name, price) {
  document.getElementById('desc_id').value = id;
  document.getElementById('desc_name').value = name;
  document.getElementById('desc_price').value = price;
  document.getElementById('formBtn').textContent = 'Update';
}
</script>

</body>
</html>
