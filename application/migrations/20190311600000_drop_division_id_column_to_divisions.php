<?php
    class Migration_Drop_division_id_column_to_divisions extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    public function up()
    {  
        $this->dbforge->drop_column('divisions', 'division_id');
    }   

    // ロールバック処理
    public function down()
    {
        $fields = [
            'division_id' => [//部署ID
                'type' => 'INT',
                'unsigned' => TRUE,
            ]
        ];
        $this->dbforge->add_column('targets', $fields);
    }
}
