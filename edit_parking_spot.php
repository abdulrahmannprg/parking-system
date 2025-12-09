<?php
session_start();

// السماح للمشرف فقط
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';

if (!isset($_GET['id'])) {
    die("لم يتم تحديد الموقف.");
}

$id = (int)$_GET['id'];

// جلب بيانات الموقف
$result = mysqli_query($conn, "SELECT * FROM parking_spots WHERE id = '$id'");
if (!$result || mysqli_num_rows($result) == 0) {
    die("الموقف غير موجود.");
}

$spot = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spot_number = $_POST['spot_number'];
    $status      = $_POST['status'];
    $is_vip      = isset($_POST['is_vip']) ? 1 : 0;

    $sql = "UPDATE parking_spots 
            SET spot_number = '$spot_number',
                status      = '$status',
                is_vip      = '$is_vip'
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "حدث خطأ أثناء تعديل الموقف: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل موقف</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="text-center mb-4">تعديل الموقف رقم: <?= htmlspecialchars($spot['spot_number']); ?></h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>رقم الموقف:</label>
            <input type="text" name="spot_number" class="form-control" 
                   value="<?= htmlspecialchars($spot['spot_number']); ?>" required>
        </div>

        <div class="form-group">
            <label>الحالة:</label>
            <select name="status" class="form-control">
                <option value="available" <?= $spot['status'] === 'available' ? 'selected' : ''; ?>>متاح</option>
                <option value="booked" <?= $spot['status'] === 'booked' ? 'selected' : ''; ?>>محجوز</option>
            </select>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" name="is_vip" class="form-check-input" id="vipCheck"
                   <?= $spot['is_vip'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="vipCheck">موقف VIP</label>
        </div>

        <button type="submit" class="btn btn-warning btn-block">حفظ التعديلات</button>
        <a href="dashboard.php" class="btn btn-secondary btn-block mt-2">الرجوع للوحة التحكم</a>
    </form>
</div>
</body>
</html>
