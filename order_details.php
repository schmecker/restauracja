<?php include "header.php"; ?>
<?php include "connect.php"; ?>
<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_purchases.php");
    exit();
}

$order_id = $_GET['id'];
$order_items_result = mysqli_query($con, "SELECT order_items.*, menu.title, menu.image 
                                          FROM order_items 
                                          JOIN menu ON order_items.p_id = menu.id 
                                          WHERE order_items.order_id = '$order_id'");
$order_result = mysqli_query($con, "SELECT * FROM orders WHERE id = '$order_id'");
$order = mysqli_fetch_assoc($order_result);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Szczegóły Zamówienia</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .content {
            margin-top: 120px; 
        }
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            min-height: calc(100vh - 160px); 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .business-card {
            position: relative;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
        }
        .business-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0);
            z-index: 1;
            transition: background 0.3s ease; 
        }
        .business-card:hover::before {
            background: rgba(0, 0, 0, 0.5); 
        }
        .business-card:hover {
            transform: scale(1.05); 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); 
        }
        .business-card .image-container {
            margin-bottom: 15px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .business-card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .business-card-container .business-card {
            flex: 1 0 calc(50% - 10px); 
            box-sizing: border-box;
        }
        .card-content {
            position: relative;
            z-index: 2;
            color: #000; 
        }
        .back-button {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">

        <!-- Sidebar Start -->
        <?php 
        $sidebar_path = 'sidebar.php';
        if (file_exists($sidebar_path)) {
            include $sidebar_path;
        } else {
            echo "<!-- Sidebar not found -->";
        }
        ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
        <?php 
        $navbar_path = 'navbar.php';
        if (file_exists($navbar_path)) {
            include $navbar_path;
        } else {
            echo "<!-- Navbar not found -->";
        }
        ?>
            <!-- Navbar End -->

            <!-- Order Details Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="order-summary">
                            <div>
                                <h1 class="mb-4">Szczegóły Zamówienia #<?php echo $order_id; ?></h1>
                                <p><strong>Numer zamówienia:</strong> <?php echo $order['id']; ?></p>
                                <p><strong>Imię i nazwisko:</strong> <?php echo $order['name']; ?></p>
                                <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                                <p><strong>Adres dostawy:</strong> <?php echo $order['address']; ?></p>
                                <p><strong>Telefon:</strong> <?php echo $order['phone']; ?></p>
                                <p><strong>Wartość:</strong> <?php echo $order['total']; ?> zł</p>
                                <p><strong>Data złożenia:</strong> <?php echo $order['created_at']; ?></p>
                            </div>
                            <div class="back-button">
                                <a href="view_purchases.php" class="btn btn-primary">Powrót do zamówień</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="business-card-container">
                            <?php if (mysqli_num_rows($order_items_result) > 0): ?>
                                <?php while ($item = mysqli_fetch_assoc($order_items_result)): ?>
                                    <div class="business-card">
                                        <div class="image-container">
                                            <img src="admin/<?php echo $item['image']; ?>" class="img-fluid" alt="Image">
                                        </div>
                                        <div class="card-content">
                                            <h4><?php echo $item['title']; ?></h4>
                                            <p>Ilość: <?php echo $item['qty']; ?></p>
                                            <p>Cena: <?php echo $item['price']; ?> zł</p>
                                            <p>Suma: <?php echo $item['total']; ?> zł</p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-center">Brak pozycji w zamówieniu.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Details End -->

            <!-- Footer Start -->
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php include "footer.php"; ?>
