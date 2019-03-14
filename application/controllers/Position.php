<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Position extends CI_Controller {
   
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
            $this->form_validation->set_rules('name', '部署名', 'required|is_unique[positions.position_name]');
            
            if ($this->form_validation->run() === FALSE) {
                $this->showView('position/add');//役職名の登録はログイン後なので、showViewを使って表示する
            } else {
                $name = ['name' => $this->input->post('name')];//役職名nameを受け取る
                $this->Position_model->create($name);//役職名をdbへ登録する
                redirect('position/index');//役職一覧へ飛ばす
            }
        }
        
        /**
         * 部署名の編集
         */
        public function edit($id)
        {
            $this->form_validation->set_rules('name', '役職名', 'required|callback_name_check');
            
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_userdata('position_id', $id);//position_idでsessionを設定する
                $position_id = $this->session->userdata('position_id');//変数position_idにsessionを代入する
                $data['position'] = $this->Position_model->findById($position_id);//idからpositionデータを取得する
                $this->showView('position/edit', $data);//idで取得したpositionデータをviewに渡す
            } else {
                $position = ['name' => $this->input->post('name')];//postの値でupdateする
                $this->Position_model->update($position, $id);
                redirect('position/index');
            }
        }

        /**
         * 部署名一覧
         */
        public function index()
        {
            $data['positions'] = $this->Position_model->findAll();//positionデータを全て取得する
            $this->showView('position/index', $data);//一覧ページへ飛ばす
        }

        /**
         * コールバック処理
         * 部署名の編集時のvalidation
         */
        public function name_check($name)
        {
            $id = $this->session->userdata('position_id');
            $positionBySession = $this->Position_model->findById($id);//$idを用いてpost前のnameを取得する。(row();)
            $positionByByName = $this->Position_model->findByName($name);//$nameを用いてpost時のnameからdb内に同じemailが1以上あるかを調べる。(resutl();→全フィールドから該当のものを取得できる)
            //post前のnameとpost時のnameを比較 && $checkedNameCountの返り値が1つの場合(post前のnemeのみ) || post前とpost時のnameが異なる && $checkedNameCountの返り値が空の場合(DBに重複nameがない)
            if ($positionBySession->position_name === $name && count($positionByName->position_name) === 1 || $positionBySession->position_name !== $email && empty($positionByName->position_name)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

