<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오전 1:10
 */
session_start();

error_reporting(E_ALL);

ini_set("display_errors", 1);

require_once '../resources/php/classes/Mysql/MysqlInfo.php';
require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/lang/get_lang.php';

if (empty($_SESSION['member'])) {
    header('Location:../login/login.php');
    exit();
} else {
    $db_conn = new \Mysql\mysqlInfo('jho_groupware');

    $member = unserialize($_SESSION['member']);
    $team = $member->getTeam();
    $name = $member->getName();
    $permission = $member->getPermission();
}
$writer = $name;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $name = $_POST['insert_name'];
    $type = $_POST['insert_type'];
    $rmks = $_POST['insert_rmks'];
    $amount = $_POST['insert_amount'];
    $date = $_POST['insert_date'];
    date_default_timezone_set("Asia/Seoul");
    $now_date = date("Y-m-d H:i:s");

    if (isset($name) and isset($type) and isset($rmks) and isset($amount) and isset($date)) {

        $db_conn = new mysqli('jho_groupware');


        $sql = "INSERT INTO deposit_history
(m_name, t_team, d_category, d_rmks, d_ammount, d_date, d_processed_date, d_writer, d_editor) 
VALUE 
('$name', '$team', '$type', '$rmks', '$amount', '$date', '$now_date', '$writer', '$writer')";

        if ($result = $db_conn->query($sql)) {
            $_SESSION['alert'] = "SAVING_SUCCESS";
        } else {
            $_SESSION['alert'] = "SAVING_FAILED";
        }


    } else {
        $_SESSION['alert'] = "SAVING_FAILED";
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
    <script type="text/javascript">
        $(document).bind("mobileinit", function () {
            $.mobile.ajaxLinksEnabled = false;
            $.mobile.ajaxFormsEnabled = false;
            $.mobile.ajaxEnabled = false;
        });
    </script>
    <script type="text/javascript" src="../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT -->

    <title></title>
</head>

<body>

<!-- Start of the insert page -->
<div data-role="page" id="insert" data-theme="c">
    <div data-role="panel" id="insert_menu" data-display="reveal">
        <a href="../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($permission >= 2) {
                echo '<li><a href="view.php#all_summary" data-ajax="false">' . $lang['ALL_VIEW']
                    . '</a></li>';
            } ?>
            <li><a href="view.php#personal_summary"
                   data-ajax="false"><?php echo $lang['PERSONAL_VIEW'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete"
           data-ajax="false"><?php echo $lang['LOGOUT'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false" data-id="personal_header">
        <a href="#insert_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['TRANSACTION'] . " " . $lang['INSERT'] ?></h1>
        <a data-rel="back" data-icon="back" data-ajax="false"><?php echo $lang['BACK_KEY'] ?></a>
        <div data-role="navbar" id="insert_navbar">
            <ul>
                <li><a href="view.php#all_summary"
                       data-ajax="false"><?php echo $lang['ALL_VIEW'] ?></a>
                </li>
                <li><a href="view.php#personal_summary"
                       data-ajax="false"><?php echo $lang['PERSONAL_VIEW'] ?></a>
                </li>

            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <?php if (isset($_SESSION['alert'])) { ?>
            <?php echo $lang['ALERT'] . $lang['MESSAGE'][$_SESSION['alert']]; ?>
            <?php unset($_SESSION['alert']);
        } ?>

        <?php if ($permission < 2) { ?>

            <img src="../resources/images/no_permission.png">

        <?php } else { ?>

            <form id="insertion_form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                  data-ajax="false">
                <!--Name-->
                <div class="ui-field-contain">
                    <label for="name_input"><?php echo $lang['NAME'] ?>: </label>
                    <input data-clear-btn="true" name="insert_name" id="name_input"
                           placeholder="<?php echo $lang['NAME_EXAMPLE'] ?>" value=""
                           type="text" autofocus>

                </div><!--/Name-->

                <!--type-->
                <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" data-theme="b">
                    <legend><?php echo $lang['TYPE'] ?></legend>
                    <input name="insert_type" id="type_minus" value="-1" type="radio">
                    <label for="type_minus"><?php echo $lang['WITHDRAWAL'] ?></label>
                    <input name="insert_type" id="type_zero" value="0" checked="checked" type="radio">
                    <label for="type_zero">0</label>
                    <input name="insert_type" id="type_plus" value="1" type="radio">
                    <label for="type_plus"><?php echo $lang['DEPOSIT'] ?></label>
                </fieldset><!--type-->

                <!--rmks-->
                <div class="ui-field-contain">
                    <label for="rmks_input"><?php echo $lang['RMKS'] ?>: </label>
                    <input data-clear-btn="true" name="insert_rmks" id="rmks_input"
                           placeholder="<?php echo $lang['RMKS_EXAMPLE'] ?>"
                           value=""
                           type="text">
                </div><!--rmks-->

                <!--amount-->
                <div class="ui-field-contain">
                    <label for="amount_input"><?php echo $lang['AMOUNT_OF_MONEY'] ?>: </label>
                    <input data-clear-btn="true" name="insert_amount" id="amount_input" placeholder="20000" value=""
                           type="text">
                </div><!--amount-->

                <!--date-->
                <div class="ui-field-contain">
                    <label for="date"><?php echo $lang['DATE'] ?>: </label>
                    <input name="insert_date" id="date" data-role="date" data-theme="a"
                           data-inline="true"
                           type="date">
                </div><!--/date-->

                <!--submit-->
                <button data-role="button" id="submit_btn" type="submit"
                        value="submit"><?php echo $lang['SAVE'] ?></button><!--/submit-->


            </form>

        <?php } ?>


    </div><!-- /content -->

    <?php include 'view_footer.php' ?>
</div><!-- /page -->

</body>
</html>