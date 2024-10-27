<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $kondisi_mobil = $_POST['kondisi_mobil'];
    $denda = isset($_POST['denda']) ? $_POST['denda'] : 0; // Opsional

    // Masukkan data ke tbl_kembali
    $query = "INSERT INTO tbl_kembali (id_transaksi, tgl_kembali, kondisi_mobil, denda) VALUES ('$id_transaksi', '$tgl_kembali', '$kondisi_mobil', '$denda')";
    
    if (mysqli_query($conn, $query)) {
        // Update status transaksi
        mysqli_query($conn, "UPDATE tbl_transaksi SET status = 'kembali' WHERE id_transaksi = '$id_transaksi'");
        $msg = 'Data pengembalian berhasil disimpan.';
    } else {
        $msg = 'Gagal menyimpan data pengembalian.';
    }

    header("Location: detail.php?id=$id_transaksi&msg=$msg");
    exit;
}
?>
