<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN INPUT PANGAN</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #dcdcdc;
      font-family: 'Segoe UI', sans-serif;
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
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.16);
    }

    .btn-custom {
      background-color: #028a0f;
      color: white;
      border-radius: 30px;
      padding: 0.5rem 1.5rem;
      font-weight: bold;
      border: none;
    }

    .btn-custom:hover {
      background-color: #019170;
    }

    .btn-riwayat {
      background-color: white;
      color:  #028a0f;
      border: 2px solid  #028a0f;
      font-weight: bold;
      padding: 0.4rem 1rem;
      border-radius: 30px;
    }

    .btn-riwayat:hover {
      background-color: #028a0f;
      color: white;
    }
  </style>
</head>
<body>

<?php if (session()->getFlashdata('sukses')): ?>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= session()->getFlashdata('sukses'); ?>',
        confirmButtonColor: '#3085d6'
      });
    });
  </script>
<?php endif; ?>

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
        <h5 class="m-0">HALAMAN INPUT - ADMIN</h5>
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= session('admin_nama') ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">🚪 Logout</a></li>
          </ul>
        </div>
      </div>

      <div class="container form-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold text-success">INPUT</h4>
        </div>

        <form action="<?= base_url('admin/store') ?>" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="komoditas_id" class="form-label">Jenis Komoditas Pangan</label>
            <select name="komoditas_id" id="komoditas_id" class="form-select" required>
              <option disabled selected>-- Pilih Komoditas --</option>
              <?php foreach ($komoditas as $k): ?>
                <option value="<?= $k['komoditas_id'] ?>"><?= $k['nama_komoditas'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="harga" class="form-label">Harga Pangan Terbaru</label>
            <input type="number" name="harga" id="harga" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Input</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="wilayah_id" class="form-label">Wilayah</label>
            <select name="wilayah_id" id="wilayah_id" class="form-select" required>
              <option disabled selected>-- Pilih Wilayah --</option>
              <?php foreach ($wilayah as $w): ?>
                <option value="<?= $w['wilayah_id'] ?>"><?= $w['nama_wilayah'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-custom">UPDATE HARGA</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
