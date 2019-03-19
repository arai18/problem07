<?php
class Member_model extends CI_Model{
    
    /**
     * genderのインスタンス変数を定義
     */
    public $gender_mail = 1;
    public $gender_femail = 2;


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
        $query = 'insert into members(first_name, last_name, first_name_kana, last_name_kana, gender, birthday, address, entering_company_date, retirement_date, division_id, position, email, emergency_contact_address) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
        $this->db->query($query, [//$queryのクエリ文の変数に値を挿入する。（プリペアドステートメント）
            $data['first_name'], //パスワード以外の情報をdbへ登録する。
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
            $data['emergency_contact_address']
            ]);
        $memberCreated = 'select created from members where email = ?';//email検索し、createdを取得する
        $created = $this->db->query($memberCreated, $data['email'])->row();
        $insertPassword = 'update members set password = ? where email = ?';
        $this->db->query($insertPassword, [$this->utility->getHash($data['password'], $created->created), $data['email']]);
    }
     
    /**
     * idにヒットする情報を取得する
     * @param type $id
     * @return type
     */
    public function findById($id) //整数値のみ受け付けるように処理するよう変更をする。
    {
        $query = 'select * from members where id = ?';
        return $this->db->query($query, $id)->row();//dbよりmembersテーブルからidが一致するものを返す
    }
    
    /**
     * emailによりmemberデータを取得する
     */
    public function findByEmail(string $email)
    {
        $query = 'select * from members where email = ?';
        return $this->db->query($query, $email)->row();
    }
    
    /**
     * emailによりmemberデータを取得する
     */
    public function findByPostEmail(string $email)
    {
        $query = 'select email from members where email = ?';
        return $this->db->query($query, $email)->result();
    }

    /**
     * $data(上書きする値)とidでdbを上書きする
     * @param type $data
     * @param type $userId
     */
    public function update($data, $member_id) 
    {
        $query = 'update members set first_name = ?, last_name = ?, first_name_kana = ?, last_name_kana = ?, gender = ?, birthday = ?, address = ?, entering_company_date = ?, retirement_date = ?, division_id = ?, position = ?, email = ?, emergency_contact_address = ?  where id = ?';
        $this->db->query($query, [
            $data['first_name'], //パスワード以外の情報をdbへ登録する。
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
            $data['emergency_contact_address'],
            $member_id
            ]);//idを検索して該当情報を取得し、更新処理する。
    }
    
    /**
     * passwordのupdate処理
     */
    public function updatePassword($password, $member_id)
    {
        $query = 'update members set password = ? where id = ?';
        $getMember = $this->Member_model->findById($member_id);
        $this->db->query($query, [$this->utility->getHash($password, $getMember->created), $member_id]);
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