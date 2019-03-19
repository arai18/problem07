<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Division extends CI_Controller {
   
        /**
         * ログインセッション(admin_id)の確認
         */
        public function __construct() {
            parent::__construct();
            if (!$this->session->userdata('admin_id')) {
                redirect('admin/logout');
            }
        }
        
        /**
         * 引数に整数のみ受け付ける条件
         */
        private function argumentCheck($id)//if文の条件を共通化
        {
            return !is_numeric($id) || intval($id) < 1;//returnしないと正常に動かない。
        }
        
        /**
         * adminのview統合表示
         */
        private function showView($subView, $subData = '')//引数にコンテンツビューと渡すデータを渡す
        {
            $content = $this->load->view($subView, $subData, true);//コンテンツビューを文字列で取得する
            $data['content'] = $content;//レイアアウトビューに渡すdataを設定する
            $this->load->view('layout/admin/layout', $data);//layoutビューにコンテンツとdataを渡す
        }

        /**
         * 部署名の新規登録
         */
        public function add()
        {
            $this->form_validation->set_rules('name', '部署名', 'required|is_unique[divisions.division_name]');
            
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('is_unique', 'この【{field}】は既に登録済みです');
            
            if ($this->form_validation->run() === FALSE) {
                $this->showView('division/add');//部署名の登録はログイン後なので、showViewを使って表示する
            } else {
                $name = ['name' => $this->input->post('name')];//部署名nameを受け取る
                $this->Division_model->create($name);//部署名をdbへ登録する
                $this->session->set_flashdata('flash_message', '新しい部署名を登録しました');
                redirect('division/index');//のちにdivision/index.phpに飛ばす
            }
        }
        
        /**
         * 部署名の編集
         */
        public function edit($id)
        {
            $this->form_validation->set_rules('name', '部署名', 'required|callback_name_check');
            //validationメッセージ
            $this->form_validation->set_message('required', '【{field}】が未入力です');
            $this->form_validation->set_message('name_check', 'この【{field}】は既に登録済みです');
            
            if ($this->argumentCheck($id)) {//整数1以上の条件分岐
                redirect('admin/logout');
            } else {
                if ($this->form_validation->run() === FALSE) {
                    $this->session->set_userdata('division_id', $id);
                    $division_id = $this->session->userdata('division_id');
                    $data['division'] = $this->Division_model->findById($division_id);
                    if (!$data['division']) {//nullの場合(不正アクセス)
                        $this->session->sess_destroy();
                        show_404();
                    }
                    $this->showView('division/edit', $data);
                } else {//validationに通った場合
                    $division = ['name' => $this->input->post('name')];
                    $this->Division_model->update($division, $id);//update処理
                    $this->session->set_flashdata('flash_message', '部署名を編集しました');
                    redirect('division/index');
                }
            } 
        }

        /**
         * 部署名一覧
         */
        public function index()
        {
            $data['divisions'] = $this->Division_model->findAll();//連想配列での取得のため、エラーハンドルなし。
            $this->showView('division/index', $data);
        }
        
        /**
         * 部署名を削除
         */
        public function delete($id)
        {
           if ($this->argumentCheck($id)) {
                redirect('admin/logout');
           } else {
                $this->Division_model->destroy($id); 
                $this->session->set_flashdata('flash_message', '部署名を削除しました');
                redirect('division/index');
           }
        }
        
        /**
         * コールバック処理
         * 部署名の編集時のvalidation
         */
        public function name_check($name)
        {
            $id = $this->session->userdata('division_id');
            $divisionBySession = $this->Division_model->findById($id);//$idを用いてpost前のnameを取得する。(row();)
            if (!$divisionBySession) {//nullの場合(不正アクセス)
                $this->session->sess_destroy();
                show_404();
            }
            $divisionByName = $this->Division_model->findByName($name);//$nameを用いてpost時のnameからdb内に同じemailが1以上あるかを調べる。(resutl();→全フィールドから該当のものを取得できる)、連想配列→エラー処理なし
            //post前のnameとpost時のnameを比較 && $checkedNameCountの返り値が1つの場合(post前のnemeのみ) || post前とpost時のnameが異なる && $checkedNameCountの返り値が空の場合(DBに重複nameがない)
            if ($divisionBySession->division_name === $name && count($divisionByName) === 1 || $divisionBySession->division_name !== $name && empty($divisionByName)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

