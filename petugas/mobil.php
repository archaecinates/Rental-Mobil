<?php
$title = 'Data Mobil';
require 'koneksi.php';

$data = mysqli_query($conn, 'SELECT * FROM tbl_mobil ORDER BY nopol asc');

require 'header.php';
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        </div>
        <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] <> '') { ?>
            <div class="alert alert-success" role="alert" id="msg">
                <?= $_SESSION['msg']; ?>
            </div>
        <?php }
        $_SESSION['msg'] = ''; ?>
    </div>
</div>
<div class="page-inner mt--5">

    <diva class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"><?= $title; ?></h4>
                        <a href="tambah_mobil.php" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Mobil
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>No Polisi</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Tahun</th>
                                    <th>Sub Brand</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($data) > 0) {
                                    while ($tbl_mobil = mysqli_fetch_assoc($data)) {
                                ?>

                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $tbl_mobil['nopol']; ?></td>
                                            <td><?= $tbl_mobil['brand']; ?></td>
                                            <td><?= $tbl_mobil['type']; ?></td>
                                            <td><?= $tbl_mobil['tahun']; ?></td>
                                            <td><?= $tbl_mobil['sub_brand']; ?></td>
                                            <td><?= $tbl_mobil['harga']; ?></td>
                                            <td><?= $tbl_mobil['status']; ?></td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="edit_mobil.php?id=<?= $tbl_mobil['nopol']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="hapus_mobil.php?id=<?= $tbl_mobil['nopol']; ?>" onclick="return confirm('Yakin hapus data?');" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</div>
</div>
<?php
require 'footer.php';
?>