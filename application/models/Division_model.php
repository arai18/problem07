<?php
class Division_model extends CI_Model{
    
    /**
     * position_idから部署名を取得する
     */
    public function findById($id)
    {
        $query = 'select * from divisions where id = ?';
        return $this->db->query($query, $id)->row();
    }
}
