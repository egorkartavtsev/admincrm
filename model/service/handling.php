<?php

class ModelServiceHandling extends Model {
    public function createAccident($acc){
        $sql = "INSERT INTO ".DB_PREFIX."accidents SET ";
        foreach ($acc as $key => $value) {
            if($key!='date' && $key!='dateprot' && $key!='datedecree' && $key!='dateref' && $key!='datespec' && $key!='causer_ins_date'){
                $sql.= $key." = '".$value."', ";
            }
        }
        $sql.= "date = '".date("Y-m-d H:i:s", strtotime($acc['date']))."', ";
        $sql.= "dateprot = '".date("Y-m-d", strtotime($acc['dateprot']))."', ";
        $sql.= "datedecree = '".date("Y-m-d", strtotime($acc['datedecree']))."', ";
        $sql.= "dateref = '".date("Y-m-d", strtotime($acc['dateref']))."', ";
        $sql.= "datespec = '".date("Y-m-d", strtotime($acc['datespec']))."', ";
        $sql.= "causer_ins_date = '".date("Y-m-d H:i:s", strtotime($acc['causer_ins_date']))."' ";
        $this->db->query($sql);
        $id = $this->db->getLastId();
        return $id;
    }
    
    public function createHandling($handling) {
        $sql = "INSERT INTO ".DB_PREFIX."handling SET ";
        foreach ($handling as $key => $value) {
            $sql.= $key." = '".$value."', ";
        }
        $sql.= "date = NOW(), handl_name = '".(int)rand(10000, 99999)."'";
        $this->db->query($sql);
        return $this->db->getLastId();
    }
    
    public function getHandlingInfo($handl) {
        $result = [];
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."handling WHERE id = ".(int)$handl);
        $result['info'] = $sup->row;
        $sup = $this->db->query(
                "SELECT "
                . "c.id, c.contn, c.note, c.date, "
                . "cs.contract_status_name AS cont_stat, cs.contract_label AS cont_stat_class, "
                . "cps.contract_payment_status_name AS payment_stat, cps.contract_payment_label AS payment_stat_class, "
                . "lfa.name AS agent, lfh.name AS handl_type, lfs.name AS serv_type "
                . "FROM ".DB_PREFIX."contract c "
                . "LEFT JOIN ".DB_PREFIX."handling_library_agent lfa ON c.agent = lfa.agent_id "
                . "LEFT JOIN ".DB_PREFIX."handling_library_type lfh ON c.handl_type = lfh.ht_id "
                . "LEFT JOIN ".DB_PREFIX."handling_library_service lfs ON c.serv_type = lfs.service_id "
                . "LEFT JOIN ".DB_PREFIX."contract_status cs ON c.cont_stat = cs.contract_status_id "
                . "LEFT JOIN ".DB_PREFIX."contract_payment_status cps ON c.payment_stat = cps.contract_payment_status_id "
                . "WHERE handling = ".(int)$handl." ORDER BY c.date DESC "
        );
        $result['services'] = $sup->rows;
        return $result;
    }
    public function getAccidentInfo($acc) {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."accidents WHERE id = ".(int)$acc);
        return $sup->row;
    }
    
    public function createContract($contr) {
        $tmp = $this->db->query("select handl_name from ".DB_PREFIX."handling WHERE id = ".(int)$contr['handling']);
        $contr['contn'] = $tmp->row['handl_name'].'-AG-'.(int)rand(100, 999);
        $contr['cont_stat'] = 3;
        $contr['payment_stat'] = 3;
        $sql = "insert into ".DB_PREFIX."contract SET date = NOW()";
        foreach ($contr as $key => $value) {
            $sql.= ", ".$key." = '".$value."'";
        }
        $this->db->query($sql);
        return $this->db->query(
                "SELECT "
                . "c.id, c.contn, c.note, c.date, "
                . "cs.contract_status_name AS cont_stat, cs.contract_label AS cont_stat_class, "
                . "cps.contract_payment_status_name AS payment_stat, cps.contract_payment_label AS payment_stat_class, "
                . "lfa.name AS agent, lfh.name AS handl_type, lfs.name AS serv_type "
                . "FROM ".DB_PREFIX."contract c "
                . "LEFT JOIN ".DB_PREFIX."handling_library_agent lfa ON c.agent = lfa.agent_id "
                . "LEFT JOIN ".DB_PREFIX."handling_library_type lfh ON c.handl_type = lfh.ht_id "
                . "LEFT JOIN ".DB_PREFIX."handling_library_service lfs ON c.serv_type = lfs.service_id "
                . "LEFT JOIN ".DB_PREFIX."contract_status cs ON c.cont_stat = cs.contract_status_id "
                . "LEFT JOIN ".DB_PREFIX."contract_payment_status cps ON c.payment_stat = cps.contract_payment_status_id "
                . "WHERE c.id = ".(int)$this->db->getLastId()
        )->row;
    }
    
    public function getEditableData($cont){
        $stats = $this->db->query("SELECT * FROM ".DB_PREFIX."contract_status ")->rows;
        $paystats = $this->db->query("SELECT * FROM ".DB_PREFIX."contract_payment_status ")->rows;
        $contr = $this->db->query("SELECT * FROM ".DB_PREFIX."contract WHERE id = ".(int)$cont)->row;
        return [
            'stats' => $stats,
            'paystats' => $paystats,
            'contr' => $contr
        ];
    }
    
    public function updateContractData($data) {
        $this->db->query("UPDATE ".DB_PREFIX."contract SET "
                . "payment_stat = ".(int)$data['paystat'].", "
                . "cont_stat = ".(int)$data['stat'].", "
                . "note = '".$data['note']."'"
                . "WHERE id = ".(int)$data['contract']);
        return $this->db->query(
                "SELECT "
                . "c.id, c.contn, c.note, c.date, "
                . "cs.contract_status_name AS cont_stat, cs.contract_label AS cont_stat_class, "
                . "cps.contract_payment_status_name AS payment_stat, cps.contract_payment_label AS payment_stat_class, "
                . "lfa.name AS agent, lfh.name AS handl_type, lfs.name AS serv_type "
                . "FROM ".DB_PREFIX."contract c "
                . "LEFT JOIN ".DB_PREFIX."lib_fills lfa ON c.agent = lfa.id "
                . "LEFT JOIN ".DB_PREFIX."lib_fills lfh ON c.handl_type = lfh.id "
                . "LEFT JOIN ".DB_PREFIX."lib_fills lfs ON c.serv_type = lfs.id "
                . "LEFT JOIN ".DB_PREFIX."contract_status cs ON c.cont_stat = cs.contract_status_id "
                . "LEFT JOIN ".DB_PREFIX."contract_payment_status cps ON c.payment_stat = cps.contract_payment_status_id "
                . "WHERE c.id = ".(int)$data['contract']
        )->row;
    }
}

