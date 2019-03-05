<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class Target extends CI_Controller {
    
    /**
     * 目標一覧
     */
    public function index($member_id = 0) //$member_idにはsessionデータを入れる。
    {  
        //member_idが同じものを取得する。
        //年度が同じで四半期の4つを選択する。
        //viewにそれを渡す。
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
            $target = [
                'year' => $this->input->post('year'),
                'term' => $this->input->post('term'),
                'target' => $this->input->post('target')
            ];
            $this->target_model->create($target);
            //redirect indexページに
            redirect('target/index');
        }
    }
    
    /**
     *  目標の編集
     */
    public function edit($member_id = 0, $year, $term)//とりあえず$member_idに初期値0を設定。
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
            redirect('target/index');//リダイレクトさせる。
        }
    }
    
    /**
     * 目標の削除
     */
    public function delete($member_id = 0, $year, $term) 
    {
        $this->target_model->destroy($member_id, $year, $term);
        redirect('target/index');
    }
}
