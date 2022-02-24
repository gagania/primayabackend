<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

    public function __construct() {
        parent::__construct();
//        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('Product_model','Category_model'));
    }

    function index() {
        $where = array();
        $title = '';
        
        $this->data['dataList'] = $this->Product_model->getProducts('', 0, $where, 'where', 'prdc_name,ASC');
        $this->data['totaldata'] = sizeof($this->Product_model->getProducts('', 0, $where, 'where', 'prdc_name,ASC'));
        $this->data['title'] = $title;
        $this->data['content'] = 'product/index';
        $this->load->view('layout', $this->data);
    }

    function add() {
        $dataTables = array();
        if ($this->uri->segment(3)) { //edited
            //get data from database by id
            $where = array();
            $where['id ='] = $this->uri->segment(3);
            $dataTables = $this->Product_model->getByCategory($where);
            $this->data['title'] = 'Edit - Product';
        } else {
            $this->data['title'] = 'Add - Product';
        }

        $this->data['category'] = $this->Category_model->getData();
        $this->data['content'] = 'product/add';
        $this->data['dataRow'] = $dataTables;
        $this->load->view('layout', $this->data);
    }

    function get_categories() {
        $menuId = $this->input->post('menuid');
        $categoryData = $this->Category_model->getData('', '', array('ctgr_menu_id' => $menuId));
        $temp = '';
        if (sizeof($categoryData) > 0) {
            foreach ($categoryData as $index => $value) {
                $temp .= $this->category_list($value, true);
            }
        }
        $result['htmldata'] = $temp;
        echo json_encode($result);
    }

    function category_list($ctgrData = array(), $html = false) {
        $temp = '<tr>'
                . '<td><div class="col-md-4"><input id="ctgr_name[]" name="ctgr_name[]" required="required" class="form-control" type="text" value="' . (isset($ctgrData['ctgr_name']) ? $ctgrData['ctgr_name'] : '') . '"/></div>'
                . '<td><img src="' . base_url() . 'assets/themes/dist/images/delete.gif" onclick="javascript:delitems(this);"/></td>'
                . '</tr>';
        if ($html) {
            return $temp;
        } else {
            $data['htmldata'] = $temp;
            echo json_encode($data);
        }
    }

    function save() {
        if ($this->input->post('btncancel')) {
            redirect('product/index');
            return;
        }
        $new = true;
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }
        $postData = $this->input->post();
        if (isset($postData['prdc_locations'])) {
            $postData['prdc_locations'] = json_encode($postData['prdc_locations']);
        }

        if ($new) { // add
            $id = $this->Product_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $id = $postData['id'] = trim($this->input->post('id'));
            $this->Product_model->update($postData);
        }

        redirect('product');
    }

    function set_upload_options($file_name, $pathFile) {
        //  upload an image and document options

        $config = array();
        $config['file_name'] = $file_name;
        $config['upload_path'] = './' . $pathFile;
        $config['allowed_types'] = '*';
        $config['max_size'] = '0'; // 0 = no file size limit
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = TRUE;

        return $config;
    }

    function delete() {
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            $mainData = $this->Product_model->getByCategory(array('id' => $data[0]['id']));
            $menu_alias = $mainData[0]['menu_alias'];
            $ctgrId = $mainData[0]['ctgr_id'];
            foreach ($data as $value) {

                $this->Product_model->delete($this->Product_model->_table, array('id' => $value['id']));
            }
            $result['success'] = true;
            $result['message'] = 'Data Berhasil di hapus';
            $result['url'] = 'index/' . $menu_alias . '/' . $ctgrId;
        }
        echo json_encode($result);
    }

    function get_data() {
        $id = $this->input->post('id');
        //get header data
        $headerData = $this->Category_model->getData($this->_limit, '', array('id' => $id));
        $result['header'] = $headerData;
        echo json_encode($result, true);
        exit;
    }


    function menuSelect($data, $select = '', $margin = 0) {
        if ($data) {
            $selectMenu = '';
            $selected = '';
            foreach ($data as $index => $item) {
                if (isset($item['child'])) {
                    continue;
                }
                if ($item['menu_parent'] == 0) {
                    $margin = 0;
                }
                if ($select == $item['id']) {
                    $selected = 'selected=selected';
                } else {
                    $selected = '';
                }

                $selectMenu .= '<option value="' . $item['id'] . '" ' . $selected . ' style="margin-left:' . $margin . 'px;">' . $item['menu_name'] . '</option>';
                if (isset($item['child'])) {
                    $margin += 10;
                    $selectMenu .= $this->menuSelect($item['child'], $select, $margin);
                    $margin -= 10;
                }
            }
        }

        return $selectMenu;
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
        $totalData = $this->Category_model->getData(0, $limit, $whereSearch, 'or_like');
        $result = $this->Category_model->getData($this->_limit, $limit, $whereSearch, 'or_like');

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
                                <td><a href="#modal_category" class="edit_category" data-toggle="modal" data-id="' . $value['id'] . '">' . $value['ctgr_name'] . '</a></td>
                            </tr>';
        }
        return $template;
    }
}
