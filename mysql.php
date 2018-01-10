<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-04
 * Time: 14:49
 */

$db_host = "localhost";
$db_user = "root";
$db_password = "root1234";
$db_name = "jho_groupware";


// DB Connecting test
$db_conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($db_conn->connect_errno) {
    die('Connection Error : ' . $db_conn->connect_error);
} else {
    $db_conn->query('set session character_set_connection = utf8;');
    $db_conn->query('set session character_set_results = utf8;');
    $db_conn->query('set session character_set_client = utf8;');
}

