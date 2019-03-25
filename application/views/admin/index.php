<h1>Admin一覧</h1>

<table border='1'>
    <tr>
        <th>ID</th>
        <th>名前</th>
        <th>メールアドレス</th>
        <th>作成日時</th>
        <th>更新日時</th>
    </tr>
    <?php foreach($admins as $admin): ?>
    <tr>
        <td><?php echo $admin->id; ?></td>
        <td><?php echo $admin->name?></td>
        <td><?php echo $admin->email?></td>
        <td>
            <?php
                $createdTime = $admin->created;
                $unixTime = strtotime($createdTime);
                echo date("y/m/d H:i", $unixTime); 
            ?>
        </td>
        <td>
            <?php
                $modifiedTime = $admin->modified;
                $unixTime = strtotime($modifiedTime);
                echo date("y/m/d H:i", $unixTime); 
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>