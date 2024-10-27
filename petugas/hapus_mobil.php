<?php
require 'koneksi.php';

$query = "DELETE FROM tb_mobil WHERE nopol = " . $_GET['nopol'];
$delete = mysqli_query($conn, $query);

if ($delete == 1) {
    $_SESSION['msg'] = 'Berhasil Mengahapus Data';
    header('location:mobil.php');
} else {
    $_SESSION['msg'] = 'Gagal Hapus Data!!!';
    header('location:mobil.php');
}
