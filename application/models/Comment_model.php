<?php
class Comment_model extends CI_Model{
    
    /**
     * コンストラクタ
     */
    public function __construct() {
            parent::__construct(); 
    }
        
    /**
     * idによる取得
     */
    public function findById($id) 
    {
        $query = 'select * from comments where id = ?';
        return $this->db->query($query, $id)->row();
    }


    /**
     * member_idで取得する
     * @param type $member_id
     */
    public function findByTargetId($id) 
    {
        $query = 'select * from comments where target_id = ?';
        return $this->db->query($query, $id)->result();   
    }
    
    /**
     * member_idによる取得
     */
    public function findByAdminIdAndTargetId($admin_id, $target_id) 
    {
        $query = 'select * from comments where admin_id = ? and target_id = ?';
        return $this->db->query($query, [$admin_id, $target_id])->row();
    }
    
    /**
     * commentを追加する
     */
    public function create(array $data) 
    {
        $query = 'insert into comments(member_id, target_id, year, admin_id, comment) values(?, ?, ?, ?, ?)';
        $this->db->query($query, [
            $data['member_id'],
            $data['target_id'],
            $data['year'],
            $data['admin_id'],
            $data['comment']
            ]);
    }
    
    /**
     * commentを更新する
     */
    public function update(array $data) 
    {
        $query = 'update comments set comment = ? where id = ?';
        $this->db->query($query, [$data['comment'], $data['id']]);
    }
    
    /**
     * commentを削除する
     */
    public function destroy($id)
    {
        $query = 'delete from comments where id = ?';
        $this->db->query($query, $id);
    }
}

