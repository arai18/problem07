<?php
    class Migration_Drop_target_columns_to_targets extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    public function up()
    {   
        $this->dbforge->drop_column('targets', 'target_text_1');//target_text_1を削除する。
        $this->dbforge->drop_column('targets', 'target_text_2');//target_text_2を削除する。
        $this->dbforge->drop_column('targets', 'target_text_3');//target_text_3を削除する。
        $this->dbforge->drop_column('targets', 'target_text_4');//target_text_4を削除する。
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
        $this->dbforge->add_column('targets', $member_id);//ロールバック実行時にmember_idカラムを元に戻す。
    }

}
