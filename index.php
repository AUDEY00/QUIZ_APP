<?php
include "Connect.php"; 


$questions = [
    [
        "question" => "What does echo do in PHP?",
        "options" => ["Stops the execution of the script", "Outputs data to the screen", " Declares a variable", "Public Hypertext Preprocessor"],
        "answer" => 1
    ],
    [
        "question" => "What symbol is used to denote a variable in PHP?",
        "options" => ["$", "@", "::", "#"],
        "answer" => 0
    ],
    [
        "question" => "Which function is used to include a file in PHP?",
        "options" => ["include()", "require()", "import()", "load()"],
        "answer" => 0
    ]
];


$score = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($questions as $index => $question) {
        if (isset($_POST["question$index"]) && $_POST["question$index"] == $question['answer']) {
            $score++;
        }
    }

    // Save score to database using MySQLi
    $username = htmlspecialchars($_POST['username']); 
    $query = "INSERT INTO users(Username, Score) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $username, $score); 
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            echo "Error saving score: " . mysqli_stmt_error($stmt);
        } else {
            echo "<h2>Your Score: $score/" . count($questions) . "</h2>";
            echo '<a href="index.php">Try Again</a> | <a href="Leaderboard.php">View Leaderboard</a>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Quiz</title>
    <script>
        // Timer settings
        let timeLeft = 60; 

        function startTimer() {
            const timerDisplay = document.getElementById('timer');
            const timerForm = document.getElementById('quizForm');
            
            const interval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    alert("Time's up! Submitting your answers.");
                    timerForm.submit();
                } else {
                    timerDisplay.textContent = `Time Left: ${timeLeft} seconds`;
                    timeLeft--;
                }
            }, 1000);
        }
    </script>
</head>
<body onload="startTimer()">
    <h1>PHP Quiz</h1>
    <div id="timer" style="font-weight: bold; margin-bottom: 20px;">Time Left: 60 seconds</div>
    <form method="post" action="">
        <label for="username">Enter your name:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <?php foreach ($questions as $index => $question): ?>
            <fieldset>
                <legend><?php echo $question['question']; ?></legend>
                <?php foreach ($question['options'] as $optionIndex => $option): ?>
                    <label>
                        <input type="radio" name="question<?php echo $index; ?>" value="<?php echo $optionIndex; ?>">
                        <?php echo $option; ?>
                    </label><br>
                <?php endforeach; ?>
            </fieldset>
        <?php endforeach; ?>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
