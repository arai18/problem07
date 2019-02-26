<!DOCTYPE html>
<html>
    <head>
        <title>社員情報登録</title>
    </head>
    <body>
        <h1>社員情報登録</h1>
        
        <?php echo validation_errors(); ?>
        
        <?php echo form_open('/member/add'); ?>
            <?php echo form_label('氏'); ?>
            <?php echo form_input('first_name', set_value('first_name')); ?><br />
            
            <?php echo form_label('名'); ?>
            <?php echo form_input('last_name', set_value('last_name')); ?><br />
            
            <?php echo form_label('生年月日'); ?>
            <?php echo form_input('age', set_value('age')); ?><br />
            
            <?php echo form_label('出身地'); ?>
            <?php echo form_input('home', set_value('home')); ?><br />
            
            <?php echo form_submit('submit', '登録'); ?><br />
        <?php echo form_close(); ?>   
    </body>
</html>
