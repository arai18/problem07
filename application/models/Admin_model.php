<?php
    class Admin_model extends CI_Model {
        
        /**
         * データベースへの新規登録
         * @param array $data
         */
        public function create(array $data)
        {
            $query = 'insert into admin(email, name) values(?, ?)';//password以外をinsert
            $this->db->query($query, [$data['email'], $data['name']]);
            $selectQuery = 'select * from admin where email = ?';//ユニークなemailからcreatedを検索して取得する。
            $getAdmin = $this->db->query($selectQuery, $data['email'])->row();
            $insertPassword = 'update admin set password = ? where email = ?';//ハッシュ化したpasswordをupdateで挿入する。
            $this->db->query($insertPassword, [$this->utility->getHash($data['password'], $getAdmin->created), $data['email']]);   
        }
        
        /**
         * 全てを取得する
         */
        public function findAll() 
        {
            $query = 'select * from admin';
            return $this->db->query($query)->result();
        }
        
        /**
         * idからadmin情報を取得する
         */
        public function findById(int $id)
        {
            $query = 'select * from admin where id = ?';
            return $this->db->query($query, $id)->row();
        }
        
        /**
         * emailで検索しresult()で取得する
         */
        public function findResultByEmail($email)
        {
            $query = 'select * from admin where email = ?';
            return $this->db->query($query, $email)->result();
        }
        
        /**
         * emailによってadminデータを取得する
         */
        public function findByEmail($email)
        {
            $query = 'select * from admin where email = ?';
            return $this->db->query($query, $email)->row();
        }

        /**
         * 更新処理
         */
        public function update(array $data, int $id)
        {
            $query = 'update admin set email = ?, name = ? where id = ?';
            $this->db->query($query, [$data['email'], $data['name'], $id]);
        }
        
        /**
         * パスワード更新処理
         */
        public function updatePassword(string $password, int $id)
        {
            $query = 'update admin set password = ? where id = ?';
            $admin = $this->Admin_model->findById($id);//idでadminを取得
            $this->db->query($query, [$this->utility->getHash($password, $admin->created), $id]);
        }
        
        /**
         * トークン発行処理
         */
        public function createToken($id)
        {
            $query = 'update admin set token = ?, create_token_time = now() where id = ?';
            return $this->db->query($query, [sha1(time()), $id]);
        }
    }