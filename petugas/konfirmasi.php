<?php
$title = 'Konfirmasi Pengembalian dan Pembayaran';
require 'koneksi.php'; // Pastikan koneksi sudah diatur

// Proses penyimpanan data pembayaran
if (isset($_POST['btn-bayar'])) {
    $id_kembali = $_POST['id_kembali'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $total_bayar = $_POST['total_bayar'];
    $status = $_POST['status'];

    // Cek apakah pembayaran sudah ada
    $checkQuery = "SELECT * FROM tbl_bayar WHERE id_kembali = '$id_kembali'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $existingPayment = mysqli_fetch_assoc($checkResult);

    if ($existingPayment) {
        // Jika sudah ada pembayaran, update status dan total
        $newTotalBayar = $existingPayment['total_bayar'] + $total_bayar;
        $updateQuery = "UPDATE tbl_bayar SET tgl_bayar = '$tgl_bayar', total_bayar = '$newTotalBayar', status = 'lunas' WHERE id_kembali = '$id_kembali'";

        if (mysqli_query($conn, $updateQuery)) {
            $_SESSION['msg'] = 'Pembayaran telah dilunasi.';
            header('Location: konfirmasi.php');
            exit();
        } else {
            $_SESSION['msg'] = 'Gagal melunasi pembayaran.';
            header('Location: konfirmasi.php');
            exit();
        }
    } else {
        // Jika belum ada, insert data pembayaran ke tbl_bayar
        $insertQuery = "INSERT INTO tbl_bayar (id_kembali, tgl_bayar, total_bayar, status) 
                        VALUES ('$id_kembali', '$tgl_bayar', '$total_bayar', '$status')";

        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['msg'] = 'Berhasil mengonfirmasi pembayaran.';
            header('Location: konfirmasi.php');
            exit();
        } else {
            $_SESSION['msg'] = 'Gagal mengonfirmasi pembayaran.';
            header('Location: konfirmasi.php');
            exit();
        }
    }
}

// Mengambil data dari tbl_kembali
$query = mysqli_query($conn, "SELECT * FROM tabel_kembali");
require 'header.php';
?>

<div class="container">
    <h2><?= $title; ?></h2>
    <?php if (isset($_SESSION['msg'])) : ?>
        <div class="alert alert-info"><?= $_SESSION['msg']; ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Kembali</th>
                <th>Tanggal Kembali</th>
                <th>Kondisi Mobil</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['id_kembali']; ?></td>
                <td><?= $row['tgl_kembali']; ?></td>
                <td><?= $row['kondisi_mobil']; ?></td>
                <td><?= $row['denda']; ?></td>
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
                                    <label for="tgl_bayar">Tanggal Bayar</label>
                                    <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" min="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="total_bayar">Total Bayar</label>
                                    <input type="number" class="form-control" name="total_bayar" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="lunas">Lunas</option>
                                        <option value="belum lunas">Belum Lunas</option>
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

<?php
require 'footer.php';
mysqli_close($conn); // Menutup koneksi
?>
