<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "rental_mobil");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = md5($_POST['pass']); 

    echo "user: " . $user . "<br>";
    echo "pass (hashed): " . $pass . "<br>";

    $query = "SELECT * FROM tbl_user WHERE user = '$user' AND pas = '$pass'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $_SESSION['lvl'] = $data['lvl'];
        $_SESSION['id_user'] = $data['id_user'];

        echo "lvl: " . $data['lvl'];

        if ($data['lvl'] == 'admin') {
            header('location:admin/index.php');
        } else if ($data['lvl'] == 'petugas') {
            header('location:petugas/index.php');
        }
    } else {
        $message = 'User atau password salah!!!';
        header('location:index.php?message=' . urlencode($message));
        exit();
    }
} else {
    $message = 'Harap masukkan user dan password!!!';
    header('location:index.php?message=' . urlencode($message));
    exit();
}
