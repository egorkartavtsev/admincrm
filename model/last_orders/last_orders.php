<?php
    class ModelLastOrdersLastOrders extends Model {
		
		public function getLastOrders() {
            $query = $this->db->query("SELECT id, name, city, client, date FROM ".DB_PREFIX."sales_info ORDER BY date DESC LIMIT 10 OFFSET 0");
            $arr = $query->rows;
            if(!empty($arr)){
                foreach ($arr as $ord) {
                    $result[] = array(
                        'id' => $ord['id'],
						'name' => $ord['name'],
						'city' => $ord['city'],
						'client' => $ord['client'],
						'date' => $ord['date']
                    );
                }
            }
            return (isset($result))?$result:NULL;
        }
		
	}
