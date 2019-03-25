<?php echo $this->session->flashdata('flash_message'); ?>

<h1>コメント一覧</h1>

<h3><?php echo $target->year; ?>年度</h3>
<table border="1">
    <tr>
        <th>No</th>
        <th>期間</th>
        <th>目標</th>
        <th>作成日時</th>
        <th>更新日時</th>
    </tr>
    <tr>
        <td><?php echo $target->id; ?></td>
        <td><?php echo $target->term; ?></td>
        <td><?php echo $target->target; ?></td>
        <td>
            <?php 
                $createdTime = $target->created;
                $unixTime = strtotime($createdTime);
                echo date("y/m/d H:i", $unixTime);
            ?>
        </td>
        <td>
            <?php 
                $createdTime = $target->modified;
                $unixTime = strtotime($createdTime);
                echo date("y/m/d H:i", $unixTime);
            ?>
        </td>
    </tr>
</table>
<br>
<br>
<br>

<?php if (!$comments): ?>
    <p>まだコメントが登録されていません。</p>
<?php else: ?>
    <table border="1">
    <tr>
        <th>No</th>
        <th>コメント</th>
        <th>投稿者</th>
        <th>投稿日時</th>
        <th>更新日時</th>
    </tr>
    
    <?php $count = 0; ?>
    <?php foreach ($comments as $comment): ?>
    
    
    <?php $count++; ?>
    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $comment->comment; ?></td>
        <td><?php echo $comment->admin->name; ?></td>
        <td>
            <?php 
                $createdTime = $comment->created;
                $unixTime = strtotime($createdTime);
                echo date("y/m/d H:i", $unixTime);
            ?>
        </td>
        <td>
            <?php 
                $createdTime = $comment->modified;
                $unixTime = strtotime($createdTime);
                echo date("y/m/d H:i", $unixTime);
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>