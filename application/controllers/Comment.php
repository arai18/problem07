<?php
class Comment extends CI_Controller {
    public function index() {
        $this->load->model('comment_model');
        $this->comment_model->findAll();
    }
    
    
}

