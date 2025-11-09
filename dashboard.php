<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- شريط التنقل -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">🚗 لوحة التحكم</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="booking.php">حجز موقف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">لوحة التحكم</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- محتوى الصفحة -->
    <div class="container mt-4">
        <h2>الإحصائيات</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">إجمالي المواقف</h5>
                        <p class="card-text">
                            <?php
                                include 'db_connect.php';
                                $result = mysqli_query($conn, "SELECT COUNT(*) FROM parking_spots");
                                $row = mysqli_fetch_assoc($result);
                                echo $row['COUNT(*)'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">المواقف المتاحة</h5>
                        <p class="card-text">
                            <?php
                                $result = mysqli_query($conn, "SELECT COUNT(*) FROM parking_spots WHERE status = 'available'");
                                $row = mysqli_fetch_assoc($result);
                                echo $row['COUNT(*)'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">المواقف المحجوزة</h5>
                        <p class="card-text">
                            <?php
                                $result = mysqli_query($conn, "SELECT COUNT(*) FROM parking_spots WHERE status = 'booked'");
                                $row = mysqli_fetch_assoc($result);
                                echo $row['COUNT(*)'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
