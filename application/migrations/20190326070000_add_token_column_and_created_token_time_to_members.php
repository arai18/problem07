<?php
    class Migration_Add_token_column_and_created_token_time_to_members extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    /**
     * カラムの追加
     */
    public function up()
    {  
        $fields = [
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
            ],
            'create_token_time' => [
                'type' => 'DATETIME'
            ]
        ];
        $this->dbforge->add_column('members', $fields);
    }   

    // ロールバック処理
    /*
     * カラムの削除
     */
    public function down()
    {
        $this->dbforge->drop_column('members', 'token');
        $this->dbforge->drop_column('members', 'create_token_time');
    }
}
