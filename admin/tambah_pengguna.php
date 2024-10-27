<?php
$title = 'Tambah Data Pengguna';
require 'koneksi.php';

if (isset($_POST['btn-simpan'])) {
    // Mengambil data dari form
    $user = $_POST['user']; 
    $pass = md5($_POST['pass']); 
    $lvl = $_POST['lvl'];

    // Query untuk menyimpan data
    $query = "INSERT INTO tbl_user (user, pass, lvl) VALUES ('$user', '$pass', '$lvl')";

    // Menjalankan query
    $insert = mysqli_query($conn, $query);
    if ($insert) {
        $_SESSION['msg'] = 'Berhasil menambahkan ' . $lvl . ' baru';
        header('location:pengguna.php');
        exit(); // Tambahkan exit untuk menghentikan script
    } else {
        $_SESSION['msg'] = 'Gagal menambahkan data!!!';
        header('location: pengguna.php');
        exit(); // Tambahkan exit untuk menghentikan script
    }
}

// Mengambil data pengguna untuk ditampilkan (jika diperlukan)
$userData = mysqli_query($conn, "SELECT * FROM tbl_user");

require 'header.php';
?>
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="index.php">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="pengguna.php">Pengguna</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="tambah_pengguna.php">Tambah Pengguna</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><?= $title; ?></div>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="largeInput">Username</label>
                                <input type="text" name="user" class="form-control" id="defaultInput" placeholder="Username..." required>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Password</label>
                                <input type="password" name="pass" class="form-control" id="defaultInput" placeholder="Pass..." required>
                            </div>
                            <div class="form-group">
                                <label for="defaultSelect">Role</label>
                                <select name="lvl" class="form-control" id="defaultSelect" required>
                                    <option value="admin">Admin</option>
                                    <option value="petugas">Petugas</option>
                                </select>
                            </div>
                            <div class="card-action">
                                <button type="submit" name="btn-simpan" class="btn btn-success">Submit</button>
                                <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-danger">Batal</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
