<?php
session_start();
if ($_SESSION) {
    if ($_SESSION['lvl'] == 'admin') {
    } else {
        header("location:../index.php");
    }
} else {
    header('location:../index.php');
}

$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

if (mysqli_connect_error()) {
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}
