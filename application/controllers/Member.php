<?php
    class Member extends CI_Controller {
        public function index() {
            $this->load->model('member_model');//モデルの読み込み
            $data['members'] = $this->member_model->getMember();//モデルのメソッドからの返り値を代入
            
            $this->load->view('index', $data);//viewに$dataを渡す。
        }
        
        public function add() {
            $first_name = $_POST[first_name];
            $last_name = $_POST[last_name];
            $age = $_POST[age];
            $home = $_POST[home];
            
            
            $this->member_model->create_member([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'age' => $age,
                'home' => $home
            ]);
        }
    }
