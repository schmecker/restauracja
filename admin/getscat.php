<?php
include "../connect.php";

$q = $_GET['q'];

$result = mysqli_query($con, "SELECT sub_cat FROM food_cat WHERE catnm = '$q'");

echo "<select name='scat' class='text'>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['sub_cat'] . "'>" . $row['sub_cat'] . "</option>";
}
echo "</select>";
?>
