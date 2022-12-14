<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Breadcrumb');
        $this->load->helper('../../common/helpers/thai_date');
    }


    protected function loadViewWithScript($body_views)
    {
        $this->load->view('common/header', $this->data);
        $this->load->view($body_views, $this->data);
        $this->load->view('common/footer', $this->data);
    }


    protected function check_isvalidated()
    {
        $chk_login = $this->session->userdata('validated');
        if ($chk_login) {
            return true;
        } else {
            return false;
        }
    }
}
