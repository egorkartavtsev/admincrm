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

    $result = $mysqli->query("SELECT * from oc_product_to_avito where 1 = 1 and dateEnd > STR_TO_DATE('2021-08-01', '%Y-%m-%d') ORDER BY dateEnd DESC", MYSQLI_USE_RESULT);
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
	
    $xmls = simplexml_load_file('https://admin.xn--174-5cdagf5b9cdset.xn--p1ai/Avito/ads.xml');
	
	/*foreach($xmls->Ad as $ad)
	{
		echo var_dump($ad);
	}*/
	echo '<table>';
	$i = 1;
    foreach ($xmls->Ad as $row)
	{		
		echo '<tr>';		
		echo '<td>'.$i.'</td><td>'.$row->Id.'</td><td>'.$row->DateBegin.'</td><td>'.$row->DateEnd.'</td>';
		echo '</tr>';
		$i++;
    }

	echo '</table>';
	die();



	echo '<table>';
	$i = 1;
    foreach ($data as $row)
	{
		$key = array_search(
			$row['vin'],
			array_column((array)$xmls->Ad,'Id')
		);
		
		echo '<tr>';		
		echo '<td>'.$i.'</td><td>'.$row['vin'].'</td><td>'.$row['dateStart'].'('.($key?$xmls->Ad[$key]['DateStart']:'-').')</td><td>'.$row['dateEnd'].'</td>';
		echo '</tr>';
		$i++;
    }

	echo '</table>';/**/
    echo count($xmls->Ad).' != '.count($data);

//    foreach($xmls->Ad as $ad) {
//        echo $ad->Id.' - '.$ad->DateEnd.'<br/>';
//    }