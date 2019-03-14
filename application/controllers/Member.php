<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Member extends CI_Controller {
        
        /**
         * ログインセッションの判定
         */
        public function __construct() 
        {
            parent::__construct();
            if (!$this->session->userdata('member_id')) {//session情報がない場合の処理
                $this->session->unset_userdata('member_id');
                redirect('member/login');
            }
        }
        
        /**
         * viewを表示する処理(社員ページ用)
         */
        private function showView($subView, $subData = '')
        {
            $content = $this->load->view($subView, $subData, true);
            $data['content'] = $content;
            $this->load->view('layout/member/layout', $data);
        }

        /**
         * 更新処理
         * @param type $id
         */
        public function edit()//sessionを用いるため引数にmember_idは含めない
        {
            $this->form_validation->set_rules('first_name', '氏', 'required');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('last_name', '名', 'required');
            $this->form_validation->set_rules('first_name_kana', '氏(カナ)', 'required|regex_match[/^[ァ-ヶー]+$/u]');//全角カナ入力
            $this->form_validation->set_rules('last_name_kana', '名(カナ)', 'required|regex_match[/^[ァ-ヶー]+$/u]');//全角カナ入力
            $this->form_validation->set_rules('gender', '性別', 'required');
            $this->form_validation->set_rules('birthday', '生年月日', 'required|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');
            $this->form_validation->set_rules('address', '住所', 'required');
            $this->form_validation->set_rules('entering_company_date', '入社日', 'required|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');//存在、日付のvalidation。
            $this->form_validation->set_rules('retirement_date', '退職日', 'regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');//日付のvalidation
            $this->form_validation->set_rules('division_id', '部署ID', 'required');
            $this->form_validation->set_rules('position', '役職ID', 'required');
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|callback_email_check');//メールアドレスのvalidation
            $this->form_validation->set_rules('emergency_contact_address', '緊急連絡先電話番号', 'required|regex_match[/^(0{1}\d{9,10})$/]');//ハイフンなしの電話番号で制限するvalidation

            if ($this->form_validation->run() === FALSE) {
                $member_id = $this->session->userdata('member_id');
                $data['member'] = $this->Member_model->findById($member_id);//member_idがsessionと同じmemberデータを取得する。
                $this->showView('member/edit', $data);//$dataでlayoutに渡し、表示させる。
            } else {
                $updatedMember = [//上書きするデータの配列を作成
                    'first_name' => $this->input->post('first_name'),//first_nameの値受け取り
                    'last_name' => $this->input->post('last_name'),//last_nameの値受け取り
                    'first_name_kana' => $this->input->post('first_name_kana'),//first_name_kanaの値受け取り
                    'last_name_kana' => $this->input->post('last_name_kana'),//last_name_kanaの値受け取り
                    'gender' => $this->input->post('gender'),//genderの値受け取り
                    'birthday' => $this->input->post('birthday'),//birthdayの値受け取り
                    'address' => $this->input->post('address'),//addressの値受け取り
                    'entering_company_date' => $this->input->post('entering_company_date'),//entering_company_dateの値受け取り
                    'retirement_date' => $this->input->post('retirement_date'),//retirement_dateの値受け取り
                    'division_id' => $this->input->post('division_id'),//division_idの値受け取り
                    'position' => $this->input->post('position'),//positionの値受け取り
                    'email' => $this->input->post('email'),//emailの値受け取る
                    'emergency_contact_address' => $this->input->post('emergency_contact_address')//emergency_contact_addressの値受け取り
                ];
                $member_id = $this->session->userdata('member_id');
                $this->Member_model->update($updatedMember, $member_id);//member_modelのupdateメソッドで$updateMemberと$userIdを用いデータベースを上書きする。
                redirect('target/index');//redirectrメソッドでindexページへリダイレクト
            }
        }
        
        /**
         * passwordの更新処理
         */
        public function edit_password()
        {
            $this->form_validation->set_rules('old_password', '現在のパスワード', 'required|callback_old_password_check');//現在のパスワードが一致しているか確認する。
            $this->form_validation->set_rules('new_password', '新しいパスワード', 'required|callback_new_password_check');//現在のパスワードと新規のパスワードが一致していないか確認する。

            if ($this->form_validation->run() === FALSE) {
                $this->showView('member/edit_password');//パスワード変更リンクも表示される。                    
            } else {
                $member_id = $this->session->userdata('member_id');
                $updatedPassword = $this->input->post('new_password');//新規パスワードをpostで受け取る
                $this->Member_model->updatePassword($updatedPassword, $member_id);//dbへ新規パスワードをupdateする
                redirect("target/index");//target/indexにリダイレクトする
            }
        }
        
        /**
         * memberのログアウト機能
         */
        public function logout()
        {
            $this->session->unset_userdata('member_id');//sessionを削除する
            redirect('member/login');//loginページへリダイレクト
        }
        
        /**
         * callback処理
         * emailのvalidation設定
         */
        public function email_check($email)
        {
            $id = $this->session->userdata('member_id');//sessionからmember_idを取得して変数$idに代入
            $memberBySession = $this->Member_model->findById($id);//$idを用いてpost前のemailを取得する。(row();)
            $checkedEmailCount = $this->Member_model->findByPostEmail($email);//$emailを用いてpost時のemailからdb内に同じemailが1以上あるかを調べる。(resutl();→全フィールドから該当のものを取得できる)
            //post前のemailとpost時のemailを比較 && $checkedEmailCountの返り値が1つの場合(post前のemailのみ) || post前とpost時のemailが異なる && $checkedEmailCountの返り値が空の場合(DBに重複emailがない)
            if ($memberBySession->email === $email && count($checkedEmailCount) === 1 || $memberBySession->email !== $email && empty($checkedEmailCount)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * old_passwordのvalidation設定
         */
        public function old_password_check($password)
        {
            $id = $this->session->userdata('member_id');//sessionからmember_idを取得する
            $memberBySession = $this->Member_model->findById($id);//$idからmemberデータを取得する
            $hashedOldPassword = $this->utility->getHash($password, $memberBySession->created);//post時のpasswordでハッシュ化
            if ($hashedOldPassword === $memberBySession->password) {//post前とpost時のpasswordを比較する
                return TRUE;
            } else {
                return FALSE;
            }
        }

        /**
         * new_passwordのvalidation設定
         */
        public function new_password_check($password)
        {
            $id = $this->session->userdata('member_id');//sessionからmember_idを取得する
            $memberBySession = $this->Member_model->findById($id);//$idからmemberデータを取得する
            $hashedNewPassword = $this->utility->getHash($password, $memberBySession->created);//post時のpasswordでハッシュ化
            if ($hashedNewPassword !== $memberBySession->password) {//post前とpost時のpasswordを比較する
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }