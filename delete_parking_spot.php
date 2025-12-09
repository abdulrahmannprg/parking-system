<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';

if (!isset($_GET['spot_id'])) {
    die("لم يتم تحديد الموقف.");
}

$id = (int)$_GET['spot_id'];

$sql = "DELETE FROM parking_spots WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    header('Location: dashboard.php');
    exit;
} else {
    echo "حدث خطأ أثناء حذف الموقف: " . mysqli_error($conn);
}
?>
