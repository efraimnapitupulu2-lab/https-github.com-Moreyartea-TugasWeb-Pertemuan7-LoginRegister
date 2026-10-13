<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

const USERS_FILE = __DIR__ . '/users.json';

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function readUsers(): array
{
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, "[]\n", LOCK_EX);
    }

    $contents = file_get_contents(USERS_FILE);
    if ($contents === false || trim($contents) === '') {
        return [];
    }

    $users = json_decode($contents, true);
    return is_array($users) ? $users : [];
}

function saveUsers(array $users): bool
{
    $json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return file_put_contents(USERS_FILE, $json . PHP_EOL, LOCK_EX) !== false;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function takeFlash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $message = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $message;
}

function requireLogin(): void
{
    if (!isset($_SESSION['user_id'])) {
        flash('error', 'Silakan login terlebih dahulu untuk membuka dashboard.');
        header('Location: login.php');
        exit;
    }
}
