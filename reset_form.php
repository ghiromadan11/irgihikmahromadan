<form action="<?= base_url('reset-password/process') ?>" method="post">
  <input type="hidden" name="token" value="<?= esc($token) ?>">
  <label>Password Baru</label>
  <input type="password" name="password" class="form-control" required>
  <button type="submit" class="btn btn-success mt-2">Reset Password</button>
</form>
