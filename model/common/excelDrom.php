<?php
    class ModelCommonExcelDrom extends Model {

        public function getDromDescription($data) {
    //--------------------------------------------------------------
        $this->load->model('common/avito');
        $settings = $this->model_common_avito->getSetts();
        $stock = $this->db->query("SELECT * FROM ".DB_PREFIX."stocks WHERE name = '".$data['stock']."'");
        $weekend = $data['stock']=='KM'?'СБ, ВС - выходной':'СБ 11:00-16:00 , ВС - выходной';
        $phone = $data['stock']=='KM'?'+7 (908) 825-52-40':'+7 (912) 475-08-70';
        $img = $data['stock']=='KM'?'KM.jpg':'shop.jpg';
        //-----------------------------------------
        $templ = htmlspecialchars_decode($this->model_common_avito->getDescTempl());
        /************************/
            $templ = str_replace('%podcat%', $data['podcat'], $templ);
            $templ = str_replace('%brand%', $data['brand'], $templ);
            $templ = str_replace('%modrow%', $data['modRow'], $templ);
            $templ = str_replace('%complect%','', $templ);
            $templ = str_replace('%trbrand%', '', $templ);
            $templ = str_replace('%trmodrow%', '', $templ);
            $templ = str_replace('%stock%', isset($stock->row['adress'])?$stock->row['adress']:'г. Магнитогорск, ул. Магнитная 109/1', $templ);
            $templ = str_replace('%vin%', $data['vin'], $templ);
            if(trim($data['catN'])!==''){
                $templ = str_replace('%catn%', '<li>Каталожный номер: <strong>'.$data['catN'].'</strong></li>', $templ);
            } else {
                $templ = str_replace('%catn%', '', $templ);
            }
            if(trim($data['cond'])!=='-'){
                $templ = str_replace('%condit%', '<li>Состояние: '.$data['cond'].'</li>', $templ);
            } else {
                $templ = str_replace('%condit%', '', $templ);
            }
            if(trim($data['compability'])!==''){
                $templ = str_replace('%compabil%', '<li>Подходит на: '.$data['compability'].'</li>', $templ);
            } else {
                $templ = str_replace('%compabil%', '', $templ);
            }
            if(trim($data['note'])!==''){
                $templ = str_replace('%note%', '<li>'.$data['note'].'</li>', $templ);
            } else {
                $templ = str_replace('%note%', '', $templ);
            }
            if(trim($data['dop'])!==''){
                $templ = str_replace('%dopinfo%', '<li>'.$data['dop'].'</li>', $templ);
            } else {
                $templ = str_replace('%dopinfo%', '', $templ);
            }
            $templ = str_replace('%weekend%', $weekend, $templ);
    /******************************************************************/
        return $templ; 
    }
    public function getPhotoDrom($pid) {
       $templ= '';
         $qphot = $this->db->query("SELECT * FROM ".DB_PREFIX."product_image WHERE product_id = '".$pid."' ORDER BY sort_order ");
                        $photos = '';
                        foreach ($qphot->rows as $phot) {
                            $photos.= HTTP_SHOWCASE.'image/'.$phot['image'].'; ';
                            $templ = trim($photos);
                        }
                       
       return $templ;
    }
    public function getComplectDrom() {
         $sup = $this->db->query("SELECT "
                . "c.id AS cid, "
                . "c.name AS name, " 
                . "c.price AS c_price, "   
                . "c.heading AS head, "
                . "c.name AS c_name, "  
                . "c.link AS link, " 
                . "c.whole AS c_whole "
                . "FROM ".DB_PREFIX."complects c "
                . "WHERE 1 " );
        return $sup->rows;   
    }
    public function getCompDrom() {
         $sup = $this->db->query("SELECT "
                . "p.podcateg AS podcat, "
                . "p.vin AS vin, " 
                . "p.price AS price, "      
                . "p.quantity AS quant, " 
                . "p.catn AS catN, "
                . "p.comp AS comp "
                . "FROM ".DB_PREFIX."product p "
                . "WHERE (p.quantity > 0) AND (p.podcateg != '') AND (p.price > 0) AND (p.comp != '')" );
        return $sup->rows;   
    }
        public function getDromDescriptionCompl($data) {
    //--------------------------------------------------------------
        $this->load->model('common/avito');
        $settings = $this->model_common_avito->getSetts();
        $stock = $this->db->query("SELECT * FROM ".DB_PREFIX."stocks WHERE name = '".$data['stock']."'");
        $weekend = $data['stock']=='KM'?'СБ, ВС - выходной':'СБ 11:00-16:00 , ВС - выходной';
        $phone = $data['stock']=='KM'?'+7 (908) 825-52-40':'+7 (912) 475-08-70';
        $img = $data['stock']=='KM'?'KM.jpg':'shop.jpg';
        //-----------------------------------------
        $templ = htmlspecialchars_decode($this->model_common_avito->getDescTempl());
        /************************/
                $data['complect'] = ''.$data['complect'].'<br><strong> В комплекте:</strong>'; 
        $datacomp = $this->model_common_excelDrom->getCompDrom();
        foreach ($datacomp as $datasqr) {
            if ($datasqr['comp'] === $data['vin']) {
                $data['complect'] = ''.$data['complect'].'<br> - '.$datasqr['podcat'].'  '.$datasqr['vin'].'  '.$datasqr['catN'].''; 
            }
        }
        
            $templ = str_replace('%podcat%', $data['podcat'], $templ);
            $templ = str_replace('%brand%', $data['brand'], $templ);
            $templ = str_replace('%modrow%', $data['modRow'], $templ);
            $templ = str_replace('%complect%', $data['complect'], $templ);
            $templ = str_replace('%trbrand%', '', $templ);
            $templ = str_replace('%trmodrow%', '', $templ);
            $templ = str_replace('%stock%', isset($stock->row['adress'])?$stock->row['adress']:'г. Магнитогорск, ул. Магнитная 109/1', $templ);
            $templ = str_replace('%vin%', $data['vin'], $templ);
            if(trim($data['catN'])!==''){
                $templ = str_replace('%catn%', '<li>Каталожный номер: <strong>'.$data['catN'].'</strong></li>', $templ);
            } else {
                $templ = str_replace('%catn%', '', $templ);
            }
            if(trim($data['cond'])!=='-'){
                $templ = str_replace('%condit%', '<li>Состояние: '.$data['cond'].'</li>', $templ);
            } else {
                $templ = str_replace('%condit%', '', $templ);
            }
            if(trim($data['compability'])!==''){
                $templ = str_replace('%compabil%', '<li>Подходит на: '.$data['compability'].'</li>', $templ);
            } else {
                $templ = str_replace('%compabil%', '', $templ);
            }
            if(trim($data['note'])!==''){
                $templ = str_replace('%note%', '<li>'.$data['note'].'</li>', $templ);
            } else {
                $templ = str_replace('%note%', '', $templ);
            }
            if(trim($data['dop'])!==''){
                $templ = str_replace('%dopinfo%', '<li>'.$data['dop'].'</li>', $templ);
            } else {
                $templ = str_replace('%dopinfo%', '', $templ);
            }
            $templ = str_replace('%weekend%', $weekend, $templ);
    /******************************************************************/
        return $templ; 
    }
    }