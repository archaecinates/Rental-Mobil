<?php
session_start();
if (!isset($_SESSION['lvl'])) {
    header('location:../index.php');
    exit();
}
if ($_SESSION['lvl'] !== 'admin' && $_SESSION['lvl'] !== 'petugas') {
    header("location:../index.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

if (mysqli_connect_error()) {
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}
?>
