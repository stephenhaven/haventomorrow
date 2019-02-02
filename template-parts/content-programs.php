<?php

$secondsInHour = 3600;
$program_title = get_field('program_title');
$program_part = get_field('part');
$program_date = get_the_date();
$program_id = get_the_ID();
$noSongsFile = "http://haventoday.org/audio-nosongs/" . date("mdY", strtotime($program_date)) . 'HavenTodayNS.mp3';
$noSongsExists = false;
// Check if No Songs file exists
$ch = curl_init($noSongsFile);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_exec($ch);
$retcode = curl_getinfo($ch);
curl_close($ch);
if ($retcode["http_code"] == 200)
{
	if ($retcode["download_content_length"] > 0){
		$noSongsExists = true;
	}
}


date_default_timezone_set('America/Los_Angeles');

$year = date("Y",strtotime($program_date));
$month = date("m",strtotime($program_date));
$day = date("d",strtotime($program_date));
$event = mktime(00, 00, 00, $month, $day, $year);

echo '<div class="item">';
echo '<div class="button trans play" data-playing="0" data-username="haven" data-podcast="' . $event . '" data-id="' . $program_id . '"><span class="play">icon</span></div>';
if ($noSongsExists){
	echo '<div class="button trans download" data-fname="' . $noSongsFile . '"><i class="fa fa-arrow-down"></i></div>';
}
echo '<div class="txt">';
echo '<span class="title"><strong>' . $program_title . '</strong></span>';
echo '<span class="date">' . $program_date . '</span>';
echo '</div>';
echo '</div><!--end .item-->';

?>
