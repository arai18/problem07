<?php
    class User_model extends CI_Model {
        
        /**
         * データベースへの新規登録
         * @param array $data
         */
        public function create(array $data)
        {
            $query = 'insert into users(email, name) values(?, ?)';//password以外をinsert
            $this->db->query($query, [$data['email'], $data['name']]);
            $usersCreated = 'select created from users where email = ?';//ユニークなemailからcreatedを検索して取得する。
            $created = $this->db->query($usersCreated, $data['email'])->row();
            
            $insertPassword = 'update users set password = ? where email = ?';//ハッシュ化したpasswordをupdateで挿入する。
            $this->db->query($insertPassword, [sha1($data['password'] . $created->created), $data['email']]);   
        }
        
        /**
         * ログインデータをdbデータと比較する
         * @param array $data
         * @return type
         */
        public function cheakUser(array $data)
        {
            $selectQuery = 'select created from users where email = ?';//emailで検索してcreatedを取得する。
            $matchUserEmail = $this->db->query($selectQuery, $data['email'])->row();
            $query = 'select * from users where password = ?';//passwordが一致するuserを取得する。
            return $this->db->query($query, sha1($data['password'] . $matchUserEmail->created))->row();
        }
    
    }
