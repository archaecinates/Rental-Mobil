<?php
session_start();
include 'koneksi.php';


$nopol = isset($_GET['nopol']) ? $_GET['nopol'] : '';

// Proses penyimpanan data booking
if (isset($_POST['btnSimpan'])) {
    $nik = $_SESSION['nik'];
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir = $_POST['supir'];
    $tgl_booking = date('Y-m-d');
    $downpayment = $_POST['dp'];

    // Hitung jumlah hari
    $datetime1 = new DateTime($tgl_ambil);
    $datetime2 = new DateTime($tgl_kembali);
    $interval = $datetime1->diff($datetime2);
    $days = $interval->days;

    if (empty($nopol)) {
        echo "Error: No police number provided.";
        exit;
    }

    $query = "SELECT harga FROM tbl_mobil WHERE nopol = '$nopol'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $harga_perhari = $row['harga'];

    $total = $days * $harga_perhari;

    if ($supir == '1') {
        $total += 100000; // Biaya supir
    }

    $kekurangan = $total - $downpayment;

    // Simpan transaksi
    $query = "INSERT INTO tbl_transaksi (nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan, status) 
              VALUES ('$nik', '$nopol', '$tgl_booking', '$tgl_ambil', '$tgl_kembali', '$supir', '$total', '$downpayment', '$kekurangan', 'booking')";
    if (mysqli_query($conn, $query)) {
        $updateQuery = "UPDATE tbl_mobil SET status = 'tidak' WHERE nopol = '$nopol'";
        mysqli_query($conn, $updateQuery);

        echo "<script>alert('Booking berhasil!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

if (isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
} else {
    $nik = ''; // Jika NIK tidak ditemukan, set sebagai string kosong
}

if (isset($_GET['nopol'])) {
    $nopol = $_GET['nopol'];
    $mobil_result = mysqli_query($conn, "SELECT * FROM tbl_mobil WHERE nopol = '$nopol'");
    $mobil_row = mysqli_fetch_assoc($mobil_result);
} else {
    $mobil_row = null; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Booking</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
</head>
<body>
<div class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="list.php">Kendaraan</a></li>
                    <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="booking_section layout_padding">
    <div class="container">
        <h1 class="booking_taital">Car Booking</h1>
        <br>
        <div class="booking_form">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" name="nik" class="form-control" id="inputnik" value="<?= ($nik); ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="nopol">Nomor Polisi:</label>
                    <input type="text" class="form-control" id="nopol" name="nopol" value="<?= $mobil_row ? $mobil_row['nopol'] : '' ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_booking">Tanggal Booking:</label>
                    <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_ambil">Tanggal Ambil:</label>
                    <input type="date" class="form-control" id="tgl_ambil" name="tgl_ambil" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="tgl_kembali">Tanggal Kembali:</label>
                    <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="supir">Supir:</label>
                    <select class="form-control" id="supir" name="supir" required>
                        <option value="0">Tanpa Supir</option>
                        <option value="1">Dengan Supir (Tambahan 100.000)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total">Total:</label>
                    <input type="number" class="form-control" id="total" name="total" required readonly>
                </div>
                <div class="form-group">
                    <label for="dp">DP:</label>
                    <input type="number" class="form-control" id="dp" name="dp" required oninput="calculateKekurangan()">
                </div>
                <div class="form-group">
                    <label for="kekurangan">Kekurangan:</label>
                    <input type="number" class="form-control" id="kekurangan" name="kekurangan" required readonly>
                </div>
                <button type="submit" name="btnSimpan" class="btn btn-primary">Submit Booking</button>
            </form>
        </div>
    </div>
</div>
<br>

<!-- Footer section start -->
<div class="footer_section layout_padding">
    <div class="container">
        <!-- Footer content here -->
    </div>
</div>
<!-- Footer section end -->

<!-- Javascript files-->
<script>
const hargaPerHari = <?= isset($mobil_row) ? $mobil_row['harga'] : '0' ?>;

function calculateTotal() {
    const tglAmbil = document.getElementById('tgl_ambil').value;
    const tglKembali = document.getElementById('tgl_kembali').value;
    const supir = document.getElementById('supir').value;
    const days = calculateDays(tglAmbil, tglKembali);

    if (days > 0) {
        let total = days * hargaPerHari;
        if (supir === '1') {
            total += 100000; // Tambahan biaya untuk supir
        }
        document.getElementById('total').value = total;
        calculateKekurangan();
    }
}

function calculateDays(startDate, endDate) {
    const date1 = new Date(startDate);
    const date2 = new Date(endDate);
    const diffTime = Math.abs(date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
}

function calculateKekurangan() {
    const total = document.getElementById('total').value;
    const dp = document.getElementById('dp').value;
    const kekurangan = total - dp;
    document.getElementById('kekurangan').value = kekurangan < 0 ? 0 : kekurangan;
}

// Add event listeners for date inputs
document.getElementById('tgl_ambil').addEventListener('change', calculateTotal);
document.getElementById('tgl_kembali').addEventListener('change', calculateTotal);
document.getElementById('supir').addEventListener('change', calculateTotal);
</script>
</body>
</html>
