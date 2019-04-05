<?php

class ModelServiceService extends Model {
    
    private $vars = [
        /*'cont_number' => '',
        'agent_name' => '',
        'agent_ogrn' => '',
        'agent_inn' => '',
        'agent_addr' => '',
        'agent_checkacc' => '',
        'client_name' => '',
        'acc_date' => '',
        'acc_descr' => '',
        'cli_brand' => '',
        'cli_model' => '',
        'cli_year' => '',
        'cli_numb' => '',
        'cli_vin' => '',
        'cli_kmeters' => '',
        'cli_osago' => '',
        'cli_pasp' => '',
        'caus_name' => '',
        'caus_addr' => '',
        'caus_osago' => '',
        'caus_ow_name' => '',
        'caus_ow_addr' => '',
        'prot' => '',
        'decree' => '',
        'spec' => '',
        'ref' => '',
        'date_prot' => '',
        'date_decree' => '',
        'date_spec' => '',
        'date_ref' => ''*/
    ];
    
    public function getData($service){
        $sql = "";
        
        $cont = $this->db->query("SELECT * FROM ".DB_PREFIX."contract WHERE id = ".(int)$service)->row;
        $handl = $this->db->query("SELECT * FROM ".DB_PREFIX."handling WHERE id = ".(int)$cont['handling'])->row;
        $agent = $this->db->query("SELECT * FROM ".DB_PREFIX."handling_library_agent WHERE agent_id = ".(int)$cont['agent'])->row;
        $client = $this->db->query("SELECT * FROM ".DB_PREFIX."client WHERE id = ".(int)$handl['client'])->row;
        $auto = $this->db->query("SELECT * FROM ".DB_PREFIX."automobiles WHERE id = ".(int)$handl['auto'])->row;
        $accident = $this->db->query("SELECT * FROM ".DB_PREFIX."accidents WHERE id = ".(int)$handl['accident'])->row;
        
        $this->vars['cont_number'] = $cont['contn'];
        
        $this->vars['agent_name'] = $agent['name'];
        $this->vars['agent_ogrn'] = $agent['ogrn'];
        $this->vars['agent_inn'] = $agent['inn'];
        $this->vars['agent_addr'] = $agent['legal_adr'];
        $this->vars['agent_checkacc'] = $agent['check_acc'];
        $this->vars['agent_bik'] = $agent['bik'];
        $this->vars['agent_bank'] = $agent['bank'];
        $this->vars['agent_coracc'] = $agent['cor_acc'];
        
        $this->vars['client_name'] = $client['secondname'].' '.$client['firstname'].' '.$client['patronymic'];
        
        $date = new DateTime($accident['date']);
        $this->vars['acc_date'] = $date->format('d.m.Y');
        $this->vars['acc_descr'] = $accident['descript'];
        
        $this->vars['cli_brand'] = $auto['brand'];
        $this->vars['cli_model'] = $auto['model'];
        $this->vars['cli_year'] = $auto['year'];
        $this->vars['cli_numb'] = $auto['numb'];
        $this->vars['cli_vin'] = $auto['vin'];
        $this->vars['cli_kmeters'] = $auto['kmeters'];
        $this->vars['cli_osago'] = $accident['vict_insurence'];
        $this->vars['cli_addr'] = $accident['freg'].', '.$accident['farea'].', '.$accident['fcity'].', '.$accident['fstreet'].', '.$accident['fhome'];
        $date = new DateTime($client['datepas']);
        $this->vars['cli_pasp'] = $client['numpas'].' выдан '.$client['officepas'].' '.$date->format('d.m.Y');
        
        $this->vars['caus_name'] = $accident['sname_causer'].' '.$accident['fname_causer'].' '.$accident['patr_causer'];
        $this->vars['caus_addr'] = $accident['causer_reg'].', '.$accident['causer_area'].', '.$accident['causer_city'].', '.$accident['causer_street'].', '.$accident['causer_home'];
        $this->vars['caus_osago'] = $accident['causer_ins'];
        
        $this->vars['caus_ow_name'] = $accident['c_owner_sname'].' '.$accident['c_owner_fname'].' '.$accident['c_owner_patr'];
        $this->vars['caus_ow_addr'] = $accident['c_owner_reg'].', '.$accident['c_owner_area'].', '.$accident['c_owner_city'].', '.$accident['c_owner_street'].', '.$accident['c_owner_home'];
        
        $this->vars['prot'] = $accident['protocol'];
        $date = new DateTime($accident['dateprot']);
        $this->vars['date_prot'] = $date->format('d.m.Y');
        
        $this->vars['decree'] = $accident['decree'];
        $date = new DateTime($accident['date']);
        $this->vars['date_decree'] = $date->format('d.m.Y');

        $this->vars['spec'] = $accident['specif'];
        $date = new DateTime($accident['date']);
        $this->vars['date_spec'] = $date->format('d.m.Y');

        $this->vars['ref'] = $accident['reference'];
        $date = new DateTime($accident['date']);
        $this->vars['date_ref'] = $date->format('d.m.Y');
        
        
        
        return $this->vars;
    }
    
}

