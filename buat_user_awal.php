<?php
include 'config/koneksi.php';
$nama = 'Admin';
$username = 'admin';
$password = password_hash('112233', PASSWORD_DEFAULT);
$role = 'admin';

$sql = "INSERT INTO tbl_user (nama, username,password, role) VALUES ('$nama', '$username', '$password', '$role')";

if(mysqli_query($koneksi, $sql)) {
    echo 'User admin berhasil dibuat. Silahkan hapus file ini.';
} else {
    echo 'Gagal membuat user: ' . mysqli_error($koneksi);
}
?>