<?php
$title = 'Konfirmasi Pengembalian dan Pembayaran';
require 'koneksi.php'; // Pastikan koneksi sudah diatur

// Memproses konfirmasi pembayaran jika form di-submit
if (isset($_POST['btn-bayar'])) {
    $id_kembali = $_POST['id_kembali'];
    $total_bayar = $_POST['total_bayar'];
    $status = $_POST['status'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Ambil data transaksi untuk menghitung kekurangan
    $transaksiQuery = mysqli_query($conn, "SELECT * FROM tbl_transaksi WHERE id_transaksi = (SELECT id_transaksi FROM tabel_kembali WHERE id_kembali = '$id_kembali')");
    $transaksiData = mysqli_fetch_assoc($transaksiQuery);
    
    $totalSewa = $transaksiData['total'];
    $denda = $transaksiData['denda'] ?? 0;
    $kekurangan = $totalSewa + $denda;

    // Validasi total bayar tidak lebih dari kekurangan
    if ($total_bayar > $kekurangan) {
        echo "<script>alert('Total bayar tidak boleh lebih dari kekurangan!');</script>";
    } else {
        // Update data di tabel pembayaran
        $updateQuery = "UPDATE tbl_bayar SET tgl_bayar = NOW(), total_bayar = '$total_bayar', status = '$status' WHERE id_kembali = '$id_kembali'";
        mysqli_query($conn, $updateQuery);

        // Hitung kekurangan setelah pembayaran
        $newKekurangan = $kekurangan - $total_bayar;

        // Update kekurangan di tbl_transaksi
        $updateKekuranganQuery = "UPDATE tbl_transaksi SET kekurangan = '$newKekurangan' WHERE id_transaksi = (SELECT id_transaksi FROM tabel_kembali WHERE id_kembali = '$id_kembali')";
        mysqli_query($conn, $updateKekuranganQuery);

        // Redirect dengan pesan sukses
        header("Location: bayar.php?msg=Pembayaran berhasil!");
        exit();
    }
}

// Mengambil data dari tbl_bayar dengan member
$query = mysqli_query($conn, "
    SELECT b.*, t.id_transaksi, t.total AS total, m.nama AS nama
    FROM tbl_bayar b 
    JOIN tbl_transaksi t ON b.id_kembali = (SELECT id_kembali FROM tabel_kembali WHERE id_transaksi = t.id_transaksi)
    JOIN tbl_member m ON t.nik = m.nik
");

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
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%">No</th>
                                    <th>ID Kembali</th>
                                    <th>Nama Member</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Kekurangan</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    // Hitung kekurangan
                                    $totalBayar = $row['total_bayar'];
                                    $denda = $row['denda'] ?? 0; 
                                    $totalSewa = $row['total']; 
                                    $kekurangan = $totalSewa + $denda - $totalBayar; 

                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['id_kembali']; ?></td>
                                        <td><?= $row['nama']; ?></td> <!-- Nama Member -->
                                        <td><?= $row['tgl_bayar']; ?></td>
                                        <td><?= number_format($totalBayar, 0, ',', '.'); ?></td> <!-- Format jumlah -->
                                        <td><?= $row['status']; ?></td>
                                        <td><?= number_format($kekurangan, 0, ',', '.'); ?></td> <!-- Tampilkan kekurangan -->
                                        <td>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#paymentModal<?= $row['id_kembali']; ?>">
                                                Konfirmasi Pembayaran
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk konfirmasi pembayaran -->
                                    <div class="modal fade" id="paymentModal<?= $row['id_kembali']; ?>" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentModalLabel">Konfirmasi Pembayaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_kembali" value="<?= $row['id_kembali']; ?>">
                                                        <div class="form-group">
                                                            <label for="tgl_kembali">Tanggal Kembali</label>
                                                            <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" min="<?= date('Y-m-d') ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="total_bayar">Total Bayar (Kekurangan: <?= number_format($kekurangan, 0, ',', '.'); ?>)</label>
                                                            <input type="number" class="form-control" name="total_bayar" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="lunas" <?= $row['status'] === 'lunas' ? 'selected' : ''; ?>>Lunas</option>
                                                                <option value="belum lunas" <?= $row['status'] === 'belum lunas' ? 'selected' : ''; ?>>Belum Lunas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" name="btn-bayar" class="btn btn-primary">Konfirmasi Pembayaran</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
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
mysqli_close($conn); // Menutup koneksi
?>
