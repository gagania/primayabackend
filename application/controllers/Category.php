<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('Category_model'));
    }

    function index(){
            
        $this->data['title'] = 'Master Data - Category';
        $this->data['content'] = 'category/index';
        $this->data['dataList'] = $this->Category_model->getAll();
        $this->data['totaldata'] = sizeof($this->data['dataList']);
        $this->data['pnumber'] = 1;
        $this->load->view('layout', $this->data);
        
    }

    function save() {
        $new = true;
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
            
        }
        $postData = $this->input->post();
        //check the group code first, if exist then update else insert
        $checkId = $this->Category_model->getByCategory(array('id'=>$postData['id']));
        if ($checkId) {
            $this->Category_model->update($postData);
        } else {
            $this->Category_model->add($postData);
        }

        redirect('category/index');
    }
    
    //delete group table and update user table by group_code and delete acl
    function delete() {
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach($data as $value) {
                $this->Category_model->delete($this->Category_model->_table,array('id'=>$value["id"]));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
}