<?php
    class Position_model extends CI_Model{

        /**
         * 全てのpositionデータを取得する
         */
        public function findAll()
        {
            $query = 'select * from positions';
            return $this->db->query($query)->result();
        }

        /**
         * position_idから役職名を取得する
         */
        public function findById($id)
        {
            $query = 'select * from positions where id = ?';
            return $this->db->query($query, $id)->row();
        }

        /**
         * nameから役職名を取得する
         */
        public function findByName($name)
        {
            $query = 'select * from positions where position_name = ?';
            return $this->db->query($query, $name)->result();
        }

        /**
         * dbへの登録
         */
        public function create($name)
        {
            $query = 'insert into positions(position_name) values(?)';
            $this->db->query($query, $name);
        }

        /**
         * 役職名の更新
         */
        public function update($position, $id)
        {
            $query = 'update positions set position_name = ? where id = ?';
            $this->db->query($query, [$position['name'], $id]);
        }
        
        /**
         * 役職名の削除
         */
        public function destroy($id)
        {
            $query = 'delete from positions where id = ?';
            $this->db->query($query, $id);
        }
    }

