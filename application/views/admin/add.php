<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>
    <body>
        
        <h1>admin</h1>
        <h2>登録画面</h2>
        
        <?php echo validation_errors();?>
        
        <?php echo form_open('/admin/add'); ?>
            <?php echo form_label('メールアドレス'); ?>
            <?php echo form_input('email', set_value('email')); ?><br />
            
            <?php echo form_label('パスワード'); ?>
            <?php echo form_password('password', set_value('password')); ?><br />
            
            <?php echo form_label('氏名'); ?>
            <?php echo form_input('name', set_value('name')); ?><br />
            <?php echo form_submit('submit', '登録'); ?>
        <?php echo form_close(); ?>
            <a href="/admin/login">ログイン</a>
    </body>
</html>