<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN UNDUH DATA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #dcdcdc;
      font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
      background-color: #fff;
      color: #000;
      min-height: 100vh;
      padding: 1rem;
      border-right: 1px solid #ccc;
    }
    .sidebar a {
      color:  #000000;
      text-decoration: none;
      display: block;
      margin: 1rem 0;
    }
    .sidebar a:hover {
      background-color: #f0f0f0;
      padding-left: 10px;
      transition: 0.3s;
    }
     .sidebar-logo {
      border-bottom: 2px solid #ccc;
      padding-bottom: 1rem;
      margin-bottom: 1rem;
    }

    .topbar {
      background-color: #028a0f;
      color: white;
      padding: 1rem 1.5rem;
      line-height: 1.3;
      position: relative;
      z-index: 10;
    }
    .dropdown-toggle {
      border: 1px solid white;
      padding: 4px 12px;
      background-color: transparent;
      color: white;
      border-radius: 20px;
      font-size: 0.9rem;
    }
    .table-container {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
    }
    table thead {
      background-color: #eafaf7;
    }
    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    table tbody tr:hover {
      background-color: #e1f7f2;
    }
    .pdf-icon {
      color: red;
      font-size: 1.2rem;
    }
    .download-icon {
      color: green;
      font-size: 1.3rem;
    }
    .btn-green {
      background-color: #00c58e;
      color: white;
      font-weight: bold;
      border-radius: 20px;
      padding: 0.3rem 1.5rem;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar">
      <div class="sidebar-logo text-center">
        <img src="<?= base_url('assets/Kabupatensukabumi.png') ?>" alt="logo" class="img-fluid mb-2" width="100">
      </div>
      <h5 class="fw-bold">EWS Sukabumi</h5>
      <a href="<?= base_url('admin/home') ?>">🏠 Home</a>
      <a href="<?= base_url('admin/download') ?>">⬇️ Download</a>
      <a href="<?= base_url('admin/inputadmin') ?>">✍️ Input</a>
      <a href="<?= base_url('admin/riwayatinput') ?>">📄 Riwayat Input</a>
      <a href="<?= base_url('logout') ?>">🚪 Logout</a>
      <hr>
      <p style="font-size: 0.85rem;">Platform ini dirancang untuk memberikan informasi waktu nyata tentang fluktuasi harga pangan...</p>
    </div>

    <!-- Main Content -->
    <div class="col-md-10">
      <div class="topbar d-flex justify-content-between align-items-center">
        <h5 class="m-0">HALAMAN UNDUH DATA</h5>
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= session('admin_nama') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">🚪 Logout</a></li>
          </ul>
        </div>
      </div>

      <!-- Filter Tahun -->
      <div class="d-flex align-items-center mt-3 mb-3">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary me-3">⬅ KEMBALI</a>
        <form action="<?= base_url('unduh') ?>" method="get" class="d-flex align-items-center">
          <label class="me-2 fw-semibold">TAHUN :</label>
          <select name="tahun" class="form-select w-auto">
            <?php for ($t = 2025; $t <= date('Y'); $t++): ?>
              <option value="<?= $t ?>" <?= ($tahun ?? date('Y')) == $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endfor; ?>
          </select>
          <button class="btn btn-success ms-2">Tampilkan</button>
        </form>
      </div>

      <!-- Tabel Data -->
     <div class="container mt-4">
  <div class="p-4 bg-white rounded shadow">
    <h4 class="fw-bold mb-4">Daftar Periode Bulan</h4>

    <div class="row g-4">
      <?php foreach ($bulanData as $i => $item): ?>
        <div class="col-md-4">
          <div class="card shadow-sm border-0 p-3 h-100" style="background-color: #dcdcdc">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="fw-semibold mb-1"><?= $item['nama_bulan'] ?> <?= $tahun ?></h5>
                <span class="<?= $item['status'] == 'Lengkap' ? 'text-success' : 'text-danger' ?>">
                  <?= $item['status'] ?>
                </span>
              </div>
              <div style="font-size: 1.5rem;">📄</div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
              <?php if ($item['status'] == 'Lengkap'): ?>
                <a href="<?= base_url('admin/downloadPDF/' . $item['bulan'] . '/' . $tahun) ?>" class="btn btn-success btn-sm">⬇️ Unduh PDF</a>
              <?php else: ?>
                <span class="text-muted">Belum tersedia</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>