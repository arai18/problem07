<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Member extends CI_Controller {
        
        /**
         * ログインセッションの判定
         */
        public function __construct() 
        {
            parent::__construct();
            if (!$this->session->userdata('admin_id')) {
                $this->session->unset_userdata('admin_id');
                redirect('admin/login');
            }
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
                $this-> Member_model->create($member);//Member_modelのcreateメソッドを実行
                $matched_member = $this->Member_model->findByEmail($member['email']);//登録する$memberのemailからmember情報を取得する
                if (!$this->session->userdata('member_id')) {//memberセッションにデータがないことを確認する。
                    $this->session->set_userdata('member_id', $matched_member->id);//sessionにmember.idを持たせる     
                    redirect('target/index');//redirectメソッドでtarget/indexへリダイレクトさせる。
                } else {//sessionデータがある場合は削除して再発行する処理
                    $this->session->unset_userdata('member_id');
                    $this->session->set_userdata('member_id', $matched_member->id);//sessionにmember.idを持たせる       
                    redirect('target/index');//redirectメソッドでtarget/indexへリダイレクトさせる。
                }
            }
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
                $this->load->view("member/edit", $data);//member情報を持たせ、edit.phpを表示
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
                $this->Member_model->update($updatedMember, $member_id);//member_modelのupdateメソッドで$updateMemberと$userIdを用いデータベースを上書きする。
                redirect("target/index");//redirectrメソッドでindexページへリダイレクト
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
                    $this->load->view("member/edit_password");//validationにかかった際にviewへ戻す
                } else {
                    $member_id = $this->session->userdata('member_id');
                    $updatePassword = $this->input->post('new_password');//新規パスワードをpostで受け取る
                    $this->Member_model->updatePassword($updatePassword, $member_id);//dbへ新規パスワードをupdateする
                    redirect("target/index");//target/indexにリダイレクトする
                }
        }
        
        /**
         * 社員情報一覧表示機能
         */
        public function index()
        {
            $data['members'] = $this->Member_model->findAll();//配列でmemberのオブジェクトデータを取得する
            foreach ($data['members'] as $member) {//配列の要素を$memberに代入する          
                $division = $this->Division_model->findById($member->division_id);//配列要素で取れた$memberのdivision_idキーでidを取り出し、dbで検索し、divisionデータを取り出す。
                $member->division = $division;//divisionデータを$member->divisionに代入する
                $position = $this->Position_model->findById($member->position);
                $member->position = $position;
            }
            $this->load->view('member/index', $data);//$member->divisionが追加された$dataをviewに渡す。
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
                $this->Member_model->destroy($id);//Member_modelのdeleteメソッドを実行する
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
                $member = $this->Member_model->findByEmail($data['email']);//emailでmember情報を取得する。
                if ($member->password === sha1($data['password'] . $member->created)) {
                    $this->session->set_userdata('member_id', $member->id);//sessionを持たせる
                    $member_id = $this->session->userdata('member_id');//sessionを変数$member_idに代入する。
                    redirect("target/index");//各ユーザのindexページへリダイレクトする。
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
            $hashedOldPassword = sha1($password . $memberBySession->created);//post時のpasswordでハッシュ化
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
            $hashedNewPassword = sha1($password . $memberBySession->created);//post時のpasswordでハッシュ化
            if ($hashedNewPassword !== $memberBySession->password) {//post前とpost時のpasswordを比較する
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }