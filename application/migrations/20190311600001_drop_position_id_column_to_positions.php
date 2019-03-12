<?php
    class Migration_Drop_position_id_column_to_positions extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    public function up()
    {  
        $this->dbforge->drop_column('positions', 'position_id');
    }   

    // ロールバック処理
    public function down()
    {
        $fields = [
            'position_id' => [//役職ID
                'type' => 'INT',
                'unsigned' => TRUE
            ]
        ];
        $this->dbforge->add_column('positions', $fields);
    }
}
