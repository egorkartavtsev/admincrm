<?php

class ControllerCommonSupport extends Controller {

    public function index() {
        $xmls = simplexml_load_file('Avito/ads.xml');

        $date = date('m/d/Y h:i:s a', time() + 24 * 3600);
        var_dump($date);
        echo "<br>";

        $sup = 0;

        echo 'count before: '.count($xmls->Ad)."<br>";


        for($i = 0; $i < count($xmls->Ad); $i++) {
            $ad = $xmls->Ad[$i];
            $curDate = date('m/d/Y h:i:s', strtotime((string)$ad->DateEnd));
            if($curDate < $date)
            {
                $dom=dom_import_simplexml($ad);
                $dom->parentNode->removeChild($dom);
                $xmls->asXML('Avito/ads.xml');
                $i--;
            }
            $sup++;
        }
        echo 'count: '.$sup."<br>";
        echo 'count after: '.count($xmls)."<br>";

//        $data = [
//            ['a' => 1, 'b' => 0, 'c' => 'os'],
//            ['a' => 2, 'b' => 3, 'c' => 'od'],
//            ['a' => 3, 'b' => 5, 'c' => 'of'],
//            ['a' => 4, 'b' => 7, 'c' => 'oy']
//        ];
//
//        var_dump(in_array('oy', array_column($data, 'c')));
    }
}