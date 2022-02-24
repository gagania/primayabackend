<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('UTC');
        $this->load->helper('url');
        $this->load->model(array('user_admin_model'));
    }

    function index() {

        $this->data['title'] = 'Profile';
        $this->data['content'] = 'user_admin/profile';

        $id = $this->session->userdata('user_id');
        $this->data['dataRow'] = $this->user_admin_model->getByCategory(array('user_id'=>$id));

        $this->load->view('layout', $this->data);
    }

    public function save() {
        if ($this->input->post('btncancel')) {
            redirect('profile/index');
            return;
        }

        $new = true;
        $success = true;
        $message = 'Data berhasil tersimpan';
        if ($this->input->post('id') && $this->input->post('id') != '') { //edit
            $new = false;
        }
        $postData = $this->input->post();
        if ($postData['user_pass'] == '') {
            unset($postData['user_pass']);
        } else {
            $options = array('cost' => 11);
            $postData['user_pass'] = password_hash((string) $postData['user_pass'], PASSWORD_BCRYPT, $options);
        }
        unset($postData['user_pass_retype']);
        
        if (isset($postData['user_image'])) {
            $userImagePaths = $postData['user_image'];
            unset($postData['user_image']);
        }
        
        $this->load->library('upload');
        //verification file
        if (isset($_FILES['user_image_file'])) {
            $dataImage = array();
            if ($_FILES['user_image_file']['name'] != '') {
                $ext = pathinfo($_FILES['user_image_file']['name'], PATHINFO_EXTENSION);
                if ($ext != '' && ($ext == 'png' ||$ext == 'jpg'||$ext == 'jpeg'
                        ||$ext == 'JPEG' ||$ext == 'JPG' ||$ext == 'PNG')) {
                    $userImageName = $_FILES['user_image_file']['name'];                
                    $_FILES['userfile']['name'] = $_FILES['user_image_file']['name'];
                    $_FILES['userfile']['type'] = $_FILES['user_image_file']['type'];
                    $_FILES['userfile']['tmp_name'] = $_FILES['user_image_file']['tmp_name'];
                    $_FILES['userfile']['error'] = $_FILES['user_image_file']['error'];
                    $_FILES['userfile']['size'] = $_FILES['user_image_file']['size'];

                    if (!file_exists('./uploaded_file/user/'.$this->session->userdata('user_id').'/profile')) {
                        mkdir('./uploaded_file/user/'.$this->session->userdata('user_id').'/profile', 0777, true);
                    }
                    $pathFile = 'uploaded_file/user/'.$this->session->userdata('user_id').'/profile';
                    $this->upload->initialize($this->set_upload_options($userImageName, $pathFile));
    //                $this->upload->data(); 

                    if (!$this->upload->do_upload()) {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                    } else {
                        $dataImage = $this->upload->data();
                    }
                }
            }

            if (sizeof($dataImage) > 0) {
                $postData['user_image'] = $pathFile . '/' . $dataImage['file_name'];
                $this->session->unset_userdata('user_image');
                $this->session->set_userdata(array('user_image'=>$postData['user_image']));
            } else {
                $postData['user_image'] = isset($userImagePaths) ? $userImagePaths :'';
            }
            
            unset($postData['user_image_file']);
        }
        if ($new) { // add
            $id = $this->user_admin_model->add($postData);
            if (!$id) {
                $success = false;
                $message = 'Data gagal tersimpan';
            }
        } else {
            $postData['id'] = trim($this->input->post('id'));
            $this->user_admin_model->update($postData);
        }

        redirect('profile/index');
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
        $this->load->model(array('Acl_Model'));
        $data = $this->input->post('dataDelete');
        $result = array();
        if (sizeof($data) > 0) {
            foreach ($data as $value) {
                $dataUser = $this->user_admin_model->check_user(array('id' => $value['id']));
                if ($dataUser) {
                    $this->user_admin_model->delete($this->user_admin_model->_table, array('id' => $value['id']));
                    /* if ($dataUser['user_group'] != '') {
                      $group = explode(',', $dataUser['user_group']);
                      foreach ($group as &$value){
                      $value = trim($value);
                      $this->Acl_Model->delete($this->Acl_Model->_table,array('acl_role'=>$value));
                      }
                      } */
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
        $update_password = $this->user_admin_model->updateSession($updateData);

        //force to login
        $result['message'] = 'success';

        header("Content-type: application/json");
        echo json_encode($result);
    }
}