<!doctype html>
<html lang="ja">
<head>
    <title>社員一覧</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
    <script type="text/javascript" src="/assets/js/script.js"></script>
</head>
<body>
    <a href="/admin/edit/<?php echo $this->session->userdata('admin_id'); ?>">admin情報変更</a>
    <a href="/admin/edit_password/<?php echo $this->session->userdata('admin_id'); ?>">パスワード変更</a>
    <a href="/admin/logout">ログアウト</a>
    
    <h1>社員一覧</h1>
    
    <table border="1">
        <tr>
            <th>社員番号</th>
            <th>氏名</th>
            <th>年齢</th>
            <th>目標</th>
            <th>コメント</th>
            <th>登録日時</th>
            <th>更新日時</th>
        </tr>
        
            <tr>
                <th>社員番号</th>
                <th>氏名</th>
                <th>年齢</th>
                <th>目標</th>
                <th>コメント</th>
                <th>登録日時</th>
                <th>更新日時</th>
            </tr>
        
    </table>
    
</html>