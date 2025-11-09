<?php
include 'db_connect.php';

if (!isset($_GET['spot_id'])) {
    die("لم يتم تحديد الموقف.");
}

$spot_id = $_GET['spot_id'];

$result = mysqli_query($conn, "SELECT * FROM parking_spots WHERE id='$spot_id' AND status='available'");
if (!$result || mysqli_num_rows($result) == 0) {
    die("الموقف غير متاح أو تم حجزه مسبقًا.");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $car_number = $_POST['car_number'];
    $phone_number = $_POST['phone_number'];
    $duration = $_POST['duration'];

    // إضافة الحجز
    mysqli_query($conn, "INSERT INTO bookings (customer_name, car_number, phone_number, duration, spot_id)
                         VALUES ('$customer_name','$car_number','$phone_number','$duration','$spot_id')");

    // تحديث حالة الموقف
    mysqli_query($conn, "UPDATE parking_spots SET status='booked' WHERE id='$spot_id'");

    // عرض رسالة نجاح ثم إعادة التوجيه بعد 3 ثواني
    echo "
    <!DOCTYPE html>
    <html lang='ar'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>تم الحجز</title>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
        <meta http-equiv='refresh' content='3;url=index.php'> <!-- إعادة التوجيه بعد 3 ثواني -->
    </head>
    <body>
        <div class='container mt-5'>
            <div class='alert alert-success text-center'>
                <h3>تم الحجز بنجاح!</h3>
                <p>تم حجز الموقف <strong>{$row['spot_number']}</strong> بنجاح.</p>
                <p>ستتم إعادة توجيهك تلقائيًا إلى الصفحة الرئيسية...</p>
                <a href='index.php' class='btn btn-primary mt-2'>العودة فورًا</a>
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <input type="number" name="duration" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success btn-block">تأكيد الحجز</button>
    </form>
</div>
</body>
</html>
