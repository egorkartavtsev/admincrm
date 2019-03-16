<?php

class ModelServiceTools extends Model{
    
    public function findLocate($req, $kladr, $lvl) {
        $sql = "SELECT * FROM ".DB_PREFIX."kladr WHERE LOCATE('".$req."', name) ";
        if($kladr!='0'){
            $sql.= "AND kladr LIKE '".$kladr."%' ";
        }
        $sql.= "AND item_id = '".$lvl."' ORDER BY kladr LIMIT 10";
        $sup = $this->db->query($sql);
        return $sup->rows;
    }
    
    public function getClientInfo($id) {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."client WHERE id = ".(int)$id);
        return $sup->row;
    }
    
    public function getClientAuto($id) {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."auto_to_client a2c "
                . "LEFT JOIN ".DB_PREFIX."automobiles a ON a2c.auto_id = a.id "
                . "WHERE a2c.client_id = ".(int)$id." ORDER BY a2c.status DESC, a2c.id DESC");
        return $sup->rows;
    }
    
    public function getClientHandlings($id) {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."handling "
                . "WHERE client = ".(int)$id." ORDER BY date DESC");
        return $sup->rows;
    }
    
    public function tryVIN($vin) {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."automobiles WHERE vin = '".$vin."' ORDER BY id DESC");
        if($sup->num_rows){
            $reslt = $sup->row;
            $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE name = '".$reslt['model']."' AND item_id = 17");
            $reslt['model'] = array(
                'id' => $sup->row['id'],
                'name' => $sup->row['name']
            );
            return $reslt;
        } else {
            return FALSE;
        }
    }
        
    public function getBrands() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 16 ORDER BY name");
        return $sup->rows;
    }
    public function getEclass() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 32 ORDER BY name");
        return $sup->rows;
    }
    public function getColors() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 29 ORDER BY name");
        return $sup->rows;
    }
    public function getCateg() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 30 ORDER BY name");
        return $sup->rows;
    }
    public function getTypes() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 31 ORDER BY name");
        return $sup->rows;
    }
    public function getCommissars() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 33 ORDER BY name");
        return $sup->rows;
    }
    public function getInsurences() {
        $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."lib_fills WHERE parent_id = 0 AND item_id = 34 ORDER BY name");
        return $sup->rows;
    }
    public function getHandlTypes() {
        return $this->db->query("SELECT * FROM ".DB_PREFIX."handling_library_type ORDER BY name")->rows;
    }
    
    public function getCity() {
        return $this->db->query("SELECT * FROM ".DB_PREFIX."captured_cities ORDER BY city_id")->rows;
    }
    
    public function getAgents($ht, $city) {
        return $this->db->query("SELECT * FROM ".DB_PREFIX."handling_library_agent WHERE handling_type = ".(int)$ht." AND city = ".(int)$city)->rows;
    }
    
    public function getServices($agent){
        return $this->db->query("SELECT * FROM ".DB_PREFIX."handling_library_service WHERE agent_id = ".(int)$agent)->rows;
    }
    
    public function getReqs($agent){
        return $this->db->query("SELECT legal_adr, ogrn, inn, check_acc, bank, bik, cor_acc FROM ".DB_PREFIX."handling_library_agent WHERE agent_id = ".(int)$agent)->row;
    }
    
    public function saveReqs($data){
        $sql = "UPDATE ".DB_PREFIX."handling_library_agent SET ";
        foreach ($data as $key => $value) {
            if($key!=='agent'){
                $sql.= $key." = '".$value."', ";
            }
        }
        $sql.= "agent_id = ".(int)$data['agent']." WHERE agent_id = ".(int)$data['agent'];
        $this->db->query($sql);
    }
    
    public function getServDetails($serv){
        return $this->db->query("SELECT s.service_id, s.name, dt.doc_id, dt.name as doc, s.link "
                . "FROM ".DB_PREFIX."handling_library_service s "
                . "LEFT JOIN ".DB_PREFIX."doc_to_service d2s ON d2s.service_id = s.service_id "
                . "LEFT JOIN ".DB_PREFIX."document_template dt ON dt.doc_id = d2s.doc_id "
                . "WHERE s.service_id = ".(int)$serv)->row;
    }
    
    public function getTotalAgents() {
        return $this->db->query("SELECT a.agent_id, a.name as agent, ht.name as htype, c.city_name "
                . "FROM ".DB_PREFIX."handling_library_agent a "
                . "LEFT JOIN ".DB_PREFIX."captured_cities c ON a.city = c.city_id "
                . "LEFT JOIN ".DB_PREFIX."handling_library_type ht ON a.handling_type = ht.ht_id ")->rows;
    }
    
    public function saveServ($data) {
        if($data['doc']!=''){
            $this->db->query("DELETE FROM ".DB_PREFIX."doc_to_service WHERE service_id = ".(int)$data['serv']);
            $this->db->query("INSERT INTO ".DB_PREFIX."doc_to_service (doc_id, service_id) VALUES (".$data['doc'].", ".$data['serv'].") ");
        } else {
            $this->db->query("DELETE FROM ".DB_PREFIX."doc_to_service WHERE service_id = ".(int)$data['serv']);
        }
        
        $this->db->query("UPDATE ".DB_PREFIX."handling_library_service SET name = '".$data['name']."', link = '".$data['link']."' WHERE service_id = ".(int)$data['serv']);
    }
    
    public function getDocuments() {
        return $this->db->query("SELECT * FROM ".DB_PREFIX."document_template WHERE 1")->rows;
    }
    
    public function getDocDetails($doc) {
        if($doc == ''){
            return [
                'doc_id' => '',
                'name' => '',
                'file' => ''
            ];
        } else {
            $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."document_template WHERE doc_id = ".(int)$doc)->row;
            return [
                'doc_id' => $doc,
                'name' => $sup['name'],
                'file' => $sup['file']
            ];
        }
    }
    
    public function saveDocDetails($doc) {
        if($doc['doc_id']=='new-doc'){
            $this->db->query("INSERT INTO ".DB_PREFIX."document_template (name, file) VALUES ('".$doc['name']."', '".$doc['file']."')");
        } else {
            $this->db->query("UPDATE ".DB_PREFIX."document_template SET name = '".$doc['name']."', file = '".$doc['file']."' WHERE doc_id = ".(int)$doc['doc_id']);
        }
    }
    
    public function getItems($data) {
        $result = [];
        switch ($data['child']) {
            case 'subagent':
                $sup = $this->db->query("SELECT a.agent_id, a.name, c.city_name as city "
                        . "FROM ".DB_PREFIX."handling_library_agent a "
                        . "LEFT JOIN ".DB_PREFIX."captured_cities c ON c.city_id = a.city "
                        . "WHERE a.handling_type = ".(int)$data['sel'])->rows;
                // pozghe ogranichit' po gorodu menedghera
                foreach($sup as $row){
                    $result[] = [
                        'id' => $row['agent_id'],
                        'name' => $row['name'].' ('.$row['city'].')'
                    ];
                }
                break;
            case 'service':
                $sup = $this->db->query("SELECT * FROM ".DB_PREFIX."handling_library_service WHERE agent_id = ".(int)$data['sel'])->rows;
                foreach($sup as $row){
                    $result[] = [
                        'id' => $row['agent_id'],
                        'name' => $row['name']
                    ];
                }
                break;
        }
        return $result;
    }
}
