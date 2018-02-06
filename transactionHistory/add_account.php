<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오전 1:10
 */
session_start();


require_once '../resources/php/classes/Mysql/MysqlInfo.php';
require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/lang/get_lang.php';

if (empty($_SESSION['member'])) {
    header('Location:../login/login.php');
    exit();
} else {
    $db_conn = new \Mysql\MysqlInfo('jho_groupware');

    $member = unserialize($_SESSION['member']);
    foreach ($member->getAllInfo() As $k => $v) {
        $$k = $v;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $depositor = $_POST['depositor'];
    $bank = $_POST['bank'];
    $account = $_POST['account'];

    if (isset($depositor) and isset($bank) and isset($account)) {


        $sql = "INSERT INTO jho_groupware.dues_account_information(t_team, da_depositor, da_bank, da_number) 
          VALUE('$team', '$depositor', '$bank', '$account')";

        if (!($result = $db_conn->query($sql))) {
            setcookie('sqlerror', $db_conn->error, time() + 999, '/');
        }

        header('Location:view.php');

    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1">
    <link rel="stylesheet" href=" ../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT -->

    <title></title>
</head>

<body>

<!-- Start of the add_account page -->
<div data-role="page" id="add_account" data-theme="c">
    <div data-role="panel" id="add_account_menu" data-display="reveal">
        <a href=" ../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $member->getName() ?></a>
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
        <a href="#add_account_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['DUES_DEPOSIT_ACCOUNT'] . " " . $lang['SETTINGS'] ?></h1>
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

            <form id="accountSet_form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                  data-ajax="false">

                <!--bank-->
                <div class="ui-field-contain">
                    <label for="bank_input"><?php echo $lang['BANK'] ?>: </label>
                    <input data-clear-btn="true" name="bank" id="bank_input" placeholder="Toss" value=""
                           type="text" autofocus>
                </div><!--bank-->

                <!--Depositor-->
                <div class="ui-field-contain">
                    <label for="depositor_input"><?php echo $lang['DEPOSITOR'] ?>: </label>
                    <input data-clear-btn="true" name="depositor" id="depositor_input"
                           placeholder="<?php echo $lang['NAME_EXAMPLE'] ?>" value=""
                           type="text">

                </div><!--/depositor-->

                <!--account number-->
                <div class="ui-field-contain">
                    <label for="account_input"><?php echo $lang['ACCOUNT_NUMBER'] ?>: </label>
                    <input data-clear-btn="true" name="account" id="account_input"
                           type="text">
                </div><!--/account number-->

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