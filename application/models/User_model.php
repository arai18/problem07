<?php
    class User_model extends CI_Model {
        public function create(array $data) 
        {
            $this->db->insert('users', $data);
        }
    }
