<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Controller {
    protected $_groupType = array(
                   "" =>'Backend',
                   "fr" =>'Frontend'
    ); 
    protected $_groupLevel = array(
                   "" =>'--',
                   "1" =>'High',
                   "2" =>'Middle',
                   "3" =>'Low'
    ); 
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('Group_Model'));
    }

    function index(){
            
        $this->data['title'] = 'Master Data - Group';
        $this->data['content'] = 'group/index';
        $this->data['groupType'] = $this->_groupType;
        $this->data['groupLevel'] = $this->_groupLevel;
        
//        if ($this->session->userdata('user_group') && $this->session->userdata('user_group') != '00') {
//            $this->data['dataList'] = $this->Group_Model->getDefaultGroup(array('group_code not in("00")'=>''));
//            
//        } else {
            $this->data['dataList'] = $this->Group_Model->getAll();
//        }
        $this->data['totaldata'] = sizeof($this->data['dataList']);
        $this->data['pnumber'] = 1;
        $this->load->view('layout', $this->data);
        
    }
    
    function auth(){
            
        $this->data['title'] = 'Master Data - Hak Akses Group';
        $this->data['content'] = 'group/auth';
//        if ($this->session->userdata('user_group') && $this->session->userdata('user_group') != '00') {
//            $this->data['dataList'] = $this->Group_Model->getDefaultGroup(array('group_code not in("00")'=>''));
//        } else {
            $this->data['dataList'] = $this->Group_Model->getAll();
//        }
        
        $this->load->view('layout', $this->data);
        
    }
    
    function auth_edit() {
        $dataTables = array();
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $this->load->model(array('Acl_button_model'));
            $where = array();
            $groupCode = $this->uri->segment(3);
            
            $acl = $this->Acl_Model->getAclDataByRole($groupCode);
            $aclPrint = $this->Acl_button_model->getAclDataByRole($groupCode);
//            $aclStatusData = $this->Acl_status_data_model->getAclDataByRole($groupCode);
            //select group type
            $groupData = $this->Group_Model->getByCategory(array('TRIM(group_code)'=>$groupCode));
            if ($groupData) {
                $this->data['dataAcl'] = $this->_makeMenuTable($this->getAllMenuWeb('left'), $acl,$aclPrint);
            }
            $this->data['groupData'] = $groupData;
            $this->data['groupCode'] = $groupCode;
//            $this->view->topMenu = $this->_makeMenuTable($menuService->getTopMenu(), $acl);
        }
        
        $this->data['title'] = 'Hak Akses Group - Edit';
        $this->data['content'] = 'group/auth_edit';
        
//        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }
        
    private function _makeMenuTable($menus, $acl, $aclPrint,$level = 0) {
        
        $result = array();
        foreach ($menus as $item) {
            $line = array();
            $line['menu_name'] = '<div style="margin-left: ' . ($level*10) . 'px">' . $item['menu_name'] . '</div>';

            $check = '';
            $checkPrint = '';
            $checkStatusData = '';
            if (isset($acl['menu' . $item['id']])) {
                $check = 'checked="checked"';
            }
            if (isset($aclPrint['menu' . $item['id']])) {
                $checkPrint = 'checked="checked"';
            }
            
            $line['menu_check'] = '<input type="checkbox" class="flat-red" name="menuid[]" value="menu'. $item['id'] . '" ' . $check . '> <label>View</label>'
                    . '<input type="checkbox" class="flat-red" name="print[]" value="menu'. $item['id'] . '" ' . $checkPrint . '> <label>Print</label>';
//            $line['menu_check'] = '<div class="icheckbox_minimal-blue" style="position: relative;" aria-checked="false" aria-disabled="true">'
//                    . '<input type="checkbox" name="menuid[]" value="menu'. $item['id'] . '" ' . $check . ' class="minimal" style="position: absolute; opacity: 0;">'
//                    . '<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div>';

            $result[] = $line;

            if (isset($item['child'])) {
                $children = $this->_makeMenuTable($item['child'], $acl, $aclPrint,$level + 1);

                $result = array_merge($result, $children);
            }
        }
        return $result;
    }
    private function _makeMenuTableACU($acuData, $acu) {
        $level = 0;
        $result = array();
        foreach ($acuData as $item) {
            $line = array();
            $line['id_bse'] = '<div style="margin-left: ' . ($level*10) . 'px">' . $item['bse_name'] . '</div>';

            $check = '';
            if (isset($acu[$item['id_bse']])) {
                $check = 'checked="checked"';
            }
            
            $line['acu_check'] = '<input type="checkbox" name="id_bse[]" value="'. $item['id_bse'] . '" ' . $check . '>';
            $result[] = $line;
        }
        return $result;
    }
    
    private function _makeMenuTableACLButton($acuData, $acu) {
        $level = 0;
        $result = array();
        foreach ($acuData as $item) {
            $line = array();
            $line['button'] = '<div style="margin-left: ' . ($level*10) . 'px">' . $item . '</div>';

            $check = '';
            if (isset($acu[$item])) {
                $check = 'checked="checked"';
            }
            
            $line['aclb_check'] = '<input type="checkbox" name="button[]" value="'. $item . '" ' . $check . '>';
            $result[] = $line;
        }
        return $result;
    }
    
    function save_auth() {
	 if ($this->input->post('btncancel')) {
             redirect('group/auth');
             return;
        }
        $this->load->model(array('Acl_button_model'));
        $group = $this->input->post('group_code');
        $auth = $this->input->post('menuid');
        $print = $this->input->post('print');
        $data = array();
        foreach ($auth as $item) {
            $line = array('acl_resource'=>$item, 'acl_access'=>'*');
            $data[] = $line;
        }
        $this->Acl_Model->saveAcl($group, $data);
        $dataPrint = array();
        foreach ($print as $item) {
            $line = array('acl_resource'=>$item, 'acl_access'=>'*');
            $dataPrint[] = $line;
        }
        $this->Acl_button_model->saveAcl($group, $dataPrint);
        
        redirect('group/auth');
    }
    function save() {
        $new = true;
        if ($this->input->post('group_code') && $this->input->post('group_code') != '') { //edit
            $new = false;
            
        }
        $postData = $this->input->post();
        //check the group code first, if exist then update else insert
        $checkCode = $this->Group_Model->getByCategory(array('group_code'=>$postData['group_code']));
        if ($checkCode) {
            $this->Group_Model->update($postData);
        } else {
            $this->Group_Model->add($postData);
        }

        redirect('group/index');
    }
    
    //delete group table and update user table by group_code and delete acl
    function delete() {
        $this->load->model(array('Acl_Model','user_admin_model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach($data as $value) {
                //select into user_admin by group
                $dataUser = $this->user_admin_model->getByGroup($value["id"]);
                if ($dataUser) {
                    foreach($dataUser as $indexUser => $valueUser) {
                        $userGroup = explode(',',$valueUser['user_group']);
                        if ($key = array_search($value['id'],$userGroup)) {
                            unset($userGroup[$key]);
                            $userGroup = implode(',',$userGroup);
                            //update user_admin table
                            $this->user_admin_model->update(array('id'=>$valueUser["id"],'user_group'=>$userGroup));
                        }
                    }
                }
                $this->Acl_Model->delete($this->Acl_Model->_table,array('acl_role'=>$value["id"]));
                $this->Group_Model->delete($this->Group_Model->_table,array('group_code'=>$value["id"]));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
}