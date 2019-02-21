<?php
    class Member extends CI_Controller {
        
        /**
         * ログインセッションの判定
         */
        public function __construct() 
        {
            parent::__construct(); 
            if ($_SESSION['login'] === true) {
                redirect('/member/index');//ログイン成功時、/member/indexに飛ばす
            } else {
                redirect('/user/login');//ログイン失敗時、/user/loginに飛ばす
            }
        }
        
        /**
         * 一覧表示
         */
        public function index() 
        {
            $this->load->model('member_model');//モデルの読み込み
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
            $this->form_validation->set_rules('age', '年齢', 'required');
            $this->form_validation->set_rules('home', '出身地', 'required');

            if ($this->form_validation->run() == FALSE) {
                    $this->load->view('member/add');//空文字の場合、もう一度入力を促す。
                } else {//成功時には、dbへの登録を行う。
                    $this->load->model('member_model');//モデルの読み込み

                    $member = [
                        'first_name' => $this->input->post('first_name'),//first_nameの値受け取り
                        'last_name' => $this->input->post('last_name'),//last_nameの値受け取り
                        'age' => $this->input->post('age'),//ageの値受け取り
                        'home' => $this->input->post('home')//homeの値受け取り
                    ];

                    $this->member_model->create($member);//member_modelのcreateメソッドを実行
                    header('Location: /member/index');//headerメソッドでindexページへリダイレクト
                }
        }    

        /**
         * 更新処理
         * @param type $id
         */
        public function edit($id) 
        {
            $this->form_validation->set_rules('first_name', '氏', 'required');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('last_name', '名', 'required');
            $this->form_validation->set_rules('age', '年齢', 'required');
            $this->form_validation->set_rules('home', '出身地', 'required');
         
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
                header('Location: /member/index');//headerメソッドでindexページへリダイレクト
            }  
        }
         
        /**
         * 削除処理
         * @param type $id
         */
        public function delete($id)//削除するidをパラメータより取得
        {
            $this->member_model->destroy($id);//member_modelのdeleteメソッドを実行する
            header('Location: /member/index');//headerメソッドでindexページへリダイレクト
        }
}
