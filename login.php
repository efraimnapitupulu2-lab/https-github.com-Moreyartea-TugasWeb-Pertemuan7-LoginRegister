<?php
require_once __DIR__ . '/functions.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Email dan password wajib diisi.';
    } else {
        $users = readUsers();
        $foundUser = null;
        foreach ($users as $user) {
            if (isset($user['email']) && strtolower((string) $user['email']) === $email) {
                $foundUser = $user;
                break;
            }
        }

        if ($foundUser && isset($foundUser['password']) && password_verify($password, $foundUser['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['username'] = $foundUser['nama'];
            $_SESSION['email'] = $foundUser['email'];
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Email atau password salah.';
    }
}

$flash = takeFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LoginRegister</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page-shell">
    <section class="auth-card">
        <div class="brand-mark" aria-hidden="true">LR</div>
        <p class="eyebrow">SELAMAT DATANG KEMBALI</p>
        <h1>Login akun</h1>
        <p class="muted">Masuk untuk melanjutkan ke dashboard.</p>

        <?php if ($flash): ?>
            <div class="alert <?= e($flash['type']) ?>" role="status"><?= e($flash['message']) ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert error" role="alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="auth-form">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e($email) ?>" autocomplete="email" placeholder="nama@email.com" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Masukkan password" required>

            <button type="submit" class="primary-button">Login</button>
        </form>
        <p class="switch-link">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
        <p class="tiny-note">Demo pembelajaran PHP Native dengan session dan JSON.</p>
    </section>
</main>
</body>
</html>
