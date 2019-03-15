<h1>社員パスワード情報更新</h1>

<?php echo validation_errors(); ?>

<?php echo form_open("member/edit_password"); ?>
    <?php echo form_label('現在のパスワード'); ?>
    <?php echo form_password('old_password', set_value('old_password')); ?>

    <?php echo form_label('新しいのパスワード'); ?>
    <?php echo form_password('new_password', set_value('new_password')); ?>

    <?php echo form_submit('submit', '変更'); ?>
<?php echo form_close(); ?>   
