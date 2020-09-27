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
    </style>
</head><body>
        <table width=100% style="font-size: 15px">
            <tr>
                <td width=30% style="padding-left: 30px"><?= $id?></td>
                <td style="padding-left: 150px"><?= $id?></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 150px"><?= $data['nama']?></td>
            </tr>
            <tr>
                <td rowspan=2 style="vertical-align:top"><?= $data['nama']?></td>
                <td style="padding-left: 150px"><?= ucfirst(terbilang($data['nominal']))?> rupiah</td>
            </tr>
            <tr>
                <td>Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="ml-3"><?= $data['alamat']?></span></td>
            </tr>
            <tr>
                <td><?= $data['alamat']?></td>
                <td style="padding-left: 150px"><?= $data['jenis']?></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 400px">Bandung, <?= tgl_indo($data['tgl'])?></td>
            </tr>
            <tr>
                <td><?= $data['jenis']?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="vertical-align: bottom; padding-left: 30px"><?= rupiah($data['nominal'])?></td>
                <td style="vertical-align: bottom; padding-left: 30px"><?= rupiah($data['nominal'])?></td>
            </tr>
        </table>
</body></html>