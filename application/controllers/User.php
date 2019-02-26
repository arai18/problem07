<?php
    class User extends CI_Controller {
        
        /**
         * Userの新規登録とバリデーション処理
         */
        public function add() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|is_unique[users.email]');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('name', '氏名', 'required');
           
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('user/registration');//バリデーションに引っかかった場合にviewを返す
            } else {
                $user = [
                    'email' => $this->input->post('email'),//usersテーブルに新規登録する情報
                    'password' => $this->input->post('password'),
                    'name' => $this->input->post('name')
                ];
                $this->user_model->create($user);//データベースへinsertする
                $this->session->set_userdata('login', true);//sessionを持たせる。
                $data['csrf_token_name'] = $this->security->get_csrf_token_name();
                $data['csrf_token_hash'] = $this->security->get_csrf_hash();
                redirect('member/index', $data); 
                
            }
        }
        
        
        public function login() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                redirect('user/login');//バリデーションに引っかかった場合にredirectを返す。
            } else {
                $data['email'] = $this->input->post('email');//ログインフォームへ入力したemail
                $data['password'] = sha1($this->input->post('password'));//ログインフォームへ入力したpassword
                
                $cheakUser = $this->user_model->cheakUser($data);//データベースから該当するemailとpasswordを検索し、発見時の返り値を$cheakUserに代入する
            }
        }
        
        public function logout()
        {
            $this->session->unset_userdata('login');
            redirect('user/login');
        }
    }
       