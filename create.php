<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $course = $_POST["course"] ?? "BCA";
    $personality = $_POST["personality"] ?? "";

    if ($name != "" && $personality != "") {

        // Clear old game data before starting a new game.
        unset(
            $_SESSION["show_result"],
            $_SESSION["effects"],
            $_SESSION["next_action"],
            $_SESSION["result_title"],
            $_SESSION["result_message"],
            $_SESSION["askout"],
            $_SESSION["askout_step"],
            $_SESSION["show_coke"],
            $_SESSION["game_complete"]
        );

        $_SESSION["name"] = $name;
        $_SESSION["course"] = $course;
        $_SESSION["personality"] = $personality;
        $_SESSION["money"] = 2000;
        $_SESSION["coke_count"] = 0;
        $_SESSION["day"] = 1;
        $_SESSION["show_result"] = false;

        // Starting stats based on personality.
        if ($personality == "hardworking") {

            $_SESSION["academics"] = 70;
            $_SESSION["attendance"] = 80;
            $_SESSION["energy"] = 60;
            $_SESSION["happiness"] = 55;
            $_SESSION["stress"] = 40;

        }
        elseif ($personality == "chill") {

            $_SESSION["academics"] = 55;
            $_SESSION["attendance"] = 65;
            $_SESSION["energy"] = 75;
            $_SESSION["happiness"] = 75;
            $_SESSION["stress"] = 20;

        }
        elseif ($personality == "competitive") {

            $_SESSION["academics"] = 65;
            $_SESSION["attendance"] = 75;
            $_SESSION["energy"] = 70;
            $_SESSION["happiness"] = 55;
            $_SESSION["stress"] = 45;

        }
        else {

            $_SESSION["academics"] = 50;
            $_SESSION["attendance"] = 55;
            $_SESSION["energy"] = 70;
            $_SESSION["happiness"] = 70;
            $_SESSION["stress"] = 35;

        }

        header("Location: game.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Student - College Survival</title>

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

<main class="create-page">

    <div class="create-container">

        <p class="small-title">STEP 1</p>

        <h1>CREATE YOUR STUDENT</h1>

        <p class="page-description">
            Every college student has a different strategy. Choose yours.
        </p>

        <form method="POST" action="create.php">

            <div class="form-group">

                <label for="name">Your Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    required
                >

            </div>

            <div class="form-group">

                <label for="course">Course</label>

                <select id="course" name="course">
                    <option value="BCA">BCA</option>
                </select>

            </div>

            <div class="form-group">

                <label>Choose Your Personality</label>

                <div class="personality-grid">

                    <label class="personality-card">
                        <input type="radio" name="personality" value="hardworking" required>
                        <span class="personality-content">
                            <span class="personality-icon">💪</span>
                            <strong>Hardworking</strong>
                            <small>You take college seriously.</small>
                        </span>
                    </label>

                    <label class="personality-card">
                        <input type="radio" name="personality" value="chill">
                        <span class="personality-content">
                            <span class="personality-icon">😎</span>
                            <strong>Chill</strong>
                            <small>Everything will somehow work out.</small>
                        </span>
                    </label>

                    <label class="personality-card">
                        <input type="radio" name="personality" value="competitive">
                        <span class="personality-content">
                            <span class="personality-icon">🔥</span>
                            <strong>Competitive</strong>
                            <small>You don't just want to pass. You want to win.</small>
                        </span>
                    </label>

                    <label class="personality-card">
                        <input type="radio" name="personality" value="procrastinator">
                        <span class="personality-content">
                            <span class="personality-icon">💤</span>
                            <strong>Procrastinator</strong>
                            <small>Why do today what you can panic about tomorrow?</small>
                        </span>
                    </label>

                </div>

            </div>

            <button type="submit" class="main-button">
                START COLLEGE →
            </button>

        </form>

    </div>

</main>

</body>
</html>

