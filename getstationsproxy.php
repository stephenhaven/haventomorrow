<?php

if (function_exists("opcache_reset")) {
	opcache_reset();
}

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';

$zipcode = strtolower($_POST['zipcode']);
getRadioStations($zipcode);

function getRadioStations($zipcode){
	global $wpdb;

	$qDB_GetStations = "select distinct concat(trim(a.FCALL), '-', trim(a.FFREQ)) as unique_field, fcall as station, a.FMKTAREA as city,
		b.zone_name as state, a.FFREQ as dial, a.FBAND, c.time, c.ffreq, c.station
		from stationszip a
		left join zones b on a.FSTATE = b.zone_code
		left join stations_america c on a.FFREQ = c.dial AND INSTR(c.station,a.FCALL) > 0
		where a.ZIP='" . $zipcode . "'
		order by state, city, a.ffreq;";

	$rDB_GetStations = $wpdb->get_results($qDB_GetStations);

	echo json_encode($rDB_GetStations);

}

?>
