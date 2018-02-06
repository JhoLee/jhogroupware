<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 19:27
 */
session_start();

spl_autoload_register(function ($class) {
    str_replace('\\', '/', $class);
    $class = '../resources/php/classes/' . $class . '.php';
    require_once $class;
});

require_once '../resources/php/classes/Mysql/MysqlInfo.php';
$db_conn = new \Mysql\MysqlInfo('jho_groupware');

// Check login info
if (isset($_SESSION['member_id'])) { // Already logged in

    header('Location: ../index.php');
} else {

    if (!isset($_POST)) {
        $_SESSION['alert'] = "SIGN_UP_FAILED";
        header('Location: login.php');
        exit();
    } else {

        // Basic Sign Up
        // To-do: make it's details
        $id = $_POST['signUp_id'];
        $name = $_POST['signUp_name'];
        $mobile = $_POST['signUp_mobile'];
        $birthday = $_POST['signUp_birthday'];
        $team = $_POST['signUp_team'];
        $permission = 0;

        $pw = password_hash($_POST['signUp_pw1'], PASSWORD_DEFAULT, ["cost" => 12]);


        $sql =
            "
        INSERT INTO `member` (`m_id`, `m_name`, `t_team`, `m_mobile`, `m_birthday`, `m_permission`, `m_pw`) VALUES ('$id', '$name', '$team', '$mobile', '$birthday', '$permission', '$pw')
            ";

        if (!$result = $db_conn->query($sql)) {
            echo "<script type='text/javascript'>alert('Insertion Failed');</script>";
            echo "<script type='text/javascript'>alert('Insertion Success');</script>";
            $_SESSION['alert'] = "SIGN_UP_FAILED";

        } else {
            $_SESSION['alert'] = "SIGN_UP_SUCCESS";
        }
        header('Location: login.php');
        exit();


    }


// hash


}
