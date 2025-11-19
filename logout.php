<?php
session_start();
session_unset();  // إلغاء جميع المتغيرات في الجلسة
session_destroy();  // تدمير الجلسة
header("Location: login.php");  // إعادة التوجيه إلى صفحة تسجيل الدخول بعد الخروج
exit();
?>
