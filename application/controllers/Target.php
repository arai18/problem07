<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Target extends CI_Controller {
    
    /**
     * sessionの条件分岐
     */
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata('member_id')) {//session情報がない場合の処理
            redirect('member/logout');
        }
    }
    
    /**
     * viewを表示する処理
     */
    private function showView(string $subView, $subData = '')//content部分のviewを受け取る。viewに渡すdataも引数で受け取る
    {
        $content = $this->load->view($subView, $subData, true);//htmlを文字列にしたcontent(view)を変数に代入する
        $data = [];
        $data['content'] = $content;//layout(view)に渡せるように$dataに代入する
        $this->load->view('layout/member/layout', $data);//layout/layout.phpを表示させる
    }
    
    /**
    * 引数に整数のみ受け付ける条件
    */
    private function argumentCheck($year, $term)//if文の条件を共通化
    {
        return !is_numeric($year) || intval($year) < 1 || !is_numeric($term) || intval($term) < 1;//returnしないと正常に動かない。
    }
    
    
    /**
     * 目標一覧
     */
    public function index() //$member_idにはsessionデータを入れる。
    {  
        $member_id = $this->session->userdata('member_id');
        $data = [];
        $data['years'] = $this->Target_model->distinctYear($member_id);//重複しないyearを連想配列で取得する
        $data['targets'] = $this->Target_model->findById($member_id);//member_idに対応した情報を取得
        $this->showView('target/index', $data);
    }
    
    /**
     * 目標の追加
     */
    public function add() 
    {
        $this->form_validation->set_rules('year', '年度', 'required|regex_match[/^[0-9]{4}$/]|callback_year_add_check');
        $this->form_validation->set_rules('term', '期間', 'required|callback_term_add_check');
        $this->form_validation->set_rules('target', '目標', 'required');
        //validationメッセージ
        $this->form_validation->set_message('required', '【{field}】が未入力です');
        $this->form_validation->set_message('regex_match', '【{field}】の入力形式が違います');
        $this->form_validation->set_message('year_add_check', 'この【{field}】の目標は四半期全て入力済みです');
        $this->form_validation->set_message('term_add_check', 'この【{field}】の目標は既に入力済みです');
        
        if ($this->form_validation->run() === FALSE) {//target/addにアクセスした際、formの入力がないためviewが表示できる。
            $this->showView('target/add');//viewを返す
        } else {
            $target = [//targetの登録内容をviewから取得する。
                'year' => $this->input->post('year'),
                'term' => $this->input->post('term'),
                'target' => $this->input->post('target')
            ];
            $member_id = $this->session->userdata('member_id');//sessionのデータを変数$member_idに格納する。
            $this->Target_model->create($target, $member_id);//dbへtargetの内容とmember_idを登録する。
            $this->session->set_flashdata('flash_message', '新しい目標を追加しました');
            redirect('target/index');//各ユーザのindexページへリダイレクトする。
        }
    }
    
    /**
     *  目標の編集
     */
    public function edit($year, $term)
    { 
        $this->form_validation->set_rules('year', '年度', 'required|regex_match[/^[0-9]{4}$/]|callback_year_edit_check');
        $this->form_validation->set_rules('term', '期間', 'required|callback_term_edit_check');
        $this->form_validation->set_rules('target', '目標', 'required');
        //validationメッセージ
        $this->form_validation->set_message('required', '【{field}】が未入力です');
        $this->form_validation->set_message('regex_match', '【{field}】の入力形式が違います');
        $this->form_validation->set_message('year_edit_check', 'この【{field}】の目標は四半期全て入力済みです');
        $this->form_validation->set_message('term_edit_check', 'この【{field}】の目標は既に入力済みです');
        
        if ($this->argumentCheck($year, $term)) {
            redirect('member/logout');
        } else {
            if ($this->form_validation->run() === FALSE) {
                $member_id = $this->session->userdata('member_id');
                $this->session->set_userdata('year', $year);
                $this->session->set_userdata('term', $term);
                $data = [];
                $data['target'] = $this->Target_model->findByTarget($member_id, $year, $term);//編集するtargetの既存データを取得する。
                if (!$data['target']) {//nullの場合
                    $this->session->sess_destroy();
                    show_404();
                }
                $this->showView('target/edit', $data);//$data['target']を引数にviewを返す。
            } else {
                $member_id = $this->session->userdata('member_id');
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
                $this->Target_model->update($updateTarget, $findTarget);//dbのデータを引数で上書きする。
                $this->session->set_flashdata('flash_message', '目標を編集しました');
                redirect('target/index');//リダイレクトさせる。
            }
        }
        
    }
    
    /**
     * 目標の削除
     */
    public function delete($year, $term) 
    {
        if ($this->argumentCheck($year, $term)) {
            redirect('member/logout');
        } else {
            $member_id = $this->session->userdata('member_id');
            $this->Target_model->destroy($member_id, $year, $term);
            $this->session->set_flashdata('flash_message', '目標を削除しました');//削除時のflash
            redirect('target/index');
        }
    }
    
    /**
     * コールバック処理
     * 目標登録時のyear_validation
     */
    public function year_add_check($year)
    {
        $member_id = $this->session->userdata('member_id');//member_idを取得する
        $targets = $this->Target_model->findByIdAndYear($member_id, $year);//post時のtargetを連想配列で受け取る
        if (count($targets) < 4) {//db内にtargetが3つ以下であれば通す
            return TRUE;
        } else {
            return FALSE;
        }   
    }
    
    /**
     * 目標編集時のyear_validation
     */
    public function year_edit_check($year)
    {
        $member_id = $this->session->userdata('member_id');
        $targets = $this->Target_model->findByIdAndYear($member_id, $year);//post時のtargetを連想配列で受け取る→エラー処理なし  
        $postBeforeYear = $this->session->userdata('year');//post前のyearをeditの引数からsessionを通して取得する
        foreach ($targets as $target) {
            //返り値の配列が4以下でpost前とpost時とyearが同じ場合(何も変更しないで編集した場合) || 返り値の配列が3以下でpost前とpost時のyearが違う場合
           if ((count($targets) < 5 && $year === $postBeforeYear ) || (count($targets) < 4 && $year !== $postBeforeYear)) {
                return TRUE;
            } else {
                return FALSE;
            }   
        }
    }
    
    /**
     * 目標登録時のterm_validation
     */
    public function term_add_check($term)
    {
        $member_id = $this->session->userdata('member_id');
        $postYear = $this->input->post('year');//post時のyearを取得する
        $target = $this->Target_model->findByTarget($member_id, $postYear, $term);//次の処理に影響がないため、エラー処理なし
        if (!$target) {//存在しなければ通す
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 目標編集時のterm_validation
     */
    public function term_edit_check($term)
    {
        $member_id = $this->session->userdata('member_id');
        $postYear = $this->input->post('year');
        $target = $this->Target_model->findByTarget($member_id, $postYear, $term);//post時のtargetを取得する、row()でも次の処理に必要なためエラー処理なし。
        $postBeforeYear = $this->session->userdata('year');//post前のyear
        $postBeforeTerm = $this->session->userdata('term');//post前のterm
        //編集せずにpostした場合　|| post時のmember_idとpostYearとtermで検索しtargetがない場合
        if ($term === $postBeforeTerm && $postYear === $postBeforeYear || !$target) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}