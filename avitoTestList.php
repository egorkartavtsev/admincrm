<?php
// DB
$db_driver = 'mysqli';
$db_hostname = 'localhost';
$db_username = 'host1336154_nma';
$db_password = 'PoLhNI8X';
$db_database = 'host1336154_mgnauto';
$db_port = '3306';
$db_prefix = 'oc_';

    // Create connection
    $mysqli  = new \mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);

    // Check connection
    if ($mysqli ->connect_error) {
        die("Connection failed: " . $mysqli ->connect_error);
    }

    $xmls = simplexml_load_file('Avito/ads.xml');

    foreach ($xmls->Ad as $ad)
    {
        $result = $mysqli->query("select
                                                op.brand,
                                                op.catn,
                                                op.vin
                                            from
                                                oc_product op
                                            left join oc_lib_fills olf on
                                                olf.id = op.brand
                                            where
                                                op.vin = '" . $ad->Id . "'", MYSQLI_USE_RESULT);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data = $row;
        }

        if(!isset($ad->AdType))
            $ad->addChild('AdType', 'Товар приобретен на продажу');

        if(!isset($ad->OEM) && $data['catn'] != '')
            $ad->addChild('OEM', $data['catn']);

        if(!isset($ad->Brand) && $data['brand'] != '')
            $ad->addChild('Brand', $data['brand']);

        //echo var_dump($data);
        echo $data['catn'] . ' | ' . $data['brand']. ' | ' . $data['vin'];
        echo '<br><hr><br>';

    }

    $xmls->saveXML('Avito/ads.xml');
