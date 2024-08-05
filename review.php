<?php
// Start the session at the beginning of the script
session_start();



// Include the header
include "header.php";
?>
<body>
    <!-- Start All Pages -->
    <center>
        <img src="img/bg/review.jpg" style="background-color: red; margin-top: 60px;">
    </center>
    <!-- End All Pages -->
    
    <!-- Start Contact -->
    <div class="contact-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-title text-center">
                        <h2>Dodaj swoją opinię</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if(isset($_POST['sb'])) {
                        $nm = $_POST['name'];
                        $rev = $_POST['rev'];
                        $des = $_POST['desc'];
                        include "connect.php";
                        if (mysqli_query($con, "INSERT INTO review(name, review, description) VALUES('$nm', '$rev', '$des')")) {
                            echo '<div class="alert alert-success" role="alert">Opinia dodana pomyślnie!</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Wystąpił błąd podczas dodawania opinii. Spróbuj ponownie.</div>';
                        }
                    }
                    ?>

                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Twoje imię" required data-error="Wprowadź swoje imię">
                                    <div class="help-block with-errors"></div>
                                </div>                                 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="custom-select d-block form-control" id="guest" name="rev" required data-error="Wybierz ocenę">
                                        <option value="Wysmienita">Wyśmienita</option>
										<option value="Bardzo dobra">Bardzo dobra</option>
                                        <option value="Dobra">Dobra</option>
                                        <option value="Slaba">Słaba</option>
                                        <option value="Bardzo slaba">Bardzo słaba</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="message" placeholder="Wprowadź treść" rows="4" name="desc" required data-error="Wprowadź treść"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="submit-button text-center">
                                    <button name="sb" class="btn btn-common" id="submit" type="submit">Dodaj opinię</button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>            
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->
<?php include "footer.php"; ?>
