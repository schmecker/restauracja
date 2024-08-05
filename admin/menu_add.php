<!DOCTYPE html>
<html lang="en">

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

        <!-- Sidebar Start -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <?php include 'navbar.php'; ?>
            <!-- Navbar End -->

            <!-- Notifications Start -->
            <div class="container-fluid mt-3">
                <?php
                // Handle form submission for new menu item
                if (isset($_POST['s'])) {
                    $cat = $_POST['cat'];
                    $title = $_POST['title'];
                    $det = $_POST['detail'];
                    $price = $_POST['price'];
                    $i = "mimg/" . $_FILES['img']['name'];
                    move_uploaded_file($_FILES['img']['tmp_name'], $i);
                    include "../connect.php";
                    if (mysqli_query($con, "INSERT INTO menu (category, title, description, price, image) VALUES ('$cat', '$title', '$det', '$price', '$i')")) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Dane zostały dodane pomyślnie!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Wystąpił błąd podczas dodawania danych. Spróbuj ponownie.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    }
                }

                // Handle form submission for new category
                if (isset($_POST['s_cat'])) {
                    include "../connect.php";
                    $cat = mysqli_real_escape_string($con, $_POST['cat']);
                    if (mysqli_query($con, "INSERT INTO food_cat(catnm) VALUES('$cat')")) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Kategoria została dodana pomyślnie!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Wystąpił błąd podczas dodawania kategorii. Spróbuj ponownie.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    }
                }

                // Handle form submission for new table
                if (isset($_POST['s_table'])) {
                    include "../connect.php";
                    $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
                    if ($capacity < 1 || $capacity > 10) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Nieprawidłowa liczba osób. Wprowadź wartość między 1 a 10.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } else {
                        if (mysqli_query($con, "INSERT INTO tables(capacity) VALUES('$capacity')")) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Stolik został dodany pomyślnie!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Wystąpił błąd podczas dodawania stolika. Spróbuj ponownie.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                        }
                    }
                }
                ?>
            </div>
            <!-- Notifications End -->

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- Form for adding a new menu item -->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Dodaj nową pozycję do menu</h6>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="cat" id="floatingCategory" required>
                                        <option value="" selected>Wybierz kategorię</option>
                                        <?php
                                        include "../connect.php";
                                        $result = mysqli_query($con, "SELECT DISTINCT catnm FROM food_cat");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['catnm'] . "'>" . $row['catnm'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="floatingCategory">Kategoria</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingTitle" name="title" placeholder="Podaj nazwę" required>
                                    <label for="floatingTitle">Podaj nazwę</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Podaj opis" id="floatingDetail" name="detail" style="height: 150px;" required></textarea>
                                    <label for="floatingDetail">Podaj opis</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingPrice" name="price" placeholder="Podaj cenę" required>
                                    <label for="floatingPrice">Podaj cenę</label>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Dodaj zdjęcie</label>
                                    <input class="form-control" type="file" id="formFile" name="img" required>
                                </div>
                                <button type="submit" name="s" class="btn btn-primary">Dodaj</button>
                            </form>
                        </div>
                    </div>

                    <!-- Form for adding a new category and table -->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Dodaj nową kategorię</h6>
                            <form action="" method="post">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingCat" name="cat" placeholder="Wprowadź nazwę kategorii" required>
                                    <label for="floatingCat">Wprowadź nazwę kategorii</label>
                                </div>
                                <button type="submit" name="s_cat" class="btn btn-primary mb-4">Dodaj</button>
                            </form>

                            <!-- Separator line -->
                            <hr>

                            <h6 class="mb-4">Dodaj nowy stolik</h6>
                            <form action="" method="post">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="floatingCapacity" name="capacity" placeholder="Wprowadź liczbę osób" min="1" max="10" required>
                                    <label for="floatingCapacity">Wprowadź liczbę osób</label>
                                </div>
                                <button type="submit" name="s_table" class="btn btn-primary">Dodaj</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->
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
