<?php
$opts = array(
  'http'=>array(
    'header'=>"User-Agent:Kenrick-Tool/0.3"
  )
);
$tool_context = stream_context_create($opts);
$context = $tool_context;
if (isset($_REQUEST['tahun'])) {
	$tahun = $_REQUEST['tahun'];
} else {
	if (time() < mktime(0, 0, 0, 7, 1, gmdate("Y"))) {
		$tahun = gmdate("Y");
	} else if (time() >= mktime(0, 0, 0, 7, 1, gmdate("Y"))) {
		$tahun = gmdate("Y")+1;
	}
}
if (isset($_REQUEST['periode'])) {
	$periode = $_REQUEST['periode'];
} else {
	$periode = 0;
}
$cek_periode = "";
include "cekPeriode.php";
#var_dump($cek_periode);

$periode_usul = 0;
$periode_pilih = 0;
for ($i=1; $i<=23; $i++) {
	if ( ($cek_periode[$i]['start_usul'] <= time()) && (time() <= $cek_periode[$i]['end_usul'] ) ){
		$periode_usul = $i;
	} else if ( ($cek_periode[$i]['start_pilih'] <= time()) && (time() <= $cek_periode[$i]['end_pilih'] ) ){
		$periode_pilih = $i;
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kenrick Tool 0.3: WP:GPU</title>
</head>
<style type="text/css">
	@import "css/bootstrap.min.css";
	
	#main {
		margin-top:4em;
		margin-bottom:1em;
		min-height:20em;
	}
	#atas, #usul, #masuk, #pilih, #tentang {
		padding-top:4em;
		display:none;
	}
	.dummyform {
		display:none;
	}
	#inputNama, #inputHead, #inputDes {
		font-family:"Courier New", Courier, monospace;
	}
	#iframe-wp {
		width:800px;
		height:250px;
		border:1px solid black;
	}
	#masukFooter {
		text-align:center;
	}
	#masukForm {
		display:inline-block;
	}
	#alert {
		display:none;
	}
	.hor-bar {
		height:auto;
		width:800px;
		margin-bottom:60px;
	}
	.selected {
		background-color:#00CC00;
	}
	.imgSelected {
		opacity:0.7;
	}
</style>
<body>
<div id="header" class="navbar navbar-fixed-top">
	<div class="navbar-inner">
    	<div class="container">
        	<a class="brand atas-trigger" href="javascript:void(0);">WP:GPU</a>
            <ul class="nav">
                <li><a class="masuk-trigger" href="javascript:void(0);">Masuk</a></li>
                <li><a class="usul-trigger" href="javascript:void(0);">Usul</a></li>
                <li><a class="pilih-trigger" href="javascript:void(0);">Pilih</a></li>
                <li><a class="tentang-trigger"  href="javascript:void(0);">Tentang</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="main" class="container">
        <div id="top">
        	
        </div>
        <div id="content" class="span12">
            <div id="atas" class="hero-unit">
            <h1>Pemilihan Gambar Pilihan</h1>
            <p>Masuk &middot; Usul &middot; Pilih</p>
            <p>
                <a class="masuk-trigger btn btn-primary btn-large" href="javascript:void(0);">
                    Masuk
                </a>
            </p>
            </div>
            <div id="masuk" class="hero-unit">
                <h1>Masuk</h1>
                <div id="masukBody">
                    <p>Pastikan Anda telah masuk log ke Wikipedia bahasa Indonesia sebelum memilih ataupun mengusulkan gambar.</p>
                    <div style="position:relative">
                    <iframe src="http://id.wikipedia.org/wiki/" scrolling="no" name="iframe-wp" id="iframe-wp"></iframe>
                    <img src="img/transparent.png" style="position:absolute; top:0px; left:0px;">
                    </div>
                </div>
                <br />
                <div id="masukMsg"></div>
                <div id="masukFooter">
                    <form action="javascript:void(0);" method="post" id="masukForm">
                    <input name="username" id="username" type="text" placeholder="Nama pengguna Anda" autocomplete="off" class="span5"/><br />
                    <a href="javascript:void(0);" class="usul-trigger btn btn-primary btn-large span3">Usul</a>&nbsp;
                    <a href="javascript:void(0);" class="pilih-trigger btn btn-primary btn-large span3">Pilih</a>
                    </form>
                </div>
            </div>
            <div id="usul" class="hero-unit">
                <h1>Usul</h1>
                <div id="usulBody">
                    
                </div>
                <div id="usulFooter">
                    
                </div>
            </div>
            <div id="pilih" class="hero-unit">
                <h1>Pilih</h1>
                <div id="pilihBody">
                    
                </div>
                <div id="pilihFooter">
                    
                </div>
            </div>
            <div id="tentang" class="hero-unit">
                <h1>Tentang</h1>
                <div id="tentangBody">
                    <p>
                        Proyek ini dibuat untuk memfasilitasi pemilihan/pengusulan Gambar Pilihan di Wikipedia bahasa Indonesia.
                    </p>
                    <p>
                        Kredit:
                        <ul>
                            <li>Twitter Bootstrap (JS & CSS)</li>
                            <li>jQuery 1.9.1</li>
                            <li>Wikipedia API</li>
                            <li>Sebagian ide alur dari <a href="http://toolserver.org/~luxo/derivativeFX/">derivativeFX</a></li>
                            <li>Potongan kode dari <a href="http://tools.wmflabs.org/tusc/index.html">TUSC</a></li>
                        </ul>
                    </p>
                    <p>
                        Detail:
                        <ul>
                            <li>Dimulai awal Juni 2013</li>
                            <li>Percobaan "alpha" dimulai 13 Juni 2013</li>
                            <li>Selesai 17 Juni 2013</li>
                        </ul>
                    </p>
                    <p>
                        Dibuat oleh Kenrick (<a href="http://id.wikipedia.org/wiki/Pengguna:Kenrick95">Pengguna:Kenrick95</a>)
                    </p>
                    <p>
                        Di luar lisensi kode dan ide yang telah disebutkan, kode proyek ini dilisensikan dengan lisensi MIT
