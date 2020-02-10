<?php 
    /**
	* Written by Ntonsite Mwamlima. 
	   May 2019
	*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('Vendor_model');
		$this->load->helper('url');
		$this->load->library('session');

        //session capturing
        $data['id'] = $this->session->userdata('user_id');
        $this->load->view('includes/header', $data);
	}

	public function index() {
        
        $id             = $this->session->userdata('user_id');     
        $data['vendor'] = $this->Vendor_model->getVendors($id);
        
        $this->load->view('vendorView', $data);    
    }

    public function create() {
      
        $vendor_data = array (
            'name'               => $this->input->post('name'),
            'location_address'   => $this->input->post('address'),
            'contact_person'     => $this->input->post('cperson'),
            'contact_email'      => $this->input->post('email'),
            'phone_number'       => $this->input->post('phone'),
            'service_offered'    => $this->input->post('service'),
            'user_id'            => $this->session->userdata('user_id')
        );
        
        $this->Vendor_model->createData($vendor_data);
        redirect("Vendor");
    }

    public function edit($id) {
        $data['row'] = $this->Vendor_model->getData($id);
        
        $this->load->view('vendorEdit', $data);
    }

    public function update($id) {

        $vendor_data = array (
            'name'   => $this->input->post('name'),
            'location_address'     => $this->input->post('address'),
            'contact_person'       => $this->input->post('cperson'),
            'contact_email'        => $this->input->post('email'),
            'phone_number'         => $this->input->post('phone'),
            'service_offered'      => $this->input->post('service'),
            'user_id'              => $this->session->userdata('user_id')
        );
        $this->Vendor_model->updateData($id, $vendor_data);
        redirect("Vendor");
    }

    public function delete($id) {
        $this->Vendor_model->deleteData($id);
        redirect("Vendor");
    }

}

?>