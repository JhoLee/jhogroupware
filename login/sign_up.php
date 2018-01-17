<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 19:27
 */
session_start();

// Check login info
if (isset($_SESSION['member_id'])) { // Already logged in

    header('Location: ../transaction/transaction_view_personal.php');
} else {

    if (isset($_POST['signUp_id']) && isset($_POST['signUp_pw'])) {

        // Basic Sign Up
        // To-do: make it's details
        $signUp_code = "NON".$signUp_id;
        $signUp_id = $_POST['signUp_id'];
        $signUp_pw = password_hash($_POST['signUp_pw'], PASSWORD_DEFAULT, ["cost" => 12]);


        include_once "../jho.php";

        $sql =
            "
        INSERT INTO `member` (`m_id`, `m_name`, `t_team`, `m_mobile`, `m_birthday`, `m_permission`, `m_pw`) VALUES ('$signUp_code', '$signUp_id', 'NON', '010-0000-0000', '1996-01-01', '0', '$signUp_pw')
            ";

        if (!$result = $db_conn->query($sql)) {
            echo "<script type='text/javascript'>alert('Insertion Failed');</script>";
            echo "<script type='text/javascript'>alert('Insertion Success');</script>";

        }
        $_SESSION['message'] = $result;

        header('Location: login.php');


    } else {
        header( 'Location: login.php');
    }


// hash


}
