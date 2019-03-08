<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin extends CI_Controller {
        
        /**
         * Userの新規登録とバリデーション処理
         */
        public function add() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|is_unique[admin.email]');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('name', '氏名', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/add');//バリデーションに引っかかった場合にviewを返す
            } else {
                $admin = [
                    'email' => $this->input->post('email'),//usersテーブルに新規登録する情報
                    'password' => $this->input->post('password'),
                    'name' => $this->input->post('name')
                ];
                $this->admin_model->create($admin);//データベースへinsertする
                $getAdmin = $this->admin_model->findByEmail($admin);//emailからadmin_idを検索す
                if (!$this->session->userdata('admin_id')) {//session['admin']にデータがないことを確認する
                    $this->session->set_userdata('admin_id', $getAdmin->id);//sessionにadmin_idを持たせる
                    redirect('member/index');//redirectメソッドでmember/indexへリダイレクトさせる。
                } else {//sessionデータがある場合は削除して再発行する処理
                    $this->session->unset_userdata('admin_id');
                    $this->session->set_userdata('admin_id', $getAdmin->id);//sessionにmember.idを持たせる      
                    redirect('member/index');//redirectメソッドでtarget/indexへリダイレクトさせる。
                }  
            }
        }
        
        /**
         * Userのログイン処理
         */
        public function login() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('admin/login');//バリデーションに引っかかった場合にviewを返す。
            } else {
                $login = [
                    'email' => $this->input->post('email'),//ログインフォームへ入力したemail
                    'password' => $this->input->post('password')//ログインフォームへ入力したpassword
                ];                
                $getAdmin = $this->admin_model->findByEmail($login);//passwordが合致するuserデータをdbから取得する。
                if ($getAdmin->password === sha1($login['password'] . $getAdmin->created)) {//user.passwordを比較する
                    $this->session->set_userdata('admin_id', $getAdmin->id);//userがある場合はsessionをセットしてmember/indexへリダイレクト
                    redirect('member/index');
                } else {
                    redirect('admin/login');//userがない場合はuser/loginへリダイレクト
                }   
            }          
        }
        
        /**
         * logout処理
         */
        public function logout()
        {
            $this->session->unset_userdata('admin_id');//sessionを削除する
            redirect('admin/login');//loginページへリダイレクト
        }
    }
       