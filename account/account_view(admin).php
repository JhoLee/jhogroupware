<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 18:08
 */
session_start();
include_once('../jho.php');

if (!isset($_SESSION['member_id'])) { // Not logged in
    header('Location: ../login/login.php');
} else {
    if (!isset($_SESSION['member_permission']) || $_SESSION['member_permission'] < 2) {
        header('Location: ../main.php');

    } else {
        $team = $_SESSION['member_team'];

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

    <title>account_view(admin)</title>
</head>

<body>
<!--Start of the account_view(admin) page-->
<div data-role="page" id="account_view(admin)" data-theme="c">
    <div data-role="panel" id="menu" data-display="reveal">
        <a href="../my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
            <?php if ( $_SESSION['member_permission'] >= 2 ) {
                echo '<li><a href="account_view(admin).php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="#">first</a></li>
            <li><a href="#">second</a></li>
        </ui>
        <a data-role="button" href="../info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="d" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="#menu" data-icon="bars"> menu</a>
        <h1>account view(admin)</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        <table data-role="table" id="account_summary" data-mode="reflow" class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist">이름</th>
                <th colspan="1">잔액</th>
                <th colspan="1">최종 변경일</th>
            </tr>
            </thead>
            <tbody>
            <?php
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

    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="main_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li>
                    <button data-theme="b" data-icon="home">main</button>
                </li>
                <li><a href="../calendar.php" data-icon="calendar">calendar</a></li>

                <li><a href="../settings.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->