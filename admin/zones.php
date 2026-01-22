<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['admin'])) header('Location: login.php');
if($_SERVER['REQUEST_METHOD']==='POST') {
    if($_POST['action']==='add') {
        $name = $conn->real_escape_string($_POST['zone_name']); $clients = intval($_POST['clients']); $health = intval($_POST['health']);
        $stmt = $conn->prepare('INSERT INTO zones (zone_name,clients,health) VALUES (?,?,?)'); $stmt->bind_param('sii',$name,$clients,$health); $stmt->execute();
        $conn->query("INSERT INTO logs (action) VALUES ('Added zone {$name}')");
        header('Location: zones.php'); exit;
    }
    if($_POST['action']==='del') {
        $id = intval($_POST['id']); $n = $conn->query("SELECT zone_name FROM zones WHERE id={$id}")->fetch_assoc()['zone_name'] ?? 'zone';
        $d = $conn->prepare('DELETE FROM zones WHERE id=?'); $d->bind_param('i',$id); $d->execute();
        $conn->query("INSERT INTO logs (action) VALUES ('Deleted zone {$n}')");
        header('Location: zones.php'); exit;
    }
}
$res = $conn->query('SELECT * FROM zones ORDER BY id DESC');
include __DIR__ . '/../includes/header.php';
?>
<h3>Zones / Access Points</h3>
<div class="card mb-3 p-3">
  <form method="post" class="row g-2">
    <input type="hidden" name="action" value="add">
    <div class="col-md-5"><input class="form-control" name="zone_name" placeholder="Zone name" required></div>
    <div class="col-md-3"><input class="form-control" name="clients" placeholder="Clients" type="number"></div>
    <div class="col-md-2"><input class="form-control" name="health" placeholder="Health (%)" type="number"></div>
    <div class="col-md-2"><button class="btn btn-primary w-100">Add Zone</button></div>
  </form>
</div>
<div class="row g-3">
  <?php while($z=$res->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card p-3">
        <h5><?php echo htmlspecialchars($z['zone_name']); ?></h5>
        <p class="mb-1 small text-muted">Clients: <?php echo $z['clients']; ?></p>
        <p class="mb-1 small text-muted">Health: <?php echo $z['health']; ?>%</p>
        <form method="post">
          <input type="hidden" name="action" value="del">
          <input type="hidden" name="id" value="<?php echo $z['id']; ?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
  <?php endwhile; ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>