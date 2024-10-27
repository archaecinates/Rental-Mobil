<?php
$title = 'Tambah Data Mobil';
require 'koneksi.php';

if (isset($_POST['btn-simpan'])) {
    $nopol = $_POST['nopol'];
    $brand = $_POST['brand'];
    $type = $_POST['type_mobil']; 
    $tahun = $_POST['tahun']; 
    $sub_brand = $_POST['sub_brand']; 
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $query = "INSERT INTO tbl_mobil (nopol, brand, type, tahun, sub_brand, harga, status) VALUES ('$nopol', '$brand', '$type', '$tahun', '$sub_brand', '$harga', '$status')";
    $insert = mysqli_query($conn, $query);
    if ($insert) {
        $_SESSION['msg'] = 'Berhasil Menyimpan Data';
        header('location: mobil.php');
        exit(); // Menambahkan exit setelah header untuk menghentikan eksekusi
    } else {
        $_SESSION['msg'] = 'Gagal menambahkan data baru!!!';
        header('location: mobil.php');
        exit(); // Menambahkan exit setelah header untuk menghentikan eksekusi
    }
}

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
                    <a href="mobil.php">Mobil</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tambah Mobil</a>
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
                                <label for="nopol">No Polisi</label>
                                <input type="text" name="nopol" class="form-control" id="nopol" placeholder="AA 123...">
                            </div>
                            <div class="form-group">
                                <label for="brand">Brand Mobil</label>
                                <input type="text" name="brand" class="form-control" id="brand" placeholder="Hyundai.." maxlength="15">
                            </div>
                            <div class="form-group">
                                <label for="type_mobil">Tipe Mobil</label>
                                <input type="text" name="type_mobil" class="form-control" id="type" placeholder="SUV.." maxlength="15">
                            </div>
                            <div class="form-group">
                                <label for="type_mobil">Tahun</label>
                                <input type="text" name="type_mobil" class="form-control" id="type" placeholder="SUV.." maxlength="15">
                            </div>
                            <div class="form-group">
                                <label for="sub_brand">Sub Brand</label>
                                <input type="text" name="sub_brand" class="form-control" id="sub_brand" placeholder="Avanza.." maxlength="15">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga / Hari</label>
                                <input type="text" name="harga" class="form-control" id="harga" placeholder="Rp250.000,00" maxlength="15">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="tersedia">Tersedia</option>
                                    <option value="tidak tersedia">Tidak Tersedia</option>
                                </select>
                            </div>
                            <div class="card-action">
                                <button type="submit" name="btn-simpan" class="btn btn-success">Submit</button>
                                <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
