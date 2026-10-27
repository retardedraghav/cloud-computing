<?php

session_start();
require_once "functions.php";

if (!isset($_SESSION["name"])) {
    header("Location: create.php");
    exit();
}

// Set default game values if they do not exist yet.
if (!isset($_SESSION["day"])) {
    $_SESSION["day"] = 1;
}

if (!isset($_SESSION["show_result"])) {
    $_SESSION["show_result"] = false;
}

if (!isset($_SESSION["coke_count"])) {
    $_SESSION["coke_count"] = 0;
}

if (!isset($_SESSION["game_complete"])) {
    $_SESSION["game_complete"] = false;
}

$day = $_SESSION["day"];

// --------------------------------------------------
// CONTINUE AFTER RESULT
// --------------------------------------------------

if (isset($_POST["continue"]) && $_SESSION["show_result"] == true) {

    $nextAction = $_SESSION["next_action"] ?? "";

    $_SESSION["show_result"] = false;

    unset($_SESSION["effects"]);
    unset($_SESSION["result_title"]);
    unset($_SESSION["result_message"]);
    unset($_SESSION["next_action"]);

    if ($nextAction == "day2") {
        goToDay(2);
    }
    elseif ($nextAction == "day3") {
        goToDay(3);
    }
    elseif ($nextAction == "day4") {
        goToDay(4);
    }
    elseif ($nextAction == "day5") {
        goToDay(5);
    }
    elseif ($nextAction == "coke") {
        $_SESSION["show_coke"] = true;
    }
    elseif ($nextAction == "results") {
        header("Location: results.php");
        exit();
    }

    header("Location: game.php");
    exit();
}

// --------------------------------------------------
// DAY 1
// --------------------------------------------------

if ($day == 1 && isset($_POST["choice"])) {

    $choice = $_POST["choice"];

    if ($choice == "class") {

        $_SESSION["academics"] += 5;
        $_SESSION["attendance"] += 5;
        $_SESSION["energy"] -= 5;

        showResult(
            [
                "📚 Academics" => "+5",
                "📅 Attendance" => "+5",
                "⚡ Energy" => "-5"
            ],
            "day2",
            "You chose the responsible option.",
            "You made it to class. Your first day is off to a decent start."
        );
    }
    elseif ($choice == "canteen") {

        $_SESSION["happiness"] += 8;
        $_SESSION["attendance"] -= 5;
        $_SESSION["money"] -= 100;

        showResult(
            [
                "😊 Happiness" => "+8",
                "📅 Attendance" => "-5",
                "💰 Money" => "-₹100"
            ],
            "day2",
            "You chose the canteen.",
            "The food was worth it. Probably."
        );
    }
    elseif ($choice == "half") {

        $_SESSION["academics"] += 3;
        $_SESSION["attendance"] += 3;
        $_SESSION["happiness"] += 3;
        $_SESSION["energy"] -= 3;

        showResult(
            [
                "📚 Academics" => "+3",
                "📅 Attendance" => "+3",
                "😊 Happiness" => "+3",
                "⚡ Energy" => "-3"
            ],
            "day2",
            "You attended half the lecture.",
            "A little responsibility, a little freedom."
        );
    }
}

// --------------------------------------------------
// DAY 2 - ASK OUT
// --------------------------------------------------

if ($day == 2 && isset($_POST["askout"])) {

    $_SESSION["askout"] = $_POST["askout"];
    $_SESSION["askout_step"] = 1;

    header("Location: game.php");
    exit();
}

if ($day == 2 && isset($_POST["retry"])) {

    unset($_SESSION["askout"]);
    unset($_SESSION["askout_step"]);

    header("Location: game.php");
    exit();
}

if ($day == 2 && isset($_POST["finish_askout"])) {

    $option = $_SESSION["askout"] ?? "";

    if ($option == "cute") {

        $_SESSION["happiness"] -= 10;
        $_SESSION["stress"] += 10;
        $_SESSION["energy"] -= 5;

        showResult(
            [
                "😊 Happiness" => "-10",
                "😰 Stress" => "+10",
                "⚡ Energy" => "-5"
            ],
            "day3",
            "That did not go as planned.",
            "It turns out today was actually her first day."
        );
    }
    elseif ($option == "course") {

        $_SESSION["happiness"] -= 15;
        $_SESSION["stress"] += 15;
        $_SESSION["academics"] -= 2;

        showResult(
            [
                "😊 Happiness" => "-15",
                "😰 Stress" => "+15",
                "📚 Academics" => "-2"
            ],
            "day3",
            "There was one small problem.",
            "She was actually your professor."
        );
    }
    elseif ($option == "pcte") {

        $_SESSION["happiness"] -= 12;
        $_SESSION["stress"] += 8;
        $_SESSION["energy"] -= 5;

        showResult(
            [
                "😊 Happiness" => "-12",
                "😰 Stress" => "+8",
                "⚡ Energy" => "-5"
            ],
            "day3",
            "Silence.",
            "The pickup line has officially entered the history books."
        );
    }

    unset($_SESSION["askout"]);
    unset($_SESSION["askout_step"]);
}

