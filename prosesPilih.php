<?php
header("Content-Type: text/html; charset=UTF-8");
$opts = array(
  'http'=>array(
    'header'=>"User-Agent:Kenrick-Tool/0.3"
  )
);
$tool_context = stream_context_create($opts);

if (isset($_REQUEST['tahun'])) {
	$tahun = $_REQUEST['tahun'];
} else {
	$tahun = date("Y");
}
if (isset($_REQUEST['periode'])) {
	$periode = $_REQUEST['periode'];
} else {
	$periode = 1;
}
if (isset($_REQUEST['p1'])) {
	$s[1] = $_REQUEST['s1'];
	$p[1] = $_REQUEST['p1'];
} else {
	$s[1] = $periode*4-3;
	$p[1] = NULL;
}
if (isset($_REQUEST['p2'])) {
	$s[2] = $_REQUEST['s2'];
	$p[2] = $_REQUEST['p2'];
} else {
	$s[2] = $periode*4-2;
	$p[2] = NULL;
}
if (isset($_REQUEST['p3'])) {
	$s[3] = $_REQUEST['s3'];
	$p[3] = $_REQUEST['p3'];
} else {
	$s[3] = $periode*4-1;
	$p[3] = NULL;
}
if (isset($_REQUEST['p4'])) {
	$s[4] = $_REQUEST['s4'];
	$p[4] = $_REQUEST['p4'];
} else {
	$s[4] = $periode*4;
	$p[4] = NULL;
}
// s: nomor slot
// p: nama berkas yg dipilih

$context = $tool_context;
$loc = "http://id.wikipedia.org/w/api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=xml&indexpageids&titles=Wikipedia:Gambar_pilihan/Usulan/".urlencode($tahun)."/Periode_".urlencode($periode);

$xml = file_get_contents($loc, false, $context);
$data = new SimpleXMLElement($xml);
$pageid = (int) $data->query->pageids->id;
$wikitext = trim($data->query->pages->page[0]->revisions->rev);



$slot = $s[1];
$sep = "=== " . $slot . " " . $tahun . " ===";
$piece1 = explode($sep, $wikitext);
$head = $piece1[0];

$slot = $s[2];
$sep = "=== " . $slot . " " . $tahun . " ===";
$piece2 = explode($sep, $piece1[1]);
$slot_text[1] = $piece2[0];

$slot = $s[3];
$sep = "=== " . $slot . " " . $tahun . " ===";
$piece3 = explode($sep, $piece2[1]);
$slot_text[2] = $piece3[0];

$slot = $s[4];
$sep = "=== " . $slot . " " . $tahun . " ===";
$piece4 = explode($sep, $piece3[1]);
$slot_text[3] = $piece4[0];
$slot_text[4] = $piece4[1];

#var_dump($slot_text);

foreach (range(1,4) as $i) {
	if (empty($p[$i])) {
		continue;
	}
	$piece1 = explode($p[$i], $slot_text[$i]);
	$piece2 = explode("}}\n", $piece1[1]);
	$piece3 = "* {{vote}} ~~~~\n";
	$vote = $piece2[0].$piece3;
	
	$array_join = $piece2;
	$array_join[0] = $vote;
	$joined1 = implode("}}\n", $array_join);
	$array_join = $piece1;
	$array_join[1] = $joined1;
	$joined2 = implode($p[1], $array_join);
	
	$slot_text[$i] = $joined2;
	
	#echo "<pre>";
	#echo $slot_text[$i];
	#echo "</pre>";
}
$wikitext_edit = $head;
$slot = $s[1];
$wikitext_edit .= "=== " . $slot . " " . $tahun . " ===";
$wikitext_edit .= $slot_text[1];

$slot = $s[2];
$wikitext_edit .= "=== " . $slot . " " . $tahun . " ===";
$wikitext_edit .= $slot_text[2];

$slot = $s[3];
$wikitext_edit .= "=== " . $slot . " " . $tahun . " ===";
$wikitext_edit .= $slot_text[3];

$slot = $s[4];
$wikitext_edit .= "=== " . $slot . " " . $tahun . " ===";
$wikitext_edit .= $slot_text[4];


#echo "<pre>";
#echo $wikitext;
#echo "</pre>";



#echo "<pre>";
echo $wikitext_edit;
#echo "</pre>";
?>
