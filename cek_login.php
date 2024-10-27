<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "rental_mobil");

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = md5($_POST['pass']);
    
    // Check in the admin/petugas table
    $query = "SELECT * FROM tbl_user WHERE user = '$user' AND pass = '$pass'";
    $row = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($row);
    $cek = mysqli_num_rows($row);

    if ($cek > 0) {
        $_SESSION['user'] = $data['user'];
        $_SESSION['id_user'] = $data['id_user'];
        
        if ($data['lvl'] == 'admin') {
            $_SESSION['lvl'] = 'admin';
            header('location:admin/index.php');
        } else if ($data['lvl'] == 'petugas') {
            $_SESSION['lvl'] = 'petugas';
            header('location:petugas/index.php');
        }
    } else {
        // Check in the users table
        $query_user = "SELECT * FROM tbl_member WHERE user = '$user' AND pass = '$pass'";
        $row_user = mysqli_query($conn, $query_user);
        $data_user = mysqli_fetch_assoc($row_user);
        $cek_user = mysqli_num_rows($row_user);

        if ($cek_user > 0) {
            // Assuming that the user table does not have a level field
            $_SESSION['user'] = $data_user['user'];
            $_SESSION['nik'] = $data_user['nik'];
            header('location:pengguna/index.php'); // Redirect to user dashboard or main page
        } else {
            $message = 'User atau password salah!!!';
            header('location:index.php?message=' . urlencode($message));
        }
    }
} else {
    // Jika variabel user atau pass tidak didefinisikan, arahkan kembali ke halaman login
    $message = 'Mohon masukkan username dan password.';
    header('location:index.php?message=' . urlencode($message));
}
?>
