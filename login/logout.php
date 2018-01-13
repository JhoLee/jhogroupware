<?php

session_start();

if (isset($_SESSION['member_id'])) {
    unset($_SESSION['member_id']);

    $_SESSION['message'] = "[SYSTEM] Logout Success!";

}

header("Location: login.php");