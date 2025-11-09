<?php
include 'db_connect.php';

// استعلام المواقف المتاحة
$spots = mysqli_query($conn, "SELECT * FROM parking_spots WHERE status='available'");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>حجز المواقف</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">المواقف المتاحة للحجز</h2>
    <div class="row">
        <?php if(mysqli_num_rows($spots) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($spots)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['spot_number']; ?></h5>
                            <p class="card-text">متاح</p>
                            <!-- زر الحجز يذهب لصفحة process_booking.php -->
                            <a href="process_booking.php?spot_id=<?= $row['id']; ?>" class="btn btn-success btn-block">حجز</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">لا توجد مواقف متاحة حالياً.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
