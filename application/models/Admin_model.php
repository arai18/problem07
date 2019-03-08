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
            $this->db->query($insertPassword, [sha1($data['password'] . $getAdmin->created), $data['email']]);   
        }
        
        /**
         * emailによってadminデータを取得する
         */
        public function findByEmail(array $data)
        {
            $query = 'select * from admin where email = ?';
            return $this->db->query($query, $data['email'])->row();
        }

        
    
    }
