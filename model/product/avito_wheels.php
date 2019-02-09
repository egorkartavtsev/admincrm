<?php

class ModelProductAvito extends Model {
    
    public function getAvitoWheels(){
         $sup = $this->db->query("SELECT "
                . "p.vin AS vin, " 
                . "p.price AS price, "      
                . "p.quantity AS quant, " 
                . "p.catn AS catN, "  // состояние
                . "p.note AS note, "
                . "p.type AS type, " // новый/б/у
                . "p.adress AS adress, " 
                . "p.diameter AS diam, " 
                . "p.width AS width, " 
                . "p.disctype AS dType, " 
                . "p.qholes AS qholes, " 
                . "p.dHoles AS dHoles, " 
                . "p.season AS season, " 
                . "p.hprof AS hprof, " 
                . "p.tbrand AS dbrand, " 
                . "p.tmodel AS dmodel, " 
                . "p.speedIndex AS SI, " 
                . "p.hardindex AS HI, " 
                . "p.comp AS comp "
                . "FROM ".DB_PREFIX."product p "
                . "WHERE ((p.structure = '2') OR (p.structure = '3')) AND (p.quantity > 0) AND (p.price > 0)" );
        return $sup->rows;   
    }
    public function filterWheels($filter) {
        
    }
    }