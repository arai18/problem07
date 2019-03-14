<h1>目標一覧</h1>
<h2><a href="/target/add">目標追加</a></h2>

    <?php foreach ($years as $year): ?>
    <h3><?php echo $year->year; ?></h3>
        <table border="1">
            <tr>
                <th>No</th>
                <th>期間</th>
                <th>目標</th>
                <th>編集</th>
                <th>削除</th>
                <th>コメント</th>
                <th>作成日時</th>
                <th>更新日時</th>
            </tr>
            <?php $count = 0; ?>
            <?php foreach ($targets as $target): ?>
                <?php if ($year->year === $target->year): ?>
                <?php $count++; ?>
                <tr>
                    <td><?php echo $count;?></td>
                    <td>
                        <?php 
                            switch($target->term) {
                                case 1:
                                    echo '4~6月';
                                    break;
                                case 2:
                                    echo '7~9月';
                                    break;
                                case 3:
                                    echo '10~12月';
                                    break;
                                case 4:
                                    echo '1~3月';
                                    break;
                            }
                        ?>
                    </td>
                    <td><?php echo $target->target;?></td>
                    <td><a href="/target/edit/<?php echo $target->year?>/<?php echo $target->term?>">編集</a></td>
                    <td><a href="/target/delete/<?php echo $target->year?>/<?php echo $target->term?>">削除</a></td>
                    <td><a href="#">コメント</a></td>
                    <td>
                        <?php
                            $createdTime = $target->created;
                            $unixTime = strtotime($createdTime);
                            echo date("y/m/d H:i", $unixTime); 
                        ?>
                    </td>
                    <td>
                        <?php
                            $modifiedTime = $target->modified;
                            $unixTime = strtotime($modifiedTime);
                            echo date("y/m/d H:i", $unixTime); 
                        ?>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>