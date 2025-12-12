<?php
include_once("config.php");

// ambil semua data
$res = mysqli_query($mysqli, "SELECT * FROM mahasiswati ORDER BY no DESC");
$rows = [];
while($r = mysqli_fetch_assoc($res)) $rows[] = $r;
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Data Mahasiswa — Pink Glamour</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- AOS (animasi) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* SUPER ESTHETIC PINK THEME */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg,#ffe6f7,#ffd1ec,#ffc2e7);
      min-height: 100vh;
      padding-bottom: 60px;
    }

    /* decorative bubbles */
    .bubble {
      position: absolute;
      border-radius: 50%;
      filter: blur(40px);
      opacity: 0.35;
      z-index: 0;
    }
    .bubble.one { width: 260px; height: 260px; background: #ff9ad0; top: -40px; left: -40px; }
    .bubble.two { width: 320px; height: 320px; background: #ff79c2; bottom: -80px; right: -60px; }

    .card-pink {
      position: relative;
      z-index: 2;
      border-radius: 18px;
      background: rgba(255,255,255,0.55);
      backdrop-filter: blur(8px);
      padding: 20px;
      box-shadow: 0 10px 30px rgba(255,105,180,0.18);
      border: 1px solid rgba(255,120,170,0.14);
    }

    .search-box {
      position: relative;
      max-width: 520px;
    }
    .search-box input {
      padding-left: 48px;
      border-radius: 30px;
      border: 3px solid #ff99cc;
      background: rgba(255,255,255,0.8);
      box-shadow: 0 8px 18px rgba(255,125,195,0.18);
    }
    .search-icon {
      position: absolute;
      top: 10px; left: 14px; color: #ff47a8; font-size: 20px;
    }

    .btn-pink {
      background: linear-gradient(90deg,#ff4fa6,#ff66b3);
      color: #fff; border-radius: 24px; border: none;
      box-shadow: 0 8px 24px rgba(255,105,180,0.18);
    }
    .btn-pink:hover { transform: translateY(-3px); }

    .table-wrap {
      border-radius: 16px;
      overflow: hidden;
      background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
      border: 1px solid rgba(255,153,204,0.2);
    }

    table thead {
      background: linear-gradient(90deg,#ff99d9,#ffb3df);
      color: #fff;
    }
    table tbody tr { background: rgba(255,255,255,0.6); }
    table tbody tr:hover { background: #fff0f8; transform: scale(1.005); }

    .profile-icon { font-size: 56px; color: #ff4fa6; }

    .modal-content {
      border-radius: 20px; border: 3px solid rgba(255,153,204,0.5);
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(8px);
    }

    .badge-jk { border-radius: 999px; background: #ffb3d9; color: #fff; padding: 6px 10px; font-weight:600; }

    .small-muted { color: #6c6c6c; }
  </style>
</head>
<body>

  <div class="bubble one"></div>
  <div class="bubble two"></div>

  <div class="container py-5">
    <div class="card-pink mx-auto" data-aos="fade-up">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h3 class="mb-0 text-dark"><i class="bi bi-people-fill"></i> Data Mahasiswa</h3>
          <small class="small-muted">Sistem CRUD — Pink Glamour UI</small>
        </div>

        <div class="d-flex gap-2">
          <a href="dashboard.php" class="btn btn-light"><i class="bi bi-bar-chart-line"></i> Statistik</a>
          <a href="add.php" class="btn btn-pink"><i class="bi bi-person-plus"></i> Tambah</a>
        </div>
      </div>

      <!-- controls -->
      <div class="row g-3 mb-3 align-items-center">
        <div class="col-auto search-box">
          <i class="bi bi-search search-icon"></i>
          <input id="searchInput" class="form-control" placeholder="Cari nama / NIM / asal sekolah...">
        </div>

        <div class="col-auto">
          <select id="filterJK" class="form-select">
            <option value="">Semua Jenis Kelamin</option>
            <option value="laki-laki">Laki-Laki</option>
            <option value="perempuan">Perempuan</option>
          </select>
        </div>

        <div class="col text-end">
          <small class="small-muted me-2">Sort by:</small>
          <button class="btn btn-outline-dark btn-sm" onclick="sortTable('nim')">NIM</button>
          <button class="btn btn-outline-dark btn-sm" onclick="sortTable('nama')">Nama</button>
          <button class="btn btn-outline-dark btn-sm" onclick="sortTable('umur')">Umur</button>
        </div>
      </div>

      <!-- table -->
      <div class="table-wrap p-2" data-aos="fade-up" data-aos-delay="150">
        <div class="table-responsive">
          <table class="table align-middle text-center" id="dataTable">
            <thead>
              <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>Jenis Kelamin</th>
                <th>Asal Sekolah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <?php foreach($rows as $r): 
                $icon = ($r['jeniskelamin'] === 'perempuan') ? 'bi-gender-female' : 'bi-gender-male';
              ?>
                <tr>
                  <td class="col-no"><?php echo htmlspecialchars($r['no']); ?></td>
                  <td class="col-nim"><?php echo htmlspecialchars($r['nim']); ?></td>
                  <td class="col-nama text-start ps-3"><?php echo htmlspecialchars($r['nama']); ?></td>
                  <td class="col-umur"><?php echo htmlspecialchars($r['umur']); ?></td>
                  <td class="col-jk"><span class="badge-jk"><i class="bi <?php echo $icon; ?>"></i> <?php echo htmlspecialchars($r['jeniskelamin']); ?></span></td>
                  <td class="col-asal"><?php echo htmlspecialchars($r['asalsekolah']); ?></td>
                  <td>
                    <!-- View: modal -->
                    <button class="btn btn-sm btn-pink me-1 viewDetail"
                      data-nim="<?php echo htmlspecialchars($r['nim'], ENT_QUOTES); ?>"
                      data-nama="<?php echo htmlspecialchars($r['nama'], ENT_QUOTES); ?>"
                      data-umur="<?php echo htmlspecialchars($r['umur'], ENT_QUOTES); ?>"
                      data-jk="<?php echo htmlspecialchars($r['jeniskelamin'], ENT_QUOTES); ?>"
                      data-asal="<?php echo htmlspecialchars($r['asalsekolah'], ENT_QUOTES); ?>">
                      <i class="bi bi-eye-fill"></i>
                    </button>

                    <a href="edit.php?no=<?php echo $r['no']; ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>

                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $r['no']; ?>)"><i class="bi bi-trash-fill"></i></button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- pagination -->
        <nav class="mt-3">
          <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
      </div>

    </div>
  </div>

  <!-- detail modal (estetik) -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header border-0">
          <h5 class="modal-title"><i class="bi bi-person-heart"></i> Biodata Mahasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <i id="bioIcon" class="bi profile-icon"></i>
          <h4 id="bioNama" class="mt-2"></h4>
          <p class="small-muted">Mahasiswa</p>

          <div class="text-start mt-3 px-3">
            <p><strong>NIM:</strong> <span id="bioNim"></span></p>
            <p><strong>Umur:</strong> <span id="bioUmur"></span></p>
            <p><strong>Jenis Kelamin:</strong> <span id="bioJK"></span></p>
            <p><strong>Asal Sekolah:</strong> <span id="bioAsal"></span></p>
          </div>

          <div class="mt-3">
            <button class="btn btn-pink" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS: Bootstrap, AOS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>AOS.init();</script>

  <script>
    // DATA ROWS (DOM-based)
    const allRows = Array.from(document.querySelectorAll('#tableBody tr'));

    // SEARCH & FILTER
    const searchInput = document.getElementById('searchInput');
    const filterJK = document.getElementById('filterJK');

    function filterRows(){
      const q = searchInput.value.toLowerCase().trim();
      const jk = filterJK.value;
      const filtered = allRows.filter(tr => {
        const text = tr.innerText.toLowerCase();
        const matchQ = !q || text.includes(q);
        const matchJK = !jk || tr.querySelector('.col-jk').innerText.toLowerCase().includes(jk);
        return matchQ && matchJK;
      });
      currentRows = filtered;
      currentPage = 1;
      renderPage();
    }

    searchInput.addEventListener('input', filterRows);
    filterJK.addEventListener('change', filterRows);

    // SORTING client-side
    let sortKey = null;
    let sortDir = 1;
    function sortTable(key){
      sortKey = key;
      sortDir = -sortDir;
      currentRows.sort((a,b)=>{
        let va = '', vb = '';
        if(key === 'nim') { va = a.querySelector('.col-nim').innerText; vb = b.querySelector('.col-nim').innerText; }
        if(key === 'nama'){ va = a.querySelector('.col-nama').innerText; vb = b.querySelector('.col-nama').innerText; }
        if(key === 'umur'){ va = a.querySelector('.col-umur').innerText; vb = b.querySelector('.col-umur').innerText; }
        va = va.toLowerCase(); vb = vb.toLowerCase();
        if(!isNaN(va) && !isNaN(vb)) return (Number(va)-Number(vb))*sortDir;
        return (va>vb?1:-1)*sortDir;
      });
      renderPage();
    }

    // PAGINATION client-side
    const pageSize = 6;
    let currentRows = allRows.slice();
    let currentPage = 1;

    function renderPage(){
      const tbody = document.getElementById('tableBody');
      tbody.innerHTML = '';
      const start = (currentPage-1)*pageSize;
      const pageRows = currentRows.slice(start, start+pageSize);
      pageRows.forEach(r => tbody.appendChild(r));
      renderPagination();
    }

    function renderPagination(){
      const pages = Math.max(1, Math.ceil(currentRows.length / pageSize));
      const pg = document.getElementById('pagination');
      pg.innerHTML = '';
      for(let i=1;i<=pages;i++){
        const li = document.createElement('li');
        li.className = 'page-item ' + (i===currentPage ? 'active' : '');
        li.innerHTML = `<a class="page-link" href="#" onclick="goPage(${i});return false;">${i}</a>`;
        pg.appendChild(li);
      }
    }

    function goPage(n){ currentPage = n; renderPage(); }

    // initial render
    filterRows();

    // Modal show for biodata
    document.querySelectorAll('.viewDetail').forEach(btn => {
      btn.addEventListener('click', function(){
        const nim = this.dataset.nim;
        const nama = this.dataset.nama;
        const umur = this.dataset.umur;
        const jk = this.dataset.jk;
        const asal = this.dataset.asal;
        document.getElementById('bioNim').innerText = nim;
        document.getElementById('bioNama').innerText = nama;
        document.getElementById('bioUmur').innerText = umur;
        document.getElementById('bioJK').innerText = jk;
        document.getElementById('bioAsal').innerText = asal;
        const icon = document.getElementById('bioIcon');
        icon.className = 'bi ' + (jk === 'perempuan' ? 'bi-gender-female' : 'bi-gender-male') + ' profile-icon';
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
      });
    });

    // Delete confirm with SweetAlert2
    function confirmDelete(no){
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4fa6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!'
      }).then((result)=>{
        if(result.isConfirmed){
          window.location.href = 'delete.php?no=' + no;
        }
      });
    }
  </script>

</body>
</html>
