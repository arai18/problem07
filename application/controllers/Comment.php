<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comment extends CI_Controller {
    
    /**
     * セッション条件分岐
     */
    public function __construct() 
    {
        parent::__construct();
        if (!$this->session->userdata('admin_id')) {//adminセッションによるアクセス制限
            redirect('logout/admin');
        }
    }
    
    /**
     * adminのlayout
     */
    private function showView(string $subView, $subData = '')//adminのヘッダー表示
    {
        $content = $this->load->view($subView, $subData, true);
        $data = [];
        $data['content'] = $content;
        $this->load->view('layout/admin/layout', $data);
    }
    
    /**
    * 引数に整数のみ受け付ける条件
    */
    private function argumentCheck($id)//if文の条件を共通化(ユーザからダイレクトで受け取るため型宣言できない)
    {
        return !is_numeric($id) || intval($id) < 1;//returnしないと正常に動かない。
    }
    
    /**
     * コメントの追加
     */
    public function add($target_id)//targetに対するコメントの追加
    {
        $this->form_validation->set_rules('comment', 'コメント', 'required|callback_exists_check');
        $this->form_validation->set_message('required', '【{field}】が未入力です');
        $this->form_validation->set_message('unique_check', 'この目標の【コメント】は既に登録済みです');
        
        if ($this->argumentCheck($target_id)) {
            redirect('logout/admin');
        } else {
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_userdata('target_id', $target_id);
                $data = [];
                $data['target_id'] = $target_id;
                $this->showView('/comment/add', $data);
            } else {
                $this->session->set_userdata('target_id', $target_id);
                $target_id = $this->session->userdata('target_id');//redirect時のクエリパラメータにも使用
                $target = $this->Target_model->findById($target_id);
                $admin = $this->session->userdata('admin_id');
                $comment = [
                    'member_id' => $target->member_id,
                    'target_id' => $target->id,
                    'year' => $target->year,
                    'admin_id' => $admin,
                    'comment' => $this->input->post('comment')   
                ];
                $this->Comment_model->create($comment);
                $this->session->set_flashdata('flash_message', 'コメントを登録しました');
                redirect("comment/index/{$target_id}");
            }
        }
    }
    
    /**
     * コメントの編集
     */
    public function edit($id)
    {
        $this->form_validation->set_rules('comment', 'コメント', 'required|callback_admin_id_check');
        $this->form_validation->set_message('required', '【{field}】が未入力です');
        $this->form_validation->set_message('admin_id_check', '社員IDが違うため更新できません');
        
        if ($this->argumentCheck($id)) {
            redirect('logout/admin');
        } else {
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_userdata('comment_id', $id);//callback時に使用する
                $data = [];
                $data['comment'] = $this->Comment_model->findById($id);//row()で取得するため、エラー処理必要
                if (!$data['comment']) {
                    $this->session->sess_destroy();
                    show_404();
                }
                $this->showView('comment/edit', $data);
            } else {
                $comment = [
                    'id' => $id,
                    'comment' => $this->input->post('comment')
                ];
                $this->Comment_model->update($comment);
                $this->session->set_flashdata('flash_message', 'コメントを編集しました');
                $target = $this->session->userdata('target_id');
                redirect("comment/index/{$target}");
            }
        } 
    }

    /**
     * コメントの表示
     */
    public function index($target_id) 
    {
        $data = [];
        $target = $this->Target_model->findById($target_id);//row()よる取得のためエラー処理必要
        if (!$target) {
            $this->session->sess_destroy();
            show_404();
        }
        switch ($target->term) {//termを該当の期間に上書きする
            case 1:
                $target->term = '4~6月';
                break;
            case 2:
                $target->term = '7~9月';
                break;
            case 3:
                $target->term = '10~12月';
                break;
            case 4:
                $target->term = '1~3月';
                break;
            default ://街灯がない場合は不正アクセス
                $this->session->sess_destroy();
                show_404();
        }
        $data['target'] = $target;
        $comments = $this->Comment_model->findByTargetId($target_id);
        foreach ($comments as $comment) {
            $admin = $this->Admin_model->findById($comment->admin_id);//ここの理解ができていない!
            $comment->admin = $admin;
        }
        $data['comments'] = $comments;
        $this->showView('comment/index', $data);
    }
    
    /**
     * 削除
     */
    public function delete($id)
    {
        if ($this->argumentCheck($id)) {
            redirect('logout/admin');
        } else {
            $target = $this->Comment_model->findById($id);//row()で取得するためエラー処理必要
            if (!$target) {
                $this->session->sess_destroy();
                show_404();
            }
            $this->Comment_model->destroy($id);
            $this->session->set_userdata('target', $target->id);
            $target_id = $this->session->userdata('target_id');
            redirect("comment/index/{$target_id}");
        }
    }
    
   
    
    /**
     * validationコールバック処理
     * 登録時のadmin_idチェック
     */
    public function exists_check()
    {
        $admin_id = $this->session->userdata('admin_id');//ログイン時(=登録時)のadmin_id
        $target_id = $this->session->userdata('target_id');//登録するcommentのtarget_id
        $comment = $this->Comment_model->findByAdminIdAndTargetId($admin_id, $target_id);//既に存在するかチェック
        if (!$comment) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 編集時のadmin_idチェック
     */
    public function admin_id_check() 
    {
        $adminIdBySession = $this->session->userdata('admin_id');//ログイン時(=編集時)のadmin_id
        $commentId = $this->session->userdata('comment_id');//編集するcomment_id
        $adminIdByCommentId = $this->Comment_model->findById($commentId);//編集するcommentをidで検索
        if ($adminIdBySession === $adminIdByCommentId->admin_id) {//編集するadminが登録時と同じかチェックする
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}

