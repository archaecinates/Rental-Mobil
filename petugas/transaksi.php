<?php
$title = 'Data Transaksi';
require 'koneksi.php';

$query = "SELECT tbl_transaksi.*, tbl_member.nama FROM tbl_transaksi 
          INNER JOIN tbl_member ON tbl_member.nik = tbl_transaksi.nik";
$data = mysqli_query($conn, $query);

require 'header.php';
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
            </div>
        </div>
        <?php if (isset($_GET['msg'])) : ?>
            <div class="alert alert-success" id="msg"><?= $_GET['msg'] ?></div>
        <?php endif ?>
    </div>
</div>
<div class="page-inner mt--5">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"><?= $title; ?></h4>
                        <a href="konfirmasi.php" class="btn btn-primary btn-round ml-auto mr-2">
                            <i class="fa fa-user-check"></i>
                            Konfirmasi Pengembalian
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%">No</th>
                                    <th>NIK</th>
                                    <th>No Polisi</th>
                                    <th>Tanggal Booking</th>
                                    <th>Tanggal Ambil</th>
                                    <th>Supir</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($data) > 0) {
                                    while ($trans = mysqli_fetch_assoc($data)) {
                                ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $trans['nik']; ?></td>
                                            <td><?= $trans['nopol']; ?></td>
                                            <td><?= date('d-m-Y', strtotime($trans['tgl_booking'])); ?></td>
                                            <td><?= date('d-m-Y', strtotime($trans['tgl_ambil'])); ?></td>
                                            <td><?= $trans['supir']; ?></td>
                                            <td><?= 'Rp ' . number_format($trans['total']); ?></td>
                                            <td><?= $trans['status']; ?></td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="detail.php?id=<?= $trans['id_transaksi']; ?>" type="button" data-toggle="tooltip" title="Detail" class="btn btn-primary">
                                                        <i class="far fa-eye"></i> Detail
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
