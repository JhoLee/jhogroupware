<?php

session_start();

if (isset($_SESSION['member'])) {
    unset($_SESSION['member']);

    $_SESSION['alert'] = "LOGOUT_SUCCESS";

} else {
    $_SESSION['alert'] = "NOT_LOGGED_IN";
}

header("Location: login.php");
exit();