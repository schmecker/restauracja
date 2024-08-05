<?php
session_start();
include "connect.php";

if (isset($_POST['pid']) && isset($_POST['price']) && isset($_SESSION['uid'])) {
    $pid = $_POST['pid'];
    $price = $_POST['price'];
    $uid = $_SESSION['uid'];
    
    // Check if the item is already in the cart
    $result = mysqli_query($con, "SELECT * FROM addcart WHERE p_id='$pid' AND u_id='$uid'");
    if (mysqli_num_rows($result) > 0) {
        // If item is already in the cart, update the quantity and total
        $row = mysqli_fetch_assoc($result);
        $qty = $row['qty'] + 1;
        $total = $price * $qty;
        mysqli_query($con, "UPDATE addcart SET qty='$qty', total='$total' WHERE p_id='$pid' AND u_id='$uid'");
    } else {
        // If item is not in the cart, insert a new row
        $total = $price;
        mysqli_query($con, "INSERT INTO addcart (p_id, u_id, price, qty, total) VALUES ('$pid', '$uid', '$price', 1, '$total')");
    }
    
    echo "Item added to cart";
} else {
    echo "Failed to add item to cart";
}
?>
