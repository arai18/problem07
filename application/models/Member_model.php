<?php
class Member_model extends CI_Model{
    
    /**
     * 全てのmemberを取得する
     * @return type
     */
    public function findAll()
    {
        $query = $this->db->query('select * from members order by id desc');//降順で全てのmemberを取得する
        return $query->result();//結果をオブジェクトデータの配列で返す
    }
    
    
    /**
     * $data(新規)でdbに書き込む
     * @param array $data
     */
    public function create(array $data)
    {
        $query = 'insert into members(first_name, last_name, age, home) values(?, ?, ?, ?);';
        $this->db->query($query, [$data['first_name'], $data['last_name'], $data['age'], $data['home']]);//$queryのクエリ文の変数に値を挿入する。（プリペアドステートメント）
    }
    
    
    /**
     * idにヒットする情報を取得する
     * @param type $id
     * @return type
     */
    public function findById(int $id) 
    {
        $query = 'select * from members where id = ?';
        return $this->db->query($query, $id)->row();//dbよりmembersテーブルからidが一致するものを返す
    }
    
    
    /**
     * $data(上書きする値)とidでdbを上書きする
     * @param type $data
     * @param type $userId
     */
    public function update($data, $userId) 
    {
        $this->db->where('id', $userId);//idを検索して該当情報を取得する
        $this->db->update('members', $data);//membersテーブルの上記ID該当情報を上書きする
    }
    
    
    /**
     * 該当するidを持つmemberを削除する
     * @param type $id
     */
    public function destroy($id) 
    {
        $query = 'delete ';
        $this->db->where('id', $id);//該当するidを持つmemberを検索する
        $this->db->delete('members');//membersテーブル内で上記IDのmemberを削除する
    }
    
    
}