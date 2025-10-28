<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WARNING KEPALA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #dcdcdc;
    }
    .sidebar {
      background-color: #ffffff;
      color: #000000;
      min-height: 100vh;
      padding: 1rem;
      border-right: 1px solid #ddd;
    }
    .sidebar a {
      color: #000000;
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
    .scrolling-container {
      width: 100%;
      overflow: hidden;
      position: relative;
      height: 24px;
    }
    .scrolling-text {
      display: inline-block;
      white-space: nowrap;
      animation: scroll-left 15s linear infinite;
      font-size: 1.2rem;
      font-weight: bold;
      color: white;
    }
    .btn-filter {
      border-radius: 20px;
      padding: 6px 14px;
      font-weight: 500;
    }
    @keyframes scroll-left {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }
    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        z-index: 1050;
        width: 250px;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #fff;
        overflow-y: auto;
        border-right: 1px solid #ddd;
      }
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar collapse d-md-block" id="sidebarMenu">
      <div class="sidebar-logo text-center">
        <img src="<?= base_url('assets/Kabupatensukabumi.png') ?>" alt="logo" class="img-fluid mb-2" width="100">
      </div>
      <h5 class="fw-bold">EWS Sukabumi</h5>
      <a href="<?= base_url('kepala/home') ?>">🏠 Home</a>
      <a href="<?= base_url('kepala/unduh') ?>">⬇️ Download</a>
      <a href="<?= base_url('kepala/riwayat') ?>">📄 History Input</a>
      <a href="<?= base_url('kepala/warning') ?>">⚠️ Warning</a>
      <a href="<?= base_url('kepala/logout') ?>" onclick="return confirm('Yakin ingin logout?')">🚪 Logout</a>
      <hr>
      <p style="font-size: 0.85rem;">Platform ini dirancang untuk memberikan informasi waktu nyata tentang fluktuasi harga pangan....</p>
    </div>

     <!-- Main Content -->
    <div class="col-md-10">
      <div class="topbar d-flex justify-content-between align-items-center">
        <h5 class="m-0">HALAMAN DATA WARNIG</h5>
         <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> 
            <?= esc(session('kepala_nama') ?? 'Kepala') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item"href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')">🚪 Logout</a></li>
          </ul>
        </div>
      </div>
      <!-- Filter Buttons Section -->
      <div class="container mt-5">
        <div class="p-4 rounded shadow-sm bg-white border border-2" style="border-color: #e0e0e0;">
          <h2 class="mb-4 fw-bold text-success text-center">🚨 Data Warning Komoditas Pangan</h2>
          <div class="d-flex justify-content-center gap-3 mb-0">
            <a href="<?= base_url('kepala/warning/filter/naik') ?>" class="btn btn-danger btn-sm btn-filter">📈 Filter UP</a>
            <a href="<?= base_url('kepala/warning/filter/turun') ?>" class="btn btn-success btn-sm btn-filter">📉 Filter Down</a>
            <a href="<?= base_url('kepala/warning/filter/stabil') ?>" class="btn btn-warning btn-sm btn-filter text-white">➖ Filter Stable</a>
            <a href="<?= base_url('kepala/warning') ?>" class="btn btn-secondary btn-sm btn-filter">🔄 Reset</a>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="container mt-4">
        <div class="table-responsive bg-white p-4 rounded shadow-sm border border-2" style="border-color: #e0e0e0;">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
              <tr>
                <th>No</th>
                <th>Nama Komoditas</th>
                <th>Harga Dini</th>
                <th>Satuan</th>
                <th>Wilayah</th>
                <th>Tanggal</th>
                <th>Harga Naik</th>
                <th>Harga Turun</th>
                 <th>Harga Stabil</th>
                 <th>Harga Standar</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($data)): ?>
                <?php foreach ($data as $i => $item): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($item['nama_komoditas']) ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= esc($item['satuan']) ?></td>
                    <td><?= esc($item['nama_wilayah']) ?></td>
                    <td><?= date('d-m-Y', strtotime($item['tanggal'])) ?></td>
                    <td class="text-center"> 
                      <?php if ($filter === 'naik'): ?>
                        <span class="badge bg-danger">Naik</span>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                    </td>

                    <td class="text-center">
                      <?php if ($filter === 'turun'): ?>
                        <span class="badge bg-success">Turun</span>
                      <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>

                    <td class="text-center">
                      <?php if ($filter === 'stabil'): ?>
                        <span class="badge bg-warning text-dark">Stabil</span>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                      <?php endif; ?>
                      <td>Rp <?= number_format($item['standar_harga'], 0, ',', '.') ?></td>
                    </td>

                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-danger">Tidak ada data warning ditemukan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div> <!-- End Main Content -->
  </div> <!-- End Row -->
</div> <!-- End Container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
