<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>
    <body>
        
        <h1>ログイン画面</h1>
        
        <form action="/user/login" method="post">
            <label>メールアドレス</label>
            <input type="text" name="email"><br />
            
            <label>パスワード</label>
            <input type="password" name="password"><br />
            
            <input type="submit" value="ログイン"><br />
            <a href="/user/add">新規登録</a>
        </form>
    </body>
</html>