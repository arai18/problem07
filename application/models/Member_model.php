<?php
class Member_model extends CI_Model{
    public function findAll() {
        $query = $this->db->query('select * from members order by id desc');
        return $query->result();
    }
    
    public function create(array $data) {
        $this->db->insert('members', $data);
    }
}