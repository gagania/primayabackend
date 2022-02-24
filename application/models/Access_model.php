<?php
class Access_model extends CI_Model{  
    public $_table = 't_access';
    function __construct(){
        parent::__construct();    
    }
    
    function getAll() {
        $query = $this->db->query('SELECT * FROM '.$this->_table);
        $resultQuery = $query->result_array();
          
        return $resultQuery;
    }
    
    function getData($limit=10, $offset = 0, $where=array(),$condition='where') {
        return $this->getListData($limit, $offset, $where,$condition);
    }
    
    function getByCategory($where = array()) {
        return $this->db->get_where($this->_table, $where)->result();
    }
    
    function add($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    function update($data) {
        $this->db->where(array('id'=>$data['id']));
        $this->db->update($this->_table, $data);
    }    
    
    function getAccess($limit=10, $offset = 0, $where=array(),$condition='like',$order='id,ASC') {
        $this->db->select("a.*,b.ctgr_name");
        $this->db->from("$this->_table as a");
        $this->db->join("m_category b",'b.id=a.ctgr_id');
        if ($order != '') {
            $order = explode(',',$order);
            if(sizeof($order) > 1) {
                $this->db->order_by($order[0],$order[1]);
            } else if(sizeof($order) == 1){
                $this->db->order_by('id',$order[0]);
            }

        }
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        if ($where && sizeof($where) > 0) {
            foreach($where as $key => $value) {
                if ($value == '') {
                    $this->db->$condition($key);
                } else {
                    $this->db->$condition($key, $value,'after');
                }
            }
        }

        $query = $this->db->get()->result_array();
//            echo $this->db->last_query();exit;
        return $query;
    }
}