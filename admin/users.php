<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['admin'])) header('Location: login.php');

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])) {
    if($_POST['action']==='add') {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $conn->query("INSERT INTO users (name,email) VALUES ('{$name}','{$email}')");
        $conn->query("INSERT INTO logs (action) VALUES ('Added user {$name}')");
        header('Location: users.php'); exit;
    }
    if($_POST['action']==='block') {
        $id = intval($_POST['id']);
        $conn->query("UPDATE users SET status='blocked' WHERE id={$id}");
        $conn->query("INSERT INTO logs (action) VALUES ('Blocked user id {$id}')");
        header('Location: users.php'); exit;
    }
}

$res = $conn->query('SELECT * FROM users ORDER BY id DESC');
include __DIR__ . '/../includes/header.php';
?>
<h3>Manage Users</h3>
<div class="card mb-3 p-3">
  <form method="post" class="row g-2">
    <input type="hidden" name="action" value="add">
    <div class="col-md-4"><input class="form-control" name="name" placeholder="Name" required></div>
    <div class="col-md-4"><input class="form-control" name="email" placeholder="Email"></div>
    <div class="col-md-4"><button class="btn btn-primary">Add User</button></div>
  </form>
</div>
<div class="card p-3">
  <div class="table-responsive">
    <table class="table">
      <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <?php while($r=$res->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($r['name']); ?></td>
            <td><?php echo htmlspecialchars($r['email']); ?></td>
            <td><?php echo htmlspecialchars($r['status']); ?></td>
            <td>
              <?php if($r['status']!='blocked'): ?>
                <form method="post" style="display:inline">
                  <input type="hidden" name="action" value="block">
                  <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                  <button class="btn btn-sm btn-danger">Block</button>
                </form>
              <?php else: ?> <span class="text-muted small">Blocked</span> <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>