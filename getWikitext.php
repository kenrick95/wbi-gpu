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
if (isset($_REQUEST['section'])) {
	$section = $_REQUEST['section'];
} else {
	$section = NULL;
}
if (isset($_REQUEST['periode'])) {
	$periode = $_REQUEST['periode'];
} else {
	$periode = 1;
}
$context = $tool_context;
if (empty($section)) {
	$loc = "http://id.wikipedia.org/w/api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=xml&indexpageids&titles=Wikipedia:Gambar_pilihan/Usulan/".urlencode($tahun)."/Periode_".urlencode($periode);
} else {
	$loc = "http://id.wikipedia.org/w/api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=xml&rvsection=".$section."&indexpageids&titles=Wikipedia:Gambar_pilihan/Usulan/".urlencode($tahun)."/Periode_".urlencode($periode);
}
$xml = file_get_contents($loc, false, $context);
$data = new SimpleXMLElement($xml);
$pageid = (int) $data->query->pageids->id;
$wikitext = trim($data->query->pages->page[0]->revisions->rev);
#$data['query']['pages'][$pageid]['revisions'][0]['*']);
echo $wikitext;
?>
