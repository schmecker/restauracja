<!DOCTYPE html>
<html lang="en">
<?php include '../connect.php'; ?>

<head>
    <meta charset="utf-8">
    <title>Szczegóły zamówienia</title>
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
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
    <?php include 'sidebar.php'; ?>

        <!-- Content Start -->
        <div class="content">
        <?php include 'navbar.php'; ?>

            <!-- Order Details Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Szczegóły zamówienia</h6>
                        <a href="view_orders.php" class="btn btn-primary">Powrót</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">ID</th>
                                    <th scope="col">ID zamówienia</th>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">Ilość</th>
                                    <th scope="col">Cena</th>
                                    <th scope="col">Łączna kwota</th>
                                    <th scope="col">Data utworzenia</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if (isset($_GET['order_id'])) {
                                    $order_id = $_GET['order_id'];
                                    $s = mysqli_query($con, "
                                        SELECT oi.id, oi.order_id, m.title AS product_title, oi.qty, oi.price, oi.total, oi.created_at 
                                        FROM order_items oi 
                                        JOIN menu m ON oi.p_id = m.id 
                                        WHERE oi.order_id='$order_id'");
                                    while ($r = mysqli_fetch_array($s)) {
                            ?>
                                <tr>
                                    <td><?php echo $r['id']; ?></td>
                                    <td><?php echo $r['order_id']; ?></td>
                                    <td><?php echo $r['product_title']; ?></td>
                                    <td><?php echo $r['qty']; ?></td>
                                    <td><?php echo $r['price']; ?> zł</td>
                                    <td><?php echo $r['total']; ?> zł</td>
                                    <td><?php echo $r['created_at']; ?></td>
                                </tr>
                            <?php 
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Order Details End -->
            
            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- Widgets go here... -->
                </div>
            </div>
            <!-- Widgets End -->
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
