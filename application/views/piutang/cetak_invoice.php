<?php

    function rupiah($angka){
            
        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
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
<link href="https://fonts.googleapis.com/css?family=Galdeano&display=swap" rel="stylesheet">
    <style>
        #data tr td{
            height: 25px;
            padding-left: 5px;
            border: 1px solid gray;
            font-size : 11px;
        }

        #atas tr td{
            font-size: 12px;
        }
    </style>
</head><body>
    <div class="page" style="width: 85%; margin: auto; padding-top: 80px">
        <table width="100%" id="atas">
            <tr>
                <td width=70%><img src="<?=base_url()?>/assets/img/tarq.png" width="270px"></td>
                <td style="text-align: center; background-color: rgb(152, 72, 7); color: white">
                    <span style="font-size: 26px"><b>INVOICE</b></span>
                </td>
            </tr>
            <tr>
                <td style="text-align: justify"><b>YAYASAN TARBIYAT AL QURAN IMAAMUNA (TAR-Q)<br>Jl. Sidomukti No. 34 Sukaluyu Bandung 40123<br>Telp. (022) 2506410/082121723661</b></td>
                <td>
                    <table>
                        <tr>
                            <td>No</td>
                            <td>: <?= $id?></td>
                        </tr>
                        <tr>
                            <td>Tgl. Inv.</td>
                            <td>: <?= date("d/m/Y", strtotime($invoice['tgl_invoice']))?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <span style="font-size: 12px"><b>
            
            Ditujukan kepada:<br>
            <?= $invoice['nama_invoice']?> <br>
            Di Tempat
        </b></span>
        <table width=100% id="data" style="border-collapse: collapse;">
            <tr>
                <td width=5%><center>No.</center></td>
                <td><center>Uraian Tagihan</center></td>
                <td width=15%><center>Nominal</center></td>
                <td width=15%><center>Jumlah</center></td>
            </tr>
            <?php 
                $no = 0;
                $total = 0;
                foreach ($detail as $detail) :?>
                <tr>
                    <td><center><?= ++$no?></center></td>
                    <td><?= $detail['uraian']?></td>
                    <td><?= rupiah($detail['satuan'])?></td>
                    <td><?= rupiah($detail['nominal'])?></td>
                </tr>
            <?php 
                $total += $detail['nominal'];
                endforeach;?>
            <tr>
                <td colspan=3><center>Total</center></td>
                <td><?= rupiah($total)?></td>
            </tr>
        </table>
        <table width=100%  style="font-size: 10px">
            <tr>
                <td width=15% style="vertical-align: top">Terbilang</td>
                <td width=55% style="height: 30px; vertical-align: top">: <?= ucfirst(terbilang($total))?> rupiah</td>
            </tr>
            <tr>
                <td>Transfer via</td>
                <td>: Bank Syariah Mandiri</td>
                <td rowspan=4>
                    <center>
                    <b>BENDAHARA TAR-Q</b><br>
                    <img src="<?=base_url()?>assets/img/ttd.jpeg" alt="" width=70px><br>
                    <b>Ingrid Larasati Agustina, SE., M.Ak</b></center>
                </td>
            </tr>
            <tr>
                <td>No. Rek</td>
                <td>: 707.988.3152</td>
            </tr>
            <tr>
                <td>a.n</td>
                <td>: Yys Tarbiyat Al Quran Imaamuna</td>
            </tr>
            <tr>
                <td colspan=2>Harga sudah termasuk pajak</td>
            </tr>
            <tr>
                <td colspan=3><br><center>Jika sudah melakukan pembayaran mohon konfirmasi ke no. WA 081313019876 a.n Yesi</center></td>
            </tr>
        </table>
    </div>
</body></html>
