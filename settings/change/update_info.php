<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오후 7:46
 */
session_start();

require_once '../../resources/lang/get_lang.php';
require_once '../../resources/php/classes/Mysql/MysqlInfo.php';
require_once '../../resources/php/classes/Member/Member.php';
require_once '../settings_head.php';

if (empty($_SESSION['member'])) { // Not logged in
    header('Location: ../login/login.php');
    exit();
} else {

    $db_conn = new \Mysql\MysqlInfo('jho_groupware');

    $member = unserialize($_SESSION['member']);
    $member_info = $member->getAllInfo();
    foreach ($member->getAllInfo() As $k => $v) {
        $$k = $v;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($member->getPermission() >= 2) {
            $user_id = $_GET['user_id'];
            $sql = "SELECT * FROM jho_groupware.member WHERE m_id = '$user_id' AND t_team = '$team'";

            $result = $db_conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $user = new Member\Member($row['m_id'], $row['m_name'], $row['t_team'], $row['m_mobile'],
                        $row['m_birthday'], $row['m_permission']);
                }
            }

            if ($member->getId() == $user->getId())
                unset($user);


        }
        /* */


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mobile = $_POST['mobile'];
            $birthday = $_POST['birthday'];

            require_once '../../jho.php';


        }


    }
}


?>


<body>

<!--Start of the my_info_update page-->
<div data-role="page" id="my_info_update" data-theme="c">

    <div data-role="panel" id="my_info_update_menu" data-display="reveal">
        <a href="../info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <li><a href="update_my_info.php" data-role="button" data-theme="a" data-icon="edit" data-ajax="false">Update
                    my Info.</a></li>
            <li><a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
                   data-ajax="false">Change
                    password</a></li>
        </ul>
        <a data-role="button" href="../info/app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../../login/logout.php" data-theme="b" data-icon="delete"
           data-ajax="false">logout</a>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#my_info_update_menu" data-icon="bars"> menu</a>
        <h1><?php echo $lang['UPDATE_MY_INFO'] ?></h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        <form id="myInfo_form" method="post" action="update_my_info.php" data-ajax="false">
            <div id="my_id_info" class="ui-field-contain">
                <label for="name"><?php echo $lang['ID'] . $lang['MESSAGE']['READ_ONLY'] ?>: </label>
                <input name="id" id="id" value="<?php echo $user->getId() ?>"
                       placeholder=""
                       type="text" readonly>
            </div>
            <div id="my_name_info" class="ui-field-contain">
                <label for="name"><?php echo $lang['NAME'] . $lang['MESSAGE']['READ_ONLY'] ?>: </label>
                <input name="name" id="name" value="<?php echo $user->getName() ?>"
                       placeholder=""
                       type="text" readonly>
            </div>

            <?php if (!empty($user)) { ?>
                <!--type-->
                <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" data-theme="b">
                <legend><?php echo $lang['TYPE'] ?></legend>
                <?php if ($member->getPermission() >= 2) { ?>
                    <input name="insert_type" id="type_0" value="0"
                           type="radio" <?php if ($user->getPermission() == 0) echo 'checked="checked"' ?>>
                    <label for="type_0"><?php echo $member->_getRate(0) ?></label>
                    <input name="insert_type" id="type_1" value="1"
                           type="radio" <?php if ($user->getPermission() == 1) echo 'checked="checked"' ?>>
                    <label for="type_1"><?php echo $member->_getRate(1) ?></label>
                    </fieldset><!--type-->
                <?php } ?>

            <?php } ?>
            <div id="my_team_info" class="ui-field-contain">
                <label for="team"><?php echo $lang['TEAM'] . $lang['MESSAGE']['READ_ONLY'] ?>: </label>
                <input name="team" id="team" value="<?php echo $team ?>"
                       placeholder="Input your team"
                       type="text" readonly>
            </div>

            <div id="my_mobile_info" class="ui-field-contain">
                <label for="mobile"><?php echo $lang['MOBILE'] ?>: </label>
                <input name="mobile" id="mobile" value="<?php echo $user->getMobile() ?>"
                       placeholder="<?php echo $user->getMobile() ?>" type="tel">
            </div>

            <div id="my_birthday_info" class="ui-field-contain">
                <label for="birthday"><?php echo $lang['BIRTHDAY'] ?>: </label>
                <input name="birthday" id="my_birthday" value="<?php echo $user->getBirthday() ?>"
                       placeholder="" type="date">
            </div>

            <input data-theme="a" id="edit_button" type="submit" data-icon="check" value="<?php echo $lang['EDIT'] ?>">

        </form><!--/form-->

    </div><!--/content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../../transactionHistory/view.php" data-icon="bullets"> transaction</a></li>
                <li>
                    <a href="../../calendar/index.php" data-icon="calendar">calendar</a>
                </li>
                <li><a href="../index.php" data-theme="b" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->


</div><!--/page#my_info_update-->

</body>

</html>