<?php 
session_start();

$u = $_POST['uid'];
$p = $_POST['pass'];
include "connect.php";

$s = mysqli_query($con, "SELECT * FROM registration WHERE userid='$u' AND password='$p'");

if ($r = mysqli_fetch_array($s)) {
    $_SESSION['uid'] = $u;
    $_SESSION['id'] = $r['id']; 

    if ($r['id'] == 1) {
        header("Location: admin/menu_view.php");
    } else {
        header("Location: index.php");
    }
    exit(); 
} else {
    echo "<br><div style='color:black; border-radius:10px; padding:10px; text-align:center; background-color:tomato;'>Please Enter Valid User and password</div><br>";
    include "login.php";
}
?>
