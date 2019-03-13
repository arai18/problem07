<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Login extends CI_Controller {
    
        /**
         * admin用のログイン処理
         */
        public function admin() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('login/admin');//バリデーションに引っかかった場合にviewを返す。
            } else {
                $login = [
                    'email' => $this->input->post('email'),//ログインフォームへ入力したemail
                    'password' => $this->input->post('password')//ログインフォームへ入力したpassword
                ];                
                $admin = $this->Admin_model->findByEmail($login['email']);//passwordが合致するuserデータをdbから取得する。
                if ($admin->password === sha1($login['password'] . $admin->created)) {//user.passwordを比較する
                    $this->session->set_userdata('admin_id', $admin->id);//userがある場合はsessionをセットしてmember/indexへリダイレクト
                    redirect('admin/member_index');
                } else {
                    redirect('login/admin');//userがない場合はuser/loginへリダイレクト
                }   
            }          
        }
        
        /**
         * 社員用のログイン処理
         */
        public function member()
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required');
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('login/member');
            } else {
                $data['email'] = $this->input->post('email');
                $data['password'] = $this->input->post('password');
                $member = $this->Member_model->findByEmail($data['email']);//emailでmember情報を取得する。
                if ($member->password === sha1($data['password'] . $member->created)) {
                    $this->session->set_userdata('member_id', $member->id);//sessionを持たせる
                    redirect('target/index');//各ユーザのindexページへリダイレクトする。
                } else {
                    redirect('login/member');//パスワードが合わなかった際はログインページへ飛ばす。
                }
            }
        }
        
    }

