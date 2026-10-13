# Tugas Web Pertemuan 7 — Login/Register

Aplikasi autentikasi sederhana menggunakan PHP Native dan file JSON, sesuai tugas rutin Pertemuan 7.

## Fitur
- Registrasi nama, email, password, dan konfirmasi password.
- Validasi field wajib, format email (`filter_var`), dan password minimal 6 karakter.
- Pengecekan email duplikat.
- Password disimpan sebagai hash dengan `password_hash()` dan diperiksa dengan `password_verify()`.
- Penyimpanan akun ke `users.json`.
- Login dan pengelolaan status menggunakan PHP session.
- Dashboard dilindungi: pengunjung yang belum login diarahkan ke halaman login.
- Logout menghapus data session.
- Output input pengguna di-escape dengan `htmlspecialchars()`.
- Tampilan responsif dengan CSS.

## Kebutuhan
- PHP 8.x
- Laragon atau XAMPP (Apache + PHP)
- Browser dan editor seperti VS Code

## Cara menjalankan di Laragon
1. Ekstrak folder project.
2. Salin folder `TugasWeb-Pertemuan7-LoginRegister` ke folder `C:\laragon\www\`.
3. Jalankan Laragon dan klik **Start All**.
4. Buka `http://localhost/TugasWeb-Pertemuan7-LoginRegister/`.
5. Pilih **Daftar sekarang**, buat akun uji, lalu login.
6. Coba buka `dashboard.php` pada browser/incognito yang belum login; aplikasi harus mengarahkan ke halaman login.
7. Klik **Logout**, lalu pastikan dashboard tidak dapat dibuka sebelum login kembali.

## Cara menjalankan di XAMPP
1. Salin folder project ke `C:\xampp\htdocs\`.
2. Jalankan Apache dari XAMPP Control Panel.
3. Buka `http://localhost/TugasWeb-Pertemuan7-LoginRegister/`.

## Catatan file JSON
- `users.json` dimulai sebagai array kosong yang valid (`[]`).
- Setelah registrasi berhasil, data akun akan otomatis ditambahkan ke file tersebut.
- Jangan pernah menyimpan password dalam teks biasa. Field `password` di JSON berisi hash.
- Untuk tugas pembelajaran ini, JSON dipakai sesuai materi. Untuk aplikasi nyata, gunakan database, kontrol akses file yang ketat, HTTPS, perlindungan CSRF, dan kebijakan keamanan tambahan.

## Struktur file
- `index.php` — mengarahkan pengguna ke login.
- `functions.php` — fungsi session, baca/tulis JSON, flash message, dan proteksi login.
- `register.php` — form serta proses registrasi.
- `login.php` — proses autentikasi.
- `dashboard.php` — halaman setelah login.
- `logout.php` — mengakhiri session.
- `users.json` — penyimpanan akun.
- `style.css` — tampilan aplikasi.

## Upload ke GitHub
1. Buat repository **Public** dengan nama `TugasWeb-Pertemuan7-LoginRegister`.
2. Upload seluruh file project, termasuk `users.json`.
3. Pastikan `users.json` tidak berisi akun pribadi atau data sensitif sebelum repository dipublikasikan. Untuk pengumpulan, gunakan data contoh/uji saja.
4. Salin link repository dan kumpulkan melalui LMS sesuai instruksi dosen.
