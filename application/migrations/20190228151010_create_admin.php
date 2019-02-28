<?php
    class Migration_Create_admin extends CI_Migration {

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
            'email' => [//メールアドレス
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'password' => [//パスワード
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'name' => [//名前
                'type' => 'VARCHAR',
                'constraint' => '30'
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
        $this->dbforge->create_table('admin');//テーブルを作成する
    }   

    // ロールバック処理
    public function down()
    {   
        $this->dbforge->drop_table('admin');//ロールバック実行時にテーブルを削除する
    }

}
