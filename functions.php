<?php

function limitStats()
{
    $_SESSION["academics"] = max(0, min(100, $_SESSION["academics"]));
    $_SESSION["attendance"] = max(0, min(100, $_SESSION["attendance"]));
    $_SESSION["energy"] = max(0, min(100, $_SESSION["energy"]));
    $_SESSION["happiness"] = max(0, min(100, $_SESSION["happiness"]));
    $_SESSION["stress"] = max(0, min(100, $_SESSION["stress"]));
    $_SESSION["money"] = max(0, $_SESSION["money"]);
}

function showResult($effects, $nextAction, $title, $message = "")
{
    $_SESSION["effects"] = $effects;
    $_SESSION["next_action"] = $nextAction;
    $_SESSION["result_title"] = $title;
    $_SESSION["result_message"] = $message;
    $_SESSION["show_result"] = true;
}

function goToDay($day)
{
    $_SESSION["day"] = $day;
    $_SESSION["show_result"] = false;
    unset($_SESSION["effects"]);
    unset($_SESSION["next_action"]);
    unset($_SESSION["result_title"]);
    unset($_SESSION["result_message"]);
}

?>
