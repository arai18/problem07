<?php
class Member_model extends CI_Model{
    public function findAll() {
        $query = $this->db->query('select * from members order by id desc');
        return $query->result();
    }
    
    public function create(array $data) {
        $this->db->insert('members', $data);
    }
    
    public function findById($id) {
        return $this->db->get_where('members', array('id' => $id))->result_array();
    }
    
    public function update($data, $userId) {
        $this->db->where('id', $userId);
        $this->db->update('members', $data);
    }
    
    
}