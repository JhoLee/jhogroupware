<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-07
 * Time: 오후 11:55
 */


session_start();


spl_autoload_register(
    function ($class) {
        $class = str_replace('\\', '/', $class);
        require_once 'resources/php/classes/' . $class . '.php';
    });


require_once 'resources/lang/get_lang.php';


$member = unserialize($_SESSION['member']);

if ($member->getPermission() == 0) {
    $_SESSION['alert'] = "NO_PERMISSION_YET";
    unset($_SESSION['member']);
    header('../login/login.php');
    exit();

}

$team = $member->getTeam();
$name = $member->getName();
$permission = $member->getPermission();
$db_conn = new \Mysql\MysqlInfo('jho_groupware');

?>

<!DOCTYPE html>
<html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="resources/js/jquery.js"></script>
    <script type="text/javascript" src=" resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->

    <title> <?php $lang['PAGE_TITLE'] ?></title>
    <script type="text/javascript">
        $('document').ready(function () {
            $.ajax({
                type: "POST",
                url: "transactionHistory/view.php",
                data: {
                    category: "transaction",
                    division: "personal",
                    section: "summary"
                },
                success: function (data) {
                    alert(data);
                    $('#index').html(data);
                },
                error: function (request, status, error) {
                    alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error: " + error);
                }
            });

        });

        $.on("click", "a", function (event) {
            let link = event.target.getAttribute('href');
            event.preventDefault();
            alert(link.indexOf('#'));

            if (link.indexOf('#') !== 0) {
                alert(link);
                $.ajax({
                    type: "POST",
                    url: event.target.getAttribute('href'),
                    data: {
                        category: "transaction",
                        division: "personal_summary"
                    },
                    success: function (data) {
                        $('#index').html(data)

                    },
                    error: function (request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error: " + error);
                    }
                });
            }



        });

    </script>
</head>


<body>
<!--Start of the index page-->
<div data-role="page" id="index" data-theme="c">

</div><!-- /page#index-->