<?php
/**
* Written by Ntonsite Mwamlima. 
   May 2019
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    function createData($contract_data) {

        $this->db->insert('contract', $contract_data);
    }

    function getAllData($id) {

        $query = $this->db->query('SELECT * FROM `contract` WHERE user_id ="$id"');
        return $query->result();
    } 
    function getOverdues() {
        $query = $this->db->query('SELECT * FROM cnt_over');
        return $query->result();
    }

    function getData($id) {
        $query = $this->db->query('SELECT * FROM contract WHERE `user_id` ="$id"');
        return $query->row();
    }

    function updateData($id, $contract_data) {
       
        $this->db->where('id', $id);
        $this->db->update('contract', $contract_data);
    }

    function deleteData($id) {
        $this->db->where('id', $id);
        $this->db->delete('contract');
    }
    function getCount($id){
        
       $this->db->from('contract');
       $this->db->where('user_id',$id);
       return $num_rows = $this->db->count_all_results();
    }
    function getOverdue($id)
    {
        $this->db->from('cnt_over');
        $this->db->where('user_id',$id);
        return $num_rows = $this->db->count_all_results();
    }
    function getOverduez()
    {
        $query = $this->db->query('SELECT * FROM `cnt_over`');
        return $query=$this->db->count_all_results();

        if($query > 0){
            return true;
        }else
        {
            return false;
        }
    }

    function contractOnDeadlines($id){
        $this->db->from('deadline_contract');
        $this->db->where('user_id',$id);
        return $num_rows = $this->db->count_all_results();
    }

}
