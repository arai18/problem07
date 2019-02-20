<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>
    <body>
        
        <h1>ユーザ登録画面</h1>
        
        <?php echo validation_errors();?>
        
        <form action="/user/add" method="post">
            <label>メールアドレス</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>"><br />
            
            <label>パスワード</label>
            <input type="password" name="password" value="<?php echo set_value('password'); ?>"><br />
            
            <label>氏名</label>
            <input type="text" name="name" value="<?php echo set_value('name'); ?>"><br />
            
            <input type="submit" value="登録"><br />
        </form>
    </body>
</html>