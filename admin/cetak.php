<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        /* CSS untuk tampilan cetak */
        @media print {
            @page {
                margin: 0; /* Hilangkan margin yang biasanya memunculkan URL di header/footer */
            }
            body {
                margin: 1cm; /* Tambahkan margin internal agar dokumen rapi */
            }

            /* Hilangkan elemen yang tidak diperlukan */
            .no-print {
                display: none;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2 align="center">Laporan Peminjaman Buku</h2>
    <table>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status Peminjaman</th>
        </tr>
        <?php
        include "koneksi.php"; // Pastikan koneksi.php sudah ada dan mengatur variabel $conn
        $i = 1;

        // Query untuk mengambil data peminjaman
        $query = mysqli_query($conn, "SELECT * FROM tbl_transaksi t
                                       LEFT JOIN tbl_member m ON m.nik = t.nik
                                       LEFT JOIN tabel_kembali k ON t.id_transaksi = k.id_transaksi");

        // Loop untuk menampilkan data
        while($data = mysqli_fetch_array($query)) {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['nopol']; ?></td>
            <td><?php echo $data['tgl_ambil']; ?></td>
            <td><?php echo $data['tgl_kembali']; ?></td>
            <td><?php echo $data['status']; ?></td>
        </tr>
        <?php
        }
        ?>
    </table>

    <script>
        window.print(); // Memanggil dialog print
        setTimeout(function() {
            window.close(); // Menutup jendela setelah cetak selesai
        }, 100);
    </script>

</body>
</html>
