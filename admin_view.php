<?php
$servername = "localhost";
$username = "sqluser";
$password = "password";
$dbname = "semlima_db";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari tabel reports
$sql = "SELECT id, npm, name, report, image_path, submitted_at FROM reports";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan Mahasiswa</title>
    <link rel="stylesheet" href="admin.css"> <!-- Pastikan CSS sudah link dengan benar -->
</head>
<body>
    <div class="admin-wrapper">
        <!-- Pastikan judul ada di sini -->
        <h1>Data Laporan Mahasiswa</h1>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th> <!-- Kolom untuk nomor urut -->
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Laporan</th>
                    <th>Gambar</th>
                    <th>Waktu Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi dan query
                $servername = "localhost";
                $username = "sqluser";
                $password = "password";
                $dbname = "semlima_db";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, npm, name, report, image_path, submitted_at FROM reports ORDER BY id ASC";
                $result = $conn->query($sql);
                $counter = 1;

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $counter++; ?></td> <!-- Nomor urut -->
                            <td><?php echo $row['npm']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['report']; ?></td>
                            <td>
                                <?php if ($row['image_path']): ?>
                                    <a href="<?php echo $row['image_path']; ?>" target="_blank">Lihat Gambar</a>
                                <?php else: ?>
                                    Tidak ada gambar
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['submitted_at']; ?></td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="6">Tidak ada data yang tersedia</td>
                    </tr>
                <?php endif;
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

