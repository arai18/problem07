<?php
class Member_model extends CI_Model{
    public function findAll() {//全てのmemberを取得する
        $query = $this->db->query('select * from members order by id desc');//降順で全てのmemberを取得する
        return $query->result();//結果をオブジェクトデータの配列で返す
    }
    
    public function create(array $data) {//$data(新規)でdbに書き込む
        $this->db->insert('members', $data);//membersテーブルに$dataの値を新規で追加する
    }
    
    public function findById($id) {//idにヒットする情報を取得する
        return $this->db->get_where('members', array('id' => $id))->result_array();//dbよりmembersテーブルからidが一致するものを連想配列で返す
    }
    
    public function update($data, $userId) {//$data(上書きする値)とidでdbを上書きする
        $this->db->where('id', $userId);//idを検索して該当情報を取得する
        $this->db->update('members', $data);//membersテーブルの上記ID該当情報を上書きする
    }
    
    
    public function destroy($id) {//該当するidを持つmemberを削除する
        $this->db->where('id', $id);//該当するidを持つmemberを検索する
        $this->db->delete('members');//membersテーブル内で上記IDのmemberを削除する
    }
    
    
}