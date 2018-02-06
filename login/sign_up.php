<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 19:27
 */
session_start();

require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/php/classes/Mysql/MysqlInfo.php';
$db_conn = new \Mysql\MysqlInfo('jho_groupware');

// Check login info
if (isset($_SESSION['member'])) { // Already logged in

    header('Location: ../transaction/view.php');
} else {

    if (!isset($_POST)) {
        $_SESSION['alert'] = "SIGN_UP_FAILED";
    } else {
        if ($_POST['type'] == 'sign_up') {
            if (empty($_POST['id_available']) or empty($_POST['pw_length']) or empty($_POST['pw_same'])) {
                $_SESSION['message'] = 'bye';
                $_SESSION['alert'] = "SIGN_UP_FAILED";
            } else {
                $id = $_POST['signUp_id'];
                $name = $_POST['signUp_name'];
                $team = $_POST['signUp_team'];
                $mobile = empty($_POST['signUp_mobile']) ? "010-0000-0000" : $_POST['signUp_mobile'];
                $birthday = empty($_POST['signUp_birthday']) ? "2002-02-02" : date("Y-m-d", $_POST['signUp_birthday']);
                $permission = $_POST['team_check'] == '1' ? 3 : 0;
                $pw = $_POST['signUp_pw1'];
                $pw = password_hash($pw, PASSWORD_DEFAULT, ["cost" => 12]);

                $sql = "INSERT INTO member (`m_id`, `m_name`, `t_team`, `m_mobile`, `m_birthday`, `m_permission`, `m_pw`) VALUE ('$id', '$name', '$team', '$mobile', '$birthday', '$permission', '$pw')";

                $result = $db_conn->query($sql);
                setcookie('sqlerror', $db_conn->error, time() + 999, '/');
                $_SESSION['message'] = $birthday;
                if (!$result) {

                    $_SESSION['alert'] = "SIGN_UP_FAILED";
                } else {
                    $_SESSION['alert'] = "SIGN_UP_SUCCESS";
                    $type = '0';
                    $rmks = 'Init.';
                    $amount = '0';
                    $date = date("Y-m-d", time());
                    $now_date = date("Y-m-d", time());
                    $writer = 'System';
                    $sql = "INSERT INTO deposit_history
(m_id, t_team, d_category, d_rmks, d_ammount, d_date, d_processed_date, d_writer, d_editor) 
VALUE 
('$id', '$team', '$type', '$rmks', '$amount', '$date', '$now_date', '$writer', '$writer')";
                    $db_conn->query($sql);
                }
            }
        }
    }
    header('Location:login.php');
    exit();
}

