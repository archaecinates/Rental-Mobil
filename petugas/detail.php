<?php
$title = 'Detail Pembayaran';
require 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tbl_transaksi WHERE id_transaksi = '$id'");

if ($query) {
    // Ambil data
    $data = mysqli_fetch_assoc($query);
    
    // Cek apakah data ditemukan
    if (!$data) {
        die("Data tidak ditemukan.");
    }
} else {
    die("Query gagal: " . mysqli_error($conn));
}

// Status yang diizinkan untuk perubahan
$statusOptions = [
    'booking' => 'approve',
    'approve' => 'ambil',
    'ambil' => 'kembali',
    'kembali' => null // Tidak ada status selanjutnya setelah kembali
];

$currentStatus = $data['status'];

// Cek jika ada pengiriman dari form perubahan status
if (isset($_POST['btn-simpan'])) {
    $status = $_POST['status'];

    // Update status transaksi
    $query = "UPDATE tbl_transaksi SET status = '$status' WHERE id_transaksi = '$id'";
    $update = mysqli_query($conn, $query);
    if ($update) {
        $msg = 'Berhasil mengubah status pembayaran';
        header('location:transaksi.php?msg=' . $msg);
        exit; // Tambahkan exit setelah redirect
    } else {
        $_SESSION['msg'] = 'Gagal Mengubah Status Transaksi!!!';
        header('location:detail.php?id=' . $id);
        exit; // Tambahkan exit setelah redirect
    }
}

// Cek jika ada pengiriman dari form pengembalian
// Cek jika ada pengiriman dari form pengembalian
if (isset($_POST['btn-kembalikan'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $kondisi_mobil = $_POST['kondisi_mobil'];

    // Ambil tanggal ambil dari data yang ada
    $tgl_ambil = $data['tgl_ambil'];

    // Cek apakah terlambat
    $terlambat = (strtotime($tgl_kembali) > strtotime($tgl_ambil));
    $denda = 0;

    // Ambil harga mobil dari database
    $harga_mobil = $data['total']; // Asumsikan total adalah harga mobil

    // Tentukan denda
    if ($terlambat) {
        $denda = $harga_mobil; // Jika terlambat, denda sesuai harga mobil
    } elseif ($kondisi_mobil == 'rusak') {
        // Jika kondisi mobil rusak, denda harus diisi oleh petugas
        $denda = $_POST['denda']; // Ambil denda yang diinput petugas
    }

    // Insert data pengembalian ke tabel_kembali
    $insertQuery = "INSERT INTO tabel_kembali (id_transaksi, tgl_kembali, kondisi_mobil, denda) 
                    VALUES ('$id_transaksi', '$tgl_kembali', '$kondisi_mobil', '$denda')";
    
    if (mysqli_query($conn, $insertQuery)) {
        // Redirect setelah sukses
        $msg = 'Berhasil mengonfirmasi pengembalian';
        header('location:detail.php?id=' . $id . '&msg=' . $msg);
        exit; // Tambahkan exit setelah redirect
    } else {
        $_SESSION['msg'] = 'Gagal mengonfirmasi pengembalian: ' . mysqli_error($conn);
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
                    <a href="transaksi.php">Transaksi</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#"><?= $title; ?></a>
                </li>
            </ul>
            <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') { ?>
                <div class="alert alert-success" role="alert" id="msg">
                    <?= $_SESSION['msg']; ?>
                </div>
            <?php }
            $_SESSION['msg'] = ''; ?>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><?= $title; ?></div>
                    </div>
                    <!-- Form Detail Transaksi untuk perubahan status -->
                    <form action="" method="POST">
                        <div class="card-body">
                            <!-- Form Detail Transaksi -->
                            <div class="form-group">
                                <label for="largeInput">NIK</label>
                                <input type="text" name="nik" class="form-control" id="defaultInput" value="<?= $data['nik']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Nopol</label>
                                <input type="text" class="form-control" value="<?= $data['nopol']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Tanggal Booking</label>
                                <input type="text" class="form-control" value="<?= $data['tgl_booking']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Tanggal Ambil</label>
                                <input type="text" class="form-control" value="<?= $data['tgl_ambil']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Tanggal Kembali</label>
                                <input type="text" class="form-control" value="<?= $data['tgl_kembali']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Supir</label>
                                <input type="text" class="form-control" value="<?= $data['supir']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Total Sewa</label>
                                <input type="text" class="form-control" value="<?= $data['total']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">DP</label>
                                <input type="text" class="form-control" value="<?= $data['downpayment']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Kekurangan</label>
                                <input type="text" class="form-control" value="<?= $data['kekurangan']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="defaultSelect">
                                    <option value="<?= $currentStatus ?>" selected><?= $currentStatus ?></option>
                                    <?php if (isset($statusOptions[$currentStatus]) && $statusOptions[$currentStatus] != null): ?>
                                        <option value="<?= $statusOptions[$currentStatus] ?>"><?= $statusOptions[$currentStatus] ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-button-action">
                                <button type="submit" name="btn-simpan" class="btn btn-primary">Simpan Status</button>
                            </div>
                            <div class="form-button-action">
                                <!-- Tampilkan tombol Input Pengembalian jika statusnya 'kembali' -->
                                <?php if ($currentStatus == 'kembali') : ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnModal<?= $data['id_transaksi']; ?>">
                                        <i class="fa fa-plus"></i> Isi Pengembalian
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <!-- Modal Form Pengembalian -->
                    <div class="modal fade" id="returnModal<?= $data['id_transaksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="returnModalLabel">Form Pengembalian</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Form Pengembalian di dalam modal -->
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="id_transaksi" value="<?= $data['id_transaksi']; ?>">
                                        <div class="form-group">
                                            <label for="tgl_kembali">Tanggal Kembali</label>
                                            <input type="date" class="form-control" name="tgl_kembali" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kondisi_mobil">Kondisi Mobil</label>
                                            <select name="kondisi_mobil" class="form-control" required>
                                                <option value="baik">Baik</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="dendaContainer" style="display: none;">
                                            <label for="denda">Denda</label>
                                            <input type="number" name="denda" class="form-control" value="<?= $denda; ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" name="btn-kembalikan" class="btn btn-primary">Kembalikan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kondisiMobilSelect = document.querySelector('select[name="kondisi_mobil"]');
        const dendaContainer = document.getElementById('dendaContainer');

        kondisiMobilSelect.addEventListener('change', function () {
            if (this.value === 'rusak') {
                dendaContainer.style.display = 'block'; // Tampilkan input denda
            } else {
                dendaContainer.style.display = 'none'; // Sembunyikan input denda
            }
        });
    });
</script>

<?php require 'footer.php'; ?>
