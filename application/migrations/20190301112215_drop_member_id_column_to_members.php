<?php
    class Migration_Drop_member_id_column_to_members extends CI_Migration {

    public function __construct()
    {   
        parent::__construct();
    }

    // アップデート処理
    public function up()
    {   
        $this->dbforge->drop_column('members', 'member_id');//member_idを削除する。
    }   

    // ロールバック処理
    public function down()
    {   
        $member_id = [
            'member_id' => [
                'type' => 'INT',
                'unsigned' => TRUE
            ]
        ];
        $this->dbforge->add_column('members', $member_id);//ロールバック実行時にmember_idカラムを元に戻す。
    }

}
