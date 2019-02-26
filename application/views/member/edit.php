<!DOCTYPE html>
<html>
    <head>
        <title>社員情報更新</title>
    </head>
    <body>
        <h1>社員情報更新</h1>
        
        <?php echo validation_errors();?>
        
        <?php echo form_open("/member/edit/{$member->id}"); ?>
            <?php echo form_hidden('id', "{$member->id}"); ?>
            
            <?php echo form_label('氏'); ?>
            <?php echo form_input('first_name', set_value('first_name', $member->first_name)); ?><br />
            
            <?php echo form_label('名'); ?>
            <?php echo form_input('last_name', set_value('last_name', $member->last_name)); ?><br />
            
            <?php echo form_label('生年月日'); ?>
            <?php echo form_input('age', set_value('age', $member->age)); ?><br />
            
            <?php echo form_label('出身地'); ?>
            <?php echo form_input('home', set_value('home', $member->home)); ?><br />
            <?php echo form_submit('submit', '登録'); ?>
        <?php echo form_close();?>
    </body>
</html>
