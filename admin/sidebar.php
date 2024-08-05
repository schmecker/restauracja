       <!-- Spinner Start -->
       <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <?php
session_start();

// Check if user is logged in and has id == 1
if (!isset($_SESSION['id']) || $_SESSION['id'] != 1) {
    // Redirect to login page or another page
    header("Location: ../index.php");
    exit();
}

// Your dashboard code goes here
?>

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">BLUE SHARK <BR>ADMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                    <?php
                    if(isset($_SESSION['uid'])) {
                        echo '<h6 class="mb-0"><span style="font-weight: normal;">Witaj </span><strong>' . htmlspecialchars($_SESSION['uid']) . '</strong></h6>';
                    }
                    ?>
                    <span>Admin</span>
                </div>

                </div>
                <div class="navbar-nav w-100">

                <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Menu</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="menu_view.php" class="dropdown-item">Wyswietl menu</a>
                            <a href="menu_add.php" class="dropdown-item">Dodaj menu</a>
                        </div>
                    </div>
                    <a href="admin_reservations.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Rezerwacje</a>
                    <a href="view_orders.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Zamowienia</a>



                    <a href="review.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Opinie</a>




                </div>
            </nav>
        </div>
        <!-- Sidebar End -->