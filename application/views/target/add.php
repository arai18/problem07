<!doctype html>
<html lang="ja">
<head>
    <title>目標登録</title>
</head>
<body>
    <h1>目標登録</h1>
    
    <h2><a href="/target/add">目標追加</a></h2>
    <h3><a href="/member/logout">ログアウト</a></h3>
    
    <?php echo validation_errors(); ?>
    
    <?php echo form_open('/target/add'); ?>
        <?php echo form_label('年度'); ?>
        <?php
            $year = [
                'name' => 'year',
                'value' => set_value('year'),
                'placeholder' => date('Y')
            ];
        ?>
        <?php echo form_input($year); ?>
    <?php echo form_close(); ?>
</body>
    
</html>