// --------------------------------------------------
// DAY 3 - SURPRISE TEST
// --------------------------------------------------

if ($day == 3 && isset($_POST["day3_choice"])) {

    $choice = $_POST["day3_choice"];

    if ($choice == "all_night") {

        $_SESSION["academics"] += 12;
        $_SESSION["energy"] -= 15;
        $_SESSION["stress"] += 10;

        showResult(
            [
                "📚 Academics" => "+12",
                "⚡ Energy" => "-15",
                "😰 Stress" => "+10"
            ],
            "day4",
            "You studied all night.",
            "The test should go better. Your sleep schedule, however, disagrees."
        );
    }
    elseif ($choice == "two_hours") {

        $_SESSION["academics"] += 7;
        $_SESSION["energy"] -= 8;
        $_SESSION["stress"] += 5;

        showResult(
            [
                "📚 Academics" => "+7",
                "⚡ Energy" => "-8",
                "😰 Stress" => "+5"
            ],
            "day4",
            "You studied for two hours.",
            "Enough preparation to avoid complete disaster."
        );
    }
    elseif ($choice == "nothing") {

        $_SESSION["happiness"] += 3;
        $_SESSION["academics"] -= 8;

        showResult(
            [
                "😊 Happiness" => "+3",
                "📚 Academics" => "-8"
            ],
            "day4",
            "You decided not to study.",
            "At least you had a peaceful evening."
        );
    }
}

// --------------------------------------------------
// DAY 4 - SURVIVAL DAY
// --------------------------------------------------

if ($day == 4 && isset($_POST["day4_choice"])) {

    $choice = $_POST["day4_choice"];

    if ($choice == "push") {

        $_SESSION["energy"] -= 10;
        $_SESSION["stress"] += 8;

        showResult(
            [
                "⚡ Energy" => "-10",
                "😰 Stress" => "+8"
            ],
            "coke",
            "You pushed through the day.",
            "You survived, but you are running on fumes."
        );
    }
    elseif ($choice == "skip") {

        $_SESSION["attendance"] -= 5;
        $_SESSION["happiness"] += 3;
        $_SESSION["money"] -= 50;

        showResult(
            [
                "📅 Attendance" => "-5",
                "😊 Happiness" => "+3",
                "💰 Money" => "-₹50"
            ],
            "coke",
            "You skipped the last lecture.",
            "Technically, you survived the day."
        );
    }
    elseif ($choice == "home") {

        $_SESSION["energy"] += 3;
        $_SESSION["academics"] -= 5;
        $_SESSION["happiness"] -= 2;

        showResult(
            [
                "⚡ Energy" => "+3",
                "📚 Academics" => "-5",
                "😊 Happiness" => "-2"
            ],
            "coke",
            "You went home early.",
            "At least you got some rest."
        );
    }
}

// --------------------------------------------------
// COKE POWER-UP
// --------------------------------------------------

if ($day == 4 && isset($_SESSION["show_coke"]) && $_SESSION["show_coke"] == true) {

    if (isset($_POST["drink_coke"])) {

        if ($_SESSION["money"] >= 50) {

            $_SESSION["money"] -= 50;
            $_SESSION["happiness"] += 12;
            $_SESSION["energy"] += 7;
            $_SESSION["stress"] -= 8;
            $_SESSION["coke_count"] += 1;

            $_SESSION["show_coke"] = false;

            showResult(
                [
                    "😊 Happiness" => "+12",
                    "⚡ Energy" => "+7",
                    "😰 Stress" => "-8",
                    "💰 Money" => "-₹50"
                ],
                "day5",
                "Much better.",
                "Sometimes the solution is surprisingly simple. 🥤"
            );
        }
        else {

            $_SESSION["show_coke"] = false;

            showResult(
                [],
                "day5",
                "No Coke today.",
                "Your wallet said no."
            );
        }
    }
    elseif (isset($_POST["skip_coke"])) {

        $_SESSION["show_coke"] = false;

        showResult(
            [],
            "day5",
            "You decided to keep going.",
            "No shortcuts today."
        );
    }
}

