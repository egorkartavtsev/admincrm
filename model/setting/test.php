<?php

class ModelSettingTest extends Model {
	public function getTestProduct() {
            $productinfo = $this->db->query("SELECT pd.`name` AS nametest, p.`vin` as vintest, p.`price` as pricetest, p.`image` as imagetest  FROM `".DB_PREFIX."product` p RIGHT JOIN `".DB_TPROD."description` pd ON p.`product_id` = pd.`product_id` WHERE price>=1000 and price<=1500 LIMIT 50");
            return $productinfo->rows;            
        }           
        public function lightFiltr($filtered) {
            if($filtered['minpriceTest']==''){
                $filtered['minpriceTest']='0';
            }
            if($filtered['maxpriceTest']=='' || $filtered['maxpriceTest']<0 || $filtered['minpriceTest']>$filtered['maxpriceTest']){
                $filtered['maxpriceTest']='99999999999999';
            }
            if ($filtered['colvo']==0) {
                $filtered['colvo']=50;
            }
            $sql = "SELECT "
                    . "pd.`name` AS nametest, "
                    . "p.`vin` as vintest, "
                    . "p.`price` as pricetest, "
                    . "p.`image` as imagetest  "
                . "FROM `".DB_PREFIX."product` p "
                . "RIGHT JOIN `".DB_TPROD."description` pd ON p.`product_id` = pd.`product_id` "
                . "WHERE "
                    . "locate('".$filtered['brandTest']."', brand) "
                    . "and price>=".$filtered['minpriceTest']." "
                    . "and price<=".$filtered['maxpriceTest']." "
                . "LIMIT ".$filtered['colvo'];
            $litlfiltr = $this->db->query($sql);
//            exit(var_dump($sql));
//            exit(var_dump($litlfiltr->num_rows));
            return $litlfiltr->rows;
        }
}       