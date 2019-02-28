<?php
    class Migration_Create_divisions extends CI_Migration {

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
            'division_id' => [//部署ID
                'type' => 'INT',
                'unsigned' => TRUE,
            ],
            'division_name' => [//部署名
                'type' => 'VARCHAR',
                'constraint' => '50'
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
        $this->dbforge->create_table('divisions');//テーブルを作成する
    }   

    // ロールバック処理
    public function down()
    {   
        $this->dbforge->drop_table('divisions');//ロールバック実行時にテーブルを削除する
    }

}
