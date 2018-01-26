<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-07
 * Time: 오후 11:55
 */


session_start();

if (!isset($_SESSION['member_id'])) { // Not logged in


    require_once 'jho.php';

    if (isset($_POST['member_team']) and isset($_POST['member_name']) and isset($_POST['member_pw'])) {

        $member_team = $_POST['member_team'];
        $member_name = $_POST['member_name'];
        $member_pw = $_POST["member_pw"];


        $result = $db_conn->query("SELECT * FROM member WHERE m_name='$member_name' AND t_team='$member_team'");
        if ($result->num_rows > 0) { // 일치하는 ID 존재
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (password_verify($member_pw, $row['m_pw'])) { // ID & PW 일치

                $_SESSION['member_id'] = $row['m_id'];
                $_SESSION['member_name'] = $row['m_name'];
                $_SESSION['member_team'] = $row['t_team'];
                $_SESSION['member_mobile'] = $row['m_mobile'];
                $_SESSION['member_birthday'] = $row['m_birthday'];
                $_SESSION['member_permission'] = $row['m_permission'];
                header("Location: ../index.php");

            }
        } // ID 미존재 혹은 PW 불일치
        $_SESSION['alert'] = "LOGIN_FAILED";
        header('Location: login.php');

    } else {
        header('Location: login.php');
    }

}


require_once 'resources/head.php';

?>

<body>
<!--Start of the index page-->
<div data-role="page" id="index" data-theme="c">
    <div data-role="panel" id="index_menu" data-display="reveal">
        <a href="settings/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
        </ul>
        <a data-role="button" href="settings/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT'] ?></a>
    </div><!--/panel-->


    <div data-role="header" data-theme="a" data-position="fixed">
        <a href="#index_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['INDEX'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">
        <?php header('Location: transactionHistory/view.php'); ?>
        <img src="resources/images/under_construction.png" width="100%">
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="transaction_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="transactionHistory/view.php"
                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                <li><a href="calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>
                <li>
                    <a href="settings/index.php" data-icon="gear"><?php echo $lang['SETTINGS'] ?></a>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#index-->