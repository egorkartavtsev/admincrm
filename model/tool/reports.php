<?php

class ModelToolReports extends Model {
    
    private $order = '';
    
    public function getDefaultSales() {
        $tmp = $this->db->query("SELECT "
                    . "si.date, si.saleprice "
                . "FROM ".DB_PREFIX."sales_info si "
                . "WHERE si.date>'".date("Y")."-01-01 00:00:00' ORDER BY si.date")->rows;
        $res = ['01' => 0, '02' => 0, '03' => 0,
            '04' => 0, '05' => 0, '06' => 0,
            '07' => 0, '08' => 0, '09' => 0,
            '10' => 0, '11' => 0, '12' => 0
        ];
        foreach ($tmp as $sale) {
            $i = date("m", strtotime($sale['date']));
            $res[$i]+= $sale['saleprice'];
        }
        //exit(var_dump($res));
        return $res;
    }
    
    public function getSales($filter) {
        $sql = '';
        $sql = "SELECT "
                . "p.manager, si.saleprice, si.wherefrom, si.date, si.city,"
                . "p.type, p.category, p.brand, p.model, p.adress "
            . "FROM ".DB_PREFIX."sales_info si "
            . "LEFT JOIN ".DB_PREFIX."product p ON p.vin = si.sku "
            . "WHERE 1 ";
        if(isset($filter['startdate'])){
            $sql.= "AND si.date>='".date("Y-m-d H:i:s", strtotime($filter['startdate']))."' ";
        } else {
            $sql.="AND si.date>='".date("Y")."-01-01 00:00:00' ";
        }
        if(isset($filter['enddate'])){
            $sql.= "AND date<='".date("Y-m-d H:i:s", strtotime($filter['enddate']))."' ";
        }
        $order = $this->getOrder($filter);
        
        //exit($sql);
        $tmp = $this->db->query($sql.$order)->rows;
        $sup = [];
        foreach ($tmp as $sale) {
            $i = $this->tryLabels($filter, $sale);
            
            if(isset($filter['yAxis'])){
                if($filter['yAxis']==='count'){
                    if(!isset($sup[$i])){
                        $sup[$i] = 1;
                    } else {
                        $sup[$i]+= 1;
                    }
                } else {
                    if(!isset($sup[$i])){
                        $sup[$i] = $sale['saleprice'];
                    } else {
                        $sup[$i]+= $sale['saleprice'];
                    }
                }
            } else {
                if(!isset($sup[$i])){
                    $sup[$i] = $sale['saleprice'];
                } else {
                    $sup[$i]+= $sale['saleprice'];
                }
            }
        }
        $res = [];
        foreach ($sup as $key => $value) {
            $res['labels'][] = $key;
            $res['series'][0][] = $value;
        }
//        $res = ['01' => 0, '02' => 0, '03' => 0,
//            '04' => 0, '05' => 0, '06' => 0,
//            '07' => 0, '08' => 0, '09' => 0,
//            '10' => 0, '11' => 0, '12' => 0
//        ];
//        foreach ($tmp as $sale) {
//            $i = date("m", strtotime($sale['date']));
//            $res[$i]+= $sale['saleprice'];
//        }
//        exit(var_dump($res));
        return $res;
    }
    
    public function getAdded($filter) {
        $sql = '';
        $sql = "SELECT *, p.date_added as date "
            . "FROM ".DB_PREFIX."product p "
            . "WHERE 1 ";
        if(isset($filter['startdate'])){
            $sql.= "AND p.date_added>='".date("Y-m-d H:i:s", strtotime($filter['startdate']))."' ";
        } else {
            $sql.="AND p.date_added>='".date("Y")."-01-01 00:00:00' ";
        }
        if(isset($filter['enddate'])){
            $sql.= "AND p.date_added<='".date("Y-m-d H:i:s", strtotime($filter['enddate']))."' ";
        }
        $order = $this->getOrder($filter, '_added');
        
        //exit($sql);
        $tmp = $this->db->query($sql.$order)->rows;
        $sup = [];
        foreach ($tmp as $prod) {
            $i = $this->tryLabels($filter, $prod);
            if(isset($filter['yAxis']) && $filter['yAxis']==='count_added'){
                if(!isset($sup[$i])){
                    $sup[$i] = 1;
                } else {
                    $sup[$i]+= 1;
                }
            } else {
                if(!isset($sup[$i])){
                    $sup[$i] = $prod['price'];
                } else {
                    $sup[$i]+= $prod['price'];
                }
            }          
        }
        $res = [];
        foreach ($sup as $key => $value) {
            $res['labels'][] = $key;
            $res['series'][0][] = $value;
        }

        return $res;
    }
    
