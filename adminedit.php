<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN EDIT PANGAN</title>
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
      color: #000;
      text-decoration: none;
      display: block;
      margin: 1rem 0;
    }
    .sidebar a:hover {
      background-color: #eee;
      padding-left: 10px;
      transition: 0.3s;
    }
    .topbar {
      background-color: #028a0f;
      color: white;
      padding: 1rem 1.5rem;
      line-height: 1.3;
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
    .btn-success {
      background-color: #028a0f;
      border: none;
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
        <h5 class="m-0">Edit Harga Pangan</h5>
       <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= session('admin_nama') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">🚪 Logout</a></li>
          </ul>
        </div>
      </div>

      <div class="container">
        <div class="form-box mt-4">
          <form action="<?= base_url('admin/update/' . $harga['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal</label>
              <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $harga['tanggal'] ?>" required>
            </div>

            <div class="mb-3">
              <label for="komoditas_id" class="form-label">Komoditas</label>
              <select name="komoditas_id" id="komoditas_id" class="form-select" required>
                <option value="">-- Pilih Komoditas --</option>
                <?php foreach ($komoditas as $k): ?>
                  <option value="<?= $k['komoditas_id'] ?>" <?= $harga['komoditas_id'] == $k['komoditas_id'] ? 'selected' : '' ?>>
                    <?= $k['nama_komoditas'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="wilayah_id" class="form-label">Wilayah</label>
              <select name="wilayah_id" id="wilayah_id" class="form-select" required>
                <option value="">-- Pilih Wilayah --</option>
                <?php foreach ($wilayah as $w): ?>
                  <option value="<?= $w['wilayah_id'] ?>" <?= $harga['wilayah_id'] == $w['wilayah_id'] ? 'selected' : '' ?>>
                    <?= $w['nama_wilayah'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" name="harga" id="harga" class="form-control" value="<?= $harga['harga'] ?>" required>
            </div>

            <div class="mb-3">
              <label for="gambar" class="form-label">Gambar (Opsional)</label>
              <input type="file" name="gambar" id="gambar" class="form-control">
              <?php if (!empty($harga['gambar'])): ?>
                <div class="mt-2">
                  <img src="<?= base_url('assets/img/harga_pangan/' . $harga['gambar']) ?>" width="100">
                </div>
              <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
            <a href="<?= base_url('admin/home') ?>" class="btn btn-secondary">⬅ Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
