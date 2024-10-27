<?php
$title = 'Data Penyewa';
require 'koneksi.php';

$query = 'SELECT * FROM tbl_member ORDER BY nik DESC';
$data = mysqli_query($conn, $query);

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
                        <!-- <a href="tambah_penyewa.php" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Penyewa
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%">No.</th>
                                    <th style="width: 20%;">NIK</th>
                                    <th style="width: 20%;">Nama</th>
                                    <th style="width: 20%;">Username</th>
                                    <th style="width: 20%;">Telephone</th>
                                    <th style="width: 25%;">Alamat</th>
                                    <th style="width: 15%;">Jenis Kelamin</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($data) > 0) {
                                    while ($plg = mysqli_fetch_assoc($data)) {
                                ?>

                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $plg['nik']; ?></td>
                                            <td><?= $plg['nama']; ?></td>
                                            <td><?= $plg['user']; ?></td>
                                            <td><?= $plg['telp']; ?></td>
                                            <td><?= $plg['alamat']; ?></td>
                                            <td>
    <?php
    if ($plg['jk'] == 'l') {
        echo "Laki-laki";
    } elseif ($plg['jk'] == 'p') {
        echo "Perempuan";
    }
    ?>
</td>

                                            <td>
                                                <div class="form-button-action">
                                                    <a href="edit_pelanggan.php?id=<?= $plg['nik']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="hapus_pelanggan.php?id=<?= $plg['nik']; ?>" onclick="return confirm('Yakin hapus data?');" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
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