<?php
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);

    // Enkripsi password sebelum disimpan
    $hashed_password = md5($password);

    // Cek apakah email sudah digunakan
    $cek_user = "SELECT * FROM tbl_member WHERE user = '$user'";
    $result = mysqli_query($conn, $cek_user);
    
    if (mysqli_num_rows($result) > 0) {
        header("Location: register.php?message=user sudah terdaftar!");
        exit();
    }

    // Query untuk insert data user baru
    $sql = "INSERT INTO tbl_member (nik, nama, user, pass, telp, alamat, jk) VALUES ('$nik', '$nama', '$user', '$telp', '$hashed_password', '$alamat', '$jk')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?message=Registrasi berhasil, silakan login.");
    } else {
        header("Location: register.php?message=Terjadi kesalahan, coba lagi.");
    }
}
?>
