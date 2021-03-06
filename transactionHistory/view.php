<?php

/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-25
 * Time: 오후 9:26
 *
 * Integrated file.
 *   |_'ALL_VIEW.php'
 *   |_'transaction_view_personal.php'
 */
session_start();


require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/php/classes/Mysql/MysqlInfo.php';
require_once '../resources/lang/get_lang.php';


/*
 *
 if (!isset($_SESSION['member'])) { // Not logged in
    $_SESSION['message'] = "Not Logged in 'view'";
    header('Location: ../login/login.php');
    exit();
} else */

if (empty($_SESSION['member'])) { // Not logged in
    header('Location: ../login/login.php');
    exit();

} else {
    $member = unserialize($_SESSION['member']);
    foreach ($member->getAllInfo() As $k => $v) {
        $$k = $v;
    }
    if ($member->getPermission() == 0) {
        $_SESSION['alert'] = "NO_PERMISSION_YET";
        unset($_SESSION['member']);
        header('../login/login.php');
        exit();

    }

    $permission = $member->getPermission();
    $db_conn = new \Mysql\MysqlInfo('jho_groupware');
}

$sql = "
            SELECT
              SUM(ql.잔액) AS '계좌 잔액'
            FROM
              (SELECT 
                m_id AS '이름', 
                SUM(d_category * d_ammount) AS '잔액', 
                MAX(d_date) AS '최종 변경일' 
                FROM `deposit_history` 
                WHERE `t_team` = '$team' 
                GROUP BY m_id) AS ql";
$result = $db_conn->query($sql);
if (isset($result)) {
    $balance_sum = 0;
    while ($row = $result->fetch_assoc()) {
        $balance_sum = number_format($row['계좌 잔액']);
    }
} ?>
<!DOCTYPE html>
<html>
<?php require_once '../resources/head.php'; ?>


