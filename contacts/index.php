<?php


session_start();

require_once '../resources/lang/get_lang.php';
require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/php/classes/Mysql/MysqlInfo.php';

if (empty($_SESSION['member'])) { // Not logged in
    header('Location: ../login/login.php');
    exit();
} else {

    $member = unserialize($_SESSION['member']);

    if ($member->getPermission() < 2) {
        header('Location: ../');
        exit();
    } else {
        /* Get Members in same team */
        if ($member->getPermission() < 2) {
            return [];
        } else {
            $team = $member->getTeam();
            $sql = "SELECT * FROM jho_groupware.member WHERE t_team ='$team' ORDER BY  m_permission DESC, m_name ";
            $db_conn = new \Mysql\mysqlInfo('jho_groupware');
            $result = $db_conn->query($sql);

            $teamMembers_info = array();
            while ($row = $result->fetch_assoc()) {

                $members[$row['m_id']] = new Member\Member($row['m_id'], $row['m_name'], $row['t_team'], $row['m_mobile'],
                    $row['m_birthday'], $row['m_permission']);

            }


        }
        /* */

    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $member_pw = $_POST["current_pw"];

    if (!isset($_POST['change_pw1']) || !isset($_POST['change_pw2'])) {
        $_SESSION['alert'] = 'PLZ_ENTER';
    } else {
        if ($_POST['change_pw1'] != $_POST['change_pw2']) {
            $_SESSION['alert'] = 'PW_NOT_SAME';
        } else {


            $result = $db_conn->query("SELECT * FROM member WHERE m_name='$name'");
            if ($result->num_rows <= 0) {

                $_SESSION['alert'] = 'UNKNOWN_ERROR';
            } else { // 일치하는 ID 존재
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (!password_verify($member_pw, $row['m_pw'])) {

                    $_SESSION['alert'] = 'PW_INCORRECT';
                } else { // ID & PW 일치

                    $change_pw = password_hash($_POST['change_pw1'], PASSWORD_DEFAULT, ["cost" => 12]);

                    $sql = "UPDATE member SET m_pw = '$change_pw' WHERE m_name = '$name' AND t_team = '$team'";

                    $db_conn->query($sql);

                    $_SESSION['alert'] = 'PW_CHANGE_SUCCESS';

                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->


    <title> <?php echo $lang['PAGE_TITLE'] ?></title>
</head>

<body>
<!--Start of the my_info page-->
<div data-role="page" id="my_info" data-theme="c">
    <div data-role="panel" id="my_info_menu" data-display="reveal">
        <?php include_once 'contacts_panel.php'; ?>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#my_info_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['CONTACTS'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">


        <?php if (isset($_SESSION['message'])) { ?>
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']);
        } ?>


        <table data-role="table" class="ui-responsive">
            <thead>

            <th><?php echo $lang['NAME'] ?></th>
            <th><?php echo $lang['MOBILE'] ?></th>
            <th><?php echo $lang['BIRTHDAY'] ?></th>
            </thead>
            <tobdy>

                <?php
                /** @var \Member\Member $members */
                foreach ($members

                as $user_id => $user) { ?>
                <?php if ($user->getPermission() != 0) { ?>
                    <tr>


                        <?php $col = $user->getAllInfo(); ?>
                        <th><?php echo $col['name'] ?></th>
                        <td><?php echo $col['mobile'] ?></td>
                        <td><?php echo $col['birthday'] ?></td>

                    </tr>
                <?php } ?>
            </tobdy>
            <?php } ?>
        </table>
        <?php if ($member->getPermission() >= 2) { ?>
            <a href="manage_members.php" data-theme="a" data-role="button"
               data-icon="edit" data-ajax="false"><?php echo $lang['MANAGE_MEMBERS'] ?></a>
        <?php } ?>

    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../transactionHistory" data-icon="bullets"
                       data-ajax="false"><?php echo $lang['TRANSACTION'] ?></a>
                </li>
                <li>
                    <button data-theme="b" data-icon="user" data-ajax="false"><?php echo $lang['CONTACTS'] ?></button>
                </li>
                <li>
                    <a href="../calendar/index.php" data-icon="calendar"
                       data-ajax="false"><?php echo $lang['CALENDAR'] ?></a>
                </li>
                <li><a href="../settings/index.php" " data-icon="gear"
                    data-ajax="false"><?php echo $lang['SETTINGS'] ?></a>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->


</body>
</html>