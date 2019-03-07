<?php
    class Migration_Create_members extends CI_Migration {

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
                'unsigned' => TRUE
            ],
            'first_name' => [//氏
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'last_name' => [//名
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'first_name_kana' => [//氏(カナ)
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'last_name_kana' => [//名(カナ)
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'gender' => [//性別
                'type' => 'tinyint',
                'constraint' => '1'
            ],
            'birthday' => [//生年月日
                'type' => 'date'
            ],
            'address' => [//住所
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'entering_company_date' => [//入社日
                'type' => 'date'
            ],
            'retirement_date' => [//退職日
                'type' => 'date',
                'null' => TRUE
            ],
            'division_id' => [//部署ID
                'type' => 'INT',
                'unsigned' => TRUE
            ],
            'position' => [//役職ID
                'type' => 'INT',
                'unsigned' => TRUE
            ],
            'email' => [//メールアドレス
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'password' => [//パスワード
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'emergency_contact_address' => [//緊急連絡先電話番号
                'type' => 'VARCHAR',
                'constraint' => '16'
            ],
            'deleted' => [//削除日時
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'created timestamp not null default current_timestamp',
            'modified timestamp not null default current_timestamp on update current_timestamp' 
        ];
       
        $this->dbforge->add_field($fields);//フィールドを読み込む
        
        $this->dbforge->add_key('id', TRUE);//idを主キーにする
        $this->dbforge->create_table('members');//テーブルを作成する
    }   

    // ロールバック処理
    public function down()
    {   
        $this->dbforge->drop_table('members');//ロールバック実行時にテーブルを削除する
    }

}
