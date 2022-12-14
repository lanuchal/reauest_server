<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->helper('../../../../website_cmex_helper/php/hash_helper'); //[Anucha][16/11/2565][add hash_helper]
    }

    public function validate($username,$password){
        $password = getHash($password); // [Anucha][16/11/2565][Add getHash()]

        $sql_dt = "SELECT u.NUM_OT,w.New_Heading,po.position_name,p.Fname,p.Lname
                   FROM tb_nuser u LEFT JOIN tb_person p ON u.NUM_OT = p.NUM_OT
                                  LEFT JOIN tb_position po ON u.PP = po.position_code
                                  LEFT JOIN tb_nward w ON u.ward_code = w.ward_code
                   WHERE u.NUM_OT = '" . $username . "'AND u.Upass = '" . $password . "' AND u.deleted = 0";

        $row = $this->db->query($sql_dt)->row();

        if ($row) {
            $data = array(
                    'validated' => TRUE,
                    'numot'  => $row->NUM_OT,
                    'Fname'  => $row->Fname,
                    'organization'  => $row->New_Heading,
                    'position_name'  => $row->position_name,
                    'Lname'  => $row->Lname
            );
            
            $this->session->set_userdata($data);
            return true;
        }else {

            return false ;
        }
    }

}
