<?php
include("connection.php");
include("mailer.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Find admin by email
    $result = $conn->query("SELECT * FROM admins WHERE email='$email' LIMIT 1");
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $conn->query("UPDATE admins SET reset_token='$token', reset_expires='$expires' WHERE email='$email'");

        $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;

        if (sendResetEmail($email, $resetLink)) {
            $message = "✅ A password reset link has been sent to your email.";
        } else {
            $message = "❌ Failed to send email. Please contact support.";
        }
    } else {
        $message = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <h3 class="mb-3 text-center">Forgot Password</h3>
          <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>
          <form method="POST">
            <div class="mb-3">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Send Reset Link</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
