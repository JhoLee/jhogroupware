<!DOCTYPE html>
<meta charset="utf-8" />
<html>
<head>
    <title>JQM 예제 04</title>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a1/jquery.mobile-1.0a1.min.css" />
    <script src="http://code.jquery.com/jquery-1.4.3.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.0a1/jquery.mobile-1.0a1.min.js"></script>
</head>
<body>
<section id="first" data-role="page">
    <header data-role="header">
        <h1>페이지 헤더</h1>
    </header>
    <div data-role="content" class="content">
        <p>버튼 테마 예시</p>
        <button type="submit" data-theme="a" name="submit" value="1번" id="submit-button-1">알림창 열기 1</button>
        <button type="submit" data-theme="b" name="submit" value="2번" id="submit-button-2">알림창 열기 2</button>
        <button type="submit" data-theme="c" name="submit" value="3번" id="submit-button-3">알림창 열기 3</button>
    </div>
    <footer data-role="footer">
        <h4>페이지 푸터</h4>
    </footer>
</section>
<script>
    $('button').click(function() {
        alert(this.value+" 버튼 누름.");
    });
</script>
</body>
</html>