<?php
    class User extends CI_Controller {
        public function add() {
            $this->load->view('login');
        }
        
        public function create() {
            $this->load->model('user_model');
            
            $user = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'name' => $this->input->post('name')
            );
          
            
            $this->user_model->create($user);
            redirect('member/index');
        }
    }