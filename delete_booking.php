<?php
session_start();
include 'db_connect.php';

// التحقق من أن المستخدم قد سجل الدخول وأنه مشرف
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');  // إذا لم يكن مشرفًا أو لم يسجل دخوله، إعادة التوجيه إلى صفحة تسجيل الدخول
    exit;
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // استعلام لحذف الحجز
    $sql = "DELETE FROM bookings WHERE id = $booking_id";
    mysqli_query($conn, $sql);

    // إعادة التوجيه إلى لوحة التحكم بعد الحذف
    header("Location: dashboard.php");
    exit;
}
?>
