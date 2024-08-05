<?php
include '../connect.php';

// Create an associative array to map review ratings to the scale
$reviewMap = [
    'Wysmienite' => 0,
    'Bardzo Dobre' => 0,
    'Dobre' => 0,
    'Slabe' => 0,
    'Bardzo Slabe' => 0
];

$query = "SELECT review, COUNT(*) as count FROM review GROUP BY review";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $review = $row['review'];
    if (isset($reviewMap[$review])) {
        $reviewMap[$review] = intval($row['count']);
    }
}

// Extract counts in the order of the defined reviewMap
$reviewCounts = array_values($reviewMap);

echo json_encode(['reviewCounts' => $reviewCounts]);
?>
