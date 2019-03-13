<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin extends CI_Controller {
        
        /**
         * ログインセッションの条件分岐
         */
        public function __construct() {
            parent::__construct();
            if (!$this->session->userdata('admin_id')) {
                $this->session->unset_userdata();
                redirect('login/admin');
            }
        }

        /**
         * adminの新規登録
         */
        public function add() 
        {
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|is_unique[admin.email]');//各種バリデーションの設定(空文字はfalse)
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('name', '氏名', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/add');//バリデーションに引っかかった場合にviewを返す
            } else {
                $admin = [
                    'email' => $this->input->post('email'),//usersテーブルに新規登録する情報
                    'password' => $this->input->post('password'),
                    'name' => $this->input->post('name')
                ];
                $this->Admin_model->create($admin);//データベースへinsertする
                $admin = $this->Admin_model->findByEmail($admin['email']);//emailからadmin_idを検索す
                if (!$this->session->userdata('admin_id')) {//session['admin']にデータがないことを確認する
                    $this->session->set_userdata('admin_id', $admin->id);//sessionにadmin_idを持たせる
                    redirect('admin/member_index');//redirectメソッドでmember/indexへリダイレクトさせる。
                } else {//sessionデータがある場合は削除して再発行する処理
                    $this->session->unset_userdata('admin_id');
                    $this->session->set_userdata('admin_id', $admin->id);//sessionにmember.idを持たせる      
                    redirect('admin/member_index');//redirectメソッドでtarget/indexへリダイレクトさせる。
                }  
            }
        }
        
        /**
         * 社員の新規登録
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
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|is_unique[members.email]');//メールアドレスのvalidation。is_unique[テーブル名.カラム名]
            $this->form_validation->set_rules('password', 'パスワード', 'required');
            $this->form_validation->set_rules('emergency_contact_address', '緊急連絡先電話番号', 'required|regex_match[/^(0{1}\d{9,10})$/]');//ハイフンなしの電話番号で制限するvalidation
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/member_add');
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
                redirect('admin/member_index');
            }
        } 
        
        /**
         * adminの編集
         */
        public function edit()
        {
            
        }


        /**
         * 登録社員の一覧表示
         */
        public function member_index()
        {
            $members = $this->Member_model->findAll();//配列でmemberのオブジェクトデータを取得する
            foreach ($members as $member) {//配列の要素を$memberに代入する          
                $division = $this->Division_model->findById($member->division_id);//配列要素で取れた$memberのdivision_idキーでidを取り出し、dbで検索し、divisionデータを取り出す。
                $member->division = $division;//divisionデータを$member->divisionに代入する
                $position = $this->Position_model->findById($member->position);//
                $member->position = $position;
            }
            $data['members'] = $members;
            $content = $this->load->view('admin/member_index', $data, true);
            $data['content'] = $content;
            $this->load->view('layout/admin/layout', $data);
        }
        
        /**
         * logout処理
         */
        public function logout()
        {
            $this->session->unset_userdata('admin_id');//sessionを削除する
            redirect('login/admin');//loginページへリダイレクト
        }
        
        
    }
       