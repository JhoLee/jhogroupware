<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-10
 * Time: 오전 8:57
 *
 * +) Check 'id' and 'password' with MySQL DB
 */

session_start();

if (isset($_SESSION['member_id'])) {
    header("Location: ../transaction/transaction_view_personal.php");
}


include_once '../jho.php';

if (isset($_POST["member_name"]) && isset($_POST["member_pw"])) {

    $member_name = $_POST['member_name'];
    $member_pw = $_POST["member_pw"];


    $result = $db_conn->query("SELECT * FROM member WHERE m_name='$member_name'");
    if ($result->num_rows > 0) { // 일치하는 ID 존재
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (password_verify($member_pw, $row['m_pw'])) { // ID & PW 일치

            $_SESSION['member_id'] = $row['m_id'];
            $_SESSION['member_name'] = $row['m_name'];
            $_SESSION['member_team'] = $row['t_team'];
            $_SESSION['member_mobile'] = $row['m_mobile'];
            $_SESSION['member_birthday'] = $row['m_birthday'];
            $_SESSION['member_permission'] = $row['m_permission'];
            header("Location: ../transaction/transaction_view_personal.php");

        }
    } // ID 미존재 혹은 PW 불일치
    $_SESSION['message'] = "[ERROR] Wrong ID or PW";
    header('Location: login.php');

} else {
    $_SESSION['message'] = "[ERROR] Please enter ID & PW";
    header('Location: login.php');
}