// --------------------------------------------------
// DAY 5 - FINAL CHALLENGE
// --------------------------------------------------

if ($day == 5 && isset($_POST["day5_choice"])) {

    $choice = $_POST["day5_choice"];

    if ($choice == "prepare") {

        $_SESSION["academics"] += 10;
        $_SESSION["energy"] -= 12;
        $_SESSION["stress"] += 8;

        showResult(
            [
                "📚 Academics" => "+10",
                "⚡ Energy" => "-12",
                "😰 Stress" => "+8"
            ],
            "results",
            "You prepared seriously.",
            "Whatever happens next, at least you tried."
        );
    }
    elseif ($choice == "relax") {

        $_SESSION["happiness"] += 6;
        $_SESSION["stress"] -= 8;
        $_SESSION["academics"] += 4;

        showResult(
            [
                "😊 Happiness" => "+6",
                "😰 Stress" => "-8",
                "📚 Academics" => "+4"
            ],
            "results",
            "You stayed calm.",
            "Sometimes confidence does the heavy lifting."
        );
    }
    elseif ($choice == "panic") {

        $_SESSION["energy"] -= 20;
        $_SESSION["stress"] += 20;
        $_SESSION["academics"] -= 8;

        showResult(
            [
                "⚡ Energy" => "-20",
                "😰 Stress" => "+20",
                "📚 Academics" => "-8"
            ],
            "results",
            "You panicked.",
            "You did everything at once. That was probably the problem."
        );
    }
}

// Keep percentage-based stats between 0 and 100.
limitStats();

// --------------------------------------------------
// PAGE DATA
// --------------------------------------------------

