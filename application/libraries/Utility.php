<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Utility {
        
        /**
         * パスワードハッシュ化
         */
        public function getHash($password, $created_at)
        {
            return sha1($password . $created_at);
        }
    }

