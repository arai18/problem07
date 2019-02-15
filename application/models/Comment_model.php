<?php
class Comment_model extends CI_Model{
    
    public function __construct() {
            parent::__construct(); 
        }
    
    public function findAll() {
        $this->load->model('comment_model');
        $this->comment_model->findAll();
    }
}

