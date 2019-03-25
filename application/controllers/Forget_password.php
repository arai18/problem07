<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Forget_password extends CI_Controller {
    
        /**
         * コンストラクタ処理
         */
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * メールアドレス入力画面(admin)
         */
        public function admin_send_email()
        {
            $this->form_validation->set_rules('email', '登録いただいたメールアドレス', 'required|valid_email|callback_admin_email_exist_check');
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('valid_email', '【{field}】の入力形式が違います');
            $this->form_validation->set_message('admin_email_exist_check', 'こちらのメールアドレスは登録されていません');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('change_password/admin_send_email');
            } else {
                $email = $this->input->post('email');
                //emailからトークンを発行
                $admin = $this->Admin_model->findByEmail($email);
                if (!$admin) {//row()による取得のためエラー処理
                    $this->session->sess_destroy();
                    redirect('logout/admin');
                }
                $this->Admin_model->createToken($admin->id);//トークンを発行→dbのパスワードを変更
                $updatedAdmin = $this->Admin_model->findById($admin->id);//トークンを取得する
                
                //メールアドレスを送る処理
                mb_language('japanese');
                mb_internal_encoding('UTF-8');
                $to = $email;
                $title = '社員管理システムパスワード再設定のお知らせ';
                $message = "下記URLをクリックしパスワードを変更してください。\n"//メールメッセージ内容
                        . "http://local.problem07.com/change_password/admin?token={$updatedAdmin->token}";
                if(mb_send_mail($to, $title, $message)){//メール送信の判定
                    $this->session->set_flashdata('flash_message', 'メールが送信されました');
                    $this->session->set_userdata('email', $email);//新しいパスワードを設定する際に使用する
                    redirect('login/admin');
                }else{
                    $this->session->set_flashdata('flash_message', 'メールが送信されました');//第三者にわからないようにするため上記と同じメッセージを表示
                    redirect('login/admin');
                }
            }
        }
        
        /**
         * メールアドレス入力画面(member)
         */
        public function member_send_email()
        {
            $this->form_validation->set_rules('email', '登録いただいたメールアドレス', 'required|valid_email|callback_member_email_exist_check');
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('valid_email', '【{field}】の入力形式が違います');
            $this->form_validation->set_message('member_email_exist_check', 'こちらのメールアドレスは登録されていません。再度、ご確認いただき入力してください。');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('forget_password/member_send_email');
            } else {
                $email = $this->input->post('email');
                $member = $this->Member_model->findByEmail($email);
                if (!$member) {
                    $this->session->sess_destroy();
                    redirect('logout/member');
                }
                $this->Member_model->createToken($member->id);//トークンを発行→dbのパスワードを変更
                $updatedMember = $this->Member_model->findById($member->id);//トークンを取得する
                
                //メールアドレスを送る処理
                mb_language('japanese');
                mb_internal_encoding('UTF-8');
                $to = $email;
                $title = '社員管理システムパスワード再設定のお知らせ';
                $message = "下記URLをクリックしパスワードを変更してください。\n" 
                        . "http://local.problem07.com/change_password/member?token={$updatedMember->token}";
                if(mb_send_mail($to, $title, $message)){
                    $this->session->set_flashdata('flash_message', 'メールが送信されました');
                    $this->session->set_userdata('email', $email);
                    redirect('login/member');
                }else{
                    $this->session->set_flashdata('flash_message', 'メールが送信されました');//第三者にわからないようにするため上記と同じメッセージを表示
                    redirect('login/member');
                }
            }
        }
        
        /**
         * コールバック処理
         * emailがdbに存在するかチェックする(admin)
         */
        public function admin_email_exist_check($email)
        {
            $admin = $this->Admin_model->findByEmail($email);//row()で取得するが、エラー処理は必要なし
            if (!$admin) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
        
        /**
         * emailがdbに存在するかチェックする(member)
         */
        public function member_email_exist_check($email) 
        {
            $member = $this->Member_model->findByEmail($email);
            if (!$member) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
