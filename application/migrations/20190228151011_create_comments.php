<?php
    class Migration_Create_comments extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    public function up()
    {   
        $fields = [
            'id' => [//id
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'member_id' => [//社員ID
                'type' => 'INT',
                'unsigned' => TRUE,
            ],
            'target_id' => [//目標ID
                'type' => 'INT',
                'unsigned' => TRUE
            ],
            'year' => [//年
                'type' => 'YEAR',
                'constraint' => '4'
            ],
            'admin_id' => [//投稿者(Admin)
                'type' => 'INT',
                'unsigned' => TRUE
            ],
            'comment' => [//コメント
                'type' => 'TEXT',
            ],
            'deleted' => [//削除日時
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'created timestamp not null default current_timestamp',//登録日時
            'modified timestamp not null default current_timestamp on update current_timestamp' //更新日時
        ];
       
        $this->dbforge->add_field($fields);//フィールドを読み込む
        $this->dbforge->add_key('id', TRUE);//idを主キーにする
        $this->dbforge->create_table('comments');//テーブルを作成する
    }   

    // ロールバック処理
    public function down()
    {   
        $this->dbforge->drop_table('comments');//ロールバック実行時にテーブルを削除する
    }

}
