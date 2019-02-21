<!DOCTYPE html>
<html>
    <head>
        <title>社員情報登録</title>
    </head>
    <body>
        <h1>社員情報登録</h1>
        
        <?php echo validation_errors(); ?>
        
        <form action="/member/add" method="post">
            <label>氏</label>
            <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"><br />
            
            <label>名</label>
            <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"><br />
            
            <label>生年月日</label>
            <input type="text" name="age" value="<?php echo set_value('age'); ?>"><br />
            
            <label>出身地</label>
            <input type="text" name="home" value="<?php echo set_value('home'); ?>"><br />
            
            <input type="submit" value="登録">
            
        </form>
        
    </body>
</html>
