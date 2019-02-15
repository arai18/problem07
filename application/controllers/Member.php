<?php
    class Member extends CI_Controller {
        
        public function __construct() {
            parent::__construct(); 
        }

    public function index() {
            $this->load->model('member_model');//モデルの読み込み
            $data['members'] = $this->member_model->findAll();//モデルのメソッドからの返り値を代入
            
            $this->load->view('index', $data);//viewに$dataを渡す。
        }
        
        
        public function add() {
            $this->load->view('add');//add.phpを表示
        }    
           
        
        
        public function create() {
            $this->load->model('member_model');//モデルの読み込み
            
          
            $member = array(
                'first_name' => $this->input->post('first_name'),//first_nameの値受け取り
                'last_name' => $this->input->post('last_name'),//last_nameの値受け取り
                'age' => $this->input->post('age'),//ageの値受け取り
                'home' => $this->input->post('home')//homeの値受け取り
            );
            
            
            $this->member_model->create($member);//member_modelのcreateメソッドを実行
            $this->index();//indexメソッドを実行
            
            
        }
        
        
        public function update($id) {
            $this->load->model('member_model');//モデルを読み込み
            
            $data['member'] = $this->member_model->findById($id);//パラメータと同じIDを持つmemberをdbより取得
            $this->load->view('edit', $data);//member情報を持たせ、edit.phpを表示
        }
        
        
        public function edit() {
            $this->load->model('member_model');
            
            $updateMember = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'age' => $this->input->post('age'),
                'home' => $this->input->post('home')
            );
           
            $userId =$this->input->post('id');
            
            $this->member_model->update($updateMember, $userId);
            $this->index();
        }
        
        
        
        public function destroy(){
            
        }
}
