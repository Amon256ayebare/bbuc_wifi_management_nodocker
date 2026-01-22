<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['admin'])) header('Location: login.php');
// assemble bandwidth array from devices.bandwidth or sample
$res = $conn->query('SELECT bandwidth FROM devices');
$bands = [];
while($r=$res->fetch_assoc()) $bands[] = floatval($r['bandwidth']);
if(count($bands)==0) $bands=[120,90,70,150,240,300,360,320,280,400,330,180];
include __DIR__ . '/../includes/header.php';
?>
<h3>Bandwidth (24h sample)</h3>
<div class="card p-3">
  <canvas id="bwChart" height="120"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('bwChart').getContext('2d');
const labels = ['00:00','02:00','04:00','06:00','08:00','10:00','12:00','14:00','16:00','18:00','20:00','22:00'];
const data = {
  labels: labels,
  datasets: [{ label: 'Bandwidth (Mbps)', data: <?php echo json_encode(array_slice(array_pad($bands,12,0),0,12)); ?>, fill:true, tension:0.4, borderColor:'#4F46E5', backgroundColor:'rgba(79,70,229,0.12)'}]
};
new Chart(ctx,{type:'line',data:data,options:{responsive:true}});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>