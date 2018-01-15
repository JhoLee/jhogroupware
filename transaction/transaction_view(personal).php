<?php
/**
 * User: Jho
 * Date: 2018-01-10
 * Time: 08:17
 */
session_start();
include_once('../jho.php');
?>
<!DOCTYPE html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT -->

    <title> title </title>
</head>

<body>
<!-- Start of the summary page -->
<div data-role="page" id="summary" data-theme="c">
    <div data-role="panel" id="menu" data-display="reveal">
        <a href="../my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="transaction_view(admin).php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="transaction_view(personal).php">개별 조회</a></li>
        </ul>
        <a data-role="button" href="../info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="d" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="transaction_header">
        <a href="#menu" data-icon="bars">menu</a>
        <h1>Personal View(summary)</h1>
        <a data-rel="back" data-icon="back">back</a>
        <div data-role="navbar" id="accountView_navbar">
            <ul>
                <li><a href="#summary">summary</a></li>
                <li><a href="#revenue">revenue</a></li>
                <li><a href="#expenditure">expenditure</a></li>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">
        <table data-role="table" id="transaction_summary(personal)" data-mode="reflow"
               class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist">이름</th>
                <th colspan="1">잔액</th>
                <th colspan="1">최종 변경일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $name = $_SESSION['member_id'];
            $team = $_SESSION['member_team'];
            $sql = "SELECT m_name AS '이름', SUM(d_category * d_ammount) AS '잔액', MAX(d_date) AS '최종 변경일'
                    FROM deposit_history WHERE t_team='$team' AND m_name = '$name'";
            $result = $db_conn->query($sql);
            if (isset($result)) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                    echo
                        "<tr>
                    <th>" . $row['이름'] . "</th>
                    <td>" . $row['잔액'] . "</td>
                    <td>" . $row['최종 변경일'] . "</td>
                </tr>";
                }
            } ?>
            </tbody>
        </table>
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
                <th data-priority="persist">회비 입금 계좌</th>
                <th colspan="1">예금주명</th>
                <th colspan="1">계좌 번호</th>
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
    </div><!-- /content -->

    <?php } ?>
    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
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
                    <li><a href="../calendar.php" data-icon="calendar">calendar</a></li>

                    <li><a href="../settings.php" data-icon="gear">settings</a></li>
                </ul>
            </div>
    </div><!-- /footer -->
</div><!-- /page -->

<!-- Start of the revenue page -->
<div data-role="page" id="revenue" data-theme="c">
    <div data-role="panel" id="menu" data-display="reveal">
        <a href="../my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="transaction_view(admin).php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="#summary">개별 조회</a></li>
        </ul>
        <a data-role="button" href="../info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="d" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="transaction_header">
        <a href="#menu" data-icon="bars">menu</a>
        <h1>Personal View(revenue)</h1>
        <a data-rel="back" data-icon="back">back</a>
        <div data-role="navbar" id="accountView_navbar">
            <ul>
                <li><a href="#summary">summary</a></li>
                <li><a href="#revenue">revenue</a></li>
                <li><a href="#expenditure">expenditure</a></li>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">
        <table data-role="table" id="transaction_revenue(personal)" data-mode="reflow"
               class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist">이름</th>
                <th colspan="1">잔액</th>
                <th colspan="1">최종 변경일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $name = $_SESSION['member_id'];
            $team = $_SESSION['member_team'];
            $sql = "SELECT m_name AS '이름', SUM(d_category * d_ammount) AS '잔액', MAX(d_date) AS '최종 변경일'
                    FROM deposit_history WHERE t_team='$team' AND m_name = '$name'";
            $result = $db_conn->query($sql);
            if (isset($result)) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                    echo
                        "<tr>
                    <th>" . $row['이름'] . "</th>
                    <td>" . $row['잔액'] . "</td>
                    <td>" . $row['최종 변경일'] . "</td>
                </tr>";
                }
            } ?>
            </tbody>
        </table>
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
                <th data-priority="persist">회비 입금 계좌</th>
                <th colspan="1">예금주명</th>
                <th colspan="1">계좌 번호</th>
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
    </div><!-- /content -->

    <?php } ?>
    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
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
                <li><a href="../calendar.php" data-icon="calendar">calendar</a></li>

                <li><a href="../settings.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer -->
</div><!-- /page -->


</body>
</html>