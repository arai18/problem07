<h1>コメント</h1>
<h2>編集画面</h2>

<?php echo validation_errors();?>

<?php echo form_open("/comment/edit/{$comment->id}"); ?>
    <?php echo form_label('コメント'); ?><br>
    <?php echo form_textarea('comment', set_value('comment', $comment->comment)); ?><br>
    
    <?php echo form_submit('submit', '更新'); ?>
    <a href="/comment/index/<?php echo $comment->target_id; ?>">戻る</a>
<?php echo form_close(); ?>