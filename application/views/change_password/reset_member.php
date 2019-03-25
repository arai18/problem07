<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>社員管理システム</title>
    </head>
    <body>
        <?php echo $this->session->userdata('flash_message'); ?>
        
        <h1>パスワード再設定画面</h1>
        
        <?php echo validation_errors(); ?>
        
        <?php echo form_open('/change_password/reset_member'); ?>
        <?php echo form_label('新しいパスワード'); ?>
        <?php echo form_password('password', set_value('password')); ?>
        
        <?php echo form_submit('submit', '設定')?>
        <?php echo form_close(); ?>
    </body>
</html>
