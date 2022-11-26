<?php

class ModelProductAvitoXml extends Model
{
    private $Result;
    private $Filter;

    public function getProds($filter)
    {
        $result = array();
        $this->Filter = $filter;
        //exit(var_dump($this->Filter));
        $xmls = $this->getProdsByFilter();
        //exit(var_dump($xmls));
        $i = 0;
        foreach ($xmls as $ad) {
            $tmp = (array)$ad;
            $sup = $this->db->query("select p.image, pd.name from oc_product p left join oc_product_description pd on p.product_id = pd.product_id where p.vin = '" . $tmp['Id'] . "'");

            $tmp["name"] = (count($sup->rows) > 0) ? $sup->row["name"] : "";
            $tmp["mainImage"] = (count($sup->rows) > 0) ? $sup->row["image"] : "";


            $this->Result['prods'][] = $tmp;
        }

        return $this->Result;
    }

    public function ActivateAd($vin)
    {
        $dateE = date('Y-m-d', strtotime(date('Y-m-d')."+30 days"));
        $dateS = date('Y-m-d', strtotime(date('Y-m-d')));
        $xmls = simplexml_load_file('./Avito/ads.xml');
        $sup = 0;
        foreach($xmls as $ad){
            if(in_array($vin, (array)$ad)){
                $xmls->Ad[$sup]->DateBegin = $dateS;
                $xmls->Ad[$sup]->DateEnd = $dateE;
                $xmls->saveXML('./Avito/ads.xml');
                return 1;
            } else {
                ++$sup;
            }
        }
        echo $vin;

    }

    public function DeactivateAd($vin)
    {
        $date = date('Y-m-d', strtotime(date('Y-m-d')."-5 days"));
        $xmls = simplexml_load_file('./Avito/ads.xml');
        $sup = 0;
        foreach($xmls as $ad){
            if(in_array($vin, (array)$ad)){
                $xmls->Ad[$sup]->DateBegin = '1999-01-01';
                $xmls->Ad[$sup]->DateEnd = $date;
                $xmls->saveXML('./Avito/ads.xml');
                return 1;
            } else {
                ++$sup;
            }
        }
        echo $vin;
    }

    public function DropAd($vin)
    {
        $xmls = simplexml_load_file('./Avito/ads.xml');
        $sup = 0;
        foreach($xmls as $ad){
            if(in_array($vin, (array)$ad)){
                $dom=dom_import_simplexml($xmls->Ad[$sup]);
                $dom->parentNode->removeChild($dom);
                $xmls->saveXML('./Avito/ads.xml');
                return 1;
            } else {
                ++$sup;
            }
        }

        echo $vin;
    }

    function getProdsByFilter()
    {
        return $this->applyFilters();
    }

    function applyFilters()
    {
        $result = array();
        $tmp = (array)$this->getTotalProds();

        // <editor-fold defaultstate="collapsed" desc="filters apply">
        if ($this->Filter["priceFrom"] > 0)
            $tmp = array_filter($tmp, function ($ad) {
                return $ad->Price >= $this->Filter["priceFrom"];
            });
        if ($this->Filter["priceFrom"] < 100000)
            $tmp = array_filter($tmp, function ($ad) {
                return $ad->Price <= $this->Filter["priceTo"];
            });
        if ($this->Filter["date"] != '1976-01-01')
            $tmp = array_filter($tmp, function ($ad) {
                return strtotime($ad->DateEnd) >= strtotime($this->Filter["date"]);
            });
        if ($this->Filter['vin'] != '')
            $tmp = array_filter($tmp, function ($ad) {
                return $ad->Id == $this->Filter['vin'];
            });

        if ($this->Filter['name'] != '')
            $tmp = array_filter($tmp, function ($ad) {
                $i = 0;
                $wordArr = explode(' ', trim($this->Filter['name']));
                foreach ($wordArr as $word) {
                    if (stripos($ad->Title, $word) !== false)
                        $i++;
                }
                return $i == count($wordArr);
            });

        if ($this->Filter['mess'] != '')
            $tmp = array_filter($tmp, function ($ad) {
                if ((int)$this->Filter['mess'])
                    return strtotime($ad->DateEnd) >= strtotime("Now");
                else
                    return strtotime($ad->DateEnd) < strtotime("Now");
            });

        if ($this->Filter['donor'] != '')
            $tmp = array_filter($tmp, function ($ad) {
                $check = $this->db->query("select count(*) cnt  from oc_product op where op.numb = '" . $this->Filter['donor'] . "' and op.vin = '" . $ad->Id . "'")->row['cnt'];
                return (int)$check > 0;
            });
        // </editor-fold>

        $this->Result['total'] = count($tmp);

        //pagination apply
        $tmp = array_values($tmp);
        for ($i = $this->Filter["start"]; $i < $this->Filter["start"] + $this->Filter["limit"]; $i++)
            if (isset($tmp[$i]))
                $result[] = $tmp[$i];

        return $result;
    }

    function getTotalProds()
    {
        $out = array();
        $xmlObject = simplexml_load_file('Avito/ads.xml');
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? xml2array($node) : $node;

        return $out["Ad"];
    }
}