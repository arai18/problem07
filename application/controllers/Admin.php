<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin extends CI_Controller {
        
        /**
         * ログインセッションの条件分岐
         */
        public function __construct() {
            parent::__construct();
            if (!$this->session->userdata('admin_id')) {
                redirect('logout/admin');
            }
        }
        
        /**
         * admin用のview
         */
        private function showView($subView, $subData = '')
        {
            $content = $this->load->view($subView, $subData, true);
            $data = [];
            $data['content'] = $content;
            $this->load->view('layout/admin/layout', $data);
        }

        /**
         * 引数に整数のみ受け付ける条件
         */
        private function argumentCheck($id)//if文の条件を共通化
        {
            return !is_numeric($id) || intval($id) < 1;//returnしないと正常に動かない。
        }

        /**
         * adminの新規登録
         */
        public function add() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|is_unique[admin.email]');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('name', '氏名', 'required');
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('valid_email', '【{field}】の入力形式が違います');
            $this->form_validation->set_message('is_unique', 'この【{field}】は既に登録済みです');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/add');//バリデーションに引っかかった場合にviewを返す
            } else {
                $admin = [
                    'email' => $this->input->post('email'),//usersテーブルに新規登録する情報
                    'password' => $this->input->post('password'),
                    'name' => $this->input->post('name')
                ];
                $this->Admin_model->create($admin);//データベースへinsertする
                $admin = $this->Admin_model->findByEmail($admin['email']);//emailからadmin_idを検索
                if (!$admin) {
                    $this->session->sess_destroy();
                    show_404();
                }
                $this->session->set_userdata('admin_id', $admin->id);//sessionにadmin_idを持たせる
                $this->session->set_flashdata('flash_message', '新しいadminを登録しました');
                redirect('admin/member_index');//redirectメソッドでmember/indexへリダイレクトさせる
            }
        }
        
        /**
         * 社員の新規登録
         * form_validationの１回目で部署名、役職名が登録されていなければ、各一覧ページへ飛ばし登録を促す。
         * 
         */
        public function member_add() 
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
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|is_unique[members.email]');//メールアドレスのvalidation。is_unique[テーブル名.カラム名]
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('emergency_contact_address', '緊急連絡先電話番号', 'required|regex_match[/^(0{1}\d{9,10})$/]');//ハイフンなしの電話番号で制限するvalidation
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('valid_email', '【{field}】の入力形式が違います');
            $this->form_validation->set_message('is_unique', 'この【{field}】は既に登録済みです');
            
            if ($this->form_validation->run() === FALSE) {
                $divisions = $this->Division_model->findAll();//プルダウンメニュー用の部署データを取得し、$dataに渡す。
                $division_options = [];
                foreach ($divisions as $division) {//viewへ渡す部署名プルダウンメニュー
                    $division_options[$division->id] = "{$division->id} : {$division->division_name}";
                }
                $data = [];
                $data['division_options'] = $division_options;
                $positions = $this->Position_model->findAll();//プルダウンメニュー用の役職データを取得し、$dataに渡す。
                $position_options = [];
                foreach ($positions as $position) {//viewへ渡す役職名プルダウンメニュー
                    $position_options[$position->id] = "{$position->id} : {$position->position_name}";
                }
                $data['position_options'] = $position_options;
                $this->showView('admin/member_add', $data);
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
                $this->Member_model->create($member);//Member_modelのcreateメソッドを実行
                $this->session->set_flashdata('flash_message', '新しい社員を登録しました');
                redirect('admin/member_index');
            }
        }

        /**
         * adminの編集作業
         */
        public function edit()
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|callback_admin_email_check');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('name', '氏名', 'required');
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('valid_email', '【{field}】の入力形式が違います');
            $this->form_validation->set_message('admin_email_check', 'この【{field}】は既に登録済みです');
            
            if ($this->form_validation->run() === FALSE) {//バリデーションに引っかかった場合の処理
                $admin_id = $this->session->userdata('admin_id');//変数にsessionのadmin_idを代入する
                $data = [];
                $data['admin'] = $this->Admin_model->findById($admin_id);//idからadmin情報を取得する
                if (!$data['admin']) {//nullの場合(不正アクセス)
                    $this->session->sess_destroy();
                    show_404();
                }
                $this->showView('admin/edit', $data);//バリデーションに引っかかった場合にviewを返す
            } else {
                $admin = [
                    'email' => $this->input->post('email'),//usersテーブルに新規登録する情報
                    'name' => $this->input->post('name')
                ];
                $admin_id = $this->session->userdata('admin_id');
                $this->Admin_model->update($admin, $admin_id);
                $this->session->set_flashdata('flash_message', 'admin情報を編集しました');
                redirect('admin/member_index');//redirectメソッドでtarget/indexへリダイレクトさせる。
            }
        }
        
        /**
         * 社員情報の編集作業
         */
        public function member_edit($member_id)//sessionを用いるため引数にmember_idは含めない
        {
            if ($this->argumentCheck($member_id)) {//member_idが1以上の整数か判断する
                redirect('login/admin');
            }else {
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
                $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|callback_member_email_check');//メールアドレスのvalidation
                $this->form_validation->set_rules('emergency_contact_address', '緊急連絡先電話番号', 'required|regex_match[/^(0{1}\d{9,10})$/]');//ハイフンなしの電話番号で制限するvalidation
                //validationメッセージ
                $this->form_validation->set_message('required', '【{field}】が未入力です');
                $this->form_validation->set_message('valid_email', '【{field}】の入力形式が違います');
                $this->form_validation->set_message('member_email_check', 'この【{field}】は既に登録済みです');
                
                if ($this->form_validation->run() === FALSE) {
                    $this->session->set_userdata('member_id', $member_id);
                    $data = [];
                    $data['member'] = $this->Member_model->findById($member_id);//引数のidをもとにmember情報を取得する
                    if (!$data['member']) {//nullの場合(不正なアクセス)
                        $this->session->sess_destroy();
                        show_404();
                    }
                    $data['divisions'] = $this->Division_model->findAll();//プルダウンメニュー用の部署データを取得し、$dataに渡す。
                    $data['positions'] = $this->Position_model->findAll();//プルダウンメニュー用の役職データを取得し、$dataに渡す。
                    $this->showView('admin/member_edit', $data);
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
                    $this->session->set_flashdata('flash_message', '社員情報を編集しました');
                    redirect('admin/member_index');//redirectrメソッドでindexページへリダイレクト
                }
            }
        }

        /**
         * 登録社員の一覧表示
         */
        public function member_index()
        {
            $members = $this->Member_model->findAll();//配列でmemberのオブジェクトデータを取得する
            if (!$members) {//社員がnullの場合
                $this->session->sess_destroy();
                show_404();
            } else {
                foreach ($members as $member) {//配列の要素を$memberに代入する          
                    $division = $this->Division_model->findById($member->division_id);//配列要素で取れた$memberのdivision_idキーでidを取り出し、dbで検索し、divisionデータを取り出す。
                    if (!$division) {//nullの場合
                        $this->session->sess_destroy();
                        show_404();
                    }
                    $member->division = $division;//divisionデータを$member->divisionに代入する
                    $position = $this->Position_model->findById($member->position);
                    if (!$position) {
                        $this->session->sess_destroy();
                        show_404();
                    }
                    $member->position = $position;
                }
                $data = [];
                $data['members'] = $members;
                $this->showView('admin/member_index', $data);
            } 
        }
        
        /**
         * 社員削除処理
         * @param type $id
         */
        public function delete($id)//削除するidをパラメータより取得
        {
            if ($this->argumentCheck($id)) {//$idが整数ではなく、マイナスである場合の条件分岐
                redirect('user/logout');
            } else {
                $this->Member_model->destroy($id);//Member_modelのdeleteメソッドを実行する
                $this->session->set_flashdata('flash_message', '社員を削除しました');
                redirect('admin/member_index');//redirectメソッドでindexページへリダイレクト
            }
        }
        
        /**
         * adminのlogout処理
         */
        public function logout()
        {
            $this->session->unset_userdata('admin_id');//sessionを削除する
            $this->session->set_flashdata('flash_message', 'ログアウトしました');
            redirect('login/admin');//loginページへリダイレクト
        }
        
        /**
         * コールバック処理(adminのemail_validation)
         */
        public function admin_email_check($email)
        {
            $id = $this->session->userdata('admin_id');//sessionからadmin_idを取得して変数$idに代入
            $AdminBySession = $this->Admin_model->findById($id);//$idを用いてpost前のemailを取得する。(row();)
            if (!$AdminBySession) {//nullの場合(不正アクセス)
                $this->session->sess_destroy();
                show_404();
            }
            $checkedEmailCount = $this->Admin_model->findResultByEmail($email);//$emailを用いてpost時のemailからdb内に同じemailが1以上あるかを調べる。(resutl();→全フィールドから該当のものを取得できる)
            //post前のemailとpost時のemailを比較 && $checkedEmailCountの返り値が1つの場合(post前のemailのみ) || post前とpost時のemailが異なる && $checkedEmailCountの返り値が空の場合(DBに重複emailがない)
            if ($AdminBySession->email === $email && count($checkedEmailCount) === 1 || $AdminBySession->email !== $email && empty($checkedEmailCount)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * コールバック処理(memberのemail_validation)
         */
        public function member_email_check($email)
        {
            $member_id = $this->session->userdata('member_id');
            $member = $this->Member_model->findById($member_id);//sessionからmember_idを取得して変数$idに代入
            if (!$member) {
                $this->session->sess_destroy();
                show_404();
            }
            $memberBySession = $this->Member_model->findById($member->id);//$idを用いてpost前のemailを取得する。(row();)
            if (!$memberBySession) {
                $this->session->sess_destroy();
                show_404();
            }
            $checkedEmailCount = $this->Member_model->findByPostEmail($email);//$emailを用いてpost時のemailからdb内に同じemailが1以上あるかを調べる。(resutl();→全フィールドから該当のものを取得できる)、連想配列→エラー処理なし
            //post前のemailとpost時のemailを比較 && $checkedEmailCountの返り値が1つの場合(post前のemailのみ) || post前とpost時のemailが異なる && $checkedEmailCountの返り値が空の場合(DBに重複emailがない)
            if ($memberBySession->email === $email && count($checkedEmailCount) === 1 || $memberBySession->email !== $email && empty($checkedEmailCount)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        
    }
       