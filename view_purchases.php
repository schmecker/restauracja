<?php 
session_start();
$id = $_SESSION['id'];
include "header.php"; 
include "connect.php";

// Fetch orders for the logged-in user
$orders_result = mysqli_query($con, "SELECT * FROM orders WHERE u_id='$id'");

// Fetch reservations for the logged-in user
$reservations_result = mysqli_query($con, "SELECT * FROM reservations WHERE user_id='$id'");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje Zamówienia</title>
    <link rel="stylesheet" href="css/cart.css">
    <style>
        body {
            background-image: url('img/bg/bg1.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }
        .content {
            background-color: #ffffff; /* Nieprzenikające tło */
            padding: 20px;
            margin: 140px auto; /* Adjusted margin to add more space at the top */
            width: 90%; /* Adjust the width as needed */
            max-width: 1200px; /* Maximum width to prevent too wide content */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .back-button {
            margin-top: 20px;
        }
        hr {
            margin: 40px 0; /* Dodaje margines nad i pod linią */
            border: 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    
<div class="content">
    <div>
        <h2>Twoje zamówienia</h2> 

        <table>
            <tr>
                <th>ID zamowienia</th>
                <th>Imie i nazwisko</th>
                <th>Email</th>
                <th>Adres</th>
                <th>Telefon</th>
                <th>Wartosc</th>
                <th>Data zlozenia</th>
                <th>Akcje</th>
            </tr>

            <?php while($order = mysqli_fetch_assoc($orders_result)): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['name']; ?></td>
                    <td><?php echo $order['email']; ?></td>
                    <td><?php echo $order['address']; ?></td>
                    <td><?php echo $order['phone']; ?></td>
                    <td><?php echo $order['total']; ?> zł</td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>
                        <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Pokaż szczegóły</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <hr>

        <h2>Twoje rezerwacje</h2>

        <?php if (mysqli_num_rows($reservations_result) > 0): ?>
            <table>
                <tr>
                    <th>ID rezerwacji</th>
                    <th>Imie i nazwisko</th>
                    <th>Email</th>
                    <th>Numer stolika</th>
                    <th>Telefon</th>
                    <th>Godzina</th>
                    <th>Data rezerwacji</th>
                    <th>Akcje</th>
                </tr>

                <?php while($reservation = mysqli_fetch_assoc($reservations_result)): ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['name']; ?></td>
                        <td><?php echo $reservation['email']; ?></td>
                        <td><?php echo $reservation['table_id']; ?></td>
                        <td><?php echo $reservation['phone']; ?></td>
                        <td><?php echo $reservation['time']; ?></td>
                        <td><?php echo $reservation['date']; ?></td>
                        <td>
                            <form action="delete_reservation.php" method="post" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                <button type="submit" class="btn btn-danger">Usuń</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Nie posiadasz rezerwacji.</p>
        <?php endif; ?>
        
        <div class="back-button">
            <a href="index.php" class="btn btn-secondary">Powrót do strony głównej</a>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
