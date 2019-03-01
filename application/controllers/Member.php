<?php
    class Member extends CI_Controller {
        
        /**
         * ログインセッションの判定
         */
        public function __construct() 
        {
            parent::__construct();
//            if ($this->session->userdata('login') !== true) {//$_SESSION['login']にtrueがなかった場合。trueであればスルー。
//                $this->session->unset_userdata('login');//true以外の場合は削除する。
//                redirect('user/add');//sessionにtrueがない場合はuser/registrationにリダイレクトする。
//            }
        }
        
        private function argumentCheck($id)//if文の条件を共通化
        {
            return !is_numeric($id) || intval($id) < 1;//returnしないと正常に動かない。
        }


        /**
         * 一覧表示
         */
        public function index() 
        {
            $data['members'] = $this->member_model->findAll();//モデルのメソッドからの返り値を代入
            $this->load->view('member/index', $data);//viewに$dataを渡す。
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
            $this->form_validation->set_rules('entering_company_date', '入社日', 'requiredregex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');//存在、日付のvalidation。
            $this->form_validation->set_rules('retirement_date', '退職日', 'regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');//日付のvalidation
            $this->form_validation->set_rules('division_id', '部署ID', 'required');
            $this->form_validation->set_rules('position', '役職ID', 'required');
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|is_unique[members.email]');//メールアドレスのvalidation
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
                redirect('member/index');//headerメソッドでindexページへリダイレクト
            }
        }    

        /**
         * 更新処理
         * @param type $id
         */
        public function edit($id) 
        {
            if ($this->argumentCheck($id)) {//$idが1以上の整数か正規表現で判別する。
                redirect('user/logout');
            } else {
                $this->form_validation->set_rules('first_name', '氏', 'required');//各種バリデーションの設定(空文字はfalse)
                $this->form_validation->set_rules('last_name', '名', 'required');
                $this->form_validation->set_rules('age', '生年月日', 'required|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');
                $this->form_validation->set_rules('home', '出身地', 'required');//ここまででvalidationはあるもののviewへは飛ばしていないため、次のvalidationdで引っかかる。
         
                if ($this->form_validation->run() == FALSE) {          
                    $data['member'] = $this->member_model->findById($id);//パラメータと同じIDを持つmemberをdbより取得
                    $this->load->view('member/edit', $data);//member情報を持たせ、edit.phpを表示
                } else {
                    $updateMember = [//上書きするデータの配列を作成
                        'first_name' => $this->input->post('first_name'),//first_nameのvalueにinputの値を挿入
                        'last_name' => $this->input->post('last_name'),//last_nameのvalueにinputの値を挿入
                        'age' => $this->input->post('age'),//ageのvalueにinputの値を挿入
                        'home' => $this->input->post('home')//homeのvalueにinputの値を挿入
                    ];
                    $userId = $this->input->post('id');//memberを特定するidを別で取得する
                    $this->member_model->update($updateMember, $userId);//member_modelのupdateメソッドで$updateMemberと$userIdを用いデータベースを上書きする。
                    redirect('member/index');//headerメソッドでindexページへリダイレクト
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
    }