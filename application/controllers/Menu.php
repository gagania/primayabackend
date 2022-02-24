<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('Menu_Model'));
    }

    function index(){
            
        $this->data['title'] = 'Master Data - Menu';
        $this->data['content'] = 'menu/index';
        
        $this->data['dataList'] = $this->Menu_Model->getData($this->_limit,'',array(),'where');
        $this->data['totaldata'] = sizeof($this->Menu_Model->getAll());
        $this->data['pnumber'] = 1;
        
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
                $limit = $totaldata-$this->_limit;
                $page = $this->_limit;
                $pnumber = ceil($totaldata/10);
            } else if ($paging == 'next') {
                $page += $this->_limit;
                $limit = $page;
                $pnumber = $pnumber+1;
            } else if ($paging == 'prev') {
                if ($limit > 0) {
                    $page -= $this->_limit;
                }
                $limit = $page;
                if ($pnumber > 1) {
                    $pnumber = $pnumber-1;
                }
            } else {
                $limit = $totaldata;
            }
        } else if ($paging == 'page') {
            if ($pnumber > 0){
                $limit = (($this->_limit*$pnumber) - $this->_limit);
            } else if ($pnumber == 0){
                $limit = 0;
            }
        }  
        
        if ($searhDesc) {
            $searchDetail = explode(",",$fields);
            foreach($searchDetail as $valDetail){
                $whereSearch[$valDetail] = $searhDesc;
            }
        }
        
        $totalData = $this->Menu_Model->getData(0,$limit,$whereSearch,'or_like');
        $result = $this->Menu_Model->getData($this->_limit,$limit,$whereSearch,'or_like');
        
        $newData = '';
        if ($result) {
            $newData .= $this->searchTemplate($result);
        }
        
        $jsonData['result'] = 'success';
        $jsonData['pnumber'] = $pnumber;
        $jsonData['limit'] = $limit;
        $jsonData['totaldata'] = sizeof($totalData);
        $jsonData['template'] = $newData;
        echo json_encode($jsonData,true);
    }
    
    function searchTemplate($data) {
        $template = '';
        foreach($data as $index => $value) {
            $parentName = '';
            foreach ($data as $keyParent => $valueParent) {
                if($value['menu_parent'] == $valueParent['id']){
                    $parentName = $valueParent['menu_name'];
                }
            }
            $modulName = '';
            if($value['menu_modul'] == 'lg'){
                $modulName = 'Ledger';
            }elseif ($value['menu_modul'] == 'tt') {
                $modulName = 'Penerimaan';
            }elseif ($value['menu_modul'] == 'tk') {
                $modulName = 'Pengeluaran';
            }elseif ($value['menu_modul'] == 'ra') {
                $modulName = 'Rencana Anggaran';
            } 
            $template .= '<tr class="odd gradeX">
                                <td><input type="checkbox" class="delcheck" value="'.$value['id'].'" /></td>
                                <td><a href="#" onclick="javascript:add_menu(\''.base_url().'\', \''.$value['id'].'\');">'.$value['menu_name'].'</a></td>
                                <td>'.$parentName.'</td>
                                <td>'.$modulName.'</td>
                                <td>'.(($value['menu_active'] == 'Y') ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Not Active</span>').'</td>
                            </tr>';

        }
        return $template;
    }
    
    /* add menu*/
    function add() {
        $dataTables = array();
        $menuParent = '';
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->Menu_Model->getByCategory($where);
            $menuParent = $dataTables[0]['menu_parent'];
            $this->data['title'] = 'Ubah - Menu';
        } else {
            $this->data['title'] = 'Tambah - Menu';
        }
        
        if ($this->session->userdata('user_group') == '00') {
            $menuList = array_merge($this->getAllMenuWeb(''));
        } else {
            $menuList = $this->getAllMenuWeb('left','backend', 'menu_order asc');
        }
        
        if ($this->session->userdata('user_group') == '00') {
//            $this->data['menuType'] = $this->menuType;
        } 
        $this->data['menuCtgr'] = $this->menuCtgr;
        $this->data['menuCode'] = $this->menuCode;
        $this->data['menuList'] = '<select class="select-search" id="menu_parent" name="menu_parent"><option value="">--PILIH SATU--</option>'.$this->menuSelect($menuList, $menuParent).'</select>';
        $this->data['content'] = 'menu/add';
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }
    
    
    
    function save() {
        if ($this->input->post('btncancel')) {
             redirect('menu/index');
             return;
        }
        $postData = array();
        $new = true;
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
            
        }
        $postData = $this->input->post();
        if (!isset($postData['menu_active'])) {
            $postData['menu_active'] = 'N';
        }
        
        if (!isset($postData['is_static'])) {
            $postData['is_static'] = 'N';
        }
        
        if ($this->input->post('id')) {
            $postData['id'] = trim($this->input->post('id'));
        }
        
        if ($postData['menu_code'] == 'default') {
            $postData['menu_alias'] = trim(preg_replace('/[^A-Za-z0-9\-]/', '_', strtolower($postData['menu_name'])));
            if ($postData['menu_parent'] == '') {
                $postData['menu_link'] = 'main/index/'.$postData['menu_alias'];
            }
        } else {
            $postData['menu_alias'] = '';
        }
        
        if ($new) { // add
            $id = $this->Menu_Model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            
            $this->Menu_Model->update($postData);
        }
        
        redirect('menu/index');
    }
    
    /*deleting menus and also deleting ACL by menu id*/
    function delete() {
        $this->load->model(array('Acl_Model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach($data as $value) {
                $this->Menu_Model->delete($this->Menu_Model->_table,array('id'=>$value['id']));
                $this->Acl_Model->delete($this->Acl_Model->_table,array('acl_resource'=>'menu'.$value['id']));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = '';
        }
        echo json_encode($result);
    }
    
    function menuSelect($data, $select = '', $margin=0) {
        if ($data) {
            $selectMenu = '';
            $selected = '';
            foreach($data as $index => $item) {
                if ($item['menu_parent'] == 0) {
                    $margin = 0;
                    
                }
                if ($select == $item['id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }
                
                $selectMenu .= '<option value="'.$item['id'].'" '.$selected.'>'.$item['menu_name'].'</option>';
                if (isset($item['child'])) {
                    $margin += 10;
                    $selectMenu .= $this->menuSelect($item['child'], $select,  $margin);
                    $margin -= 10;
                } 
            }
        }
        
        return $selectMenu;
    }
}