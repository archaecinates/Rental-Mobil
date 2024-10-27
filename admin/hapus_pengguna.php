<?php
require "koneksi.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "DELETE FROM tbl_user WHERE id_user = '$id'";
    $delete = mysqli_query($conn, $query);

    if ($delete) {
        $_SESSION['msg'] = "Berhasil menghapus data";
        header('Location: pengguna.php');
    } else {
        $_SESSION['msg'] = "Gagal menghapus data";
        header('Location: pengguna.php');
    }
} else {
    $_SESSION['msg'] = "Data pengguna tidak ditemukan";
    header('Location: pengguna.php');
}