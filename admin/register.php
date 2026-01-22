<?php
require_once __DIR__ . '/../config/db.php';
session_start();
$msg = '';
if (isset($_POST['register'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare('SELECT id FROM admins WHERE username=? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $msg = '<div class="alert alert-warning">Username already exists</div>';
    } else {
        $ins = $conn->prepare('INSERT INTO admins (username,password) VALUES (?,?)');
        $ins->bind_param('ss', $username, $password);
        if ($ins->execute()) {
            $msg = '<div class="alert alert-success">Account created. <a href="login.php">Login</a></div>';
        } else {
            $msg = '<div class="alert alert-danger">Failed to create account</div>';
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Create Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>Create Admin Account</h5>
          <?= $msg ?>
          <form method="post">
            <div class="mb-2"><input name="username" class="form-control" placeholder="username" required></div>
            <div class="mb-2"><input type="password" name="password" class="form-control" placeholder="password" required></div>
            <div class="d-grid"><button class="btn btn-primary" name="register">Create Account</button></div>
          </form>
          <div class="mt-3 small"><a href="login.php">Already have account? Login</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
</body></html>