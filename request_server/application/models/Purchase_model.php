<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_purchase($state_purchase)
    {
        $this->db->select('tb_nward.New_Heading, egp_main.egp_main_id, egp_main.egp_main_name, egp_main.start_date,egp_main.modify_datetime,egp_main.end_date');
        $this->db->from('tb_nward');
        $this->db->join('egp_main', 'tb_nward.News_id = egp_main.egp_main_center');
        $this->db->where('egp_main.deleted', $state_purchase);
        $this->db->order_by('egp_main.start_date', 'desc');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function get_purchase_center()
    {
        $this->db->select('News_id,New_Heading');
        $this->db->from('tb_nward');
        $this->db->order_by('News_id', 'desc');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function insert_purchase_main($name, $description, $agency, $start_date, $end_date, $create_by, $create_datetime)
    {
        $data = array(
            'egp_main_name' => $name,
            'egp_main_description' => $description,
            'egp_main_center' => $agency,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'create_by' => $create_by,
            'create_datetime' => $create_datetime,
        );
        $this->db->insert('egp_main', $data);
        return true;
    }

    public function get_purchase_main_id($id)
    {
        $result = $this->db->get_where('egp_main', array('egp_main_id' => $id, 'deleted' => 0));
        return $result->result_array();
    }

    public function get_purchase_last_id($id, $table)
    {
        $this->db->select($id);
        $this->db->from($table);
        $this->db->order_by($id, 'desc');
        $this->db->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function get_purchase_last_file_id($name)
    {

        $this->db->select('egp_file_name, egp_file_id');
        $this->db->from('egp_file');
        $this->db->like('egp_file_name', $name);
        $this->db->order_by('egp_file_id', 'desc');
        $this->db->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function insert_purchase_detail($egp_detail_description, $egp_main_id, $create_by, $create_datetime, $state)
    {
        $data = array(
            'egp_detail_description' => $egp_detail_description,
            'egp_main_id' => strval($egp_main_id),
            'create_by' => $create_by,
            'create_datetime' => $create_datetime,
            'egp_detail_status' => $state
        );
        $this->db->insert('egp_detail', $data);
        return true;
    }

    public function insert_purchase_detail_modify($egp_detail_description, $egp_main_id, $create_by, $create_datetime, $state, $modify_by, $modify_datetime)
    {
        $data = array(
            'egp_detail_description' => $egp_detail_description,
            'egp_main_id' => strval($egp_main_id),
            'create_by' => $create_by,
            'create_datetime' => $create_datetime,
            'egp_detail_status' => $state,
            'modify_by' => $modify_by,
            'modify_datetime' => $modify_datetime
        );
        $this->db->insert('egp_detail', $data);
        return true;
    }


    public function insert_purchase_file($egp_detail_id, $egp_file_name, $egp_file_remark, $egp_file_path, $create_by, $create_datetime)
    {

        $data = array(
            'egp_detail_id' => $egp_detail_id,
            'egp_file_name' => strval($egp_file_name),
            'egp_file_remark' => strval($egp_file_remark),
            'egp_file_path' => strval($egp_file_path),
            'create_by' => $create_by,
            'create_datetime' => $create_datetime,
        );
        $this->db->insert('egp_file', $data);
        return true;
    }

    public function insert_purchase_file_modify($egp_detail_id, $egp_file_name, $egp_file_remark, $egp_file_path, $create_by, $create_datetime, $modify_by, $modify_datetime, $deleted)
    {

        $data = array(
            'egp_detail_id' => $egp_detail_id,
            'egp_file_name' => strval($egp_file_name),
            'egp_file_remark' => strval($egp_file_remark),
            'egp_file_path' => strval($egp_file_path),
            'create_by' => $create_by,
            'create_datetime' => $create_datetime,
            'modify_by' => $modify_by,
            'modify_datetime' => $modify_datetime,
            'deleted' => $deleted,
        );
        $this->db->insert('egp_file', $data);
        return true;
    }


    public function delete_purchase_main($data, $id)
    {
        $this->db->where('egp_main_id', $id);
        $this->db->update('egp_main', $data);
    }

    public function delete_purchase_mannual($table, $data, $string_id, $id)
    {
        $this->db->where($string_id, $id);
        $this->db->update($table, $data);
    }

    public function delete_purchase_fail($table_, $string_id, $id)
    {
        $this->db->delete($table_, array($string_id => $id));
    }


    public function find_egp_main($id)
    {
        $this->db->select('egp_main.egp_main_id , egp_main.egp_main_name, tb_nward.New_Heading, egp_main.egp_main_id,egp_main.egp_main_description,egp_main.modify_datetime,egp_main.start_date,egp_main.end_date');
        $this->db->from('egp_main');
        $this->db->join('tb_nward', 'egp_main.egp_main_center = tb_nward.News_id');
        $this->db->where('egp_main.egp_main_id', $id);
        $result = $this->db->get();
        return $result->row();
    }

    public function find_egp_detail($id)
    {
        $this->db->select('egp_detail.egp_detail_description , egp_detail.modify_datetime, egp_detail.egp_detail_id, egp_detail.egp_detail_status');
        $this->db->from('egp_detail');
        $this->db->where('egp_detail.egp_main_id', $id);
        $this->db->where('egp_detail.deleted', 0);
        $this->db->order_by('egp_detail.modify_datetime', 'asc');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function find_egp_detail_id($id)
    {
        $result = $this->db->get_where('egp_detail', array('egp_detail_id' => $id, 'deleted' => 0));
        $this->db->order_by("modify_datetime", "desc");
        return $result->result_array();
    }

    public function find_egp_detail_main_id($id)
    {
        $result = $this->db->get_where('egp_detail', array('egp_main_id' => $id, 'deleted' => 0));
        $this->db->order_by("egp_detail_id", "asc");
        return $result->result_array();
    }

    public function find_egp_files_detail_id($id)
    {
        $result = $this->db->get_where('egp_file', array('egp_detail_id' => $id, 'deleted' => 0));
        $this->db->order_by("modify_datetime", "desc");
        return $result->result_array();
    }

    public function find_egp_files_id($id)
    {
        $result = $this->db->get_where('egp_file', array('egp_file_id' => $id, 'deleted' => 0));
        return $result->result_array();
    }
}
