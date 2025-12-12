<?php
include_once("config.php");

if(isset($_POST['Submit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $asalsekolah = $_POST['asalsekolah'];

    mysqli_query($mysqli, "INSERT INTO mahasiswati(nim,nama,umur,jeniskelamin,asalsekolah) 
        VALUES('$nim','$nama','$umur','$jeniskelamin','$asalsekolah')");

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      Swal.fire({icon:'success',title:'Berhasil',text:'Data mahasiswa berhasil ditambahkan',confirmButtonColor:'#ff4fa6'}).then(()=>{window.location='index.php';});
    </script>";
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Mahasiswa — Pink Glamour</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(135deg,#ffe6f7,#ffd1ec,#ffc2e7); min-height:100vh; font-family:'Poppins',sans-serif; }
    .card-form { max-width:700px; margin:auto; border-radius:18px; padding:28px; background: rgba(255,255,255,0.6); box-shadow:0 10px 30px rgba(255,105,180,0.16); border:1px solid rgba(255,120,170,0.12);}
    .form-control { border-radius:20px; border:2px solid #ff99cc; background: rgba(255,255,255,0.8); }
    .form-control:focus { box-shadow:0 0 10px #ff99cc; border-color:#ff66b3; }
    .btn-pink { background: linear-gradient(90deg,#ff4fa6,#ff66b3); color:#fff; border:none; border-radius:24px; padding:10px 22px; box-shadow:0 8px 20px rgba(255,105,180,0.16);}
    .gender-icon { font-size:22px; color:#ff4fa6; margin-left:8px; }
    label { font-weight:600; }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card-form" data-aos="fade-up">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Tambah Mahasiswa</h4>
        <a href="index.php" class="btn btn-light"><i class="bi bi-arrow-left"></i> Kembali</a>
      </div>

      <form id="addForm" method="post" action="add.php" novalidate>
        <div class="row g-3">
          <div class="col-md-6">
            <label>NIM</label>
            <input name="nim" id="nim" class="form-control" required>
            <div class="invalid-feedback">NIM wajib diisi.</div>
          </div>
          <div class="col-md-6">
            <label>Nama</label>
            <input name="nama" id="nama" class="form-control" required>
            <div class="invalid-feedback">Nama wajib diisi.</div>
          </div>

          <div class="col-md-4">
            <label>Umur</label>
            <input name="umur" id="umur" class="form-control" required>
            <div class="invalid-feedback">Umur wajib diisi.</div>
          </div>

          <div class="col-md-4">
            <label>Jenis Kelamin</label>
            <div class="input-group">
              <select name="jeniskelamin" id="jeniskelamin" class="form-select" onchange="updateGenderIcon()" required>
                <option value="laki-laki">Laki-Laki</option>
                <option value="perempuan">Perempuan</option>
              </select>
              <span class="input-group-text bg-transparent border-0">
                <i id="genderIcon" class="bi bi-gender-male gender-icon"></i>
              </span>
            </div>
          </div>

          <div class="col-md-4">
            <label>Asal Sekolah</label>
            <input name="asalsekolah" id="asalsekolah" class="form-control" required>
            <div class="invalid-feedback">Asal sekolah wajib diisi.</div>
          </div>

          <div class="col-12 text-center mt-2">
            <button type="submit" name="Submit" class="btn btn-pink w-50"><i class="bi bi-save"></i> Simpan</button>
          </div>
        </div>
      </form>

    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>

<script>
  // gender icon update
  function updateGenderIcon(){
    const val = document.getElementById('jeniskelamin').value;
    const el = document.getElementById('genderIcon');
    el.className = 'bi ' + (val === 'perempuan' ? 'bi-gender-female' : 'bi-gender-male') + ' gender-icon';
  }
  updateGenderIcon();

  // simple realtime validation (only check empty)
  const addForm = document.getElementById('addForm');
  ['nim','nama','umur','asalsekolah'].forEach(id=>{
    const el = document.getElementById(id);
    el.addEventListener('input', ()=> {
      if(el.value.trim() === '') el.classList.add('is-invalid');
      else el.classList.remove('is-invalid');
    });
  });

  addForm.addEventListener('submit', function(e){
    let ok = true;
    ['nim','nama','umur','asalsekolah'].forEach(id=>{
      const el = document.getElementById(id);
      if(el.value.trim() === '') { el.classList.add('is-invalid'); ok = false; }
    });
    if(!ok) e.preventDefault();
  });
</script>
</body>
</html>
