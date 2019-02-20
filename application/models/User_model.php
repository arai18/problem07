<?php
    class User_model extends CI_Model {
        
        /**
         * データベースへの新規登録
         * @param array $data
         */
        public function create(array $data) 
        {
            $query = 'insert into users(email, password, name) values(?, ?, ?)';
            $this->db->query($query, [$data['email'], $data['password'], $data['name']]);
        }
    }
