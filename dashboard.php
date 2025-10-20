<?php
include("connection.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="admin.css" rel="stylesheet">
  
</head>
<body class="bg-light">

<?php include("admin_navbar.php"); ?>
<div class="container py-5">

  <p class="lead">Choose an action:</p>
  <a href="invoice_form.php" class="btn btn-success mb-2"> Create New Invoice</a>
  <a href="invoices.php" class="btn btn-primary mb-2"> View All Invoices</a>
  <a href="all_quotation.php" class="btn btn-primary mb-2"> View All Quotations</a>
  <a href="all_lpo.php" class="btn btn-primary mb-2"> View All LPOs</a>

</div>


</body>
</html>
