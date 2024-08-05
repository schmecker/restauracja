<?php 
session_start();
$uid = $_SESSION['uid'];
include "header.php"; 

// Include the database connection
include "connect.php";

// Initialize session cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle form submission to update quantities
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $qty = intval($qty);
        $price = $_POST['price'][$id];
        $p_id = $_POST['p_id'][$id]; // Dodanie identyfikatora produktu
        if ($qty > 0) {
            // Update quantity and total in the database
            $total = $qty * $price;
            mysqli_query($con, "UPDATE addcart SET qty='$qty', total='$total' WHERE id='$id' AND u_id='$uid'");
            
            // Update session cart
            $_SESSION['cart'][$id] = ['p_id' => $p_id, 'qty' => $qty, 'price' => $price, 'total' => $total];
        } else {
            // Remove item if quantity is 0
            mysqli_query($con, "DELETE FROM addcart WHERE id='$id' AND u_id='$uid'");
            
            // Remove from session cart
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php"); // Refresh the page to reflect changes
    exit();
}

// Handle item removal
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    mysqli_query($con, "DELETE FROM addcart WHERE id='$id' AND u_id='$uid'");
    
    // Remove from session cart
    unset($_SESSION['cart'][$id]);
    
    header("Location: cart.php"); // Refresh the page to reflect changes
    exit();
}

// Fetch cart items for the logged-in user
$s = mysqli_query($con, "SELECT addcart.id, addcart.p_id, addcart.price, addcart.qty, addcart.total, menu.image, menu.title 
                         FROM addcart 
                         INNER JOIN menu ON addcart.p_id=menu.id 
                         WHERE addcart.u_id='$uid'");

// Update session cart based on database fetch
$_SESSION['cart'] = [];
while($row = mysqli_fetch_array($s)) {
    $_SESSION['cart'][$row['id']] = [
        'p_id' => $row['p_id'], // Zapisanie identyfikatora produktu
        'qty' => $row['qty'],
        'price' => $row['price'],
        'total' => $row['total']
    ];
}

// Calculate total number of items in the cart and total value
$total_items = array_sum(array_column($_SESSION['cart'], 'qty'));
$total_value = array_sum(array_column($_SESSION['cart'], 'total'));
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
    
<div class="content">
    <div style="height: 150px;"></div>
    <div style="width: 90%; margin: 0 auto;">
        <center><img src="img/bg/cart.jpg" width="10%"></center>
        <center><p style="font-size: 2.4em; color: red">Twój koszyk</p></center>
        <div>
            <form action="cart.php" method="post">
                <table>
                    <tr>
                        <th></th>
                        <th>Produkt</th>
                        <th>Cena</th>
                        <th>Ilość</th>
                        <th>Suma</th>
                        <th></th>
                    </tr>

                    <?php mysqli_data_seek($s, 0); while($r = mysqli_fetch_array($s)): ?>
                        <tr>
                            <td align="right"><img src="admin/<?php echo $r['image']; ?>" width="100" height="100"></td>
                            <td><?php echo $r['title']; ?></td>
                            <td><?php echo $r['price']; ?> zł</td>
                            <td>
                                <input type="number" name="qty[<?php echo $r['id']; ?>]" value="<?php echo $r['qty']; ?>" min="1" style="width: 60px;">
                                <input type="hidden" name="price[<?php echo $r['id']; ?>]" value="<?php echo $r['price']; ?>">
                                <input type="hidden" name="p_id[<?php echo $r['id']; ?>]" value="<?php echo $r['p_id']; ?>"> <!-- Nowe pole -->
                            </td>
                            <td><?php echo $r['total']; ?> zł</td>
                            <td><a href="cart.php?remove=<?php echo $r['id']; ?>" class="btn btn-danger">Usuń</a></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <div class="update-button">
                    <button type="submit" name="update_cart" class="btn btn-primary">Aktualizuj koszyk</button>
                </div>
            </form>
            <div class="checkout-button">
                <a href="checkout.php" class="btn btn-success">Przejdź do kasy</a>
            </div>
            <div class="cart-summary">
                <p>Total Products in Cart: <?php echo $total_items; ?></p>
                <p>Total Cart Value: <?php echo $total_value; ?> zł</p>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
