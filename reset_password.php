<?php
include("connection.php");

$message = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $conn->query("SELECT * FROM admins WHERE reset_token='$token' AND reset_expires > NOW() LIMIT 1");

    if ($result->num_rows == 0) {
        die("❌ Invalid or expired reset link.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hashing
        $conn->query("UPDATE admins SET password='$newPassword', reset_token=NULL, reset_expires=NULL WHERE reset_token='$token'");
        $message = "✅ Password reset successful! <a href='login.php'>Login here</a>";
    }
} else {
    die("❌ No reset token provided.");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <h3 class="mb-3 text-center">Reset Password</h3>
          <?php if ($message) echo "<div class='alert alert-success'>$message</div>"; ?>
          <form method="POST">
            <div class="mb-3">
              <label>New Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
