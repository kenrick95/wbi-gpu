<?php
$opts = array(
  'http'=>array(
    'header'=>"User-Agent:Kenrick-Tool/0.3"
  )
);
$tool_context = stream_context_create($opts);
if (isset($_REQUEST['periode'])) {
	$periode = $_REQUEST['periode'];
} else {
	$periode = 1;
}
if (isset($_REQUEST['tahun'])) {
	$tahun = $_REQUEST['tahun'];
} else {
	$tahun = 2013;
}
if (isset($_REQUEST['username'])) {
	$username = $_REQUEST['username'];
	setcookie("wbigpu_username", $username, time() + 3600);
} else {
	$username = NULL;
}
$slot_wikitext = array();
$num_slot_available = 4;
?>
<?php
	if ($periode == 0) {
	?>
     <p>
    <h3>Terima kasih<br/>Periode pemilihan gambar pilihan tahun <?php echo $tahun ?> telah selesai.</h3>
    <a href="index.php" class="btn btn-primary btn-large">Kembali</a>
    </p>
    <?php
		exit();
	}
	?>
<?php
    $context = $tool_context;
    $slot = $periode*4-4;
    for ($i=1; $i<=4; $i++) {
        $slot++;
		
        $loc = 'http://id.wikipedia.org/w/api.php?action=query&prop=revisions&rvlimit=1&rvprop=content&format=json&rvsection='.$i.'&indexpageids&titles=Wikipedia:Gambar_pilihan/Usulan/2013/Periode_'.urlencode($periode);
        $json = file_get_contents($loc, false, $context);
        $data=json_decode($json, true);
        $pageid = (int) $data['query']['pageids'][0];
        $wikitext = trim($data['query']['pages'][$pageid]['revisions'][0]['*']);
        
        $spiece = array($wikitext);
        
        #echo $slot;
        if (strpos($spiece[0],"{{GP2013/Usul")!==FALSE) {
            $slot_available[$slot] = TRUE;
            $piece = explode("{{GP2013/Usul", $spiece[0]);
            $lim = sizeof ($piece);
            foreach (range(1, $lim-1) as $p) {
                $piece2 = explode("| vote = <!-- BERIKAN SUARA ANDA DI BAWAH BARIS INI -->",$piece[$p]);
                $sisa = $piece2[0];
                $slot_wikitext[$slot][$p] = $sisa;
                #var_dump($sisa);
                $p++;
                if (isset($username)) {
                    if (stripos($sisa, $username)!==FALSE) {
                        $slot_available[$slot] = FALSE;
						$num_slot_available--;
                    }
                }
            }
            $slot_num[$slot] = sizeof($slot_wikitext[$slot]);
        }
    }
        ?>

 	<?php
	if ($num_slot_available == 0) {
	?>
     <p>
    <h3>Terima kasih<br/>Anda telah mengusulkan gambar di setiap slot.</h3>
    <a href="index.php" class="btn btn-primary btn-large">Kembali</a>
    </p>
    <?php
		exit();
	}
	?>
<h3>
Periode <?php echo $periode; ?> tahun <?php echo $tahun; ?>
</h3>
<p>
    Usulkan 1 (satu) gambar di setiap slot.
</p>
 <p>
    <form class="form-horizontal" id="usulForm" action="javascript:void(0);">
    <div id="alert" class="alert alert-block alert-error">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
    	<h4 class="alert-heading">Kesalahan</h4>
        <div id="err"></div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputNama">Nama berkas<br />(tanpa awalan "Berkas:")</label>
        <div class="controls">
            <input type="text" id="inputNama" placeholder="Nama berkas" class="span7" autocomplete="off">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputHead">Deskripsi singat berkas (header)</label>
        <div class="controls">
            <input type="text" id="inputHead" placeholder="Deskripsi singkat berkas" class="span7" autocomplete="off">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputDes">Deskripsi berkas</label>
        <div class="controls">
            <textarea id="inputDes" placeholder="Deskripsi berkas" class="span7"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Slot</label>
            <div class="controls btn-group" data-toggle="buttons-radio">
                <?php
                foreach (range($periode*4-3, $periode*4) as $slot) {
                    
                ?>
                <button type="button" id="button-<?php echo $slot; ?>" class="btn btn-inputSlot"
                <?php
                    if (!$slot_available[$slot]) {
                ?>
                disabled="disabled"    
                <?php
                    }
                ?>
                value="<?php echo $slot; ?>"><?php echo $slot; ?></button>
                <?php
                }
                ?>
            </div>
            <input type="hidden" value="-1" id="inputSlot" />
            <input type="hidden" value="<?php echo $periode; ?>" id="inputPeriode" />
    </div>
    <div class="control-group" id="usulFormSubmit">
            <div class="controls span7">
                <button type="submit" class="btn btn-primary btn-large">Usul!</button>
                <br />
            	Dengan mengeklik tombol "Usul!", Anda setuju bahwa:
                <ul>
                    <li>Anda <strong>harus</strong> menonaktifkan <i>pop-up blocker</i> untuk halaman ini.</li>
                    <li>Tindakan Anda akan membuka tab baru</li>
                    <li>Anda harus memeriksa suntingan sebelum menyimpan halaman</li>
                </ul>
                
            </div>
    </div>
    </form>
    <div class="dummyform">
        <form id="usulEditForm" method="post" enctype="multipart/form-data" target="_blank" action="javascript:void(0);" style="display:inline">
        <input value="" name="wpTextbox1" type="hidden" id="usulTextbox">
        <input value="" name="wpSummary" type="hidden" id="usulSummary">
        <input value="" name="wpStarttime" type="hidden" id="usulStarttime">
        <input value="" name="wpPreview" type="hidden">
        <input value="" name="wpMinoredit" type="hidden">
        <input value="" name="wpEdittime" type="hidden" id="UsulEdittime">
        </form>
        <!--<input value="0" name="wpMinoredit" type="hidden">-->
        <!--<input name="wpPreview" value="0" type="hidden">-->
    </div>
 </p>