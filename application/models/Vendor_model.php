<?php 
/**
* Written by Ntonsite Mwamlima. 
   May 2019
*/
defined('BASEPATH') OR exit('No direct script access allowed');

	class Vendor_model extends CI_Model
	{
		function __construct()
		{
			$this->load->database();
		}

		function createData($vendor_data){
			$this->db->insert('vendor', $vendor_data);
		}

		function getVendors($id){
			$query = $this->db->query('SELECT * FROM `vendor` WHERE user_id ="$id"');
			return $query->result();
		}

		function getData($id){

			$query = $this->db->query('SELECT * FROM vendor WHERE `vendorID` ='.$id);
			return $query->row();
		}

		function getCountVendor($id){
		   
		   $this->db->from('vendor');
		   $this->db->where('user_id',$id);
		   return $num_rows = $this->db->count_all_results();
		}

		function updateData($id, $vendor_data) {
		   
		    $this->db->where('vendorID', $id);
		    $this->db->update('vendor', $vendor_data);
		}

		function deleteData($id) {
		    $this->db->where('vendorID', $id);
		    $this->db->delete('vendor');
		}
	}
 ?>