<body>
<!-- Start of the personal_summary page -->
<div data-role="page" id="personal_summary" data-theme="c">

    <div data-role="panel" id="personal_summary_menu" data-display="reveal">
        <a href=" ../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($permission >= 2) { ?>
            <li><a href="#all_summary"><?php echo $lang["ALL_VIEW"] . '</a></li>' ?>
                    <?php } ?>
            <li><a href="#personal_summary_menu"><?php echo $lang['TRANSACTION_VIEW_PERSONAL'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false">
        <a href="#personal_summary_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>

        <h1><?php echo $lang['PERSONAL_VIEW'] ?>(<?php echo $lang['SUMMARY'] ?>)</h1>

        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        <div data-role="navbar" id="summary_navbar">
            <ul>
                <li><a href="#personal_summary"><?php echo $lang['SUMMARY'] ?></a></li>
                <li><a href="#personal_details"><?php echo $lang['DETAILS']; ?></a></li>
                <?php if ($permission >= 2) { ?>
                    <li><a href="insert.php"><?php echo $lang['INSERT'] ?></a></li>
                <?PHP } ?>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <!-- Announce Board -->
        <?php require_once '../announce_board/announce_view.php' ?>
        <!-- /Announce Board -->

        <table data-role="table" id="transaction_summary_personal_table" data-mode="reflow"
               class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist"><?php echo $lang['NAME'] ?></th>
                <th colspan="1"><?php echo $lang['BALANCE'] ?></th>
                <th colspan="1"><?php echo $lang['LAST_MODIFIED_DATE'] ?></th>
            </tr>
            </thead>
            <tbody>

            <?php


            $sql = "SELECT m_id AS '아이디', SUM(d_category * d_ammount) AS '잔액', MAX(d_date) AS '최종 변경일'
                    FROM deposit_history WHERE t_team='$team' AND m_id='$id'";
            $result = $db_conn->query($sql);
            if (isset($result)) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                    echo
                        "<tr>
                    <th>" . $row['아이디'] . "</th>
                    <td>" . $lang['SYMBOL']['CURRENCY'] . number_format($row['잔액']) . "</td>
                    <td>" . $row['최종 변경일'] . "</td>
                </tr>";
                }
            } else {
                echo "??";
            }
            /*
           $sql = "SELECT m_name AS '이름', SUM(d_category * d_ammount) AS '잔액', MAX(d_date)
           AS '최종 변경일'
           FROM deposit_history WHERE t_team='$team' AND m_name = '공동기금'";

           $result = $db_conn->query($sql);
           if (!empty($result)) {
               while ($row = $result->fetch_assoc()) { ?>
                   <tr>
                       <th><?php echo $row['이름'] ?></th>
                       <td><?php echo $lang['SYMBOL']['CURRENCY'] . number_format($row['잔액']) ?></td>
                       <td><?php echo $row['최종 변경일'] ?></td>
                   </tr>
               <?php } ?>
           <?php } */ ?>

            <tr>
                <th>계좌 전체</th>
                <td><?php echo $lang['SYMBOL']['CURRENCY'] . $balance_sum ?></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <br>
        <br>
        <?php
        $sql = "SELECT da_depositor AS '예금주명', da_bank AS '은행', da_number AS '계좌번호'
                    FROM dues_account_information WHERE t_team='$team'";
        $result = $db_conn->query($sql);
        if (isset($result) && $result->num_rows > 0) {
            ?>
            <table data-role="table" id="duesAccount_info" data-mode="reflow" class="ui-responsive table-stroke">
                <thead>
                <tr>
                    <th data-priority="persist"><?php echo $lang['DUES_DEPOSIT_ACCOUNT'] ?></th>
                    <th colspan="1"><?php echo $lang['DEPOSITOR'] ?></th>
                    <th colspan="1"><?php echo $lang['ACCOUNT_NUMBER'] ?></th>
                </tr>
                </thead>
                <tbody>

                <?php while ($row = $result->fetch_assoc()) {
                    echo
                        "<tr>
            <th>" . $row['은행'] . "</th>
            <td>" . $row['예금주명'] . "</td>
            <td>" . $row['계좌번호'] . "</td>
            </tr>";
                } ?>
                </tbody>
            </table>
            <br>
            <a href="add_account.php" data-role="button" data-theme="a" data-icon="edit" data-mini="true"
               data-ajax="false"><?php echo $lang['DUES_DEPOSIT_ACCOUNT'] . " " . $lang['INSERT'] ?></a>

        <?php } ?>
    </div><!-- /content -->


    <?php include 'view_footer.php'; ?>

</div><!-- /page#personal_summary -->

