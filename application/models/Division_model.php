<?php
class Division_model extends CI_Model{
    
    /**
     * 全ての部署名を取得する
     */
    public function findAll()
    {
        $query = 'select * from divisions';
        return $this->db->query($query)->result();
    }        

    /**
     * division_idから部署名を取得する
     */
    public function findById($id)
    {
        $query = 'select * from divisions where id = ?';
        return $this->db->query($query, $id)->row();
    }
    
    /**
     * nameから部署名を取得する
     */
    public function findByName($name)
    {
        $query = 'select * from divisions where division_name = ?';
        return $this->db->query($query, $name)->result();
    }

    /**
     * dbへの登録
     */
    public function create($name)
    {
        $query = 'insert into divisions(division_name) values(?)';
        $this->db->query($query, $name);
    }
    
    /**
     * 部署名の更新
     */
    public function update($division, $id)
    {
        $query = 'update divisions set division_name = ? where id = ?';
        $this->db->query($query, [$division['name'], $id]);
    }
    
    /**
    * 部署名の削除
    */
    public function destroy($id)
    {
        $query = 'delete from divisions where id = ?';
        $this->db->query($query, $id);
    }
}
