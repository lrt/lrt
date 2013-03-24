<?php

$fp = fopen('data.csv', 'w');

for($i = 0; $i <= 1490; $i++) {
		
	$filename = "map/map_data_1_".$i.".xml";
				
	$datas = parse_file($filename);
	
	foreach ($datas as $fields) {
		fputcsv($fp, $fields, ';');
	}
}	

fclose($fp);

content(2708);

function content($id) {

	$curl = curl_init();
	
	mkdir('/content/'.$id.'/', 0777);
	
	curl_setopt($curl, CURLOPT_URL, "http://www.rollerenligne.com/spot.php?id_spot=".$id."");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$return = curl_exec($curl);

	var_dump($return);

	curl_close($curl);

}

echo "OK";

function parse_file($file) {

	$datas = array();

	if(file_exists($file)) {

		$xml = simplexml_load_file($file);

		$nb = count($xml);
								
		for($i = 0; $i <= $nb; $i++) {

			$object = $xml->m[$i];
			
			$tab = array('id' => $object['id'], 'la' => $object['la'], 'ln' =>$object['ln']);
			
			array_push($datas, $tab);
			
		}
	}
	
	return $datas;
}

?>