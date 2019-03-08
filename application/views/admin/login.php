<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>
    <body>
        <h1>Admin</h1>
        <h2>ログイン画面</h2>
        
        <?php echo validation_errors();?>
        
        <?php echo form_open('/admin/login'); ?>
        
            <?php echo form_label('メールアドレス'); ?>
            <?php echo form_input('email', set_value('email')); ?><br />
            
            <?php echo form_label('パンワード'); ?>
            <?php echo form_password('password', set_value('password')); ?><br />
            
            <?php echo form_submit('submit', 'ログイン'); ?><br />
            <a href="/admin/add">新規登録</a>
        <?php echo form_close(); ?>
    </body>
</html>