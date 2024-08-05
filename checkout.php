<?php 
session_start();
ob_start(); // Rozpoczynamy buforowanie wyjœcia
include "header.php"; 
include "connect.php";

// Debugowanie: sprawdzenie po³¹czenia z baz¹ danych
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Heebo', sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="content">
    <div style="height: 150px;"></div> <!-- Przesuniêcie zawartoœci w dó³ -->

    <div class="container">
        <div class="form-container card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="img/bg/cart.jpg" width="10%" class="mb-3">
                    <p style="font-size: 2.4em; color: ">Checkout</p>
                </div>
                <div>

                <?php
                $uid = $_SESSION['uid'];
                $id = $_SESSION['id'];
                $total_value = array_sum(array_column($_SESSION['cart'], 'total'));

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_order'])) {
                    $name = mysqli_real_escape_string($con, $_POST['name']);
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $address = mysqli_real_escape_string($con, $_POST['address']);
                    $phone = mysqli_real_escape_string($con, $_POST['phone']);

                    $query = "INSERT INTO orders (u_id, name, email, address, phone, total) VALUES ('$id', '$name', '$email', '$address', '$phone', '$total_value')";
                    
                    // Debugowanie: sprawdzenie zapytania
                    echo "<p>Query: $query</p>";

                    if (mysqli_query($con, $query)) {
                        $order_id = mysqli_insert_id($con);

                        // Debugowanie: wyœwietlenie order_id
                        echo "<p>Order ID: $order_id</p>";

                        foreach ($_SESSION['cart'] as $item) {
                            $p_id = $item['p_id'];
                            $qty = $item['qty'];
                            $price = $item['price'];
                            $total = $item['total'];

                            $item_query = "INSERT INTO order_items (order_id, p_id, qty, price, total) VALUES ('$order_id', '$p_id', '$qty', '$price', '$total')";
                            
                            // Debugowanie: sprawdzenie zapytania dla przedmiotów zamówienia
                            echo "<p>Item Query: $item_query</p>";

                            if (!mysqli_query($con, $item_query)) {
                                echo "<p>Error in item query: " . mysqli_error($con) . "</p>";
                            }
                        }

                        $_SESSION['cart'] = [];
                        mysqli_query($con, "DELETE FROM addcart WHERE u_id='$uid'");

                        $_SESSION['order_id'] = $order_id;

                        header("Location: checkout_confirmation.php");
                        exit();
                    } else {
                        echo "<p>There was an error processing your order: " . mysqli_error($con) . "</p>";
                    }
                }
                ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Imie:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Adres:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Numer telefonu:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <p>Do zaplaty: <?php echo $total_value; ?> zl</p>

                        <button type="submit" name="submit_order" class="btn btn-success">Zloz zamowienie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include "footer.php"; 
ob_end_flush(); // Opró¿niamy bufor wyjœcia i koñczymy buforowanie
?>
</body>
</html>
