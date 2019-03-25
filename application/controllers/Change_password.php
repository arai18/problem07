<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Change_password extends CI_Controller {
    
        /**
         * コンストラクタ処理
         */
        public function __construct() {
            parent::__construct();
            if (!$this->session->userdata('email')) {
                redirect('login/admin');
            }
        }
        
        /**
         * adminパスワード再設定
         */
        public function admin()
        {
            $token = $this->input->get('token');//getパラメータのtokenを取得する
            if (!$token) {//トークンの有無をチェックする
                $this->session->set_userdata('flash_message', '制限時間が終了しました。再度、メールアドレスを送信してください。');//第三者にバレないようにするためにメッセージ工夫する必要がある？？
                redirect('login/admin');
            } 
            $email = $this->session->userdata('email');//sessionのemailで検索する
            $admin = $this->Admin_model->findByEmail($email);//adminを取得
            $after30MinuteTime = date("Y-m-d H:i:s",strtotime($admin->create_token_time . "+30 minute"));//30分後の時間を作成
            if ($admin->token === $token && $admin->create_token_time <= $after30MinuteTime) {//比較する
                $this->session->set_userdata('flash_message', '新しいパスワードを設定してください');
                redirect('change_password/reset_admin');
            } else {
                $this->session->set_userdata('flash_message', '制限時間が終了しました。再度、メールアドレスを送信してください。');
                redirect('login/admin');
            }
        }
        
        /**
         * memberパスワード再設定
         */
        public function member()
        {
            $token = $this->input->get('token');//getパラメータのtokenを取得する
            if (!$token) {//トークンの有無をチェックする
                $this->session->set_userdata('flash_message', '制限時間が終了しました。再度、メールアドレスを送信してください。');//第三者にバレないようにするためにメッセージ工夫する必要がある？？
                redirect('login/member');
            } 
            $email = $this->session->userdata('email');//sessionのemailで検索する
            $member = $this->Member_model->findByEmail($email);//adminを取得
            $after30MinuteTime = date("Y-m-d H:i:s",strtotime($member->create_token_time . "+30 minute"));//保存後30分後の時間を計測する
            if ($member->token === $token && $member->create_token_time <= $after30MinuteTime) {//比較する
                $this->session->set_userdata('flash_message', '新しいパスワードを設定してください');
                redirect('change_password/reset_member');
            } else {
                $this->session->set_userdata('flash_message', '制限時間が終了しました。再度、メールアドレスを送信してください。');
                redirect('login/member');
            }
        }

        /**
         * リセット処理(admin)
         */
        public function reset_admin()
        {
            $this->form_validation->set_rules('password', '新しいパスワード', 'required');
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('change_password/reset_admin');
            } else {
                $password = $this->input->post('password');//passwordを受け取る
                $email = $this->session->userdata('email');//emaiをsessionで受け取る
                $admin = $this->Admin_model->findByEmail($email);//emailでadminを検索する
                $this->Admin_model->updatePassword($password, $admin->id);//パスワードを上書きする
                $this->session->set_flashdata('flash_message', '新しいパスワードが登録されました。ログインページからログインできます。');
                redirect('login/admin');//新しいパスワードでloginを促す
            }
        }
        
        /**
         * リセット処理(member)
         */
        public function reset_member()
        {
            $this->form_validation->set_rules('password', '新しいパスワード', 'required');
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('change_password/reset_member');
            } else {
                $password = $this->input->post('password');//passwordを受け取る
                $email = $this->session->userdata('email');//emaiをsessionで受け取る
                $member = $this->Admin_model->findByEmail($email);//emailでadminを検索する
                $this->Member_model->updatePassword($password, $member->id);//パスワードを上書きする
                $this->session->set_flashdata('flash_message', '新しいパスワードが登録されました。ログインページからログインできます。');
                redirect('login/member');//新しいパスワードでloginを促す
            }
        }
    }
