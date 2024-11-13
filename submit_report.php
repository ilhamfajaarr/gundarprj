<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "sqluser";
$password = "password";
$dbname = "semlima_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
}

$message = "";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $npm = $_POST['class'];
        $name = $_POST['name'];
        $report = $_POST['complaint'];
        $submitted_at = date('Y-m-d H:i:s');

        // Cek apakah NPM ada di database users
        $npmCheckQuery = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $npmCheckQuery->bind_param("s", $npm);
        $npmCheckQuery->execute();
        $npmCheckResult = $npmCheckQuery->get_result();

        if ($npmCheckResult->num_rows === 0) {
            throw new Exception("NPM tidak ditemukan di database. Silakan periksa kembali.");
        }

        $npmCheckQuery->close();

        // Proses upload gambar
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_tmp_path = $_FILES['image']['tmp_name'];
            $image_name = basename($_FILES['image']['name']);
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . $image_name;

            if (move_uploaded_file($image_tmp_path, $image_path)) {
                $stmt = $conn->prepare("INSERT INTO reports (npm, name, report, image_path, submitted_at) VALUES (?, ?, ?, ?, ?)");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("sssss", $npm, $name, $report, $image_path, $submitted_at);

                if ($stmt->execute()) {
                    $message = "<div class='success'>Laporan berhasil dikirim</div>";
                } else {
                    throw new Exception("Error: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Failed to upload image");
            }
        } else {
            throw new Exception("Gambar wajib diunggah untuk mengirim laporan");
        }
    }
} catch (Exception $e) {
    $message = "<div class='error'>Error: " . $e->getMessage() . "</div>";
}

$conn->close();
echo $message;
?>

