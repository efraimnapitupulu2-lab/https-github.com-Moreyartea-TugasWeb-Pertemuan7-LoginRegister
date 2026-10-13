<?php
require_once __DIR__ . '/functions.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | LoginRegister</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">
<header class="topbar">
    <a class="topbar-brand" href="dashboard.php"><span class="mini-mark">LR</span> LoginRegister</a>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout ↗</button>
    </form>
</header>
<main class="dashboard-shell">
    <section class="welcome-card">
        <div class="welcome-icon" aria-hidden="true">✓</div>
        <p class="eyebrow">DASHBOARD</p>
        <h1>Halo, <?= e($_SESSION['username'] ?? 'Pengguna') ?>!</h1>
        <p class="muted">Kamu berhasil login. Halaman ini hanya bisa dibuka oleh pengguna yang sudah memiliki session login.</p>
        <div class="profile-panel">
            <div><span class="detail-label">Nama pengguna</span><strong><?= e($_SESSION['username'] ?? '-') ?></strong></div>
            <div><span class="detail-label">Email</span><strong><?= e($_SESSION['email'] ?? '-') ?></strong></div>
            <div><span class="detail-label">Status</span><strong class="status-pill">● Login aktif</strong></div>
        </div>
        <p class="tiny-note">Data akun disimpan pada file <code>users.json</code>.</p>
    </section>
</main>
</body>
</html>
