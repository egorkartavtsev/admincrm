<?php
    class ModelCommonExcelDrom extends Model {
        
        public function DataDrom (){
            
                $sup = $this->db->query("SELECT "
                . "p.product_id AS pid, "
                . "p.podcateg AS podcat, " //Наименование товара
                . "p.type AS type, "      // б/у, новое
                . "b.name AS brand, "    //Марка
                . "p.model AS model, "    //Модель
                . "ph.sku AS vin, "        //внутренний номер
                . "p.note AS note, "        //Примечание
                . "p.price AS price, "      //Цена
                . "p.quantity AS quant, " //Количество 
                . "p.donor AS donor, "
                . "p.avito AS avito, "
                . "p.drom AS drom, "
                . "FROM ".DB_PREFIX."product_history ph "
                . "LEFT JOIN ".DB_PREFIX."product p ON ph.sku = p.vin "
                . "LEFT JOIN ".DB_PREFIX."product_description pd ON pd.product_id = p.product_id "
                . "LEFT JOIN ".DB_PREFIX."brand b ON b.id = p.brand "
                . "WHERE "
                    . "ph.date_added > '".$sup_date->row['date']."' "
                    . "OR ph.date_modify > '".$sup_date->row['date']."' "
                    . "OR ph.date_sale > '".$sup_date->row['date']."' "
                    . "OR ph.date_refund > '".$sup_date->row['date']."' "
                . "GROUP BY ph.sku");
                
        }
    }