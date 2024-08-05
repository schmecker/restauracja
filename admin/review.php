<!DOCTYPE html>
<html lang="en">
<?php include '../connect.php';  ?>

<head>
    <meta charset="utf-8">
    <title>BlueShard Adminpanel</title>
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
        <div class="content" >
        <?php include 'navbar.php'; ?>


<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Opinie klientow</h6>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr align=center class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Imie</th>
                        <th scope="col">Ocena</th>
                        <th scope="col">Tresc</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $s = mysqli_query($con,"select * from review");
                    while($r = mysqli_fetch_array($s))
                    {
                    ?>
                        <tr align=center>
                            <td><?php echo $r['id']; ?></td>
                            <td><?php echo $r['name']; ?></td>
                            <td><?php echo $r['review']; ?></td>
                            <td><?php echo $r['description']; ?></td>
                        </tr>    
                    <?php    
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->

<!-- Doughnut Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <h6 class="mb-4">Wykres opini</h6>
        <div style="max-width: 500px; margin: 0 auto;">
            <canvas id="doughnut-chart"></canvas>
        </div>
    </div>
</div>
<!-- Doughnut Chart End -->

            
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('doughnut-chart').getContext('2d');

    // Fetch the review data from the server
    fetch('get_reviews_data.php')
        .then(response => response.json())
        .then(data => {
            const reviewCounts = data.reviewCounts;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Wysmienite', 'Bardzo Dobre', 'Dobre', 'Slabe', 'Bardzo Slabe'],
                    datasets: [{
                        label: 'Opinie',
                        data: reviewCounts,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Opinie'
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching review data:', error));
});
</script>
