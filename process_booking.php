<?php
include 'db_connect.php';

if (!isset($_GET['spot_id'])) {
    die("لم يتم تحديد الموقف.");
}

$spot_id = $_GET['spot_id'];

// التحقق من أن الموقف متاح
$result = mysqli_query($conn, "SELECT * FROM parking_spots WHERE id='$spot_id' AND status='available'");
if (!$result || mysqli_num_rows($result) == 0) {
    die("الموقف غير متاح أو تم حجزه مسبقًا.");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $car_number    = $_POST['car_number'];
    $phone_number  = $_POST['phone_number'];
    $duration      = $_POST['duration'];

    // إضافة الحجز في جدول bookings
    $insert_booking = mysqli_query(
        $conn,
        "INSERT INTO bookings (customer_name, car_number, phone_number, duration, spot_id)
         VALUES ('$customer_name', '$car_number', '$phone_number', '$duration', '$spot_id')"
    );

    if (!$insert_booking) {
        die("حدث خطأ أثناء حفظ الحجز.");
    }

    // الحصول على رقم الحجز الجديد
    $booking_id = mysqli_insert_id($conn);

    // تحديث حالة الموقف إلى محجوز
    mysqli_query($conn, "UPDATE parking_spots SET status='booked' WHERE id='$spot_id'");

    // عرض رسالة نجاح + نموذج التقييم مع id الحجز الصحيح
    echo "
    <!DOCTYPE html>
    <html lang='ar'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>تم الحجز بنجاح</title>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container mt-5'>
            <div class='alert alert-success text-center'>
                <h3>تم الحجز بنجاح!</h3>
                <p>تم حجز الموقف <strong>{$row['spot_number']}</strong>.</p>
                <p>الآن يمكنك تقييم الخدمة:</p>

                <form method='POST' action='submit_rating.php?id={$booking_id}' class='mt-3'>
                    <div class='form-group'>
                        <label>التقييم (من 1 إلى 5):</label>
                        <input type='number' name='rating' min='1' max='5' class='form-control' required>
                    </div>

                    <button type='submit' class='btn btn-primary btn-block'>إرسال التقييم</button>
                    <a href='index.php' class='btn btn-secondary btn-block mt-2'>العودة للصفحة الرئيسية</a>
                </form>
            </div>
        </div>
    </body>
    </html>
    ";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>حجز الموقف <?= $row['spot_number']; ?></title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">حجز الموقف: <?= $row['spot_number']; ?></h2>

    <form method="POST">
        <div class="form-group">
            <label>الاسم الكامل:</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>رقم السيارة:</label>
            <input type="text" name="car_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label>رقم الجوال:</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label>مدة الحجز (بالساعات):</label>
            <input type="number" name="duration" min="1" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">تأكيد الحجز</button>
        <a href="index.php" class="btn btn-danger btn-block mt-2">إلغاء الحجز</a>
    </form>
</div>

</body>
</html>
