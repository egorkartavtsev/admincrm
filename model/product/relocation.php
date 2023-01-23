<?php
class ModelProductRelocation extends Model {
    
    public function getProducts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		$sql .= " WHERE !LOCATE('complect', vin)";
		
		if (isset($data['filter_vin']) && !is_null($data['filter_vin'])) {
			$sql .= " AND p.vin LIKE '" . $this->db->escape($data['filter_vin']) . "%'";
		}
		// фильтры местоположения
		$names = $this->getNames();
		foreach ($names as $name) {
			if (isset($data['filter_'.$name.'']) && !is_null($data['filter_'.$name.'']) && $data['filter_'.$name.''] != "-") {
				$sup = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills WHERE id='" . $this->db->escape($data['filter_'.$name.'']) . "'");
				$sql .= " AND p.".$name." = '" . $sup->row['name'] . "'";
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
		$sql .= " WHERE p.price > '0' ";
		
		if (isset($data['filter_vin']) && !is_null($data['filter_vin'])) {
			$sql .= " AND p.vin LIKE '" . $this->db->escape($data['filter_vin']) . "%'";
		}
		// фильтры местоположения
		$names = $this->getNames();
		foreach ($names as $name) {
			if (isset($data['filter_'.$name.'']) && !is_null($data['filter_'.$name.'']) && $data['filter_'.$name.''] != "-") {
				$sup = $this->db->query("SELECT name FROM " . DB_PREFIX . "lib_fills WHERE id='" . $this->db->escape($data['filter_'.$name.'']) . "'");
				$sql .= " AND p." . $name . " = '" . $sup->row['name'] . "'";
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
		//обновляем значения тех полей, которые пришли в массиве $newAddr (возможные поля: Адрес/Склад/Стеллаж/Ярус/Полка/Коробка), в таблице product
		$sql = "UPDATE " . DB_PREFIX . "product SET ";
		$names = $this->getNames();
		foreach ($names as $name) {
			if(array_key_exists($name, $newAddr)){
				$sql .= $name . " = (SELECT name FROM " . DB_PREFIX . "lib_fills olf WHERE olf.id = '" . $newAddr[$name] . "'),";
			}
		}
		$sql = rtrim($sql, ",");
		$sql .= " WHERE product_id IN (" . $products . ")";
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
				$sqlUpdate = "UPDATE " . DB_PREFIX . "product SET " . $child . " = '-' WHERE product_id IN (" . $products . ")";
				$queryUpdate = $this->db->query($sqlUpdate);
			}
		}
	}
    
}
