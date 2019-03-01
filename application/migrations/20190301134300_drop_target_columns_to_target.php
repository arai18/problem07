<?php
    class Migration_drop_target_columns_to_target extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    public function up()
    {   
        $drop_columns = [
            'target_text_1',
            'target_text_2',
            'target_text_3',
            'target_text_4'
        ];
        $this->dbforge->drop_column('members', $drop_columns);//member_idを削除する。
        
        $add_columns = [
            'term tinyint(1) not null',//yearカラムの後に追加する。
            
            'target' => [
                'type' => 'text'
            ]
        ];
        $this->dbforge->add_column('members', $add_columns);
        
    }   

    // ロールバック処理
    public function down()
    {   
        $member_id = [
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
            ]
        ];
        $this->dbforge->add_column('members', $member_id);//ロールバック実行時にmember_idカラムを元に戻す。
        
        $drop_columns = [
            'term',
            'target'
        ];
        $this->dbforge->drop_column('members', $drop_columns);
    }

}
