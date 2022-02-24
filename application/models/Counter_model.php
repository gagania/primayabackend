<?php
class Counter_model extends CI_Model {

    public $_table = 's_counter';
    private static $counterList = array();

    function runRegNumber($lctnCode,$period,$ctgr) {
        $period = str_replace("-","",$period);
        if ($period != '') { // will generate counter in all month in $year
            $line = $this->getCounterNumber($period, $lctnCode.$ctgr);
            if ($line) {
                //throw new Exception('cost center already exists for branch');
                /* Already exists for specified year */
                return;
            }
            $data = array();
            $data['cntr_period'] = $period;
            $data['cntr_cntr_code'] = $lctnCode.$ctgr;

            $this->db->insert($this->_table, $data);
            
        }
//        else {
//            for ($i=1;$i<=12;$i++) { // loop aall month number in a year
//                if (strlen($i) < 2) {
//                    $period = '0'.$i.$year;
//                } else {
//                    $period = $i.$year;
//                }
//                $line = $this->getCounterNumber('', $period, self::JVLYN);
//                if ($line) {
//                    //throw new Exception('cost center already exists for branch');
//                    /* Already exists for specified year */
//                    continue;
//                }
//                $data = array();
//                $data['cntr_period'] = $period;
//                $data['cntr_cntr_code'] = self::JVLYN;
//                $this->db->insert($data);
//            }
//        }
    }
    
    function getCounterNumber($period='', $code='') {
//        $where = array();
//        $where['cntr_period'] = $period;
//        $where['cntr_cntr_code'] = $code;
        $sql = "SELECT * FROM $this->_table WHERE cntr_period = ? AND cntr_cntr_code = ?";
        $query =  $this->db->query($sql, [$period, $code]);
        return $query->result_array();
//        return $this->db->table($this->table)->where($where);
    }
    
    public function getRegNumber($lctnCode,$period = '',$ctgr = '') {
        $period = str_replace("-","",$period);
        $ctgr = strtoupper($ctgr);
        //create counter first
        $this->runRegNumber($lctnCode,$period, $ctgr);
        $key = "$ctgr$period";
        
        if (!isset(self::$counterList[$key])) {
            $data = $this->getCounterNumber($period,$lctnCode.$ctgr);
            if (!$data) {
                return;
                
            }
            self::$counterList[$key] = $data[0];
        }

        $data = self::$counterList[$key];
        $data['cntr_cntr'] = $data['cntr_cntr'] + 1;

        self::$counterList[$key] = $data;
        $this->setCounterValue($data['id'], $data['cntr_cntr']);
        $num = str_pad($data['cntr_cntr'], 4, '0', STR_PAD_LEFT);

        $noReg = $lctnCode.$ctgr.$period.$num;
        return array('regnmbr'=>$noReg);
    }
    
    function setCounterValue($id, $value) {
        $data = array();
        $data['cntr_cntr'] = $value;
//        $this->db->where(array('id'=>$id));
//        $this->db->update($id, $data);
        
        $this->db->where(array('id' => $id));
        $this->db->update($this->_table, $data);
    }
    
    function reverseCounterValue() {
        $year = substr(date('Y'), 2);
        $month = date('m');
        $this->db->query('UPDATE '.$this->_table.' set cntr_cntr = cntr_cntr-1 WHERE cntr_period =  "'.$month.$year.'" and cntr_cntr_code = "'.self::SO.'"');
    }
    
    function checkCounter() {
        $year = substr(date('Y'), 2);
        $month = date('m');
        
        return $this->getCounterNumber('', $month.$year, self::SO);
    }
}