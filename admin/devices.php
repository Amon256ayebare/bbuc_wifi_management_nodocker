<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['admin'])) header('Location: login.php');

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])) {
    if($_POST['action']==='add') {
        $name = $conn->real_escape_string($_POST['device_name']);
        $mac = $conn->real_escape_string($_POST['mac_address']);
        $ip = $conn->real_escape_string($_POST['ip_address']);
        $zone = $conn->real_escape_string($_POST['zone']);
        $bw = floatval($_POST['bandwidth']);
        $stmt = $conn->prepare('INSERT INTO devices (device_name,mac_address,ip_address,zone,bandwidth) VALUES (?,?,?,?,?)');
        $stmt->bind_param('ssssd',$name,$mac,$ip,$zone,$bw); $stmt->execute();
        $conn->query("INSERT INTO logs (action) VALUES ('Added device {$name}')");
        header('Location: devices.php'); exit;
    }
    if($_POST['action']==='toggle') {
        $id = intval($_POST['id']);
        $r = $conn->query("SELECT status,device_name FROM devices WHERE id={$id}")->fetch_assoc();
        if($r) {
            $new = ($r['status']=='active') ? 'blocked' : 'active';
            $u = $conn->prepare('UPDATE devices SET status=? WHERE id=?'); $u->bind_param('si',$new,$id); $u->execute();
            $conn->query("INSERT INTO logs (action) VALUES ('Device {$r['device_name']} set to {$new}')");
        }
        header('Location: devices.php'); exit;
    }
}

$res = $conn->query('SELECT * FROM devices ORDER BY id DESC');
$zonesRes = $conn->query('SELECT zone_name FROM zones');
$zones=[]; while($z=$zonesRes->fetch_assoc()) $zones[]=$z['zone_name'];
include __DIR__ . '/../includes/header.php';
?>
<h3>Devices</h3>
<div class="card mb-3 p-3">
  <form method="post" class="row g-2">
    <input type="hidden" name="action" value="add">
    <div class="col-md-3"><input class="form-control" name="device_name" placeholder="Device name" required></div>
    <div class="col-md-2"><input class="form-control" name="mac_address" placeholder="MAC"></div>
    <div class="col-md-2"><input class="form-control" name="ip_address" placeholder="IP"></div>
    <div class="col-md-2"><input class="form-control" name="zone" placeholder="Zone"></div>
    <div class="col-md-1"><input class="form-control" name="bandwidth" placeholder="BW" type="number" step="0.1"></div>
    <div class="col-md-2"><button class="btn btn-primary">Add Device</button></div>
  </form>
</div>
<div class="card p-3">
  <div class="table-responsive">
    <table class="table">
      <thead><tr><th>Name</th><th>MAC</th><th>IP</th><th>Zone</th><th>BW</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <?php while($d=$res->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($d['device_name']); ?></td>
            <td><?php echo htmlspecialchars($d['mac_address']); ?></td>
            <td><?php echo htmlspecialchars($d['ip_address']); ?></td>
            <td><?php echo htmlspecialchars($d['zone']); ?></td>
            <td><?php echo htmlspecialchars($d['bandwidth']); ?></td>
            <td><?php echo htmlspecialchars($d['status']); ?></td>
            <td>
              <form method="post" style="display:inline">
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                <button class="btn btn-sm <?php echo $d['status']=='active'?'btn-danger':'btn-success' ?>">
                  <?php echo $d['status']=='active'?'Block':'Unblock'; ?>
                </button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>