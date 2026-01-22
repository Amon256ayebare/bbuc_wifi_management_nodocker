<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BBUC WiFi Management</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/bbuc_wifi_management_nodocker/assets/css/theme.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/bbuc_wifi_management_nodocker/admin/dashboard.php">BBUC WiFi Admin</a>
    <div>
      <?php if(isset($_SESSION['admin'])): ?>
        <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION['admin']); ?></span>
        <a href="/bbuc_wifi_management_nodocker/admin/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      <?php else: ?>
        <a href="/bbuc_wifi_management_nodocker/admin/login.php" class="btn btn-outline-light btn-sm">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 sidebar p-3">
      <h5 class="text-white">Menu</h5>
      <a href="/bbuc_wifi_management_nodocker/admin/dashboard.php">Dashboard</a>
      <a href="/bbuc_wifi_management_nodocker/admin/users.php">Users</a>
      <a href="/bbuc_wifi_management_nodocker/admin/devices.php">Devices</a>
      <a href="/bbuc_wifi_management_nodocker/admin/zones.php">Zones</a>
      <a href="/bbuc_wifi_management_nodocker/admin/bandwidth.php">Bandwidth</a>
    </div>
    <div class="col-md-10 p-4">