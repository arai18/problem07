<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>    
        <?php echo $this->session->flashdata('flash_message'); ?>
    
        <h1>ログイン画面</h1>
        <?php echo validation_errors();?>
        
        <?php echo form_open('/login/member'); ?>
        
            <?php echo form_label('メールアドレス'); ?>
            <?php echo form_input('email', set_value('email')); ?><br />
            
            <?php echo form_label('パスワード'); ?>
            <?php echo form_password('password', set_value('password')); ?><br />
            
            <?php echo form_submit('submit', 'ログイン'); ?><br />
        <?php echo form_close(); ?>
    </body>
</html>

