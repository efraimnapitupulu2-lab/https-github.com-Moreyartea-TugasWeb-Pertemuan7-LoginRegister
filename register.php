<?php
require_once __DIR__ . '/functions.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$nama = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['nama'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $konfirmasi = (string) ($_POST['konfirmasi_password'] ?? '');

    if ($nama === '') {
        $errors[] = 'Nama lengkap wajib diisi.';
    } elseif (strlen($nama) > 400) {
        $errors[] = 'Nama maksimal 100 karakter.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Masukkan alamat email yang valid.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }
    if ($password !== $konfirmasi) {
        $errors[] = 'Konfirmasi password tidak sama.';
    }

    $users = readUsers();
    foreach ($users as $user) {
        if (isset($user['email']) && strtolower((string) $user['email']) === $email) {
            $errors[] = 'Email sudah terdaftar. Silakan gunakan email lain atau login.';
            break;
        }
    }

    if (!$errors) {
        $newUser = [
            'id' => (int) (microtime(true) * 1000),
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $users[] = $newUser;

        if (saveUsers($users)) {
            flash('success', 'Registrasi berhasil! Silakan login menggunakan akun yang baru dibuat.');
            header('Location: login.php');
            exit;
        }
        $errors[] = 'Data gagal disimpan. Periksa izin tulis file users.json.';
    }
}

$flash = takeFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun | LoginRegister</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page-shell">
    <section class="auth-card">
        <div class="brand-mark" aria-hidden="true">LR</div>
        <p class="eyebrow">AKUN BARU</p>
        <h1>Buat akun</h1>
        <p class="muted">Daftar untuk mulai menggunakan aplikasi.</p>

        <?php if ($flash): ?>
            <div class="alert <?= e($flash['type']) ?>" role="status"><?= e($flash['message']) ?></div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="alert error" role="alert">
                <strong>Periksa kembali data kamu:</strong>
                <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php" class="auth-form">
            <label for="nama">Nama lengkap</label>
            <input id="nama" name="nama" type="text" value="<?= e($nama) ?>" maxlength="100" autocomplete="name" placeholder="Nama lengkap kamu" required>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e($email) ?>" autocomplete="email" placeholder="nama@email.com" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" minlength="6" autocomplete="new-password" placeholder="Minimal 6 karakter" required>

            <label for="konfirmasi_password">Konfirmasi password</label>
            <input id="konfirmasi_password" name="konfirmasi_password" type="password" minlength="6" autocomplete="new-password" placeholder="Ulangi password" required>

            <button type="submit" class="primary-button">Daftar sekarang</button>
        </form>
        <p class="switch-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        <p class="tiny-note">Password disimpan dalam bentuk hash, bukan teks asli.</p>
    </section>
</main>
</body>
</html>
