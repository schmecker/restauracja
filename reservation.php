<?php
session_start();
include "connect.php";
$userId = isset($_SESSION['id']) ? $_SESSION['id'] : 'NULL';


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time = mysqli_real_escape_string($con, $_POST['time']);
    $person = mysqli_real_escape_string($con, $_POST['person']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : 'NULL';

echo $userId;
    $tableQuery = "
        SELECT t.id 
        FROM tables t
        WHERE t.capacity >= '$person' 
        AND NOT EXISTS (
            SELECT 1 
            FROM reservations r 
            WHERE r.table_id = t.id 
            AND r.date = '$date' 
            AND r.time = '$time'
        )
        ORDER BY t.capacity ASC
        LIMIT 1";
    
    $tableResult = mysqli_query($con, $tableQuery);
    
    if (!$tableResult) {
        die("Query failed: " . mysqli_error($con));
    }
    
    if (mysqli_num_rows($tableResult) > 0) {
        $tableRow = mysqli_fetch_assoc($tableResult);
        $tableId = $tableRow['id'];

        $sql = "INSERT INTO reservations (date, time, person, name, email, phone, table_id, user_id) 
                VALUES ('$date', '$time', '$person', '$name', '$email', '$phone', '$tableId', $userId)";
        
        if (mysqli_query($con, $sql)) {
            $_SESSION['table_id'] = $tableId; 
            header("Location: reservation_confirm.php"); 
            exit();
        } else {
            $message = "Błąd podczas dodawania rezerwacji: " . mysqli_error($con);
        }
    } else {
        $message = "Brak dostępnych stolików dla wybranej liczby osób w tym terminie.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezerwacja stolika</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: background 1s ease-in-out;
            background-color: #000; /* Fallback color */
        }

        body.loaded {
            background-image: url('img/bg/table1.jpg');
            background-size: cover;
            background-position: center;
        }

        .container-flex {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .reservation-box {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            width: 100%;
        }

        .footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
            position: relative;
        }

        .footer .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer .col-lg-3 {
            margin: 10px 0;
        }

        .footer h3 {
            color: #f39c12;
            margin-bottom: 10px;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer .text-color {
            color: #f39c12;
        }

        .footer .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 18px;
        }

        .footer .social-icons a:hover {
            color: #f39c12;
        }
    </style>
</head>
<body>
<?php include "header.php"; ?>

    <div class="container-flex">
        <div class="reservation-box">
            <div class="container">
                <div class="heading-title text-center">
                    <h2>Rezerwacja stolika</h2>
                    <p>Zarezerwuj stolik już teraz!</p>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($message): ?>
                            <p class="message"><?php echo $message; ?></p>
                        <?php endif; ?>
                        <form action="reservation.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="date" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" name="time" required>
                                            <option value="" disabled selected>Wybierz godzinę</option>
                                            <?php
                                            for ($i = 12; $i <= 22; $i++) {
                                                $time = sprintf("%02d:00", $i);
                                                echo "<option value=\"$time\">$time</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" name="person" required>
                                            <option value="" disabled selected>Ilość osób</option>
                                            <?php
                                            for ($i = 1; $i <= 10; $i++) {
                                                echo "<option value=\"$i\">$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Imię i nazwisko" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="Telefon" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="submit-button text-center">
                                        <button class="btn btn-common" type="submit">Zarezerwuj</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.add('loaded');
        });
    </script>

</body>
</html>

<?php
mysqli_close($con); 
?>
