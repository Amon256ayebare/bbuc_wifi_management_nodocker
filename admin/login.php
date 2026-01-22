<?php
require_once __DIR__ . '/../config/db.php';
session_start();
$error = '';
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT password FROM admins WHERE username=? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $username;
            // log in logs table
            $ins = $conn->prepare('INSERT INTO logs (action) VALUES (?)');
            $m = "Admin $username logged in";
            $ins->bind_param('s', $m); $ins->execute();
            header('Location: dashboard.php'); exit;
        } else $error = 'Invalid credentials.';
    } else $error = 'Invalid credentials.';
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Admin Login</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>Admin Login</h5>
          <?php if($error) echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; ?>
          <form method="post">
            <div class="mb-2"><input name="username" class="form-control" placeholder="username" required></div>
            <div class="mb-2"><input type="password" name="password" class="form-control" placeholder="password" required></div>
            <div class="d-grid"><button class="btn btn-primary" name="login">Sign in</button></div>
          </form>
          <div class="mt-3 small"><a href="register.php">Create admin account</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
</body></html>