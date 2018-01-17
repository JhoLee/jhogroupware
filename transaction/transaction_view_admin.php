<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 18:08
 */
session_start();
include_once('../jho.php');

if (!isset($_SESSION['member_name'])) { // Not logged in
    header('Location: ../login/login.php');
} else {
    if (!isset($_SESSION['member_permission']) || $_SESSION['member_permission'] < 2) {
        header('Location: transaction_view_personal.php');

    } else {
        $team = $_SESSION['member_team'];


    }
}
?>

<!DOCTYPE html >
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->

    <title></title>
</head>

<body>
<!--Start of the admin_summary page-->
<div data-role="page" id="admin_summary" data-theme="c">
    <div data-role="panel" id="admin_summary_menu" data-display="reveal">
        <a href="../settings/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="transaction_view_admin.php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="transaction_view_personal.php">개별 조회</a></li>
        </ui>
        <a data-role="button" href="../settings/app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete"
           data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="admin_header">
        <a href="#admin_summary_menu" data-icon="bars"> menu</a>
        <h1>account view(admin)</h1>
        <a data-rel="back" data-icon="back"> back</a>
        <div data-role="navbar" id="admin_summary_navbar">
            <ul>
                <li><a href="#admin_summary" data-ajax="false">summary</a></li>
                <li><a href="#admin_details" data-ajxa="false">details</a></li>
                <li><a href="transaction_insert.php">insert</a></li>
            </ul>
        </div>

    </div><!-- /header-->

    <div data-role="content">

        <?php if ($_SESSION['member_permission'] < 2) { ?>

            <img src="../resources/images/no_permission.png" width="100%">

        <?php } else { ?>

            <table data-role="table" id="account_summary" data-mode="reflow" class="ui-responsive table-stroke">
                <thead>
                <tr>
                    <th>이름</th>
                    <th>잔액</th>
                    <th>최종 변경일</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT 
                m_name AS '이름', 
                SUM(d_category * d_ammount) AS '잔액', 
                MAX(d_date) AS '최종 변경일' 
                FROM `deposit_history` 
                WHERE `t_team` = '$team' 
                GROUP BY m_name
            ";
                if (isset($db_conn)) {
                    $result = $db_conn->query($sql);
                }

                if (isset($result)) {
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                        echo "<tr>
                    <th>" . $row['이름'] . "</th>
                    <td>" . $row['잔액'] . "</td>
                    <td>" . $row['최종 변경일'] . "</td>
                  </tr>";
                    }
                } ?>
                </tbody>
            </table>

        <?php } ?>

    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="transaction_footer">
        <?php $sql = "
                SELECT MAX(d_processed_date) AS 'last updated date' 
                FROM deposit_history 
                WHERE deposit_history.t_team = '$team'
                ";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <h2>Data Last Updated at : <?php echo $row['last updated date']; ?></h2>
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li>
                    <button data-theme="b" data-icon="bullets">transaction</button>
                </li>
                <li><a href="../calendar/calendar.php" data-icon="calendar">calendar</a></li>

                <li><a href="../settings/settings.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->

<!--Start of the admin_details page-->
<div data-role="page" id="admin_details" data-theme="c">
    <div data-role="panel" id="admin_details_menu" data-display="reveal">
        <a href="../settings/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="transaction_view_admin.php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="transaction_view_personal.php">개별 조회</a></li>
        </ui>
        <a data-role="button" href="../settings/app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed">
        <a href="#admin_details_menu" data-icon="bars"> menu</a>
        <h1>account view(admin)</h1>
        <a data-rel="back" data-icon="back"> back</a>
        <div data-role="navbar" id="admin_details_navbar">
            <ul>
                <li><a href="#admin_summary" data-ajax="false">summary</a></li>
                <li><a href="#admin_details" data-ajaxa="false">details</a></li>
                <li><a href="transaction_insert.php"data-ajaxa="false">insert</a></li>
            </ul>
        </div>

    </div><!-- /header-->

    <div data-role="content">

        <?php if ($_SESSION['member_permission'] < 2) { ?>

            <img src="../resources/images/no_permission.png" width="100%">

        <?php } else { ?>

            <table data-role="table" id="account_summary" data-mode="reflow" class="ui-responsive table-stroke">
                <thead>
                <tr>
                    <th>날짜</th>
                    <th>이름</th>
                    <th>구분</th>
                    <th>금액</th>
                    <th>내용</th>
                    <th>잔액</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = $_SESSION['member_id'];
                $name = $_SESSION['member_name'];
                $team = $_SESSION['member_team'];


                $db_conn->query('SET @balance := 0;');
                $sql = "
SELECT
ql.날짜,
ql.이름,
ql.구분,
ql.금액,
ql.비고,
(@balance := @balance + (ql.구분 * ql.금액)) AS '잔액',
ql.입력일

FROM
(SELECT
m_name           AS '이름',
d_category       AS '구분',
d_ammount        AS '금액',
d_rmks           AS '비고',
d_date           AS '날짜',
d_processed_date AS '입력일'
FROM deposit_history
WHERE t_team = '$team'

ORDER BY 날짜, 이름) AS ql

ORDER BY ql.날짜, ql.이름, ql.입력일 ASC;

";
                $result = $db_conn->query($sql);
                if (isset($result)) {
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                        echo "<tr >
                    <th>" . $row['날짜'] . "</th>
                    <td>" . $row['이름'] . "</td>";
                        if ($row['구분'] > 0) {
                            echo "<td>입금</td>";
                        } else if ($row['구분'] < 0) {
                            echo "<td>출금</td>";

                        } else {
                            echo "<td>??</td>";
                        }
                        echo "<td> " . ($row['구분'] * $row['금액']) . "원 </td >
                          <td > " . $row['비고'] . " </td >
                          <td > " . $row['잔액'] . "원 </td >
                  </tr > ";
                    }
                } ?>
                </tbody>
            </table>

        <?php } ?>

    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="transaction_footer">
        <?php $sql = "
                SELECT MAX(d_processed_date) AS 'last updated date' 
                FROM deposit_history 
                WHERE deposit_history . t_team = '$team'
                ";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <h2>Data Last Updated at : <?php echo $row['last updated date']; ?></h2>
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li>
                    <button data-theme="b" data-icon="bullets">transaction</button>
                </li>
                <li><a href=" ../calendar / calendar . php" data-icon="calendar">calendar</a></li>

                <li><a href=" ../settings / settings . php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#admin_details-->
