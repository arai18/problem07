<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Login extends CI_Controller {
    
        /**
         * admin用のログイン処理
         */
        public function admin() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|regex_match[/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/]');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            //バリデーションメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('regex_match', '【{field}】の入力形式が違います');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('login/admin');//バリデーションに引っかかった場合にviewを返す。
            } else {
                $login = [
                    'email' => $this->input->post('email'),//ログインフォームへ入力したemail
                    'password' => $this->input->post('password')//ログインフォームへ入力したpassword
                ];                
                $admin = $this->Admin_model->findByEmail($login['email']);//passwordが合致するuserデータをdbから取得する。
                if ($admin->password === $this->utility->getHash($login['password'], $admin->created)) {//user.passwordを比較する
                    $this->session->set_userdata('admin_id', $admin->id);//userがある場合はsessionをセットしてmember/indexへリダイレクト
                    $this->session->set_flashdata('flash_message', 'ログインに成功しました');//ログイン成功時のflashdataを設定
                    redirect('admin/member_index');
                } else {
                    $this->session->set_flashdata('flash_message', 'メールアドレスまたはパスワードが一致しません');
                    redirect('login/admin');//userがない場合はuser/loginへリダイレクト
                }   
            }          
        }
        
        /**
         * 社員用のログイン処理
         */
        public function member()
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|regex_match[/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/]');
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            $this->form_validation->set_message('required', '【{field}】が未入力です');//バリデーションメッセージを設定
            $this->form_validation->set_message('regex_match', '【{field}】の入力形式が違います');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('login/member');
            } else {
                $login = [
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password')
                ];
                $member = $this->Member_model->findByEmail($login['email']);//emailでmember情報を取得する。
                if ($member->password === $this->utility->getHash($login['password'], $member->created)) {
                    $this->session->set_userdata('member_id', $member->id);//sessionを持たせる
                    $this->session->set_flashdata('flash_message', 'ログインに成功しました');
                    redirect('target/index');//各ユーザのindexページへリダイレクトする。
                } else {
                    $this->session->set_flashdata('flash_message', 'メールアドレスまたはパスワードが一致しません');
                    redirect('login/member');//パスワードが合わなかった際はログインページへ飛ばす。
                }
            }
        }
        
    }

