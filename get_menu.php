<?php
include "connect.php";

$category = $_GET['category'];

if ($category == 'all') {
    $s = mysqli_query($con, "SELECT * FROM menu");
} else {
    $s = mysqli_query($con, "SELECT * FROM menu WHERE category='$category'");
}

while ($r = mysqli_fetch_array($s)) {
    echo "
    <div class='col-lg-4 col-md-6 special-grid drinks'>
        <div class='business-card'>
            <div class='image-container'>
                <img src='admin/{$r['image']}' class='img-fluid' alt='Image'>
            </div>
            <div class='card-content'>
                <h4>{$r['title']}</h4>
                <p>{$r['description']}</p>
                <p>{$r['price']} zł</p>
            </div>
            <div class='button-container'>";
                if (isset($_SESSION['uid'])) {
                    echo "<button class='btn custom-btn add-to-cart' data-pid='{$r['id']}' data-price='{$r['price']}'>Dodaj do koszyka</button>";
                } else {
                    echo "<a href='login.php' class='btn custom-btn'>Dodaj do koszyka</a>";
                }
    echo "
            </div>
        </div>
    </div>";
}
?>
