<?php
include "Connect.php"; 


$query = "SELECT Username, Score, datetaken FROM users ORDER BY Score DESC, datetaken ASC LIMIT 10";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching leaderboard data: " . mysqli_error($conn));
}


$leaderboards = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>
<body>
    <h1>Leaderboard</h1>

    <?php if ($leaderboards): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Score</th>
                    <th>Date Taken</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rank = 1; 
                foreach ($leaderboards as $row): ?>
                    <tr>
                        <td><?php echo $rank++; ?></td>
                        <td><?php echo htmlspecialchars($row['Username']); ?></td>
                        <td><?php echo $row['Score']; ?></td>
                        <td><?php echo $row['datetaken']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No scores to display.</p>
    <?php endif; ?>
    <a href="index.php">Back to Quiz</a>
</body>
</html>