<!-- Start of the personal_details page -->
<div data-role="page" id="personal_details" data-theme="c">

    <div data-role="panel" id="personal_details_menu" data-display="reveal">
        <a href="../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($permission >= 2) { ?>
            <li><a href="#all_summary"><?php echo $lang["ALL_VIEW"] . '</a></li>' ?>
                    <?php } ?>
            <li><a href="#personal_summary"><?php echo $lang['PERSONAL_VIEW'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false">
        <a href="#personal_details_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>

        <h1><?php echo $lang['PERSONAL_VIEW'] ?>(<?php echo $lang['DETAILS'] ?>)</h1>

        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        <div data-role="navbar" id="summary_navbar">
            <ul>
                <li><a href="#personal_summary"><?php echo $lang['SUMMARY'] ?></a></li>
                <li><a href="#personal_details"><?php echo $lang['DETAILS'] ?></a></li>
                <?php if ($permission >= 2) { ?>
                    <li><a href="insert.php"><?php echo $lang['INSERT'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <script language="javascript">
            /*

            $(document).on("pageshow", "#dataTablesExample1", function () {

                if ($.fn.DataTable.isDataTable('#example')) {
                    $('#example').DataTable().columns.adjust();
                    return;
                }

                $('#example').dataTable({
                    "scrollX": true,
                    "scrollXollapse": true,
                    "ajax": 'assets/files/demos/jquery_mobile/datatables/dt_ajax_example.json',
                    "pagingType": "full"
                });
            });

            $(document).on("pageremove", function (event) {
                $('#example').DataTable().destroy(false);
            });
*/
        </script>


        <table data-role="table" id="transaction_details_personal_table" data-mode="reflow"
               class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist"><?php echo $lang['DATE'] ?></th>
                <th colspan="1">구분</th>
                <th colspan="1"><?php echo $lang['AMOUNT_OF_MONEY'] ?></th>
                <th colspan="1">내용</th>
                <th colspan="1"><?php echo $lang['BALANCE'] ?></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $db_conn->query("SET @balance := 0;");
            $sql = "
            SELECT
              ql.d_id,
              ql.비고,
              ql.구분,
              ql.금액,
              ql.날짜,
              ql.입력일,
            
              (@balance := @balance + (ql.구분 * ql.금액)) AS '잔액'
            
            FROM
              (SELECT
                 d_id,
                 d_category       AS '구분',
                 d_ammount        AS '금액',
                 d_rmks           AS '비고',
                 d_date           AS '날짜',
                 d_processed_date AS '입력일'
               FROM deposit_history
               WHERE t_team = '$team' AND m_id = '$id'
               GROUP BY d_id, d_date
               ORDER BY d_date, d_id) AS ql
            ORDER BY ql.날짜, ql.d_id ASC;";
            $result = $db_conn->query($sql);
            if (isset($result)) {

                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                    echo "<tr >
                      <th>" . $row['날짜'] . "</th>";
                    if ($row['구분'] > 0) {
                        $category = "DEPOSIT";
                    } else if ($row['구분'] < 0) {
                        $category = "WITHDRAWAL";
                    } else {
                        $category = "UNKNOWN";
                    }
                    echo "<td>" . $lang[$category] . "</td >
                        <td >" . $lang['SYMBOL']['CURRENCY'] . number_format($row['구분'] * $row['금액']) . " </td >
                          <td > " . $row['비고'] . " </td >
                          <td >" . $lang['SYMBOL']['CURRENCY'] . number_format($row['잔액']) . " </td >
                  </tr > ";
                }
            } ?>
            </tbody>
        </table>
        <br>

    </div><!-- /content -->

    <?php include 'view_footer.php'; ?>

</div><!-- /page#personal_details -->


<!--Start of the all_summary page-->
<div data-role="page" id="all_summary" data-theme="c">

    <div data-role="panel" id="all_summary_menu" data-display="reveal">
        <a href=" ../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($permission >= 2) { ?>
            <li><a href="#all_summary"><?php echo $lang["ALL_VIEW"] . '</a></li>' ?>
                    <?php } ?>
            <li><a href="#personal_summary"><?php echo $lang['TRANSACTION_VIEW_PERSONAL'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false">
        <a href="#all_summary_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>

        <h1><?php echo $lang['ALL_VIEW'] ?>(<?php echo $lang['SUMMARY'] ?>)</h1>

        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        <div data-role="navbar" id="summary_navbar">
            <ul>
                <li><a href="#all_summary"><?php echo $lang['SUMMARY'] ?></a></li>
                <li><a href="#all_details"><?php echo $lang['DETAILS'] ?></a></li>
                <?php if ($permission >= 2) { ?>
                    <li><a href="insert.php"><?php echo $lang['INSERT'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <table data-role="table" id="account_summary" data-mode="reflow" class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th><?php echo $lang['NAME'] ?></th>
                <th><?php echo $lang['BALANCE'] ?></th>
                <th><?php echo $lang['LAST_MODIFIED_DATE'] ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>총계</th>
                <td><?php echo $lang['SYMBOL']['CURRENCY'] . $balance_sum ?></td>
                <td></td>
            </tr>
            <?php
            $sql = "SELECT 
                m_id AS '이름', 
                SUM(d_category * d_ammount) AS '잔액', 
                MAX(d_date) AS '최종 변경일' 
                FROM `deposit_history` 
                WHERE `t_team` = '$team' 
                GROUP BY m_id
            ";
            if (isset($db_conn)) {
                $result = $db_conn->query($sql);
            }

            if (isset($result)) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>

                    <tr>
                        <th><?php echo $row['이름'] ?></th>
                        <td><?php echo $lang['SYMBOL']['CURRENCY'] . number_format($row['잔액']) ?></td>
                        <td><?php echo $row['최종 변경일'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>


    </div><!-- /content-->

    <?php include 'view_footer.php'; ?>

</div><!-- /page#all_summary-->

<!--Start of the all_details page-->
<div data-role="page" id="all_details" data-theme="c">

    <div data-role="panel" id="all_details_menu" data-display="reveal">
        <a href="../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($permission >= 2) { ?>
            <li><a href="#all_summary"><?php echo $lang["ALL_VIEW"] . '</a></li>' ?>
                    <?php } ?>
            <li><a href="#personal_summary"><?php echo $lang['TRANSACTION_VIEW_PERSONAL'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false">
        <a href="#all_details_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>

        <h1><?php echo $lang['ALL_VIEW'] ?>(<?php echo $lang['DETAILS'] ?>)</h1>

        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        <div data-role="navbar" id="summary_navbar">
            <ul>
                <li><a href="#all_summary"><?php echo $lang['SUMMARY'] ?></a></li>
                <li><a href="#all_details"><?php echo $lang['DETAILS'] ?></a></li>
                <?php if ($permission >= 2) { ?>
                    <li><a href="insert.php"><?php echo $lang['INSERT'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <?php if ($permission < 2) { ?>

            <img src="../resources/images/no_permission.png">

        <?php } else { ?>

            <table data-role="table" id="account_summary" data-mode="reflow" class="ui-responsive table-stroke">
                <thead>
                <tr>
                    <th><?php echo $lang['DATE'] ?></th>
                    <th><?php echo $lang['NAME'] ?></th>
                    <th>구분</th>
                    <th><?php echo $lang['AMOUNT_OF_MONEY'] ?></th>
                    <th>내용</th>
                    <th><?php echo $lang['BALANCE'] ?></th>
                </tr>
                </thead>
                <tbody>
                <?php


                $db_conn->query('SET @balance := 0;');
                $sql = "
SELECT
ql.id,
ql.날짜,
ql.이름,
ql.구분,
ql.금액,
ql.비고,
(@balance := @balance + (ql.구분 * ql.금액)) AS '잔액',
ql.입력일

FROM
(SELECT
d_id             AS 'id',
m_id           AS '이름',
d_category       AS '구분',
d_ammount        AS '금액',
d_rmks           AS '비고',
d_date           AS '날짜',
d_processed_date AS '입력일'
FROM deposit_history
WHERE t_team = '$team'

ORDER BY 날짜, 이름) AS ql

ORDER BY ql.날짜, ql.입력일, ql.이름  ASC;

";
                $result = $db_conn->query($sql);
                if (isset($result)) {
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                        echo "<tr >
                    <th>" . $row['날짜'] . "</th>
                    <td>" . $row['이름'] . "</td>";
                        if ($row['구분'] > 0) {
                            $category = "DEPOSIT";
                        } else if ($row['구분'] < 0) {
                            $category = "WITHDRAWAL";
                        } else {
                            $category = "UNKNOWN";
                        }
                        echo "<td>" . $lang[$category] . "</td >
                             <td> " . $lang['SYMBOL']['CURRENCY'] . ($row['구분'] * $row['금액']) . "</td >
                            <td > " . $row['비고'] . " </td >
                            <td > " . $lang['SYMBOL']['CURRENCY'] . number_format($row['잔액']) . "</td >
                  </tr > ";
                    }
                } ?>
                </tbody>
            </table>

        <?php } ?>

    </div><!-- /content-->

    <?php include 'view_footer.php'; ?>

</div><!-- /page#all_details-->


</body>

