<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오전 1:10
 */
session_start();

include_once '../jho.php';

$writer = $_SESSION['member_name'];
$team = $_SESSION['member_team'];

if (isset($_POST['insert_name']) && isset($_POST['insert_type']) && isset ($_POST['insert_rmks']) && isset($_POST['insert_amount']) && isset($_POST['insert_date'])) {


    $name = $_POST['insert_name'];
    $type = $_POST['insert_type'];
    $rmks = $_POST['insert_rmks'];
    $amount = $_POST['insert_amount'];
    $date = $_POST['insert_date'];
    date_default_timezone_set("Asia/Seoul");
    $now_date = date("Y-m-d H:i:s");


    $sql = "INSERT INTO deposit_history
(m_name, t_team, d_category, d_rmks, d_ammount, d_date, d_processed_date, d_writer, d_editor) 
VALUE 
('$name', '$team', '$type', '$rmks', '$amount', '$date', '$now_date', '$writer', '$writer')";

    if (!$result = $db_conn->query($sql)) {
        $_SESSION['message'] = "[ERROR] Failed to save...";
        header('Location: transaction_view_personal.php#insert');
    } else {
        $_SESSION['message'] = "[SYSTEM] Successfully saved!";
        header('Location: transaction_view_personal.php#insert');
    }


} else {
    header('Location: transaction_view_personal.php#insert');
}