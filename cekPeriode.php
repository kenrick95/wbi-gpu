<?php
// set the default timezone to use. Available since PHP 5.1
date_default_timezone_set('UTC');


if (isset($_REQUEST['tahun'])) {
	$tahun = $_REQUEST['tahun'];
} else {
	$tahun = date("Y");
}

//  mktime(H, i, s, m, d, Y)
$periode = 1;
$start_usul = mktime(0, 0, 0, 7, 1, $tahun-1);
$end_usul =  mktime(23, 59, 59, date("m", $start_usul), date("d", $start_usul)+14, date("Y", $start_usul));
$start_pilih =  mktime(0, 0, 0, date("m", $start_usul), date("d", $start_usul)+15, date("Y", $start_usul));
$end_pilih =  mktime(23, 59, 59, date("m", $start_usul), date("d", $start_usul)+29, date("Y", $start_usul));
//echo "Periode ".$periode." -> ". date("Y-m-d",$start_usul)."<br />";

$data[$periode]['periode'] = $periode;
$data[$periode]['start_usul'] = $start_usul;
$data[$periode]['end_usul'] = $end_usul;
$data[$periode]['start_pilih'] = $start_pilih;
$data[$periode]['end_pilih'] = $end_pilih;

#$data[$periode]['start_usul'] = date("Y-m-d", $start_usul);
#$data[$periode]['end_usul'] = date("Y-m-d", $end_usul);
#$data[$periode]['start_pilih'] = date("Y-m-d", $start_pilih);
#$data[$periode]['end_pilih'] = date("Y-m-d", $end_pilih);

foreach (range(2, 23) as $periode) {
	$start_usul =  mktime(0, 0, 0, date("m", $start_usul), date("d", $start_usul)+15, date("Y", $start_usul));
	$end_usul =  mktime(23, 59, 59, date("m", $start_usul), date("d", $start_usul)+14, date("Y", $start_usul));
	$start_pilih =  mktime(0, 0, 0, date("m", $start_usul), date("d", $start_usul)+15, date("Y", $start_usul));
	$end_pilih =  mktime(23, 59, 59, date("m", $start_usul), date("d", $start_usul)+29, date("Y", $start_usul));

	
	$data[$periode]['periode'] = $periode;
	$data[$periode]['start_usul'] = $start_usul;
	$data[$periode]['end_usul'] = $end_usul;
	$data[$periode]['start_pilih'] = $start_pilih;
	$data[$periode]['end_pilih'] = $end_pilih;
	/*
	$data[$periode]['start_usul'] = date("Y-m-d", $start_usul);
	$data[$periode]['end_usul'] = date("Y-m-d", $end_usul);
	$data[$periode]['start_pilih'] = date("Y-m-d", $start_pilih);
	$data[$periode]['end_pilih'] = date("Y-m-d", $end_pilih);*/
}

$cek_periode = $data;

