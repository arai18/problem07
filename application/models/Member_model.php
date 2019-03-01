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
        $query = 'insert into members(first_name, last_name, first_name_kana, last_name_kana, gender, birthday, address, entering_company_date, retirement_date, division_id, position, email, password, emergency_contact_address) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
        $this->db->query($query, [//$queryのクエリ文の変数に値を挿入する。（プリペアドステートメント）
            $data['first_name'], 
            $data['last_name'], 
            $data['first_name_kana'], 
            $data['last_name_kana'],
            $data['gender'], 
            $data['birthday'],
            $data['address'], 
            $data['entering_company_date'],
            $data['retirement_date'], 
            $data['division_id'],
            $data['position'],
            $data['email'],
            $data['password'],
            $data['emergency_contact_address']
            ]);
    }
    
    
    /**
     * idにヒットする情報を取得する
     * @param type $id
     * @return type
     */
    public function findById($id) 
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
        $query = 'update members set first_name = ?, last_name = ?, age = ?, home = ? where id = ?';
        $this->db->query($query, [$data['first_name'], $data['last_name'], $data['age'], $data['home'], $userId]);//idを検索して該当情報を取得し、更新処理する。
    }
    
    
    /**
     * 該当するidを持つmemberを削除する
     * @param type $id
     */
    public function destroy($id) 
    {
        $query = 'delete from members where id = ?';
        $this->db->query($query, $id);//該当するidを持つmemberを検索し、削除する。
    }
    
    
}