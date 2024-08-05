<?php include "header.php"; ?>
<?php include "../connect.php"; ?>

<?php
if (!isset($_GET['a'])) {
    header("Location: menu_view.php");
    exit();
}

$id = $_GET['a'];
$result = mysqli_query($con, "SELECT * FROM menu WHERE id = '$id'");
$item = mysqli_fetch_assoc($result);

if (!$item) {
    echo "Item not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat = $_POST['cat'];
    $title = $_POST['title'];
    $detail = $_POST['detail'];
    $price = $_POST['price'];
    $image = $item['image'];

    if (!empty($_FILES['img']['name'])) {
        $image = "mimg/" . $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], $image);
    }

    $sql = "UPDATE menu SET category='$cat', title='$title', description='$detail', price='$price', image='$image' WHERE id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "<div style='text-align:center; font-size:1.3em; color:green;'>Data Updated Successfully</div>";
        header("Location: menu_view.php");
        exit();
    } else {
        echo "<div style='text-align:center; font-size:1.3em; color:red;'>Error updating data: " . mysqli_error($con) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
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
                    <!-- Form for editing a menu item -->
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Edytuj pozycję w menu</h6>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="cat" id="floatingCategory" required>
                                        <option value="" selected>Wybierz kategorię</option>
                                        <?php
                                        $result = mysqli_query($con, "SELECT DISTINCT catnm FROM food_cat");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = ($row['catnm'] == $item['category']) ? 'selected' : '';
                                            echo "<option value='" . $row['catnm'] . "' $selected>" . $row['catnm'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="floatingCategory">Kategoria</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingTitle" name="title" placeholder="Podaj nazwę" value="<?php echo $item['title']; ?>" required>
                                    <label for="floatingTitle">Podaj nazwę</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Podaj opis" id="floatingDetail" name="detail" style="height: 150px;" required><?php echo $item['description']; ?></textarea>
                                    <label for="floatingDetail">Podaj opis</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number"  class="form-control" id="floatingPrice" name="price" placeholder="Podaj cenę" value="<?php echo $item['price']; ?>" required>
                                    <label for="floatingPrice">Podaj cenę</label>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Dodaj zdjęcie</label>
                                    <input class="form-control" type="file" id="formFile" name="img">
                                    <p>Obecne zdjęcie:</p>
                                    <img src="<?php echo $item['image']; ?>" width="70" height="70" alt="<?php echo $item['title']; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Now</button>
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
