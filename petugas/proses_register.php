<?php
session_start();
require 'koneksi.php'; // Pastikan untuk menghubungkan dengan database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $pass = md5($_POST['pass']); // Menggunakan md5 untuk hashing password
    $lvl = 'petugas'; // Karena ini khusus untuk admin

    // Cek apakah username sudah ada
    $checkQuery = "SELECT * FROM tbl_user WHERE user = '$user'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Username sudah ada
        header("Location: register.php?message=Username sudah terdaftar.");
        exit();
    } else {
        // Insert ke database
        $insertQuery = "INSERT INTO tbl_user (user, pass, lvl) VALUES ('$user', '$pass', '$lvl')";

        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['msg'] = 'Registrasi berhasil, silakan login.';
            header("Location: index.php");
            exit();
        } else {
            // Gagal insert
            header("Location: register.php?message=Gagal mendaftar. Silakan coba lagi.");
            exit();
        }
    }
}

mysqli_close($conn); // Menutup koneksi
?>
