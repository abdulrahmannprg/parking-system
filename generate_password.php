<?php
// كلمة المرور الأصلية للسائق
$password = "driver123";  // يمكنك تغييرها إلى كلمة مرور جديدة للسائق

// تشفير كلمة المرور باستخدام password_hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// طباعة الكلمة المشفرة
echo "الكلمة المشفرة للسائق: " . $hashed_password;
?>
