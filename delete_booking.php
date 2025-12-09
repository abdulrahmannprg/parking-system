<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';

if (!isset($_GET['id'])) {
    die("لم يتم تحديد الحجز.");
}

$booking_id = (int)$_GET['id'];

// جلب الحجز لمعرفة رقم الموقف
$res = mysqli_query($conn, "SELECT spot_id FROM bookings WHERE id = '$booking_id'");
if (!$res || mysqli_num_rows($res) == 0) {
    die("الحجز غير موجود.");
}

$booking = mysqli_fetch_assoc($res);
$spot_id = (int)$booking['spot_id'];

// حذف الحجز
mysqli_query($conn, "DELETE FROM bookings WHERE id = '$booking_id'");

// إرجاع الموقف إلى متاح
mysqli_query($conn, "UPDATE parking_spots SET status = 'available' WHERE id = '$spot_id'");

// الرجوع للوحة التحكم مع رسالة نجاح
header('Location: dashboard.php?msg=booking_deleted');
exit;
?>
