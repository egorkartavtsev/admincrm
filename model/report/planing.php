<?php

class ModelReportPlaning extends Model {

    public function getCurrentPlan($addr) {
       $tmp = $this->db->query("SELECT * FROM " . DB_PREFIX . "sales_planing WHERE date = '" . date("Y-m") . "-01' AND adress = '".$addr."' ");
        if ($tmp->num_rows) {
            return $tmp->row['plan'];
        } else {
            return false;
        }
    }

    public function getAdresses() {
        $tmp = $this->db->query("SELECT * FROM " . DB_PREFIX . "lib_fills WHERE library_id = 2 AND item_id = 19")->rows;
        foreach ($tmp as $addr) {
            $res[$addr['name']] = $addr['id'];
        }
        return $res;
    }

    public function getCurrentFact($addr, $dayStart = '01', $dayEnd = '31') {
        $tmp = $this->db->query("SELECT * FROM " . DB_PREFIX . "sales_info si "
                                . "LEFT JOIN ".DB_PREFIX."product p ON p.vin = si.sku "
                             . "WHERE date >= '" . date("Y-m") . "-" . $dayStart . " 00:00:00' AND date <= '" . date("Y-m") . "-" . $dayEnd . " 23:59:59' AND p.adress = '".$addr."' ");
        $summ = 0;
        foreach ($tmp->rows as $sale) {
            $summ += $sale['saleprice'];
        }
        return $summ;
    }

    public function getPlanChangeHistory($addr) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "sales_planing_history WHERE date<'" . date("Y-m") . "-01'");
     return $this->db->query("SELECT * FROM " . DB_PREFIX . "sales_planing_history sph "
                       . "LEFT JOIN " . DB_PREFIX . "user u ON u.user_id = sph.user WHERE adress = '".$addr."' ORDER BY sph.date DESC ")->rows;
    }

    public function savePlan($addr, $plan) {
        $tmp = $this->db->query("SELECT * FROM " . DB_PREFIX . "sales_planing WHERE date = '" . date("Y-m") . "-01' AND adress = '".$addr."' ");
        if ($tmp->num_rows) {
            $sql = "UPDATE " . DB_PREFIX . "sales_planing SET plan = " . (int) $plan . " WHERE date = '" . date("Y-m") . "-01' AND adress = '".$addr."' ";
            $this->db->query("INSERT INTO " . DB_PREFIX . "sales_planing_history SET comment = 'Изменён размер плана на текущий месяц. " . (int) $plan . "', date = NOW(), user = " . (int) $this->user->getId() . ", adress = '".$addr."' ");
        } else {
            $sql = "INSERT INTO " . DB_PREFIX . "sales_planing SET plan = " . (int) $plan . ", date = '" . date("Y-m") . "-01', adress = '".$addr."' ";
            $this->db->query("INSERT INTO " . DB_PREFIX . "sales_planing_history SET comment = 'Установлен размер плана на текущий месяц. " . (int) $plan . "', date = NOW(), user = " . (int) $this->user->getId() . ", adress = '".$addr."' ");
        }
        $this->db->query($sql);
    }

    public function getTotalPlans($addr) {
       return $this->db->query("SELECT * FROM " . DB_PREFIX . "sales_planing WHERE adress = '".$addr."' ORDER BY date DESC ")->rows;
    }

    public function getMonthFact($month, $addr) {
        $sql = "SELECT * FROM " . DB_PREFIX . "sales_info si "
                . "LEFT JOIN ".DB_PREFIX."product p ON p.vin = si.sku "
             . "WHERE si.date >= '" . $month . "-01 00:00:00' AND si.date <= '" . $month . "-31 23:59:59' AND p.adress = '".$addr."'";
        $tmp = $this->db->query($sql)->rows;
        $summ = 0;
        foreach ($tmp as $sale) {
            $summ += $sale['saleprice'];
        }
        return $summ;
    }

}
