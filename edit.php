<?php
include_once("config.php");

if(isset($_POST['update'])) 
{
    $no = intval($_POST['no']);
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $asalsekolah = $_POST['asalsekolah'];

    mysqli_query($mysqli, "UPDATE mahasiswati SET nim='$nim', nama='$nama', umur='$umur', jeniskelamin='$jeniskelamin', asalsekolah='$asalsekolah' WHERE no=$no");

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon:'success',
            title:'Berhasil',
            text:'Data diperbarui',
            confirmButtonColor:'#ff4fa6'
        }).then(()=>{ window.location='index.php'; });
    </script>";
    exit;
}

/* ===== FIX ERROR UNDEFINED 'no' ===== */
if (!isset($_GET['no'])) {
    echo "<script>alert('Parameter NO tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$no = intval($_GET['no']);
$res = mysqli_query($mysqli, "SELECT * FROM mahasiswati WHERE no=$no");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan di database!'); window.location='index.php';</script>";
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Edit Mahasiswa — Pink Glamour</title>

  <!-- Favicon Bootstrap -->
  <link rel="icon" href="https://icons.getbootstrap.com/assets/icons/bootstrap-fill.svg">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { 
      background: linear-gradient(135deg,#ffe6f7,#ffd1ec); 
      font-family:'Poppins',sans-serif; 
      padding-bottom:60px;
    }
    .card-edit{ 
      max-width:720px; 
      margin:auto; 
      padding:24px; 
      border-radius:16px; 
      background: rgba(255,255,255,0.6); 
      box-shadow:0 10px 30px rgba(255,105,180,0.12);
    }
    .form-control{ 
      border-radius:12px; 
      border:2px solid #ff99cc; 
    }
    .btn-pink{ 
      background: linear-gradient(90deg,#ff4fa6,#ff66b3); 
      color:#fff; 
      border:none; 
      border-radius:22px;
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="card-edit" data-aos="fade-up">

      <div class="d-flex justify-content-between mb-3 align-items-center">
        <h4 class="m-0"><i class="bi bi-bootstrap-fill text-primary"></i> Edit Mahasiswa</h4>
        <a href="index.php" class="btn btn-light">Kembali</a>
      </div>

      <form id="editForm" method="post" action="edit.php">
        <input type="hidden" name="no" value="<?php echo $data['no']; ?>">

        <div class="row g-3">
          <div class="col-md-6">
            <label>NIM</label>
            <input name="nim" id="nim" value="<?php echo htmlspecialchars($data['nim']); ?>" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label>Nama</label>
            <input name="nama" id="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label>Umur</label>
            <input name="umur" id="umur" value="<?php echo htmlspecialchars($data['umur']); ?>" class="form-control" required>
          </div>

          <div class="col-md-4">
            <label>Jenis Kelamin</label>
            <select name="jeniskelamin" id="jeniskelamin" class="form-select" required>
              <option value="laki-laki" <?php if($data['jeniskelamin']=='laki-laki') echo 'selected'; ?>>Laki-Laki</option>
              <option value="perempuan" <?php if($data['jeniskelamin']=='perempuan') echo 'selected'; ?>>Perempuan</option>
            </select>
          </div>

          <div class="col-md-4">
            <label>Asal Sekolah</label>
            <input name="asalsekolah" id="asalsekolah" value="<?php echo htmlspecialchars($data['asalsekolah']); ?>" class="form-control" required>
          </div>

          <div class="col-12 text-center mt-2">
            <button type="submit" name="update" class="btn btn-pink w-50">
              <i class="bi bi-save"></i> Update
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>