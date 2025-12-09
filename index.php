<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #map {
            width: 100%;
            height: 260px; /* تكبير بسيط */
            border-radius: 10px;
            margin-top: 15px;
            margin-bottom: 30px;
        }
        .card { padding: 15px; }
        .card-title { font-size: 20px; margin-bottom: 5px; }
        .card-text { font-size: 14px; margin-bottom: 10px; }
        .welcome-box {
            margin-top: 15px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" style="font-size:18px;">نظام مواقف السيارات الذكي</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" style="font-size:14px;">
                <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="reviews.php">التقييمات</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <!-- نص الترحيب -->
    <div class="welcome-box text-center">
        <h4 style="font-size:22px;">مرحبًا بك في نظام مواقف السيارات الذكي!</h4>
        <p style="font-size:15px; margin-bottom:5px;">
            يتيح لك النظام حجز المواقف بسهولة داخل الكلية.
        </p>
    </div>

    <!-- بطاقات المواقف -->
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <div class="card shadow-sm text-center">
                <h5 class="card-title">مواقف VIP</h5>
                <p class="card-text">مواقف مميزة قريبة من المدخل.</p>
                <a href="booking.php?type=vip" class="btn btn-danger btn-block btn-sm">عرض مواقف VIP</a>
            </div>
        </div>

        <div class="col-md-6 mb-2">
            <div class="card shadow-sm text-center">
                <h5 class="card-title">المواقف العادية</h5>
                <p class="card-text">مواقف متاحة لجميع المستخدمين.</p>
                <a href="booking.php?type=regular" class="btn btn-primary btn-block btn-sm">عرض المواقف المتاحة</a>
            </div>
        </div>
    </div>

    <!-- الخريطة -->
    <h6 class="text-center">موقع الكلية</h6>
    <div id="map"></div>

</div>

<!-- Map Script -->
<script>
    var collegeLat = 24.758701;
    var collegeLng = 46.691632;

    var map = L.map('map').setView([collegeLat, collegeLng], 18);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    L.marker([collegeLat, collegeLng])
        .addTo(map)
        .bindPopup("موقع الكلية")
        .openPopup();
</script>

</body>
</html>
