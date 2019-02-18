<!DOCTYPE html>
<html>
    <head>
        <title>社員情報更新</title>
    </head>
    <body>
        <h1>社員情報更新</h1>
        
        <form action="http://local.problem07.com/member/edit" method="post">
            <input type="hidden" name="id" value="<?php echo $member[0]['id'] ;?>">
            <label>氏</label>
            <input type="text" name="first_name" value="<?php echo $member[0]['first_name'] ;?>"><br />
            
            <label>名</label>
            <input type="text" name="last_name" value="<?php echo $member[0]['last_name'] ;?>"><br />
            
            <label>年齢</label>
            <input type="text" name="age" value="<?php echo $member[0]['age'] ;?>"><br />
            
            <label>出身地</label>
            <input type="text" name="home" value="<?php echo $member[0]['home'] ;?>"><br />
            
            <input type="submit" value="登録">
            
        </form>
        
    </body>
</html>
