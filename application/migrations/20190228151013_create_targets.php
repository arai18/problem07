<?php
    class Migration_Create_targets extends CI_Migration {

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
            'year' => [//年
                'type' => 'YEAR',
                'constraint' => '4'
            ],
            'target_text_1' => [//目標(4月~6月)
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'target_text_2' => [//目標(7月~9月)
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'target_text_3' => [//目標(10月~12月)
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'target_text_4' => [//目標(1月~3月)
                'type' => 'TEXT',
                'null' => TRUE
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
        $this->dbforge->create_table('targets');//テーブルを作成する
    }   

    // ロールバック処理
    public function down()
    {   
        $this->dbforge->drop_table('targets');//ロールバック実行時にテーブルを削除する
    }

}
