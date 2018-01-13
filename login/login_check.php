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
    header("Location: ../main.php");
}


include_once '../data/mysql.php';

if (isset($_POST["member_id"]) && isset($_POST["member_pw"])) {

    $member_id = $_POST['member_id'];
    $member_pw = $_POST["member_pw"];
}


$result = $db_conn->query("SELECT * FROM member WHERE m_name='$member_id'");
if ($result->num_rows > 0) { // 일치하는 ID 존재
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo "alert(".$row['m_pw'].");";
    if (password_verify($member_pw, $row['m_pw'])) { // ID & PW 일치

        $_SESSION['member_id'] = $member_id;
        $_SESSION['member_team'] = $row['t_team'];
        $_SESSION['member_mobile'] = $row['m_mobile'];
        $_SESSION['member_permission'] = $row['m_permission'];
        header("Location: ../main.php");

    }
} // ID 미존재 혹은 PW 불일치
$_SESSION['message'] = "[ERROR] Wrong ID or PW";
header('Location: login.php');


