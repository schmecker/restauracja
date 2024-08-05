<?php session_start(); ?>
<?php include "header.php"; ?>

<style>
    .full-screen {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f8f9fa;
    }
    .inner-column {
        max-width: 800px;
        margin: auto;
    }
    .btn-circle {
        border-radius: 50px;
    }
</style>

<div class="about-section-box full-screen">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="inner-column">
                    <h1>Dziękujemy za złożenie zamówienia!</h1>
                    <p>Twoje zamówienie zostało przetworzone pomyślnie.</p>
                    <?php if (isset($_SESSION['order_id'])): ?>
                        <p>Dziekujemy za zlozenie zamowienia. Twoj numer zamowienia to  <?php echo $_SESSION['order_id']; ?></p>
                    <?php else: ?>
                        <p>Podczas skladania zamowienia wysapil blad, sprobuj ponownie</p>
                    <?php endif; ?>
                    <p><a class="btn btn-lg btn-circle btn-outline-new-white" href="index.php">Powrót do strony głównej</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
