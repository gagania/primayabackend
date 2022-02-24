<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('UTC'); 
        $this->load->helper('url');
        $this->load->model(array('Menu_Model'));
    }
    
    function index(){
        $this->data['title'] = 'Dashboard';
        $this->data['content'] = 'index/index';
        $menus = $this->Menu_Model->getHeaderMenu();
        foreach($menus as $index => $value) {
            if ($value['id'] == 1) {
                unset($menus[$index]);
                continue;
            }
            $childMenu = $this->Menu_Model->getMenus($value['id']);
            if (sizeof($childMenu) > 0) {
                $menus[$index]['menu_link'] = $childMenu[0]['menu_link'];
            }
            //check acl
            $acl = $this->Acl_Model->getByCategory(array('acl_role'=>$this->session->userdata('user_group'),'acl_resource'=>'menu'.$value['id']));
            if (sizeof($acl) == 0) {
                $menus[$index]['menu_link'] = '';
            }
        }
        $this->data['menusIndex'] = $menus;
        $this->data['new_user'] = $this->session->userdata('is_new');
        $this->load->view('layout', $this->data);
        
    }
}
