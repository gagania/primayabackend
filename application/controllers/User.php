<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('user_model'));
    }

    function index() {

        $this->data['title'] = 'User';
        $this->data['content'] = 'user/index';
        $this->data['dataList'] = $this->user_model->getData('');
        $this->load->view('layout', $this->data);
    }

    function paging() {
        $whereSearch = array();
        $pnumber = ($this->input->post('pnum')) ? $this->input->post('pnum') : 0;
        $paging = strtolower($this->input->post('page'));
        $limit = $this->input->post('limit');
        $totaldata = $this->input->post('totaldata');
        $searhDesc = $this->input->post('search');
        $fields = $this->input->post('fields');
        $page = $limit;
        if ($paging && $paging != 'page') {
            if ($paging == 'first') {
                $limit = 0;
                $page = $this->_limit;
                $pnumber = 1;
            } else if ($paging == 'last') {
                $limit = $totaldata - $this->_limit;
                $page = $this->_limit;
                $pnumber = round($totaldata / $this->_limit);
            } else if ($paging == 'next') {
                $page += $this->_limit;
                $limit = $page;
                $pnumber = $pnumber + 1;
            } else if ($paging == 'prev') {
                if ($limit > 0) {
                    $page -= $this->_limit;
                }
                $limit = $page;
                if ($pnumber > 1) {
                    $pnumber = $pnumber - 1;
                }
            } else {
                $limit = $totaldata;
            }
        } else if ($paging == 'page') {
            if ($pnumber > 0) {
                $limit = (($this->_limit * $pnumber) - $this->_limit);
            } else if ($pnumber == 0) {
                $limit = 0;
            }
        }

        if ($searhDesc) {
            $searchDetail = explode(",", $fields);
            foreach ($searchDetail as $valDetail) {
                $whereSearch[$valDetail] = $searhDesc;
            }
        }

        $totalData = $this->user_model->getData(0, $limit, $whereSearch, 'or_like');
        $result = $this->user_model->getData($this->_limit, $limit, $whereSearch, 'or_like');

        $newData = '';
        if ($result) {
            $newData .= $this->searchTemplate($result);
        }

        $jsonData['result'] = 'success';
        $jsonData['pnumber'] = $pnumber;
        $jsonData['limit'] = $limit;
        $jsonData['totaldata'] = sizeof($totalData);
        $jsonData['template'] = $newData;
        echo json_encode($jsonData, true);
    }

    function searchTemplate($data) {
        $template = '';
        foreach ($data as $index => $value) {
            $template .= '<tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="' . $value['id'] . '" /></td>
                                <td><a href="#" onclick="javascript:add_users(\'' . base_url() . '\', \'' . $value['id'] . '\');">' . $value['user_name'] . '</a></td>
                                <td>' . (isset($value['user_real_name']) ? $value['user_real_name'] : '') . '</td>
                            </tr>';
        }
        return $template;
    }

    function add() {
        $this->load->model(array('Group_Model'));
        $dataTables = array();
        $whereGroup = array();
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->user_model->getByCategory($where);
            $this->data['title'] = 'Ubah - Pengguna';
        } else {
            $this->data['title'] = 'Tambah - Pengguna';
        }

        $this->data['content'] = 'user/add';
//        $whereGroup['group_level >='] = $this->session->userdata('group_level');
        $this->data['groupData'] = $this->Group_Model->getByCategory($whereGroup);
        $this->data['gender'] = $this->gender;
        /* end check group */
//        print_r($dataTables);exit;
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }

    public function save() {
        if ($this->input->post('btncancel')) {
            redirect('user/index');
            return;
        }

        $postData = array();
        $new = true;
        $success = true;
        $message = 'Data berhasil tersimpan';
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }
        $postData = $this->input->post();
        $postData['user_group'] = implode(',',$postData['user_group']);    
        if ($postData['user_pass'] == '') {
            unset($postData['user_pass']);
        } else {
            $options = array('cost' => 11);
            $postData['user_pass'] = password_hash((string) $postData['user_pass'], PASSWORD_BCRYPT, $options);
        }
        unset($postData['user_pass_retype']);
        
        if (!$postData['user_status']) {
            $postData['user_status'] = 'N';
        } else if ($postData['user_status'] == 'Y') {
            $postData['attempt'] = 0;
        }
        
        if ($new) { // add
            $id = $this->user_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $postData['id'] = trim($this->input->post('id'));
            $this->user_model->update($postData);
        }

        redirect('user/index');
    }

    function delete() {
        $this->load->model(array('Acl_Model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $value) {
                $dataUser = $this->user_model->check_user(array('id' => $value['id']));
                if ($dataUser) {
                    $this->user_model->delete($this->user_model->_table, array('id' => $value['id']));
                }
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }

    public function change_password() {
        $options = array('cost' => 11);
        $newPassword = $this->input->post('user_pass');
        $updateData['user_id'] = $this->session->userdata('user_id');
        $updateData['is_new'] = 0;
        $updateData['user_pass'] = password_hash((string) $newPassword, PASSWORD_BCRYPT, $options);
        $update_password = $this->user_model->updateSession($updateData);

        //force to login
        $result['message'] = 'success';

        header("Content-type: application/json");
        echo json_encode($result);
    }

    function upload() {
        $this->load->model(array('user_model'));
        $fileName = $_FILES['csvdata']['tmp_name'];
        $fh = fopen($fileName, "r");
        $amount = 0;
        $messages = array();
        $start = true;

        while (($fields = fgetcsv($fh, 0))) {
            $new = true;

            //$fields = explode('|', $rows[$i]);
            if ($start) {
                $start = false;
                continue;
            }

            $amount++;
            $saveData = array();

            $saveData['id'] = null;
            $saveData['user_id'] = strtoupper(trim($fields[0]));
            $saveData['user_name'] = strtoupper(trim($fields[1]));
            $saveData['user_unit_name'] = strtoupper(trim($fields[2]));
            $saveData['user_jbtn_code'] = strtoupper(trim($fields[3]));
            $saveData['user_jbtn_name'] = strtoupper(trim($fields[4]));
            $saveData['user_pass'] = trim($fields[5]);

            
            $checkData = $this->user_model->getByCategory(array('user_name' => $saveData['user_name']));
            if ($checkData) { //update
                $saveData['id'] = $checkData[0]->id;
                $new = false;
            }
            try {
                if ($new) {
                    $saveData['user_group'] = '03';
                    $this->user_model->add($saveData);
                } else {
                    $this->user_model->update($saveData);
                }
            } catch (Exception $e) {
                $messages[] = array('id' => $amount, 'description' => $e->getMessage());
            }
        }

        redirect('user/index');
    }

}