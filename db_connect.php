<?php
$servername = "localhost";
$username = "root"; // اسم المستخدم لقاعدة البيانات
$password = ""; // كلمة المرور لقاعدة البيانات
$dbname = "ss"; // اسم قاعدة البيانات

// الاتصال بقاعدة البيانات
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}
?>
