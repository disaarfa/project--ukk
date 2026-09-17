<?php

session_start();

require_once 'config/koneksi.php';

// Pastikan data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Ambil data dari form login
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Cek input kosong
if ($username === '' || $password === '') {
    $_SESSION['pesan_error'] = 'Username dan password wajib diisi!';
    header('Location: login.php');
    exit;
}

// Cari user berdasarkan username
$sql = "SELECT * FROM tbl_user WHERE username = ?";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $_SESSION['pesan_error'] = 'Terjadi kesalahan pada database!';
    header('Location: login.php');
    exit;
}

// Masukkan username ke query
mysqli_stmt_bind_param($stmt, "s", $username);

// Jalankan query
mysqli_stmt_execute($stmt);

// Ambil hasil query
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Username tidak ditemukan
if (!$user) {
    $_SESSION['pesan_error'] = 'Username tidak ditemukan!';

    mysqli_stmt_close($stmt);

    header('Location: login.php');
    exit;
}

// Cek password
if ($password !== $user['password']) {
    $_SESSION['pesan_error'] = 'Password salah!';

    mysqli_stmt_close($stmt);

    header('Location: login.php');
    exit;
}

// =====================================
// LOGIN BERHASIL
// =====================================

$_SESSION['login'] = true;
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Tutup koneksi statement
mysqli_stmt_close($stmt);

// Arahkan ke dashboard
header('Location: dashboard.php');
exit;

?>