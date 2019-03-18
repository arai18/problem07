<?php
    class Target_model extends CI_Model {
    
        /**
         * データベース登録
         * @param array $data
         */
        public function create(array $data, $member_id)//targetの内容をdbへ書き込む
        {
            $query = 'insert into targets(member_id, year, term, target) values(?, ?, ?, ?)';
            $this->db->query($query,[$member_id, $data['year'], $data['term'], $data['target']]);                    
        }
        
        /**
         * $member_idにヒットするユーザ情報を全て取得する。
         * @param type $member_id
         * @return type
         */
        public function findById($member_id)//member_idで該当するもの全てを取得して、yearカラムの降順且つtermカラムの昇順で並び替える。
        {
            $query = 'select * from targets where member_id = ? order by year desc, term asc';
            return $this->db->query($query, $member_id)->result();
        }
        
        /**
         * 重複無しのyearを取得する
         */
        public function distinctYear($id)
        {
            $query = 'select distinct year from targets where member_id = ? order by year desc';//重複しないyearを昇順で取得する
            return $this->db->query($query, $id)->result();
        }

        /**
         * $member_id、$year、$termで検索しtargetを取得する。
         */
        public function findByTarget($member_id, $year, $term)//該当のtargetを取得する。
        {
            $query = 'select * from targets where member_id = ? and year = ? and term = ?';
            return $this->db->query($query, [$member_id, $year, $term])->row();
        }
        
        /**
         * member_idとyearで検索し該当targetを取得する。
         */
        public function findByIdAndYear($member_id, $year)
        {
            $query = 'select * from targets where member_id = ? and year = ?';
            return $this->db->query($query, [$member_id, $year])->result();
        }
        

        /**
         * dbデータの上書き処理
         */
        public function update($updateTarget, $findTarget)//該当のtargetを更新する。
        {
            $query = 'update targets set year = ?, term = ?, target = ? where member_id = ?and year = ?and term = ?';
            $this->db->query($query, [$updateTarget['year'], $updateTarget['term'], $updateTarget['target'], $findTarget['member_id'], $findTarget['year'], $findTarget['term']]);
        }

        /**
         * 指定$member_idの目標を削除する
         */
        public function destroy($member_id, $year, $term)//該当のtargetを削除する。
        {
            $query = 'delete from targets where member_id = ? and year = ? and term = ?';
            $this->db->query($query, [$member_id, $year, $term]);
        }
      
    }