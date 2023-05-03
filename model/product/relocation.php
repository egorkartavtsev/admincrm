<?php
class ModelProductRelocation extends Model {
    
    public function getProducts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		$sql .= " WHERE !LOCATE('complect', vin) AND quantity > 0";
		
		if (isset($data['filter_vin']) && !is_null($data['filter_vin'])) {
			$sql .= " AND p.vin LIKE '" . $this->db->escape($data['filter_vin']) . "%'";
		}
		// фильтры местоположения
		$names = $this->getNames();
		if ($data['isExact'] == 'no') {
			foreach ($names as $name) {
				if (isset($data['filter_'.$name.'']) && !is_null($data['filter_'.$name.'']) && $data['filter_'.$name.''] != "-") {
					$sup = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills WHERE id='" . $this->db->escape($data['filter_'.$name.'']) . "'");
					$sql .= " AND p.".$name." = '" . $sup->row['name'] . "'";
				}
			}
		} else {			
			foreach ($names as $name) {				
				if (isset($data['filter_'.$name.'']) && !is_null($data['filter_'.$name.'']) && $data['filter_'.$name.''] != "-") {
					$sup = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills WHERE id='" . $this->db->escape($data['filter_'.$name.'']) . "'");
					$sql .= " AND p.".$name." = '" . $sup->row['name'] . "'";
				}else{					
					$sql .= " AND p.".$name." IN ('', '-')";
				}
			}
		}
		$sql.= " ORDER BY p.date_added DESC ";
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
    }
	
    public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		$sql .= " WHERE quantity > 0";
		
		if (isset($data['filter_vin']) && !is_null($data['filter_vin'])) {
			$sql .= " AND p.vin LIKE '" . $this->db->escape($data['filter_vin']) . "%'";
		}
		// фильтры местоположения
		$names = $this->getNames();
		if ($data['isExact'] == 'no') {
			foreach ($names as $name) {
				if (isset($data['filter_'.$name.'']) && !is_null($data['filter_'.$name.'']) && $data['filter_'.$name.''] != "-") {
					$sup = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills WHERE id='" . $this->db->escape($data['filter_'.$name.'']) . "'");
					$sql .= " AND p.".$name." = '" . $sup->row['name'] . "'";
				}
			}
		} else {			
			foreach ($names as $name) {				
				if (isset($data['filter_'.$name.'']) && !is_null($data['filter_'.$name.'']) && $data['filter_'.$name.''] != "-") {
					$sup = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills WHERE id='" . $this->db->escape($data['filter_'.$name.'']) . "'");
					$sql .= " AND p.".$name." = '" . $sup->row['name'] . "'";
				}else{					
					$sql .= " AND p.".$name." IN ('', '-')";
				}
			}
		}
		$sql .= " AND !LOCATE('complect', vin)";
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getNames() {
		$sql = "SELECT name FROM " . DB_PREFIX . "lib_struct ols WHERE ols.library_id = 2;";
		$query = $this->db->query($sql);
		$result = $query->rows;
		$names = array_column($result, 'name');
		return $names;
	}
	
	public function relocate($products, $newAddr){
		$names = $this->getNames();
		//заполняем таблицу relocation_history
		foreach($products as $product) {
			$dop = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = " . $product . " ");
			$prodInfo = $dop->row;
			$oldAddr = "".$prodInfo['adress'].":".$prodInfo['stock']."/".$prodInfo['stell']."/".$prodInfo['jar']."/".$prodInfo['shelf']."/".$prodInfo['box']."";
			$newAddrString = "";
			foreach($names as $name) {
				if(array_key_exists($name, $newAddr)){
					$queryOldAddr = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills olf WHERE olf.id = '" . $newAddr[$name] . "'");
					if($name == "adress"){
						$newAddrString .= $queryOldAddr->row['name'] . ":";
					} elseif($name == end($newAddr)) {
						$newAddrString .= $queryOldAddr->row['name'];
					}else{
						$newAddrString .= $queryOldAddr->row['name'] . "/";
					}
				}else{
					if($name == "adress"){
						$newAddrString .= "-:";
					} elseif ($name == "box") {
						$newAddrString .= "-";
					} else {
						$newAddrString .="-/";
					}
				}
			}
			$this->db->query("INSERT INTO ".DB_PREFIX."relocation_history "
                    . "(`vin`, `old_address`, `new_address`,`relocation_date`,`manager`) VALUES "
                    . "('".$prodInfo['vin']."', '".$oldAddr."', '".$newAddrString."', NOW(),".$this->user->getId().")");
		}
		//обновляем значения тех полей, которые пришли в массиве $newAddr (возможные поля: Адрес/Склад/Стеллаж/Ярус/Полка/Коробка), в таблице product
		$sql = "UPDATE " . DB_PREFIX . "product SET ";
		foreach ($names as $name) {
			if(array_key_exists($name, $newAddr)){
				$sql .= $name . " = (SELECT name FROM " . DB_PREFIX . "lib_fills olf WHERE olf.id = '" . $newAddr[$name] . "'),";
			}
		}
		$sql = rtrim($sql, ",");
		$sql .= " WHERE product_id IN (" . implode(",", $products) . ")";
		$query = $this->db->query($sql);
		
		//берём name последнего поля из массива $newAddr
		end($newAddr);
		$key = key($newAddr);
		//ищем дочерние поля
		$sup = "SELECT * FROM " . DB_PREFIX . "lib_struct WHERE library_id = 2";
		$query = $this->db->query($sup);
		$lib_struct = $query->rows;
		$childs = [];
		$i = 0;
		foreach ($lib_struct as $element){
			if($element['name'] == $key){
				$i = 1;
			}
			if($i == 1 && $element['isparent']==='1'){
				$childSql = "SELECT name FROM " . DB_PREFIX . "lib_struct WHERE parent_id = " . $element['item_id'] . "";
				$childQuery = $this->db->query($childSql);
				$childs [] = $childQuery->row['name'];
			}
		}
		//если есть дочерние поля, обнуляем их значения
		if($childs){
			foreach($childs as $child){
				$sqlUpdate = "UPDATE " . DB_PREFIX . "product SET " . $child . " = '-' WHERE product_id IN (" . implode(",", $products) . ")";
				$queryUpdate = $this->db->query($sqlUpdate);
			}
		}
	}
	
	public function getPreviousAddr(){
		$query = $this->db->query("SELECT DISTINCT new_address FROM (SELECT new_address, relocation_date FROM "
								. DB_PREFIX . "relocation_history WHERE new_address != '' AND manager = " . $this->user->getId() . " ORDER BY relocation_date DESC LIMIT 25) d LIMIT 5");
		$history = $query->rows;
		$previousAddr = [];
		foreach($history as $addr){
			$address = explode(":", $addr['new_address']);
			$address['adress'] = $address[0];
			$address['location'] = $address[1];
			unset($address[0]);
			unset($address[1]);
			$previousAddr[] = $address;
		}
		return $previousAddr;
	}
    
}
