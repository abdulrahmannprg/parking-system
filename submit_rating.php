<?php
include 'db_connect.php';

if (isset($_GET['id']) && isset($_POST['rating'])) {
    $booking_id = $_GET['id'];
    $rating = $_POST['rating'];

    // التحقق من أن التقييم بين 1 و 5
    if ($rating < 1 || $rating > 5) {
        echo "
        <html lang='ar'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>خطأ في التقييم</title>
            <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>
            <div class='container mt-5'>
                <div class='alert alert-danger text-center'>
                    <h3>خطأ في التقييم!</h3>
                    <p>التقييم يجب أن يكون بين 1 و 5 فقط.</p>
                    <a href='index.php' class='btn btn-primary'>العودة إلى الصفحة الرئيسية</a>
                </div>
            </div>
        </body>
        </html>
        ";
        exit;
    }

    // تحديث التقييم في قاعدة البيانات
    $update_rating = "UPDATE bookings SET rating = '$rating' WHERE id = '$booking_id'";

    if (mysqli_query($conn, $update_rating)) {
        echo "
        <html lang='ar'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>تم إرسال التقييم</title>
            <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>
            <div class='container mt-5'>
                <div class='alert alert-success text-center'>
                    <h3>تم إرسال التقييم بنجاح!</h3>
                    <p>شكرًا لك على تقديم تقييمك.</p>
                    <a href='index.php' class='btn btn-primary'>العودة إلى الصفحة الرئيسية</a>
                </div>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "خطأ في إرسال التقييم. يرجى المحاولة لاحقًا.";
    }
} else {
    echo "معلومات غير صحيحة.";
}
?>
