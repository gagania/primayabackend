<?php
class Order_model extends CI_Model {

    public $_table = 't_order';

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='like',$order = '') {
        return $this->getListData($limit, $offset, $where,$condition,$order);
    }
    
     function getByCategory($where = array()) {
        return $this->db->get_where($this->_table, $where)->result_array();
    }
    
    function getOrderData($limit = 10, $offset = 0, $where = array(), $condition = 'where', $order = 'a.id,DESC') {
        $this->db->select("a.*");
        $this->db->from("$this->_table as a");
        if ($order != '') {
            $order = explode(',', $order);
            if (sizeof($order) > 1) {
                $this->db->order_by($order[0], $order[1]);
            } else if (sizeof($order) == 1) {
                $this->db->order_by('a.id', $order[0]);
            }
        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        if ($where && sizeof($where) > 0) {
            foreach ($where as $key => $value) {
                if ($value == '') {
                    $this->db->$condition($key);
                } else {
                    $this->db->$condition($key, $value, 'after');
                }
            }
        }

        $query = $this->db->get()->result_array();
//            echo $this->db->last_query();exit;
        return $query;
    }
    
    function getOrderResultData($limit = 10, $offset = 0, $where = array(), $condition = 'where', $order = 'a.id,ASC') {
        $this->db->select("a.order_reg_nmbr,a.result_e,a.result_rdrp,a.result_n,a.order_sample_date,order_schd_date,"
                . "user.user_name,user.user_birthdate,user.user_email,user.user_gndr,"
                . "user.user_idnt,user.user_addr,prdc.prdc_name,lctn.lctn_name,lctn.lctn_code,ctgr.ctgr_name,"
                . "schd.schd_desc,schd.schd_time_from,schd.schd_time_to");
        $this->db->from("$this->_table as a");
        $this->db->join("t_user user","user.id=a.order_user_id");
        $this->db->join("m_product prdc","prdc.id=a.order_prdc_id");
        $this->db->join("m_category ctgr","ctgr.id=prdc.prdc_ctgr_id");
        $this->db->join("m_location lctn","lctn.id=a.order_lctn_id");
        $this->db->join("m_schedule schd","schd.id=a.order_schd_id");
        if ($order != '') {
            $order = explode(',', $order);
            if (sizeof($order) > 1) {
                $this->db->order_by($order[0], $order[1]);
            } else if (sizeof($order) == 1) {
                $this->db->order_by('a.id', $order[0]);
            }
        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        if ($where && sizeof($where) > 0) {
            foreach ($where as $key => $value) {
                if ($value == '') {
                    $this->db->$condition($key);
                } else {
                    $this->db->$condition($key, $value, 'after');
                }
            }
        }

        $query = $this->db->get()->result_array();
//            echo $this->db->last_query();exit;
        return $query;
    }
    
    function add($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    function update($data) {
        $this->db->where(array('id'=>$data['id']));
        $this->db->update($this->_table, $data);
    }
    
    function getForExportData($limit = 10, $offset = 0, $where = array(), $condition = 'where', $order = 'a.id,ASC') {
        $this->db->select("a.order_sample_date,a.order_sample_nmbr,user.user_name,"
                . "user.user_birthdate,user.user_addr,user.user_idnt,user.user_gndr,user.user_telp,lctn.lctn_name");
        $this->db->from("$this->_table as a");
        $this->db->join("t_user user","user.id=a.order_user_id");
        $this->db->join("m_location lctn","lctn.id=a.order_lctn_id");
        if ($order != '') {
            $order = explode(',', $order);
            if (sizeof($order) > 1) {
                $this->db->order_by($order[0], $order[1]);
            } else if (sizeof($order) == 1) {
                $this->db->order_by('a.id', $order[0]);
            }
        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        if ($where && sizeof($where) > 0) {
            foreach ($where as $key => $value) {
                if ($value == '') {
                    $this->db->$condition($key);
                } else {
                    $this->db->$condition($key, $value, 'after');
                }
            }
        }

        $query = $this->db->get()->result_array();
//            echo $this->db->last_query();exit;
        return $query;
    }
    
}