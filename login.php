<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #00c853, #64dd17);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-box {
            background: #fff;
            border-radius: 10px;
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            text-align: center;
        }

        .login-box img {
            width: 80px;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-login {
            border-radius: 20px;
            background-color: #00c853;
            border: none;
        }

        .btn-login:hover {
            background-color: #00b247;
        }
    </style>
</head>
<body>

<div class="login-box">
    <img src="<?= base_url('assets/Kabupatensukabumi.png') ?>" alt="Logo">
    <h4 class="mb-3">LOGIN ADMIN</h4>

    <!-- ✅ Tampilkan flash message -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-center">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('login/process') ?>">
        <div class="mb-3 text-start">
            <input type="email" name="email" class="form-control" placeholder="Enter Email Address..." required>
        </div>

        <div class="mb-3 text-start position-relative">
            <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Enter Password ..." required>
            <i class="bi bi-eye-slash-fill position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-login text-white">LOGIN</button>
        </div>

        <p class="mt-3 text-center">
            Ubah password? <a href="<?= base_url('reset-password') ?>">Reset sekarang</a>
        </p>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Show/Hide Password -->
<script>
    const toggle = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    toggle.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash-fill");
    });
</script>
</body>
</html>
