<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN RIWAYAT INPUT </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

    .form-box {
      background: white;
      border-radius: 20px;
      padding: 2rem;
      margin-top: 2rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .filter-bar select {
      margin-right: 0.5rem;
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
        <h5 class="m-0">HALAMAN RIWAYAT INPUT</h5>
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= session('admin_nama') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">🚪 Logout</a></li>
          </ul>
        </div>
      </div>

      <div class="d-flex align-items-center mt-3 mb-3">
        <a href="<?= base_url('admin/inputadmin') ?>" class="btn btn-secondary me-3">⬅ KEMBALI</a>
        <form action="<?= base_url('riwayat') ?>" method="get" class="d-flex align-items-center">
          <select name="bulan" class="form-select">
            <option value="">BULAN :</option>
            <?php foreach (range(1,12) as $b): ?>
              <option value="<?= str_pad($b, 2, '0', STR_PAD_LEFT) ?>" <?= ($bulan ?? '') == str_pad($b, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                <?= date('F', mktime(0, 0, 0, $b, 10)) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <select name="tahun" class="form-select ms-2">
            <option value="">TAHUN :</option>
            <?php for ($t = 2025; $t <= date('Y'); $t++): ?>
              <option value="<?= $t ?>" <?= ($tahun ?? '') == $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endfor; ?>
          </select>
          <button class="btn btn-success ms-2">Filter</button>
        </form>
      </div>

      <div class="table-container">
        <table class="table table-bordered">
            <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold text-success">DAFTAR RIWAYAT</h4>
          <thead class="text-center">
            <tr>
              <th>No.</th>
              <th>Jenis Komoditas</th>
              <th>Harga Pangan</th>
              <th>Tanggal Input</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
              <?php if (empty($riwayat)): ?>
                <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
              <?php else: ?>
                <?php $no = 1; foreach ($riwayat as $row): ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row['nama_komoditas'] ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                    <td class="text-center">
                     <form action="<?= base_url('admin/riwayatinput/delete/' . $row['riwayat_id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
