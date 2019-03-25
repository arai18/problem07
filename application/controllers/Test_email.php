<?php //
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Test_email extends CI_Controller {
        
        /**
         * コンストラクタ処理
         */
        public function __construct() 
        {
            parent::__construct();
        }
        
        /**
         * テスト送信
         */
        public function index()
        {
            //メールの情報を設定
            $mailto = "kyahyo17@yahoo.co.jp";
            $title = "タイトルテスト";
            $message = "本文のテストです。";
//            $email = "mezase.nember.1@gmail.com";
//            $header = "From: $email\nReply-To: $email\n";
            mb_language("japanese");
            mb_internal_encoding("UTF-8");
            //メールの送信
            if(mb_send_mail($mailto, $title, $message)){
                    echo "送信成功";
            }else{
                    echo "送信失敗";
            }
        }
        
    }