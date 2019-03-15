<!doctype html>
<html lang="ja">
<head>
    <title>社員管理システム</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/script.js"></script>
</head>
<body>
    <a href="/target/index">目標一覧</a>
    <a href="/member/edit">メンバー情報変更</a>
    <a href="/member/edit_password">パスワード変更</a>
    <a href="/member/logout">ログアウト</a>
    <br><br>
    <?php echo $content ?>
</body>
</html>