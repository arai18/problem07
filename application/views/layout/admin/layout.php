<!doctype html>
<html lang="ja">
    <head>
        <title>社員一覧</title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
        <script type="text/javascript" src="/assets/js/script.js"></script>
    </head>
    <body>
        <a href="/admin/member_index">社員一覧</a>
        <a href="/admin/member_add">社員登録</a>
        <a href="/admin/edit">admin情報変更</a>
        <a href="/admin/edit_password">パスワード変更</a>
        <a href="/division/index">部署名一覧</a>
        <a href="/position/index">役職名一覧</a>
        <a href="/admin/logout">ログアウト</a>
        <br><br>
        
        <?php echo $content ?>
    </body>
</html>