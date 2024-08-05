<?php include "header.php"; ?>
<link rel="stylesheet" type="text/css" href="style.css">

<div class="content">
    <form action="" method="post">
        <table border=0 align="center" bgcolor="white" width="40%" style="box-shadow: 1px 3px 15px 2px;" cellpadding="10" cellspacing="15">
            <tr align="center">
                <td class="title">Dodaj nowy stół</td>
            </tr>

            <tr align="center">
                <td>
                    <input type="number" name="capacity" value="" placeholder="Podaj ilość osób" class="text" required min="1">
                </td>
            </tr>

            <tr align="center">
                <td>
                    <input type="submit" name="s" value="Dodaj teraz" class="btn">
                </td>
            </tr>
        </table>
    </form>
    
    <?php
    if(isset($_POST['s'])) {
        include "../connect.php";
        $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
        
        if ($capacity < 1) {
            echo "<div style='color:red; font-size:1.5em; font-family:arial; text-align:center;'>Ilość osób musi być większa niż 0</div>";
        } else {
            mysqli_query($con, "INSERT INTO tables (capacity) VALUES('$capacity')") or die(mysqli_error($con));
            echo "<div style='color:red; font-size:1.5em; font-family:arial; text-align:center;'>Stół dodany</div>";
        }
    }
    ?>
</div>

<?php include "footer.php"; ?>
