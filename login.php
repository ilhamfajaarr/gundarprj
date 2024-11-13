<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "sqluser";
$password = "password";
$dbname = "semlima_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];

        if ($role === 'student') {
            echo json_encode(["status" => "success", "role" => "student"]);
        } elseif ($role === 'admin') {
            echo json_encode(["status" => "success", "role" => "admin"]);
        }
    } else {
        echo json_encode(["status" => "failure"]);
    }

    $stmt->close();
}
$conn->close();
?>
