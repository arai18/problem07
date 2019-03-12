<?php
class Position_model extends CI_Model{
    
    /**
     * division_idから部署名を取得する
     */
    public function findById($id)
    {
        $query = 'select * from positions where id = ?';
        return $this->db->query($query, $id)->row();
    }
}
