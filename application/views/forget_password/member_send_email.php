<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>
    <body>
        <h1>パスワードをお忘れの方</h1>
        <div>
            <p>下記の入力欄に登録いただいたメールアドレスを入力してください。</p>
            <p>入力いただいたメールアドレス先にパスワード設定のリンクを送らせていただきます。</p>
        </div>
        
        <?php echo validation_errors();?>
        
        <?php echo form_open('/forget_password/member_send_email'); ?><br />
            <?php echo form_label('登録いただいたメールアドレス'); ?>
            <?php echo form_input('email', set_value('email')); ?>
            
            <?php echo form_submit('submit', '送信'); ?>
        <?php echo form_close(); ?>
        
        <a href="/login/member">ログイン</a><br>
    </body>
</html>