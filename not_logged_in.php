<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Akses Ditolak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="bg-white p-5 rounded shadow text-center">
      <h4 class="mb-3 text-danger">⚠️ Silakan login terlebih dahulu</h4>
      <p class="text-muted">Anda tidak dapat mengakses halaman ini tanpa login.</p>
      <a href="<?= base_url('login?from=kepala') ?>" class="btn btn-primary">LOGIN SEKARANG</a>
    </div>
  </div>
</body>
</html>
