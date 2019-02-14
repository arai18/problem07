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
            $this->load->view('add');
        }    
           
        
        
        public function create() {
            $this->load->model('member_model');
            
          
            $member = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'age' => $this->input->post('age'),
                'home' => $this->input->post('home')
            );
            
            
            $this->member_model->create($member);
            $this->index();
            
            
        }
        
        
        public function update($id) {
            $this->load->model('member_model');
            
            $data['member'] = $this->member_model->findById($id);
            $this->load->view('edit', $data);  
        }
        
        
        public function edit($data) {
            $this->load->model('member_model');
            
            $updateMember = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'age' => $this->input->post('age'),
                'home' => $this->input->post('home')
            );
            
            $id = array(
                'id' => $this->input->post('id')
            );
            
            $this->member_model->update($updateMember, $id);
            $this->index;
        }
        
        
        
        public function destroy(){
            
        }
}