    private function tryLabels($filter, $sale, $flag=''){
        if(count($filter)){
            
            switch ($filter['xAxis']) {
                case 'date':
                    if(isset($filter['timeDetalise'])){
                        switch ($filter['timeDetalise']) {
                            case 'd':
                                $i = date("d.m.Y", strtotime($sale['date']));
                            break;
                            case 'm':
                                $i = date("M.Y", strtotime($sale['date']));
                            break;
                            case 'y':
                                $i = date("Y", strtotime($sale['date']));
                            break;
                        }
                    } else {   
                        $i = date("M.Y", strtotime($sale['date']));
                    }
                break;
                case 'date_added':
                    if(isset($filter['timeDetalise'])){
                        switch ($filter['timeDetalise']) {
                            case 'd':
                                $i = date("d.m.Y", strtotime($sale['date']));
                            break;
                            case 'm':
                                $i = date("M.Y", strtotime($sale['date']));
                            break;
                            case 'y':
                                $i = date("Y", strtotime($sale['date']));
                            break;
                        }
                    } else {   
                        $i = date("M.Y", strtotime($sale['date']));
                    }
                break;
                case 'manager':
                    $i = $this->getManName($sale['manager']);
                break;
                case 'price':
                    $midStart = 1000;
                    $midStop = 10000;
                    if($sale['saleprice']<=$midStart){
                        $i = 'до '.$midStart;
                    } elseif($sale['saleprice']>$midStart && $sale['saleprice']<=$midStop) {
                        $i = 'от '.$midStart.' до '.$midStop;
                    } else{
                        $i = 'более '.$midStop;
                    }
                break;
                case 'city':
                    if(stripos($sale['city'], 'агнито') || stripos($sale['city'], 'гапов')){
                        $i = 'текущий город';
                    } else {
                        $i = 'доставка';
                    }
                break;
//                case '':
//                break;
                default :
                    $i = $sale[$filter['xAxis']];
                break;
            }
            
        } else {
            $i = date("M.Y", strtotime($sale['date']));
        }
        return $i;
    }
    
    public function getOrder($filter, $flag = '') {
        if(isset($filter['xAxis'])){
            switch ($filter['xAxis']){
                case 'type':
                    return "ORDER BY p.type ";
                break;
                case 'category':
                    return "ORDER BY p.category ";
                break;
                case 'adress':
                    return "ORDER BY p.adress ";
                break;
                case 'brand':
                    return "ORDER BY p.brand ";
                break;
                case 'model':
                    return "ORDER BY p.model ";
                break;
                case 'manager':
                    return "ORDER BY p.manager ";
                break;
                default :
                    if($flag){
                        return "ORDER BY p.".$filter['xAxis']." ";
                    } else {
                        return "ORDER BY si.".$filter['xAxis']." ";
                    }
                break;
            }
        } else {
            if($flag){
                return "ORDER BY p.date_added ";
            } else {
                return "ORDER BY si.date";
            }
        }
    }
    
    public function getManName($id) {
        $tmp = $this->db->query("SELECT * FROM ".DB_PREFIX."user WHERE user_id = ".(int)$id);
        if($tmp->num_rows){
            return $tmp->row['lastname'].' '.$tmp->row['firstname'];
        } else {
            return 'Неизвестно';
        }
    }
}