<pre>
The MIT License (MIT)

Copyright (c) 2013 Kenrick

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
</pre>
                    </p>
                </div>
                <div id="tentangFooter">
                    
                </div>
            </div>
        </div>
        <div id="bottom">
        	Oleh Kℇℵ℟ℑℭK
        </div>
</div>
<div id="footer">

</div>
</body>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function (){
		_tahun = <?php echo $tahun; ?>;
		_periode = <?php echo $periode; ?>;
		_periodeUsul = <?php echo $periode_usul; ?>;
		_periodePilih = <?php echo $periode_pilih; ?>;
		_opsi = "masuk";
		
		function scrollToElem(_elem, _duration = 600) {
			$('html, body').animate({
				 scrollTop: $(_elem).offset().top
			 }, _duration);
		}
		
		$(".atas-trigger").click(function () {
			$("#atas").show();
			$("#masuk").hide();
			$("#pilih").hide();
			$("#usul").hide();
			$("#tentang").hide();
		});
		<?php
			if (isset($_COOKIE['wbigpu_username'])) {
		?>
		$("#username").val("<?php echo $_COOKIE['wbigpu_username']; ?>");
		$("#atas").show("slow", function () {
			$('#atas').slideUp("slow", function () {
				$('#masuk').slideDown("slow", function () {
					scrollToElem("#masuk");
				});
			});
		});
		<?php
			} else {
		?>
		$("#atas").show();
		<?php
			}
		?>
		$('.masuk-trigger').click(function () {
			$('#atas').slideUp("slow", function () {
				$('#masuk').slideDown("slow", function () {
					$("body").scrollspy('refresh');
					$("#masukMsg").html("");
					$("#masukFooter").show();
				});
			});
		});
		$(".pilih-trigger").click(function () {
			_opsi = "pilih";
			$("#masukForm").submit();
		});
		$(".usul-trigger").click(function () {
			_opsi = "usul";
			$("#masukForm").submit();
		});
		$(".tentang-trigger").click(function () {
			if ($("#tentang").is(":visible")) {
				$("#tentang").slideUp();
			} else {
				$("#tentang").slideDown();
				scrollToElem("#tentang", 200);
			}
		});
		$("#masukForm").submit(function () {
			_username = $("#username").val();
			if (_username == "") {
				_opsi = "masuk";
				$("#masukMsg").html("Isikan nama pengguna Anda!");
				$("#username").focus();
				return false;
			}
			$("#masukMsg").html("<img src=\"img/ajax-loader.gif\" width=\"32\"/>");
			$("#masukFooter").hide();
			if (_opsi == "usul") {
				$.ajax({
				   type: "POST",
				   url: "usulForm.php",
				   data: { username: _username, tahun: _tahun, periode: _periodeUsul },
				   dataType: "html",
				   success: function(data) {
						$("#usulBody").html(data);
						initUsul();
						$('#masuk').slideUp("slow", function () {
							$('#usul').slideDown("slow", function () {
								scrollToElem("#usul");
							});
						});
						},
					error:function (xhr, ajaxOptions, thrownError){ alert(xhr.statusText) }
				   });
			} else if (_opsi == "pilih") {
				$.ajax({
				   type: "POST",
				   url: "pilihForm.php",
				   data: { username: _username, tahun: _tahun, periode: _periodePilih },
				   dataType: "html",
				   success: function(data) {
						$("#pilihBody").html(data);
						initPilih();
						$('#masuk').slideUp("slow", function () {
							$('#pilih').slideDown("slow", function () {
								scrollToElem("#pilih");
							});
						});
						},
					error:function (xhr, ajaxOptions, thrownError){ alert(xhr.statusText) }
				   });
			}
		});
		function initUsul() {
			
			$(".btn-inputSlot").click(function () {
				$("#inputSlot").val($(this).val());
				_inputSlot = $("#inputSlot").val();
				if (_inputSlot % 4 == 0) {
					_section = 4;
				} else {
					_section = parseInt(_inputSlot % 4);
				}
				_link = 
					"http://id.wikipedia.org/w/index.php?title=Wikipedia:Gambar pilihan/Usulan/" + _tahun + 
					"/Periode_" + _periodeUsul + "&action=edit&section=" + _section;
				_link += "#editform";
				$("#usulEditForm").attr("action", _link);
			});
			
			$("#usulForm").submit(function () {
				_inputNama = $("#inputNama").val();
				if (_inputNama == "") {
					$("#inputNama").focus();
					$("#alert").show();
					$("#err").html("Nama berkas tidak boleh kosong.");
					return false;
				}
				if (_inputNama.search("Berkas:") > -1) {
					_inputNama = _inputNama.replace("Berkas:","");
					$("#inputNama").html(_inputNama);
				}
				if (_inputNama.search("File:") > -1) {
					_inputNama = _inputNama.replace("File:","");
					$("#inputNama").html(_inputNama);
				}
				_inputHead = $("#inputHead").val();
				if (_inputHead == "") {
					$("#inputHead").focus();
					$("#alert").show();
					$("#err").html("Deskripsi singkat berkas tidak boleh kosong.");
					return false;
				}
				_inputDes = $("#inputDes").val();
				if (_inputDes == "") {
					$("#inputDes").focus();
					$("#alert").show();
					$("#err").html("Deskripsi berkas tidak boleh kosong.");
					return false;
				}
				_inputSlot = $("#inputSlot").val();
				if (_inputSlot == -1) {
					$("#alert").show();
					$("#err").html("Slot harus dipilih.");
					return false;
				}
				
				_inputPeriode = $("#inputPeriode").val();
				if (_inputSlot % 4 == 0) {
					_section = 4;
				} else {
					_section = parseInt(_inputSlot % 4);
				}
				
				
				_tempWikitext = "";
				
				
				$.ajax({
				   type: "POST",
				   url: "getWikitext.php",
				   data: { section: _section, tahun: _tahun, periode: _periodeUsul },
				   dataType: "html",
				   success: function(data) {
						_tempWikitext = data;
						if (_section == 4) {
							_tempWikitext =_tempWikitext.replace("{{GP"+_tahun+"/Bawah}}",""); 
						} else {
							_tempWikitext =_tempWikitext.replace("{{GP"+_tahun+"/Slot}}",""); 
						}
						_usulTextbox =
							_tempWikitext
							+ "\n"
							+ "{{GP2013/Usul\n"
							+ "| terpilih = <!-- JANGAN UBAH BARIS INI -->\n"
							+ "| gbr  = "+_inputNama+"\n"
							+ "| head = "+_inputHead+"\n"
							+ "| des  = "+_inputDes+"\n"
							+ "| ttd  = ~~~~\n"
							+ "| vote = <!-- BERIKAN SUARA ANDA DI BAWAH BARIS INI -->\n"
							+ "\n"
							+ "}}\n";
						
						if (_section == 4) {
							_usulTextbox += "{{GP"+_tahun+"/Bawah}}\n";
						} else {
							_usulTextbox += "{{GP"+_tahun+"/Slot}}\n";
						}
						_usulSummary = "Mengusulkan gambar untuk Gambar Pilihan ke-" + _inputSlot + " tahun " + _tahun;
						$("#usulTextbox").val(_usulTextbox);
						$("#usulSummary").val(_usulSummary);
						time = new Date();
						year = time.getUTCFullYear();
						month = time.getUTCMonth();
						day = time.getUTCDay();
						hours = time.getUTCHours();
						mins = time.getUTCMinutes();
						secs = time.getUTCSeconds();
						usulTime = year + "" + month + "" + day + "" + hours + "" + mins + "" + secs;
						$("#usulStarttime").val(usulTime);
						$("#usulEdittime").val(usulTime);
						
						$("#usulEditForm").submit();
						alert("Membuka tab baru...\njika tidak terbuka, nonaktifkan fitur pop-up blocker");
						
						_confirm = confirm("Kembali ke halaman awal?");
						if (_confirm) {
							window.location.reload(true);
						}
						},
					error:function (xhr, ajaxOptions, thrownError){ alert(xhr.statusText); }
				   });
				
			});
		}
		function initPilih() {
			_slot = 0;
			_s4 = _periodePilih*4;
			_s3 = _s4-1;
			_s2 = _s3-1;
			_s1 = _s2-1;
			_p1 = "";
			_p2 = "";
			_p3 = "";
			_p4 = "";
			
			$(".vote").click(function () {
				_slot = $(this).data("slot");
				_gbr = $(this).data("gbr");
				//alert(_slot + "    " + _gbr);
				_tableSlot = "#tableSlot-" + _slot;
				
				_filter = _tableSlot + " .selected";
				$(_filter).removeClass("selected");
				
				_filter = _tableSlot + " .imgSelected";
				$(_filter).removeClass("imgSelected");
				
				$(this).addClass("selected");
				$(this).children("div").children("img").addClass("imgSelected");
				_slotPilih = "#inputSlot-" + _slot;
				$(_slotPilih).val(_gbr);
				
				switch(_slot % 4) {
					case 1: _p1=_gbr; break;
					case 2: _p2=_gbr; break;
					case 3: _p3=_gbr; break;
					case 0: _p4=_gbr; break;
				}
				
				//alert($(_slotPilih).val());
			});
			$("#pilihForm").submit(function () {
				$.ajax({
				   type: "POST",
				   url: "prosesPilih.php",
				   data: { tahun: _tahun, periode: _periodePilih, s1:_s1, p1:_p1, s2:_s2, p2:_p2, s3:_s3, p3:_p3, s4:_s4, p4:_p4 },
				   dataType: "html",
				   success: function(data) {
				   		//$("#pilihDebug").html(data);_link = 
						_link = "http://id.wikipedia.org/w/index.php?title=Wikipedia:Gambar pilihan/Usulan/" + _tahun + 
							"/Periode_" + _periodePilih + "&action=edit";
						_link += "#editform";
						$("#pilihEditForm").attr("action", _link);
						
						_pilihTextbox = data;
						
						_pilihSummary = "Memilih gambar untuk Gambar Pilihan periode " + _periodePilih + " tahun " + _tahun;
						$("#pilihTextbox").val(_pilihTextbox);
						$("#pilihSummary").val(_pilihSummary);
						time = new Date();
						year = time.getUTCFullYear();
						month = time.getUTCMonth();
						day = time.getUTCDay();
						hours = time.getUTCHours();
						mins = time.getUTCMinutes();
						secs = time.getUTCSeconds();
						pilihTime = year + "" + month + "" + day + "" + hours + "" + mins + "" + secs;
						$("#pilihStarttime").val(pilihTime);
						$("#pilihEdittime").val(pilihTime);
						
						
						$("#pilihEditForm").submit();
						alert("Membuka tab baru...\njika tidak terbuka, nonaktifkan fitur pop-up blocker");
						_confirm = confirm("Kembali ke halaman awal?");
						if (_confirm) {
							window.location.reload(true);
						}
						},
					error:function (xhr, ajaxOptions, thrownError){ alert(xhr.statusText); }
				   });
				
			});
		}
	});
</script>
</html>
