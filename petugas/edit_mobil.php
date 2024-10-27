<?php
$title = 'Edit Data Mobil';
require 'koneksi.php';

$id = $_GET['id'];
$query = "SELECT * FROM tbl_mobil WHERE nopol = '$id'";
$queryedit = mysqli_query($conn, $query);
$edit = mysqli_fetch_assoc($queryedit);

if (isset($_POST['btn-simpan'])) {
    $nopol = $_POST['nopol'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $tahun = $_POST['tahun'];
    $sub_brand = $_POST['sub_brand'];
    $harga = str_replace('.', '', $_POST['harga']); // Hapus titik
    $harga = str_replace(',', '.', $harga); // Ganti koma dengan titik

    // Update data mobil
    $query = "UPDATE tbl_mobil SET brand = '$brand', type = '$type', tahun = '$tahun', sub_brand = '$sub_brand', harga = '$harga' WHERE nopol = '$nopol'";

    $update = mysqli_query($conn, $query);
    if ($update) {
        $_SESSION['msg'] = 'Berhasil mengubah data mobil';
        header('location: mobil.php');
        exit;
    } else {
        $_SESSION['msg'] = 'Gagal mengubah data!!!';
        header('location: mobil.php');
        exit;
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
                    <a href="#"><?= $title; ?></a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><?= $title; ?>: <strong><?= $edit['sub_brand']; ?></strong></div>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nopol">No Polisi</label>
                                <input type="text" name="nopol" class="form-control" value="<?= $edit['nopol']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand" class="form-control" value="<?= $edit['brand']; ?>" placeholder="Brand...">
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" name="type" class="form-control" value="<?= $edit['type']; ?>" placeholder="Type...">
                            </div>
                            <div class="form-group">
                                <label for="type">Tahun</label>
                                <input type="text" name="tahun" class="form-control" value="<?= $edit['tahun']; ?>" placeholder="Tahun...">
                            </div>
                            <div class="form-group">
                                <label for="sub_brand">Sub Brand</label>
                                <input type="text" name="sub_brand" class="form-control" value="<?= $edit['sub_brand']; ?>" placeholder="Sub Brand...">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="text" name="harga" class="form-control" value="<?= number_format($edit['harga'], 2, ',', '.'); ?>" placeholder="Harga...">
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
<?php require 'footer.php'; ?>
