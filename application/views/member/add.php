<!DOCTYPE html>
<html>
    <head>
        <title>社員情報登録</title>
    </head>
    <body>
        <h1>社員情報登録</h1>
        
        <?php echo validation_errors(); ?>
        
        <?php 
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
        ?>
        
        <form action="/member/add" method="post">
            <label>氏</label>
            <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"><br />
            
            <label>名</label>
            <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"><br />
            
            <label>生年月日</label>
            <input type="text" name="age" value="<?php echo set_value('age'); ?>" placeholder="1990-01-01"><br />
            
            <label>出身地</label>
            <input type="text" name="home" value="<?php echo set_value('home'); ?>"><br />
            
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <input type="submit" value="登録">
            
        </form>
        
    </body>
</html>
