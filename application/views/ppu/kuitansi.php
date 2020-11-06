<?php

    function rupiah($angka){
            
        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    function tgl_indo($tanggal){
        $bulan = array (1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        tr td{
            height: 30px;
            vertical-align: bottom;
        }
        
        .no{
			position: absolute;
			left: 110px;
			top: 74px;
		}
        
        .nama{
			position: absolute;
			left: 210px;
			top: 99px;
		}
        
        .alamat{
			position: absolute;
			left: 210px;
			top: 125px;
		}
        
        .jenis{
			position: absolute;
			left: 210px;
			top: 177px;
		}
        
        .nominal{
			position: absolute;
			left: 210px;
			top: 152px;
		}
        
        .uang{
			position: absolute;
			left: 110px;
			top: 273px;
		}
        
        .tgl{
			position: absolute;
			left: 555px;
			top: 202px;
		}
    </style>
</head><body>
        <img src="<?= base_url()?>assets/img/kuitansi_ppu.jpg" alt="" srcset="">
        <p class="no"><b><?= $id?></b></p>
        <p class="nama"><b><?= $data['nama']?></b></p>
        <p class="alamat"><b><?= $data['alamat']?></b></p>
        <p class="nominal"><b><?= ucfirst(terbilang($data['nominal']))?> rupiah</b></p>
		<?php if($data['jenis'] != ""):?>
        	<p class="jenis"><b><?= $data['jenis']?> (<?= $data['keterangan']?>)</b></p>
		<?php else :?>
        	<p class="jenis"><b><?= $data['jenis']?></b></p>
		<?php endif;?>
        <p class="uang"><b><?= rupiah($data['nominal'])?></b></p>
        <p class="tgl"><b><?= tgl_indo($data['tgl'])?></b></p>
</body></html>