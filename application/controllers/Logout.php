<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Logout extends CI_Controller {
    
        /**
         * admin
         */
        public function admin()
        {
            $this->session->sess_destroy();
            redirect('login/admin');
        }
        
        /**
         * member
         */
        public function member() 
        {
            $this->session->sess_destroy();
            redirect('login/member');
        }
    }
