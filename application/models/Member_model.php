<?php
class Member_model extends CI_Model{
    public function getMember() {
        $q = $this->db->query('select * from members order by id desc');
        return $q->result();
    }
    
    public function create_member($data) {
        $this->db->insert('members', $data);
    }
}