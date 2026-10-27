<?php

session_start();

if (!isset($_SESSION["name"])) {
    header("Location: create.php");
    exit();
}

$score = round((
    $_SESSION["academics"] +
    $_SESSION["attendance"] +
    $_SESSION["energy"] +
    $_SESSION["happiness"] +
    (100 - $_SESSION["stress"])
) / 5);

if ($score >= 80) {
    $ending = "🏆 COLLEGE LEGEND";
    $message = "You somehow managed to balance academics, friends and your questionable life decisions.";
}
elseif ($score >= 60) {
    $ending = "🎓 THE SURVIVOR";
    $message = "You didn't exactly dominate college, but you made it through.";
}
elseif ($score >= 40) {
    $ending = "😵 BARELY SURVIVED";
    $message = "Your semester was basically a series of poor decisions held together by luck.";
}
else {
    $ending = "💀 BACKLOG UNLOCKED";
    $message = "Perhaps studying would have been useful after all.";
}

$achievements = [];

if ($_SESSION["attendance"] >= 85) {
    $achievements[] = "📅 Attendance Warrior";
}

if ($_SESSION["coke_count"] >= 1) {
    $achievements[] = "🥤 Coke Lover";
}

if ($_SESSION["money"] >= 1500) {
    $achievements[] = "💰 Budget Master";
}

if (
    $_SESSION["academics"] > 60 &&
    $_SESSION["attendance"] > 60 &&
    $_SESSION["energy"] > 60 &&
    $_SESSION["happiness"] > 60 &&
    $_SESSION["stress"] < 40
) {
    $achievements[] = "⚖️ Balanced Student";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Results - College Survival</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="logo">🎓 COLLEGE SURVIVAL</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
    </div>
</nav>

<main class="game-page">

    <div class="result-card final-result">

        <p class="event-label">🎓 COLLEGE SURVIVED</p>

        <h1><?php echo htmlspecialchars($_SESSION["name"]); ?></h1>

        <h2><?php echo $ending; ?></h2>

        <p class="event-text">
            <?php echo htmlspecialchars($message); ?>
        </p>

        <div class="final-score">
            FINAL SCORE
            <strong><?php echo $score; ?></strong>
        </div>

        <h3 class="updated-title">Final Stats</h3>

        <div class="updated-stats">
            <div>📚 Academics: <strong><?php echo $_SESSION["academics"]; ?></strong></div>
            <div>📅 Attendance: <strong><?php echo $_SESSION["attendance"]; ?>%</strong></div>
            <div>⚡ Energy: <strong><?php echo $_SESSION["energy"]; ?></strong></div>
            <div>😊 Happiness: <strong><?php echo $_SESSION["happiness"]; ?></strong></div>
            <div>😰 Stress: <strong><?php echo $_SESSION["stress"]; ?></strong></div>
            <div>💰 Money: <strong>₹<?php echo $_SESSION["money"]; ?></strong></div>
        </div>

        <?php if (!empty($achievements)) { ?>

            <h3 class="updated-title">Achievements</h3>

            <div class="achievements">
                <?php foreach ($achievements as $achievement) { ?>
                    <div class="achievement">
                        <?php echo $achievement; ?>
                    </div>
                <?php } ?>
            </div>

        <?php } ?>

        <a href="create.php" class="main-button">
            PLAY AGAIN →
        </a>

    </div>

</main>

</body>
</html>
