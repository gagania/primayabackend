<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('user_admin_model', 'Acl_Model'));
        $this->data['themes'] = $this->config->item('themes');
    }

    function index() {
        if (isset($this->session->userdata['login'])) {
            redirect('index/index');
        } else {
            $this->load->view('login', $this->data);
        }
    }

    function process_login() {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $input = array('user_id' => $username);
        $newLogin = true;
        $result = array();
//        $checkSession = $this->user_admin_model->getByCategory(array('user_id' => $username));
        $result['success'] = false;
        $result['reset'] = false;

        if ($newLogin) {
            $data = $this->user_admin_model->check_user($input);
            if ($data) {
                if ($data['user_status'] == 'N') {
                    $result['reset'] = true;
                } else if ($data['user_status'] == 'Y') {
                    if ($data['attempt'] > 5) {
                        $this->user_admin_model->update(array('id' => $data['id'], 'user_status' =>'N'));
                        $result['reset'] = true;
                    } else {
                        if (password_verify($password, $data['user_pass'])) {
                            $this->load->model(array('Group_Model'));
                            $result['success'] = true;

                            $isAdmin = false;
    //                    $this->load->model(array('Group_admin_model'));
    //                    $groupAdmin = $this->Group_admin_model->getByCategory(array('group_code' => $data['user_group']));

                            $groupCodes = explode(",", $data['user_group']);
                            if (in_array('00', $groupCodes) || in_array('01', $groupCodes) || in_array('02', $groupCodes)) {
                                $isAdmin = true;
                            }

                            $input_session = array('user_id' => $data['user_id'], 
                                        'user_name' => $data['user_name'], 'login' => TRUE, 
                                        'user_group' => $data['user_group'],
                                        'is_new' => $data['is_new'], 'is_admin' => $isAdmin, 
                                        'user_email'=>$data['user_email']);
                            //update logins status
                            $this->user_admin_model->updateSession(array('user_id' => $data['user_id'], 'user_lastlogin' => date('Y-m-d H:i:s')
                                , 'user_sessionid' => session_id(),'attempt'=>0));
                            $this->session->set_userdata($input_session);
                        } else {
                            $data['attempt'] = $data['attempt'] + 1;
                            $this->user_admin_model->update(array('id' => $data['id'], 'attempt' =>$data['attempt']));
                            $result['success'] = false;
                        }
                    }
                }
            } else {
                $result['success'] = false;
            }
        }
        header("Content-type: application/json");
        print json_encode($result);
        exit;
    }

    function logout() {
        $this->user_admin_model->updateSession(array('user_id' => $this->session->userdata('user_id'), 'user_lastlogout' => date('Y-m-d H:i:s'), 'user_sessionid' => ''));
        $this->session->sess_destroy();
        redirect('/');
    }

}
