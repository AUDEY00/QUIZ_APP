<?php
include "connection.php"; 


$query = "SELECT Username, Score, datetaken FROM users ORDER BY Score DESC, datetaken ASC LIMIT 10";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching leaderboard data: " . mysqli_error($conn));
}


$leaderboards = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
