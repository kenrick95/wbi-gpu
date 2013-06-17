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
$slot_head = array();
$slot_des = array();
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
                $sisa = $piece2[1];
                $piece3 = explode("| gbr  = ",$piece2[0]);
				$piece4 = explode("\n", $piece3[1]);
				$gambar = $piece4[0];
				
				$piece_head1 = explode("| head = ", $piece2[0]);
				$piece_head2 = explode("\n", $piece_head1[1]);
				$head = $piece_head2[0];
				
				$piece_des1 = explode("| des  = ", $piece2[0]);
				$piece_des2 = explode("\n", $piece_des1[1]);
				$des = $piece_des2[0];
				
				
                #var_dump($gambar);
               	$slot_wikitext[$slot][$p] = $gambar;
               	$slot_des[$slot][$p] = $des;
               	$slot_head[$slot][$p] = $head;
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
    <h3>Terima kasih<br/>Anda telah memilih gambar di setiap slot.</h3>
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
    Pilih 1 (satu) gambar di setiap slot.
</p>
    <form class="form" id="pilihForm" action="javascript:void(0);">
    <div id="alert" class="alert alert-block alert-error">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
    	<h4 class="alert-heading">Kesalahan</h4>
        <div id="err"></div>
    </div>
	<?php
    foreach (range($periode*4-3, $periode*4) as $slot) {
    ?>
    <div class="control-group">
        <h3>Slot ke-<?php echo $slot; ?></h3>
        	
        	<?php
            if ($slot_available[$slot]) {
				$lim = sizeof($slot_wikitext[$slot]);
			?>
            <div class="hor-bar">
            	<div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" id="tableSlot-<?php echo $slot; ?>">
                <?php
				$req_img = "";
				foreach (range(1, $lim) as $p) {
					$req_img .= "File:". urlencode($slot_wikitext[$slot][$p]);
					if ($p != $lim) {
						$req_img .= "|";
					}
				}
				$loc = 'http://id.wikipedia.org/w/api.php?action=query&format=xml&prop=imageinfo&iiprop=size|url&iiurlwidth=800&titles='.$req_img;
                $xml = file_get_contents($loc, false, $context);
                $data = new SimpleXMLElement($xml);
				
				foreach (range(0, $lim-1) as $i) {
					$url[$i+1] = trim($data->query->pages->page[$i]->imageinfo->ii['url']);
					$thumburl[$i+1] = trim($data->query->pages->page[$i]->imageinfo->ii['thumburl']);
					$thumbwidth[$i+1] = trim($data->query->pages->page[$i]->imageinfo->ii['thumbwidth']);
					$thumbheight[$i+1] = trim($data->query->pages->page[$i]->imageinfo->ii['thumbheight']);
					$width[$i+1] = trim($data->query->pages->page[$i]->imageinfo->ii['width']);
					$height[$i+1] = trim($data->query->pages->page[$i]->imageinfo->ii['height']);
					
				}
				?>
                
				<?php
				foreach (range(1, $lim) as $p) {
            	?>
				<?php
                #$loc = 'http://id.wikipedia.org/w/api.php?action=query&format=xml&prop=imageinfo&iiprop=size|url&iiurlwidth=800&titles=File:'. urlencode($slot_wikitext[$slot][$p]);
                /*
				
				lambat, tapi gampang diimplementasi
				lagipula
				pengguna pasti cukup sabar untuk menunggu
				wahahahaah 3:)
				
				*//*
                $xml = file_get_contents($loc, false, $context);
                $data = new SimpleXMLElement($xml);
                $url = trim($data->query->pages->page[0]->imageinfo->ii['url']);
                $thumburl = trim($data->query->pages->page[0]->imageinfo->ii['thumburl']);
				$thumbwidth = trim($data->query->pages->page[0]->imageinfo->ii['thumbwidth']);
				$thumbheight = trim($data->query->pages->page[0]->imageinfo->ii['thumbheight']);
				$width = trim($data->query->pages->page[0]->imageinfo->ii['width']);
				$height = trim($data->query->pages->page[0]->imageinfo->ii['height']);
				*/
				$iwidth = 0;
				$iheight = 0;
				$twidth = 0;
				$theight = 0;
				if ($width[$p] > $height[$p] *2.5) {
					#panorama
					$iwidth = min(790,$thumbwidth[$p]);
					$twidth = min(790,$thumbwidth[$p]);
				} else {
					if ($width[$p] < $height[$p]) {
						#vertical
						$iwidth = min(250,$thumbwidth[$p]);
						$twidth = min(250,$thumbwidth[$p]);
					} else {
						$iwidth = min(500,$thumbwidth[$p]);
						$twidth = min(500,$thumbwidth[$p]);
					}
				}
                /*<iframe src="http://id.m.wikipedia.org/wiki/Berkas:<?php echo $slot_wikitext[$slot][$p]; ?>#file" scrolling="auto" style="border:1px; width:600px; height:600px;"></iframe>
                */
                ?>
                <tr>
            	<td
                class="vote"
                style="padding-bottom:15px; width:800px; height:auto; text-align:center; cursor:pointer; "
                data-slot="<?php echo $slot; ?>" data-gbr="<?php echo $slot_wikitext[$slot][$p]; ?>">
                	<div style="display:inline-block;">
                    	<h4><?php echo $slot_head[$slot][$p]; ?></h4>
            			<img src="<?php echo $thumburl[$p]; ?>"
                    	style="width:<?php echo $iwidth; ?>px; height:auto; margin:5px;"/>
                    	<br /><?php echo $slot_des[$slot][$p]; ?>
                    </div>
                </td>
                </tr>
			<?php
				}
			?>
            		
                </table>
            	<input type="hidden" value="-1" id="inputSlot-<?php echo $slot; ?>" />
                </div>
            </div>
            <?php
            } else {
            ?>
            <div class="hor-bar">
            	Terima kasih, Anda telah memilih di slot ini.
            </div>
            <?php
			}
			?>
            <input type="hidden" value="<?php echo $periode; ?>" id="inputPeriode" />
    </div>
    <?php
	}
	?>
    <div id="pilihDebug"></div>
    <div style="clear:both;"></div>
    <div class="control-group" id="pilihFormSubmit">
        <div class="controls span7">
            <button type="submit" class="btn btn-primary btn-large">Pilih!</button>
            <br />
            Dengan mengeklik tombol "Pilih!", Anda setuju bahwa:
            <ul>
                <li>Anda <strong>harus</strong> menonaktifkan <i>pop-up blocker</i> untuk halaman ini.</li>
                <li>Tindakan Anda akan membuka tab baru</li>
                <li>Anda harus memeriksa suntingan sebelum menyimpan halaman</li>
            </ul>
            
        </div>
    </div>
    </form>
    <div class="dummyform">
        <form id="pilihEditForm" method="post" enctype="multipart/form-data" target="_blank" action="javascript:void(0);" style="display:inline">
        <input value="" name="wpTextbox1" type="hidden" id="pilihTextbox">
        <input value="" name="wpSummary" type="hidden" id="pilihSummary">
        <input value="" name="wpStarttime" type="hidden" id="pilihStarttime">
        <input value="" name="wpPreview" type="hidden">
        <input value="" name="wpMinoredit" type="hidden">
        <input value="" name="wpEdittime" type="hidden" id="pilihEdittime">
        </form>
        <!--<input value="0" name="wpMinoredit" type="hidden">-->
        <!--<input name="wpPreview" value="0" type="hidden">-->
    </div>
	<div style="clear:both;"></div>