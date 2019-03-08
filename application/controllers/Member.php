<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Member extends CI_Controller {
        
        /**
         * ログインセッションの判定
         */
        public function __construct() 
        {
            parent::__construct();
            
        }
        
        /**
         * 引数に整数のみ受け付ける条件
         */
        private function argumentCheck($member_id)//if文の条件を共通化
        {
            return !is_numeric($member_id) || intval($member_id) < 1;//returnしないと正常に動かない。
        }
        
        /**
         * 新規登録
         */
        public function add() 
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
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|is_unique[members.email]');//メールアドレスのvalidation。is_unique[テーブル名.カラム名]
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('emergency_contact_address', '緊急連絡先電話番号', 'required|regex_match[/^(0{1}\d{9,10})$/]');//ハイフンなしの電話番号で制限するvalidation
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('member/add');//空文字の場合、もう一度入力を促す。
            } else {//成功時には、dbへの登録を行う。
                $member = [
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
                    'email' => $this->input->post('email'),//emailの値受け取り
                    'password' => $this->input->post('password'),//passwordの値受け取り
                    'emergency_contact_address' => $this->input->post('emergency_contact_address')//emergency_contact_addressの値受け取り
                ];
                $this->member_model->create($member);//member_modelのcreateメソッドを実行
                $getMember = $this->member_model->findByEmail($member);//登録する$memberのemailからmember情報を取得する。
                if (!$this->session->userdata('member_id')) {//memberセッションにデータがないことを確認する。
                    $this->session->set_userdata('member_id', $getMember->id);//sessionにmember.idを持たせる
                    $member_id = $this->session->userdata('member_id');       
                    redirect("target/index/{$member_id}");//redirectメソッドでtarget/indexへリダイレクトさせる。
                } else {//sessionデータがある場合は削除して再発行する処理
                    $this->session->unset_userdata('member_id');
                    $this->session->set_userdata('member_id', $getMember->id);//sessionにmember.idを持たせる
                    $member_id = $this->session->userdata('member_id');       
                    redirect("target/index/{$member_id}");//redirectメソッドでtarget/indexへリダイレクトさせる。
                }
            }
        }    

        /**
         * 更新処理
         * @param type $id
         */
        public function edit($member_id) 
        {
            if ($this->argumentCheck($member_id)) {//$idが1以上の整数か正規表現で判別する。
                redirect('member/logout');
            } else {
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
                    $data['member'] = $this->member_model->findById($member_id);//member_idがsessionと同じmemberデータを取得する。
                    $this->load->view("member/edit", $data);//member情報を持たせ、edit.phpを表示
                } else {
                    $updateMember = [//上書きするデータの配列を作成
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
                    $this->member_model->update($updateMember, $member_id);//member_modelのupdateメソッドで$updateMemberと$userIdを用いデータベースを上書きする。
                    redirect("target/index/{$member_id}");//redirectrメソッドでindexページへリダイレクト
                }
            }
        }
         
        /**
         * 削除処理
         * @param type $id
         */
        public function delete($id)//削除するidをパラメータより取得
        {
            if ($this->argumentCheck($id)) {//$idが整数ではなく、マイナスである場合の条件分岐
                redirect('user/logout');
            } else {
                $this->member_model->destroy($id);//member_modelのdeleteメソッドを実行する
                redirect('member/index');//redirectメソッドでindexページへリダイレクト
            }
        }
        
        /**
         * memberのログイン機能
         */
        public function login()
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required');
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('member/login');
            } else {
                $data['email'] = $this->input->post('email');
                $data['password'] = $this->input->post('password');
                $getMember = $this->member_model->findByEmail($data);//emailでmember情報を取得する。
                if ($getMember->password === sha1($data['password'] . $getMember->created)) {
                    $this->session->set_userdata('member_id', $getMember->id);//sessionを持たせる
                    $member_id = $this->session->userdata('member_id');//sessionを変数$member_idに代入する。
                    redirect("target/index/{$member_id}");//各ユーザのindexページへリダイレクトする。
                } else {
                    redirect('member/login');//パスワードが合わなかった際はログインページへ飛ばす。
                }
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
         * callback処理(email)
         */
        public function email_check($email)
        {
            $id = $this->session->userdata('member_id');//sessionからmember_idを取得して変数$idに代入
            $getMemberBySession = $this->member_model->findById($id);//$idを用いてpost前のemailを取得する。(row();)
            $checkEmailCount = $this->member_model->findByPostEmail($email);//$emailを用いてpost時のemailからdb内に同じemailが1以上あるかを調べる。(resutl();→全フィールドから該当のものを取得できる)
            //post前のemailとpost時のemailを比較 && $checkEmailCountの返り値が1つの場合(post前のemailのみ) || post前とpost時のemailが異なる && $checkEmailCountの返り値が空の場合(DBに重複emailがない)
            if ($getMemberBySession->email === $email && count($checkEmailCount) === 1 || $getMemberBySession->email !== $email && empty($checkEmailCount)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }