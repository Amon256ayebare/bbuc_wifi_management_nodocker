<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['admin'])) header('Location: login.php');

$activeUsers = $conn->query("SELECT COUNT(*) as c FROM users WHERE status='active'")->fetch_assoc()['c'] ?? 0;
$connectedDevices = $conn->query("SELECT COUNT(*) as c FROM devices")->fetch_assoc()['c'] ?? 0;
$zones = $conn->query("SELECT COUNT(*) as c FROM zones")->fetch_assoc()['c'] ?? 0;
include __DIR__ . '/../includes/header.php';
?>
<h3 class="mb-4">Dashboard Overview</h3>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card p-3 shadow-sm">
      <div class="text-muted">Active Users</div>
      <h2><?php echo $activeUsers; ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3 shadow-sm">
      <div class="text-muted">Connected Devices</div>
      <h2><?php echo $connectedDevices; ?></h2>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3 shadow-sm">
      <div class="text-muted">Zones</div>
      <h2><?php echo $zones; ?></h2>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>