<?php 
session_start();
$id = $_SESSION['id'];
include "header.php"; 
// Include the database connection
include "connect.php";

// Fetch orders for the logged-in user
$orders_result = mysqli_query($con, "SELECT * FROM orders WHERE u_id='$id'");

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
        .back-button {
            margin-top: 20px;
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
        <div class="back-button">
            <a href="index.php" class="btn btn-secondary">Powrót do strony głównej</a>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
