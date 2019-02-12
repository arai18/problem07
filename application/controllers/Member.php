<?php
    class Member extends CI_Controller {
        public function index() {
            $this->load->model('member_model');
            $data['members'] = $this->member_model->getMember();
            
            $this->load->view('index', $data);
           
        }
    }
