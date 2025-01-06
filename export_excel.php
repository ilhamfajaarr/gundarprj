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
$sql = "SELECT id, npm, name, report, image_path, submitted_at FROM reports ORDER BY id ASC";
$result = $conn->query($sql);

// Header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=data_laporan_mahasiswa.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Mulai output tabel
echo "<table border='1'>";
echo "<tr>";
echo "<th>No</th>";
echo "<th>NPM</th>";
echo "<th>Nama</th>";
echo "<th>Laporan</th>";
echo "<th>Gambar</th>";
echo "<th>Waktu Pengajuan</th>";
echo "</tr>";

if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter++ . "</td>";
        echo "<td>" . $row['npm'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['report'] . "</td>";
        echo "<td>" . ($row['image_path'] ? $row['image_path'] : "Tidak ada gambar") . "</td>";
        echo "<td>" . $row['submitted_at'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Tidak ada data yang tersedia</td></tr>";
}

echo "</table>";

// Tutup koneksi
$conn->close();
?>
