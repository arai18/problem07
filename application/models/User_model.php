<?php
    class User_model extends CI_Model {
        
        /**
         * データベースへの新規登録
         * @param array $data
         */
        public function create(array $data) 
        {
            $created = 'select created from members where email = ?';
            $salt = $this->db->query($created, $data['email']);
            $query = 'insert into users(email, password, name) values(?, ?, ?)';
            $this->db->query($query, [$data['email'], sha1($data['password'] . $salt), $data['name']]);
            $this->db->query($query, [$data['email'], $data['password'], $data['name']]);
        }
        
        public function cheakUser(array $data)
        {
            $query = 'select * from users where email = ?and password = ?';
            return $this->db->query($query, [$data['email'], $data['password']]);
        }
    
    }
