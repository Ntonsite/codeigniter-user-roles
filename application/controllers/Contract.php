<?php
/**
* Written by Ntonsite Mwamlima. 
   May 2019
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CI_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Contract_model');
        $this->load->model('Vendor_model');
        $this->load->library('session');
        //session capturing
        $data['id'] = $this->session->userdata('user_id');
        $this->load->view('includes/header', $data);
       
    }
    public function index() {

        $id = $this->session->userdata('user_id');
        
        $data['vendor'] = $this->Vendor_model->getVendors($id);
        $data['result'] = $this->Contract_model->getAllData($id);
        
        $this->load->view('conView', $data);        
    }

    public function create() {
        if(!empty($_FILES['file']['name'])){
            
            // Set preference
            $config['upload_path']   = 'uploads/contracts/';    
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']      = '100000';
            $config['file_name']     = $_FILES['file']['name'];
                
            //Load upload library
            $this->load->library('upload',$config);         
            
            // File upload
            if($this->upload->do_upload('file')){
                // Get data about the file
                $uploadData = $this->upload->data();
                
                $filename = $uploadData['file_name'];
                $data['response'] = 'successfully uploaded '.$filename;
            }else{
                $data['response'] = 'failed';
            }
        }else{
            $data['response'] = 'failed';

        }
        $contract_data = array (
            'contract_name'   => $this->input->post('contract_name'),
            'description'     => $this->input->post('description'),
            'date_of_start'    => $this->input->post('date_of_start'),
            'date_of_expiry'  => $this->input->post('date_of_expiry'),
            'vendorID'        => $this->input->post('vendor'),
            'vendorID'        => $this->input->post('vendor'),
            'user_id'         => $this->session->userdata('user_id'),
            'file'            => $filename
        );
        
        $this->Contract_model->createData($contract_data);
        redirect("Contract");
    }

    public function edit($id) {
        $id             = $this->session->userdata('user_id');
        $data['vendor'] = $this->Vendor_model->getVendors($id);
        $data['row']    = $this->Contract_model->getData($id);
        
        $this->load->view('conEdit', $data);
    }

    public function update($id) {
        if(!empty($_FILES['file']['name'])){
            
            // Set preference
            $config['upload_path'] = 'uploads/contracts/';    
            $config['allowed_types'] = 'pdf|docx|doc';
            $config['max_size']    = '100000'; // max_size in kb
            $config['file_name'] = $_FILES['file']['name'];
                
            //Load upload library
            $this->load->library('upload',$config);         
            
            // File upload
            if($this->upload->do_upload('file')){
                // Get data about the file
                $uploadData = $this->upload->data();
                
                $filename = $uploadData['file_name'];
                $data['response'] = 'successfully uploaded '.$filename;
            }else{
                $data['response'] = 'failed';
            }
        }else{
            $data['response'] = 'failed';

        }
        $contract_data = array (
            'contract_name'  => $this->input->post('contract_name'),
            'description'    => $this->input->post('description'),
            'date_of_start'    => $this->input->post('date_of_start'),
            'date_of_expiry' => $this->input->post('date_of_expiry'),
            'vendorID'       => $this->input->post('vendor'),
            'user_id'        => $this->session->userdata('user_id'),
            'file'           => $filename
        );
        $this->Contract_model->updateData($id, $contract_data);
        redirect("Contract");
    }

    public function delete($id) {
        $this->Contract_model->deleteData($id);
        redirect("Contract");
    }

    public function contractDeadlineCheck(){

        if($this->Contract_model->getOverduez()==TRUE){
            $this->notifyContract();
        }
    }

    public function notifyContract()
    {
        $this->load->library('email');

        $this->email->from('it@accessbank.co.tz', 'Vendor Management Portal Notification');
        $this->email->to('nayan.gopal@accessbank.co.tz');
        $this->email->cc('ntonsite.mwamlima@accessbank.co.tz');
        $this->email->bcc('jones.mrusha@accessbank.co.tz');

        $this->email->subject('Contract OverDue');
        $this->email->message('');

        $this->email->send();
    }

}