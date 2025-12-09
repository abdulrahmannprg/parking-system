<?php
session_start();

// يسمح فقط للمشرف
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

// إحصائيات المواقف
$vip_available     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_spots WHERE is_vip = 1 AND status='available'"))['c'];
$regular_available = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_spots WHERE is_vip = 0 AND status='available'"))['c'];
$total_booked      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_spots WHERE status='booked'"))['c'];

// متوسط التقييم
$avg_rating_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS avg_rating FROM bookings WHERE rating IS NOT NULL"));
$avg_rating = $avg_rating_row['avg_rating'] ? round($avg_rating_row['avg_rating'], 1) : null;

// جميع الحجوزات
$bookings = mysqli_query($conn,"
    SELECT b.*, p.spot_number, p.is_vip
    FROM bookings b
    LEFT JOIN parking_spots p ON b.spot_id = p.id
    ORDER BY b.booking_time DESC
");

$msg = isset($_GET['msg']) && $_GET['msg'] === "booking_deleted" 
       ? "تم إلغاء الحجز وإرجاع الموقف إلى متاح ✔" 
       : "";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لوحة تحكم المشرف</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

<style>
    body { background:#f4f6f9; }

    /* جعل الجدول نفسه أصغر */
    .table-box {
        max-width: 900px;
        margin: auto;
    }

    table.table-sm td,
    table.table-sm th {
        padding: 6px !important;
    }
</style>

</head>
<body>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="dashboard.php">لوحة تحكم المشرف</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link active" href="dashboard.php">لوحة التحكم</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">

    <!-- عنوان -->
    <h3 class="text-center mb-4">إدارة الحجوزات</h3>

    <?php if ($msg): ?>
        <div class="alert alert-success text-center"><?= $msg; ?></div>
    <?php endif; ?>

    <!-- الإحصائيات -->
    <div class="row text-center mb-4">
        <div class="col-md-3 mb-2">
            <div class="card shadow-sm"><div class="card-body">
                <h6>VIP المتاحة</h6><h4 class="text-danger"><?= $vip_available ?></h4>
            </div></div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card shadow-sm"><div class="card-body">
                <h6>العادية المتاحة</h6><h4 class="text-primary"><?= $regular_available ?></h4>
            </div></div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card shadow-sm"><div class="card-body">
                <h6>المحجوزة</h6><h4 class="text-secondary"><?= $total_booked ?></h4>
            </div></div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card shadow-sm"><div class="card-body">
                <h6>متوسط التقييم</h6>
                <?php if ($avg_rating !== null): ?>
                    <h4><?= $avg_rating ?>/5</h4>
                    <?php for($i=1;$i<=5;$i++): ?>
                        <?= $i <= round($avg_rating) 
                            ? "<i class='fas fa-star' style='color:gold'></i>" 
                            : "<i class='far fa-star' style='color:gold'></i>" ?>
                    <?php endfor; ?>
                <?php else: ?>
                    <p>لا توجد تقييمات</p>
                <?php endif; ?>
            </div></div>
        </div>
    </div>

    <!-- زر إضافة موقف -->
    <div class="d-flex justify-content-between align-items-center mb-3 table-box">
        <h5 class="mb-0">قائمة الحجوزات</h5>
        <a href="add_parking_spot.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة موقف
        </a>
    </div>

    <!-- جدول الحجوزات -->
<h5 class="mt-4 mb-3">قائمة الحجوزات</h5>

<div class="table-responsive">
    <table class="table table-bordered table-sm text-center">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>العميل</th>
                <th>السيارة</th>
                <th>الجوال</th>
                <th>الموقف</th>
                <th>النوع</th>
                <th>المدة</th>
                <th>التوقيت</th>
                <th>التقييم</th>
                <th>عمليات</th>
            </tr>
        </thead>

        <tbody>
        <?php if (mysqli_num_rows($bookings) > 0): ?>
            <?php while($b = mysqli_fetch_assoc($bookings)): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= $b['customer_name'] ?></td>
                <td><?= $b['car_number'] ?></td>
                <td><?= $b['phone_number'] ?></td>
                <td><?= $b['spot_number'] ?></td>

                <td>
                    <?= $b['is_vip']==1 
                        ? "<span class='badge badge-danger'>VIP</span>" 
                        : "<span class='badge badge-primary'>عادي</span>" ?>
                </td>

                <td><?= $b['duration'] ?></td>
                <td><?= $b['booking_time'] ?></td>

                <td>
                    <?php 
                    if ($b['rating'] !== null) {
                        for ($i=1; $i<=5; $i++) {
                            echo $i <= $b['rating']
                                ? "<i class='fas fa-star' style='color:gold'></i>"
                                : "<i class='far fa-star' style='color:gold'></i>";
                        }
                    } else {
                        echo "<span class='text-muted'>لا يوجد</span>";
                    }
                    ?>
                </td>

                <td>
                    <!-- تعديل الموقف — لون أزرق أساسي -->
                    <a href="edit_parking_spot.php?id=<?= $b['spot_id'] ?>" 
                       class="btn btn-primary btn-sm mb-1">
                       <i class="fas fa-edit"></i> تعديل الموقف
                    </a>

                    <!-- إلغاء الحجز -->
                    <a href="delete_booking.php?id=<?= $b['id'] ?>"
                       onclick="return confirm('هل أنت متأكد من إلغاء هذا الحجز؟');"
                       class="btn btn-danger btn-sm">
                       <i class="fas fa-times"></i> إلغاء الحجز
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr><td colspan="10">لا توجد حجوزات</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
