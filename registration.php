<?php include "header.php"; ?> 
<body>
    

    <!-- Start Contact -->
    <div class="container-xxl position-relative bg-white d-flex p-0">

        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.php" class="">
                            <h3 class="text-primary">Restauracja <strong>Blue Shark</strong></h3>
                            </a>
                        </div>
                        <?php
                        if(isset($_POST['sb'])) {
                            $uid = $_POST['uid'];
                            $pass = $_POST['pass'];
                            $email = $_POST['email'];
                            include "connect.php";
                            
                            $result = mysqli_query($con, "SELECT * FROM registration WHERE userid='$uid'");
                            
                            if(mysqli_num_rows($result) > 0) {
                                echo '<div class="alert alert-danger" role="alert">Uzytkownik z podanym loginem juz istnieje. Wybierz inny</div>';
                            } else {
                                mysqli_query($con, "INSERT INTO registration(userid, password, email) VALUES('$uid', '$pass', '$email')");
                                echo '<div class="alert alert-success" role="alert">Registration Successfully. Click to <a href="login.php">login</a>.</div>';
                            }
                        }
                        ?>
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingText" name="uid" placeholder="jhondoe" required>
                                <label for="floatingText">Login</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password" required>
                                <label for="floatingPassword">Haslo</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                            </div>
                            <button type="submit" name="sb" class="btn btn-primary py-3 w-100 mb-4">Zarejestruj sie</button>
                        </form>
                        <p class="text-center mb-0">Masz juz konto? <a href="login.php">Zaloguj sie</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->

<?php include "footer.php"; ?>
</body>
</html>
