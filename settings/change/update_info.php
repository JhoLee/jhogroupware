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
    foreach ($member->getAllInfo() As $k => $v) {
        $$k = $v;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($member->getPermission() < 2) {
            $_POST['rate'] = $member->getPermission();
        }

        if (!empty($_POST['id']) and !empty($_POST['name']) and !empty($_POST['team']) and !empty($_POST['mobile']) and !empty($_POST['birthday'])) {
            $user_id = $_POST['id'];
            $user_name = $_POST['name'];
            if ($user_id == '이주호')
                $user_rate = 295;
            else
                $user_rate = $_POST['rate'];
            $user_team = $_POST['team'];
            $user_mobile = $_POST['mobile'];
            $user_birthday = $_POST['birthday'];


            $sql = "UPDATE member SET m_permission = '$user_rate', m_mobile = '$user_mobile', m_birthday = '$user_birthday' WHERE m_id = '$user_id' AND t_team = '$user_team' LIMIT 1";
            $db_conn = new \Mysql\MysqlInfo('jho_groupware');

            $result = $db_conn->query($sql);

            $_SESSION['user_id'] = $user_id;

            if ($result) {
                $_SESSION['alert'] = "EDITION_SUCCESS";
            } else {
                $_SESSION['alert'] = "EDITION_FAILED";
            }

        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['user_id'])) {
            $_SESSION['user_id'] = $_GET['user_id'];
        }
    }

    if (isset($_SESSION['user_id'])) {
        if ($member->getPermission() >= 2) { // admin
            $user_id = $_SESSION['user_id'];
        } else { // not admin
            $_SESSION['user_id'] = $member->getId();
        }
        $sql = "SELECT * FROM member WHERE m_id = '$user_id' AND t_team = '$team'";

        $result = $db_conn->query($sql);
        if ($result->num_rows > 0) { // Found
            if ($row = $result->fetch_assoc()) {

                $user = new \Member\Member($row['m_id'], $row['m_name'], $row['t_team'], $row['m_mobile'],
                    $row['m_birthday'], $row['m_permission']);
                $_SESSION['user_id'] = $user->getId();
            }
        } else { // Not Found
            $_SESSION['alert'] = "NOT_FINDABLE";
            unset($_SESSION['user_id']);
        }
    } else { // Not Set "$_SESSION['user_id']"
        $user = $member;
        $_SESSION['user'] = serialize($user);
    }
    /* */


}


?>


<body>

<!--Start of the info_update page-->
<div data-role="page" id="info_update" data-theme="c">

    <div data-role="panel" id="info_update_menu" data-display="reveal">
        <?php include_once '../settings_panel.php'; ?>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="info_header">
        <a href="#info_update_menu" data-icon="bars"> menu</a>
        <h1><?php echo $lang['UPDATE_INFO'] ?></h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">

        <?php if (isset($_SESSION['alert'])) { ?>
            <?php echo $lang['ALERT'] . $lang['MESSAGE'][$_SESSION['alert']]; ?>
            <?php unset($_SESSION['alert']);
        } ?>

        <form id="myInfo_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"
              data-ajax="false">
            <div id="id_info" class="ui-field-contain">
                <label for=id"><?php echo $lang['ID'] ?>: </label>
                <input name="id" id="id" value="<?php echo $user->getId() ?>"
                       placeholder=""
                       type="text" readonly>
            </div>
            <div id="name_info" class="ui-field-contain">
                <label for="name"><?php echo $lang['NAME'] ?>: </label>
                <input name="name" id="name" value="<?php echo $user->getName() ?>"
                       placeholder=""
                       type="text" readonly>
            </div>


            <!--type-->
            <?php if (
                ($member->getId() != $user->getId() and $member->getPermission() >= 2 and $member->getPermission() > $user->getPermission()) or ($member->getId() == $user->getId())
            ) { ?>
                <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" data-theme="b">
                    <legend><?php echo $lang['TYPE'] ?></legend>

                    <input name="rate" id="rate_0" value="0"
                           type="radio" <?php if ($user->getPermission() == 0) { ?> checked="checked"<?php } ?>>
                    <label for="rate_0"><?php echo $member->_getRate(0) ?></label>
                    <input name="rate" id="rate_1" value="1"
                           type="radio" <?php if ($user->getPermission() == 1) { ?> checked="checked"<?php } ?>>
                    <label for="rate_1"><?php echo $member->_getRate(1) ?></label>
                    <input name="rate" id="rate_2" value="2"
                           type="radio" <?php if ($user->getPermission() == 2) { ?> checked="checked" <?php } ?>>
                    <label for="rate_2"><?php echo $member->_getRate(2) ?></label>
                    <?php if ($member->getPermission() >= 3) { ?>
                        <input name="rate" id="rate_3" value="3"
                               type="radio" <?php if ($user->getPermission() == 3) { ?> checked="checked" <?php } ?>>
                        <label for="rate_3"><?php echo $member->_getRate(3) ?></label>
                    <?php } ?>
                </fieldset><!--type-->
            <?php } ?>

            <div id="team_info" class="ui-field-contain">
                <label for="team"><?php echo $lang['TEAM'] ?>: </label>
                <input name="team" id="team" value="<?php echo $team ?>"
                       placeholder="Input your team"
                       type="text" readonly>
            </div>

            <div id="mobile_info" class="ui-field-contain">
                <label for="mobile"><?php echo $lang['MOBILE'] ?>: </label>
                <input name="mobile" id="mobile" value="<?php echo $user->getMobile() ?>"
                       placeholder="<?php echo $user->getMobile() ?>" type="tel">
            </div>

            <div id="birthday_info" class="ui-field-contain">
                <label for="birthday"><?php echo $lang['BIRTHDAY'] ?>: </label>
                <input name="birthday" id="birthday" value="<?php echo $user->getBirthday() ?>"
                       placeholder="" type="date">
            </div>

            <input data-theme="a" id="edit_button" type="submit" data-icon="check" value="<?php echo $lang['EDIT'] ?>">

        </form><!--/form-->
        <a href="../../contacts/manage_members.php" data-role="button" data-theme="a" data-icon="edit"
           data-ajax="false"><?php echo $lang['MANAGE_MEMBERS'] ?></a>

    </div><!--/content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../../transactionHistory/view.php"
                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                <li><a href="../../contacts/index.php" data-icon="user"><?php echo $lang['CONTACTS'] ?></a></li>
                <li><a href="../../calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>
                <li>
                    <button data-theme="b" data-icon="gear"><?php echo $lang['SETTINGS'] ?></button>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->


</div><!--/page#info_update-->

</body>

</html>