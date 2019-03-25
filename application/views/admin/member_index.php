<?php echo $this->session->flashdata('flash_message');?>

<h1>社員一覧</h1>
    
        <?php if (!$members): ?>
            <p>まだ社員が登録されていません。</p>
        <?php else: ?>
            <table border="1">
            <tr>
                <th>社員番号</th>
                <th>氏名</th>
                <th>年齢</th>
                <th>性別</th>
                <th>部署</th>
                <th>役職</th>
                <th>入社日</th>
                <th>目標</th>
                <th>編集</th>
                <th>削除</th>
                <th>登録日時</th>
                <th>更新日時</th>
            </tr>
            <?php foreach ($members as $member): ?>
            <tr>
                <td><?php echo $member->id; ?></td>
                <th><?php echo $member->first_name . $member->last_name; ?></td>
                <td>
                    <?php 
                        $now = date("Ymd");
                        $birthday = str_replace("-", "", $member->birthday);//ハイフンを除去しています。
                        echo floor(($now-$birthday)/10000);
                    ?>
                </td>
                <td><?php $gender = ($member->gender === '1')? '男':'女'; ?><?php echo $gender; ?></td>
                <td><?php echo $member->division->division_name?></td>
                <td><?php echo $member->position->position_name?></td>
                <td><?php echo $member->entering_company_date;?></td>
                <td><a href="/admin/target_index/<?php echo $member->id; ?>">一覧</a></td>
                <td><a href="/admin/member_edit/<?php echo $member->id; ?>">編集</a></td>
                <td><a href="/admin/delete/<?php echo $member->id; ?>" class="delete">削除</a></td>
                <td>
                    <?php
                        $createdTime = $member->created;
                        $unixTime = strtotime($createdTime);
                        echo date("y/m/d H:i", $unixTime); 
                    ?>
                </td>
                <td>
                    <?php
                        $modifiedTime = $member->modified;
                        $unixTime = strtotime($modifiedTime);
                        echo date("y/m/d H:i", $unixTime); 
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
        <?php endif; ?>
            
        