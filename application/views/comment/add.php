<h1>コメント</h1>
<h2>登録画面</h2>

<?php echo validation_errors();?>

<?php echo form_open("/comment/add/{$target_id}"); ?>
    <?php echo form_label('コメント'); ?><br>
    <?php echo form_textarea('comment', set_value('comment')); ?><br>
    
    <?php echo form_submit('submit', '登録'); ?>
    <a href="/comment/index/<?php echo $target_id; ?>">戻る</a>
<?php echo form_close(); ?>