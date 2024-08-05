<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = mysqli_real_escape_string($con, $_POST['reservation_id']);
    $user_id = $_SESSION['id'];

    // Upewnij się, że użytkownik jest właścicielem rezerwacji
    $checkQuery = "SELECT * FROM reservations WHERE id='$reservation_id' AND user_id='$user_id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Usuń rezerwację
        $deleteQuery = "DELETE FROM reservations WHERE id='$reservation_id'";
        if (mysqli_query($con, $deleteQuery)) {
            header("Location: orders.php");
            exit();
        } else {
            echo "Błąd podczas usuwania rezerwacji: " . mysqli_error($con);
        }
    } else {
        echo "Nie masz uprawnień do usunięcia tej rezerwacji.";
    }
} else {
    header("Location: view_purchases.php");
    exit();
}
?>
