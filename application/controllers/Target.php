<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class Target extends CI_Controller {
    
    /**
     * session['member_id']の条件分岐
     */
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata('member_id')) {//session情報がない場合の処理
            $this->session->unset_userdata('member_id');
            redirect('member/add');
        }
    }

        /**
     * 目標一覧
     */
    public function index($member_id) //$member_idにはsessionデータを入れる。
    {  
        $data['targets'] = $this->target_model->findById($member_id);//member_idに対応した情報を取得
        $this->load->view("target/index", $data);//viewにデータを渡す。
    }
    
    /**
     * 目標の追加
     */
    public function add() 
    {
        $this->form_validation->set_rules('year', '年度', 'required|regex_match[/^[0-9]{4}$/]');
        $this->form_validation->set_rules('term', '期間', 'required');
        $this->form_validation->set_rules('target', '目標', 'required');
        
        if ($this->form_validation->run() === FALSE) {//target/addにアクセスした際、formの入力がないためviewが表示できる。
            $this->load->view('target/add');
        } else {
            $target = [//targetの登録内容をviewから取得する。
                'year' => $this->input->post('year'),
                'term' => $this->input->post('term'),
                'target' => $this->input->post('target')
            ];
            $member_id = $this->session->userdata('member_id');//sessionのデータを変数$member_idに格納する。
            $this->target_model->create($target, $member_id);//dbへtargetの内容とmember_idを登録する。
            redirect("target/index/{$member_id}");//各ユーザのindexページへリダイレクトする。
        }
    }
    
    /**
     *  目標の編集
     */
    public function edit($member_id, $year, $term)//とりあえず$member_idに初期値0を設定。
    {
        $this->form_validation->set_rules('year', '年度', 'required|regex_match[/^[0-9]{4}$/]');
        $this->form_validation->set_rules('term', '期間', 'required');
        $this->form_validation->set_rules('target', '目標', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['target'] = $this->target_model->findByTarget($member_id, $year, $term);//編集するtargetの既存データを取得する。
            $this->load->view("target/edit", $data);//既存データをeditページに反映する。
        } else {
            $findTarget = [//target特定用データ
                'member_id' => $member_id,
                'year' => $year,
                'term' => $term
            ];
            $updateTarget = [//上書きするデータを取得する。
                'year' => $this->input->post('year'),//inputで取得したyearデータ
                'term' => $this->input->post('term'),//inputで取得したtermデータ
                'target' => $this->input->post('target')//inputで取得したtargetデータ
            ];
            $this->target_model->update($updateTarget, $findTarget);//dbのデータを引数で上書きする。
            redirect("target/index/{$member_id}");//リダイレクトさせる。
        }
    }
    
    /**
     * 目標の削除
     */
    public function delete($member_id, $year, $term) 
    {
        $this->target_model->destroy($member_id, $year, $term);
        redirect("target/index/{$member_id}");
    }
}
