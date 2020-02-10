<?php
/**
* Written by Ntonsite Mwamlima. 
   May 2019
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class License_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    function createData($license_data) {
        
        $this->db->insert('license', $license_data);
    }

    function getAllData($id) {
        $query = $this->db->query("SELECT * FROM `license` WHERE user_id ='$id'");
        return $query->result();
    }
    
    function getOverdues() {
        $query = $this->db->query('SELECT * FROM lcs_over');
        return $query->result();
    }

    function getData($id) {
        $query = $this->db->query('SELECT * FROM license WHERE `user_id` =' .$id);
        return $query->row();
    }

    function updateData($id,$license_data) {
        $this->db->where('id', $id);
        $this->db->update('license', $license_data);
    }

    function deleteData($id) {
        $this->db->where('id', $id);
        $this->db->delete('license');
    }
    
    function getCount($id)
    {
        $this->db->from('license');
        $this->db->where('user_id',$id);
        return $num_rows = $this->db->count_all_results();
    }

    function getOverdue($id)
    {
        $this->db->from('lcs_over');
        $this->db->where('user_id',$id);
        return $num_rows = $this->db->count_all_results();
    }

    function licenseOnDeadlines($id){
        $this->db->from('deadline_license');
        $this->db->where('user_id',$id);
        return $num_rows = $this->db->count_all_results();
    }
}
