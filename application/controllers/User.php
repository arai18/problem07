<?php
    class User extends CI_Controller {
        
        /**
         * Userの新規登録とバリデーション処理
         */
        public function add() 
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'メールアドレス', 'required');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('name', '氏名', 'required');
           
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('user/registration');
            } else {
                $this->load->model('user_model');//モデルの読み込み
                
                $user = [
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'name' => $this->input->post('name')
                ];
                
                $this->user_model->create($user);
                
                $_SESSION['login'] = true;
                header('location: ../member/index');
            }
            
        }
    }
       