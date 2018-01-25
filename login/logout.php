<?php

session_start();

if (isset($_SESSION['member_id'])) {
    unset($_SESSION['member_id']);

    $_SESSION['alert'] = "LOGOUT_SUCCESS";

} else {
    $_SESSION['alert'] = "NOT_LOGGED_IN";
}

header("Location: login.php");