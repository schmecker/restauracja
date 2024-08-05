<?php include "header.php"; ?>
<?php include "../connect.php"; ?>

<?php



if (!isset($_GET['id'])) {
    header("Location: admin_reservations.php");
    exit();
}

$id = $_GET['id'];
$reservationQuery = "SELECT * FROM reservations WHERE id=$id";
$reservationResult = mysqli_query($con, $reservationQuery);
$reservation = mysqli_fetch_assoc($reservationResult);

if (!$reservation) {
    echo "Rezerwacja nie znaleziona.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time = mysqli_real_escape_string($con, $_POST['time']);
    $person = mysqli_real_escape_string($con, $_POST['person']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);

    $updateQuery = "UPDATE reservations SET date='$date', time='$time', person='$person', name='$name', email='$email', phone='$phone' WHERE id=$id";

    if (mysqli_query($con, $updateQuery)) {
        echo "<div style='text-align:center; font-size:1.3em; color:green;'>Data Updated Successfully</div>";
        header("Location: admin_reservations.php");
        exit();
    } else {
        echo "<div style='text-align:center; font-size:1.3em; color:red;'>Error updating data: " . mysqli_error($con) . "</div>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Edytuj rezerwację</title>
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

        <!-- Sidebar Start -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
        <?php include 'navbar.php'; ?>
            <!-- Navbar End -->

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- Form for editing a reservation -->
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Edytuj rezerwację</h6>
                            <form action="edit_reservation.php?id=<?php echo $id; ?>" method="post">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floatingDate" name="date" placeholder="Wybierz datę" value="<?php echo $reservation['date']; ?>" required>
                                    <label for="floatingDate">Data</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" id="floatingTime" name="time" placeholder="Wybierz godzinę" value="<?php echo $reservation['time']; ?>" required>
                                    <label for="floatingTime">Godzina</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="floatingPerson" name="person" placeholder="Podaj ilość osób" value="<?php echo $reservation['person']; ?>" required>
                                    <label for="floatingPerson">Ilość osób</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingName" name="name" placeholder="Podaj imię i nazwisko" value="<?php echo $reservation['name']; ?>" required>
                                    <label for="floatingName">Imię i nazwisko</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="Podaj email" value="<?php echo $reservation['email']; ?>" required>
                                    <label for="floatingEmail">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingPhone" name="phone" placeholder="Podaj telefon" value="<?php echo $reservation['phone']; ?>" required>
                                    <label for="floatingPhone">Telefon</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Zaktualizuj teraz</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

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
