<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('location: pengguna/index.php'); // Ganti dengan path login member
    exit();
}

// Cek apakah user yang login adalah member
$user = $_SESSION['user'];
$query_member = "SELECT * FROM tbl_member WHERE user = '$user'";
$row_member = mysqli_query($conn, $query_member);
$data_member = mysqli_fetch_assoc($row_member);

if (!$data_member) {
    header('location: pengguna/login.php'); // Jika bukan member, redirect ke halaman login
    exit();
}
?>
