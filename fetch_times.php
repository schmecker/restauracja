<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date'])) {
    include "connect.php";

    $date = mysqli_real_escape_string($con, $_POST['date']);
    $reserved_times = [];

    // Fetch reserved times for the given date
    $query = "SELECT time FROM reservations WHERE date = '$date'";
    if ($result = mysqli_query($con, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $reserved_times[] = $row['time'];
        }
        mysqli_free_result($result);
    }

    // Define time range and interval
    $start_time = strtotime('10:00'); // Restaurant opening time
    $end_time = strtotime('22:00'); // Restaurant closing time
    $interval = 60 * 60; // 1 hour interval

    $available_times = [];
    for ($time = $start_time; $time <= $end_time; $time += $interval) {
        $formatted_time = date('H:i', $time);
        if (!in_array($formatted_time, $reserved_times)) {
            $available_times[] = $formatted_time;
        }
    }

    // Output available times as HTML options
    foreach ($available_times as $time) {
        echo "<option value=\"$time\">$time</option>";
    }

    mysqli_close($con);
}
?>
