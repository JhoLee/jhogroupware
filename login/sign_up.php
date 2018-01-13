<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-12
 * Time: 오전 9:15
 */
session_start();

// Check login info
if ( isset($_SESSION['member_id'])) { // Already logged in

    header('Location: main.php');
} else {



}