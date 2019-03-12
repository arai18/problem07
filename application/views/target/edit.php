<!DOCTYPE html>
<html lang="ja">
<head>
    <title>目標登録</title>
</head>
<body>
    <h1>目標登録</h1>
    
    <h2><a href="/target/add">目標追加</a></h2>
    <h3><a href="/member/logout">ログアウト</a></h3>
    
    <?php echo validation_errors(); ?>
    
    <?php echo form_open("/target/edit/{$target->year}/{$target->term}"); ?>
        <?php echo form_label('年度'); ?>
        <?php
            $year = [
                'name' => 'year',
                'value' => set_value('year', $target->year),
                'placeholder' => date('Y')
            ];
        ?>
        <?php echo form_input($year); ?><br />
    
        <?php echo form_label('期間'); ?>
        <?php
            $term_options = [
                1 => '4月~6月',
                2 => '7月~9月',
                3 => '10月~12月',
                4 => '1月~3月',
            ];
        ?>
        <?php echo form_dropdown('term', $term_options, set_value('term', $target->term)); ?><br />
    
        <?php echo form_label('目標'); ?><br />
        <?php
            $target = [
                'name' => 'target',
                'value' => set_value('target', $target->target),
                'placeholder' => 'ここに目標を記入してください。'
            ];
        ?>
        <?php echo form_textarea($target); ?><br />
   
        <?php echo form_submit('submit', '更新'); ?>
    <?php echo form_close(); ?>
</body>
    
</html>