$stats = [
    "📚 Academics" => "academics",
    "📅 Attendance" => "attendance",
    "⚡ Energy" => "energy",
    "😊 Happiness" => "happiness",
    "😰 Stress" => "stress"
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Survival</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="logo">🎓 COLLEGE SURVIVAL</div>

    <div class="nav-links">
        <span><?php echo htmlspecialchars($_SESSION["name"]); ?></span>
        <a href="about.php">About</a>
    </div>
</nav>

<main class="game-page">

    <div class="game-header">
        <div>
            <p class="small-title">DAY <?php echo $day; ?> / 5</p>
            <h1><?php echo htmlspecialchars($_SESSION["name"]); ?></h1>
        </div>

        <div class="course">
            🎓 <?php echo htmlspecialchars($_SESSION["course"]); ?>
        </div>
    </div>

    <div class="stats-grid">

        <?php foreach ($stats as $label => $key) { ?>

            <div class="stat-card">

                <div class="stat-name">
                    <?php echo $label; ?>
                </div>

                <div class="stat-number">
                    <?php
                    echo $_SESSION[$key];
                    if ($key == "attendance") {
                        echo "%";
                    }
                    ?>
                </div>

                <div class="progress">
                    <div
                        class="progress-bar"
                        style="width: <?php echo $_SESSION[$key]; ?>%;">
                    </div>
                </div>

            </div>

        <?php } ?>

        <div class="stat-card">
            <div class="stat-name">💰 Money</div>
            <div class="stat-number">₹<?php echo $_SESSION["money"]; ?></div>
        </div>

    </div>

    <?php if ($_SESSION["show_result"] == true) { ?>

        <div class="result-card">

            <p class="event-label">CHOICE RESULT</p>

            <h2>
                <?php echo htmlspecialchars($_SESSION["result_title"] ?? "Result"); ?>
            </h2>

            <?php if (!empty($_SESSION["result_message"])) { ?>
                <p class="event-text">
                    <?php echo htmlspecialchars($_SESSION["result_message"]); ?>
                </p>
            <?php } ?>

            <?php if (!empty($_SESSION["effects"])) { ?>

                <div class="effects-box">
                    <h3>Effects</h3>

                    <?php foreach ($_SESSION["effects"] as $stat => $change) { ?>
                        <div class="effect-row">
                            <span><?php echo $stat; ?></span>
                            <strong><?php echo $change; ?></strong>
                        </div>
                    <?php } ?>
                </div>

            <?php } ?>

            <h3 class="updated-title">Updated Stats</h3>

            <div class="updated-stats">
                <div>📚 Academics: <strong><?php echo $_SESSION["academics"]; ?></strong></div>
                <div>📅 Attendance: <strong><?php echo $_SESSION["attendance"]; ?>%</strong></div>
                <div>⚡ Energy: <strong><?php echo $_SESSION["energy"]; ?></strong></div>
                <div>😊 Happiness: <strong><?php echo $_SESSION["happiness"]; ?></strong></div>
                <div>😰 Stress: <strong><?php echo $_SESSION["stress"]; ?></strong></div>
                <div>💰 Money: <strong>₹<?php echo $_SESSION["money"]; ?></strong></div>
            </div>

            <form method="POST">
                <button type="submit" name="continue" class="main-button">
                    CONTINUE →
                </button>
            </form>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 4 && isset($_SESSION["show_coke"]) && $_SESSION["show_coke"] == true) { ?>

        <div class="event-card coke-card">

            <p class="event-label">🥤 POWER-UP</p>

            <h2>You Need Something.</h2>

            <p class="event-text">
                Your day has been rough. You know what might help.
            </p>

            <?php if ($_SESSION["money"] >= 50) { ?>

                <form method="POST">
                    <button type="submit" name="drink_coke" class="choice-button">
                        🥤 Drink Coke — ₹50
                    </button>

                    <button type="submit" name="skip_coke" class="choice-button">
                        No Thanks
                    </button>
                </form>

            <?php } else { ?>

                <p class="outcome">
                    💸 You don't have enough money for a Coke.
                </p>

                <form method="POST">
                    <button type="submit" name="skip_coke" class="main-button">
                        CONTINUE →
                    </button>
                </form>

            <?php } ?>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 1) { ?>

        <div class="event-card">

            <p class="event-label">DAY 1 — FIRST DAY</p>
            <h2>Welcome to College</h2>

            <p class="event-text">
                It's your first day. You arrive on campus and realize your first lecture has already started.
                <br><br>
                Your new friends are waiting outside.
                <br><br>
                <strong>
                    "Bro, it's our first day. Forget the lecture, let's go to the canteen."
                </strong>
            </p>

            <form method="POST">
                <button type="submit" name="choice" value="class" class="choice-button">
                    📚 Go to Class
                </button>

                <button type="submit" name="choice" value="canteen" class="choice-button">
                    🍔 Go to Canteen
                </button>

                <button type="submit" name="choice" value="half" class="choice-button">
                    ⏰ Attend Half the Lecture
                </button>
            </form>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 2 && !isset($_SESSION["askout"])) { ?>

        <div class="event-card askout-card">

            <p class="event-label">❤️ SPECIAL EVENT</p>
            <h2>The Approach</h2>

            <p class="event-text">
                You've been seeing someone around college.
                <br><br>
                Today you've finally decided to approach her.
                <br><br>
                <strong>What do you say?</strong>
            </p>

            <form method="POST">
                <button type="submit" name="askout" value="cute" class="choice-button">
                    ❤️ "I've been noticing you for several days, and I think you're really cute."
                </button>

                <button type="submit" name="askout" value="course" class="choice-button">
                    📚 "Mein thoda course puch skda?"
                </button>

                <button type="submit" name="askout" value="pcte" class="choice-button">
                    🔥 "This isn't allowed in PCTE."
                </button>
            </form>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 2 && isset($_SESSION["askout"])) { ?>

        <div class="event-card askout-card">

            <p class="event-label">❤️ YOUR APPROACH</p>

            <?php if ($_SESSION["askout"] == "cute") { ?>

                <div id="dialogue">
                    <p class="dialogue-line">
                        <strong>YOU:</strong>
                        "I've been noticing you for several days, and I think you're really cute."
                    </p>

                    <button onclick="showTwist()" class="main-button">
                        CONTINUE →
                    </button>
                </div>

                <div id="twist" style="display: none;">
                    <p class="dialogue-line">
                        <strong>HER:</strong>
                        "Actually... today's my first day here."
                    </p>

                    <p class="outcome">
                        💀 That information would have been useful earlier.
                    </p>

                    <form method="POST">
                        <button type="submit" name="retry" class="choice-button">
                            TRY ANOTHER APPROACH
                        </button>

                        <button type="submit" name="finish_askout" class="choice-button">
                            CONTINUE →
                        </button>
                    </form>
                </div>

            <?php } elseif ($_SESSION["askout"] == "course") { ?>

                <div id="dialogue">
                    <p class="dialogue-line">
                        <strong>YOU:</strong>
                        "Mein thoda course puch skda?"
                    </p>

                    <button onclick="showTwist()" class="main-button">
                        CONTINUE →
                    </button>
                </div>

                <div id="twist" style="display: none;">
                    <p class="dialogue-line">
                        <strong>HER:</strong>
                        "Sure..."
                    </p>

                    <p class="outcome">
                        💀 Wait... she's your professor.
                    </p>

                    <form method="POST">
                        <button type="submit" name="retry" class="choice-button">
                            TRY ANOTHER APPROACH
                        </button>

                        <button type="submit" name="finish_askout" class="choice-button">
                            CONTINUE →
                        </button>
                    </form>
                </div>

            <?php } elseif ($_SESSION["askout"] == "pcte") { ?>

                <div id="dialogue">
                    <p class="dialogue-line">
                        <strong>YOU:</strong>
                        "This isn't allowed in PCTE."
                    </p>

                    <button onclick="showSecondLine()" class="main-button">
                        CONTINUE →
                    </button>
                </div>

                <div id="second-line" style="display: none;">
                    <p class="dialogue-line">
                        <strong>HER:</strong>
                        "What?"
                    </p>

                    <button onclick="showFinalLine()" class="main-button">
                        CONTINUE →
                    </button>
                </div>

                <div id="final-line" style="display: none;">
                    <p class="dialogue-line">
                        <strong>YOU:</strong>
                        "To look this beautiful in PCTE."
                    </p>

                    <p class="outcome">💀 Silence.</p>

                    <form method="POST">
                        <button type="submit" name="retry" class="choice-button">
                            TRY ANOTHER APPROACH
                        </button>

                        <button type="submit" name="finish_askout" class="choice-button">
                            CONTINUE →
                        </button>
                    </form>
                </div>

            <?php } ?>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 3) { ?>

        <div class="event-card">

            <p class="event-label">DAY 3 — ACADEMIC CRISIS</p>
            <h2>The Surprise Test</h2>

            <p class="event-text">
                Your professor walks into class.
                <br><br>
                <strong>"Take out a sheet of paper. Surprise test."</strong>
                <br><br>
                What do you do?
            </p>

            <form method="POST">
                <button type="submit" name="day3_choice" value="all_night" class="choice-button">
                    📚 Study All Night
                </button>

                <button type="submit" name="day3_choice" value="two_hours" class="choice-button">
                    ⏰ Study for Two Hours
                </button>

                <button type="submit" name="day3_choice" value="nothing" class="choice-button">
                    😌 Don't Study
                </button>
            </form>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 4 && !isset($_SESSION["show_coke"])) { ?>

        <div class="event-card">

            <p class="event-label">DAY 4 — SURVIVAL DAY</p>
            <h2>Everything Is Going Wrong</h2>

            <p class="event-text">
                You've had a terrible day. Your energy is low, your stress is high,
                and college is starting to feel personal.
                <br><br>
                What do you do?
            </p>

            <form method="POST">
                <button type="submit" name="day4_choice" value="push" class="choice-button">
                    💪 Push Through the Day
                </button>

                <button type="submit" name="day4_choice" value="skip" class="choice-button">
                    🚪 Skip the Last Lecture
                </button>

                <button type="submit" name="day4_choice" value="home" class="choice-button">
                    🏠 Go Home Early
                </button>
            </form>

        </div>

    <?php } ?>

    <?php if ($_SESSION["show_result"] == false && $day == 5) { ?>

        <div class="event-card">

            <p class="event-label">DAY 5 — FINAL CHALLENGE</p>
            <h2>The Final Presentation</h2>

            <p class="event-text">
                Your final presentation is today.
                <br><br>
                You've survived five days of college decisions.
                Now make your final move.
            </p>

            <form method="POST">
                <button type="submit" name="day5_choice" value="prepare" class="choice-button">
                    📚 Prepare Seriously
                </button>

                <button type="submit" name="day5_choice" value="relax" class="choice-button">
                    😎 Relax and Trust Yourself
                </button>

                <button type="submit" name="day5_choice" value="panic" class="choice-button">
                    😰 Panic and Do Everything at Once
                </button>
            </form>

        </div>

    <?php } ?>

</main>

<script src="script.js"></script>

</body>
</html>
