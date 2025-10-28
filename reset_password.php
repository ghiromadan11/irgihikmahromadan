<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card shadow p-4" style="min-width: 350px;">
    <h5 class="mb-4 text-center">Verifikasi Akun</h5>

    <!-- Flash message -->
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Form Verifikasi Email dan Password -->
    <form action="<?= base_url('reset-password/process') ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="email" class="form-label">Masukkan Email Anda</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="current_password" class="form-label">Password Saat Ini</label>
        <input type="password" name="current_password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="new_password" class="form-label">Masukan Password Baru</label>
        <input type="password" name="new_password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Verifikasi Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success w-100">Submit</button>
    </form>

    <!-- Tombol Lupa Password -->
    <div class="text-center mt-3">
      <a href="<?= base_url('reset-password') ?>" class="text-decoration-none">🔑 Lupa Password?</a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
