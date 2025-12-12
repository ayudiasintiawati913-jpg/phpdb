<?php
include_once("config.php");

// jenis kelamin count
$res = mysqli_query($mysqli, "SELECT jeniskelamin, COUNT(*) as cnt FROM mahasiswati GROUP BY jeniskelamin");
$gLabels = []; $gData = [];
while($r = mysqli_fetch_assoc($res)){ $gLabels[] = $r['jeniskelamin']; $gData[] = (int)$r['cnt']; }

// sekolah top
$res2 = mysqli_query($mysqli, "SELECT asalsekolah, COUNT(*) as cnt FROM mahasiswati GROUP BY asalsekolah ORDER BY cnt DESC LIMIT 8");
$sLabels = []; $sData = [];
while($r = mysqli_fetch_assoc($res2)){ $sLabels[] = $r['asalsekolah']; $sData[] = (int)$r['cnt']; }
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Statistik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body{ background: linear-gradient(135deg,#ffe6f7,#ffd1ec); font-family:'Poppins',sans-serif; }
    .card{ border-radius:16px; box-shadow:0 10px 30px rgba(255,105,180,0.12); }
    .btn-pink{ background: linear-gradient(90deg,#ff4fa6,#ff66b3); color:#fff; border:none;}
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0"><i class="bi bi-bar-chart-line"></i> Statistik</h3>
      <a href="index.php" class="btn btn-light">Kembali</a>
    </div>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="card p-3">
          <h5>Distribusi Jenis Kelamin</h5>
          <canvas id="genderChart"></canvas>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-3">
          <h5>Top Sekolah Asal</h5>
          <canvas id="schoolChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
      type:'doughnut',
      data:{
        labels: <?php echo json_encode($gLabels); ?>,
        datasets:[{
          data: <?php echo json_encode($gData); ?>,
          backgroundColor: ['#ffae88ff','#ff4fa6','#ffd0e6'],
          hoverOffset:8
        }]
      }
    });

    const schoolCtx = document.getElementById('schoolChart').getContext('2d');
    new Chart(schoolCtx, {
      type:'bar',
      data:{
        labels: <?php echo json_encode($sLabels); ?>,
        datasets:[{
          label:'Jumlah',
          data: <?php echo json_encode($sData); ?>,
          backgroundColor:'#ff66b3'
        }]
      },
      options:{ scales:{ y:{ beginAtZero:true } } }
    });
  </script>
</body>
</html>
