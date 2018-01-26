<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오전 1:10
 */
session_start();

require_once '../jho.php';

require_once '../resources/lang/get_lang.php';

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
        $_SESSION['alert'] = "SAVING_FAILED";
    } else {
        $_SESSION['alert'] = "SAVING_SUCCESS";
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
        <a href="../settings/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="view.php#all_summary" data-ajax="false">' . $lang['ALL_VIEW']
                    . '</a></li>';
            } ?>
            <li><a href="view.php#personal_summary"
                   data-ajax="false"><?php echo $lang['PERSONAL_VIEW'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
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

        <?php if ($_SESSION['member_permission'] < 2) { ?>

            <img src="../resources/images/no_permission.png" width="100%">

        <?php } else { ?>

            <form id="insertion_form" method="POST" action="insert.php" data-ajax="false">
                <!--Name-->
                <div class="ui-field-contain">
                    <label for="name_input"><?php echo $lang['NAME'] ?>: </label>
                    <input data-clear-btn="true" name="insert_name" id="name_input" placeholder="Jho Lee" value=""
                           type="text">

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
                    <input data-clear-btn="true" name="insert_rmks" id="rmks_input" placeholder="Deposit by cash"
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


    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-tab-toggle="false"
         data-id="transaction_footer">
        <?php $sql = "
                SELECT MAX(d_processed_date) AS 'last updated date' 
                FROM deposit_history 
                WHERE deposit_history.t_team = '$team'
                ";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <h2><?php echo $lang['LAST_UPDATE'] ?>: <?php echo $row['last updated date']; ?></h2>
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li>
                    <button data-theme="b" data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></button>
                </li>
                <li><a href="../calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>

                <li><a href="../settings/index.php" data-icon="gear"><?php echo $lang['SETTINGS'] ?></a></li>
            </ul>
        </div>
    </div><!-- /footer -->
</div><!-- /page -->

</body>
</html>