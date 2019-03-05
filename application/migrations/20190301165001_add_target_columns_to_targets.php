<?php
    class Migration_Add_target_columns_to_targets extends CI_Migration {

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
            'term' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'after' => 'year'
            ],
            'target' => [
                'type' => 'TEXT',
                'after' => 'term'
            ]
        ];
        $this->dbforge->add_column('targets', $fields);
    }   

    // ロールバック処理
    /*
     * カラムの削除
     */
    public function down()
    {
        $this->dbforge->drop_column('targets', 'term');
        $this->dbforge->drop_column('targets', 'target');
    }
}
