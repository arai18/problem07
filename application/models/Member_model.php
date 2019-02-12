<?php
class Member_model extends CI_Model{
    public function getMember() {
        $q = $this->db->query('select * from members order by id desc');
        return $q->result();
    }
}