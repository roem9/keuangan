<?php
    function rupiah($angka){
            
        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    function ot($gol, $kbm, $oot){
        if($gol != 'E'){
            if($oot == '3'){
                if($kbm == '5'){
                    return $ot = 62500;
                } else if($kbm == '4'){
                    return $ot = 50000;
                } else if($kbm == '3'){
                    return $ot = 37500;
                } else if($kbm == '2'){
                    return $ot = 25000;
                } else if($kbm == '1'){
                    return $ot = 12500;
                } else {
                    return $ot = 0;
                }
            } else if($oot == '2'){
                if($kbm == '5'){
                    return $ot = 42000;
                } else if($kbm == '4'){
                    return $ot = 33500;
                } else if($kbm == '3'){
                    return $ot = 25000;
                } else if($kbm == '2'){
                    return $ot = 17000;
                } else if($kbm == '1'){
                    return $ot = 8500;
                } else {
                    return $ot = 0;
                }
            } else if($oot == '1'){
                if($kbm == '5'){
                    return $ot = 21000;
                } else if($kbm == '4'){
                    return $ot = 17000;
                } else if($kbm == '3'){
                    return $ot = 12500;
                } else if($kbm == '2'){
                    return $ot = 8500;
                } else if($kbm == '1'){
                    return $ot = 4500;
                } else {
                    return $ot = 0;
                }
            } 
        } else {
            if($oot == '3'){
                if($kbm == '5'){
                    return $ot = 262500;
                } else if($kbm == '4'){
                    return $ot = 210000;
                } else if($kbm == '3'){
                    return $ot = 157500;
                } else if($kbm == '2'){
                    return $ot = 105000;
                } else if($kbm == '1'){
                    return $ot = 52500;
                } else {
                    return $ot = 0;
                }
            } else if($oot == '2'){
                if($kbm == '5'){
                    return $ot = 175000;
                } else if($kbm == '4'){
                    return $ot = 140000;
                } else if($kbm == '3'){
                    return $ot = 105000;
                } else if($kbm == '2'){
                    return $ot = 70000;
                } else if($kbm == '1'){
                    return $ot = 35000;
                } else {
                    return $ot = 0;
                }
            } else if($oot == '1'){
                if($kbm == '5'){
                    return $ot = 87500;
                } else if($kbm == '4'){
                    return $ot = 70000;
                } else if($kbm == '3'){
                    return $ot = 52500;
                } else if($kbm == '2'){
                    return $ot = 35000;
                } else if($kbm == '1'){
                    return $ot = 17500;
                } else {
                    return $ot = 0;
                }
            } 
        }
    }
?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="d-flex justify-content-begin mt-3">
                    <h1 class="h3 mb-0 text-gray-800 mr-3"><?= $header?></h1>
                </div>
            </div>
            <?php $urut = 0;?>
            <?php foreach ($pengajar as $key => $pengajar) :?>
                <?php if(isset($pengajar['kelas']) || isset($pengajar['kbm_badal'])) :?>
                    <div class="table-responsive">
                        <table class="table text-dark" style="font-size: 12px" border=1>
                            <thead class="thead-light">
                                <tr>
                                    <th colspan=24><center><?= ++$urut.". ".$pengajar['nama_kpq'] . " ( Gol. " . $pengajar['golongan'] . " )"?></center></th>
                                </tr>
                            </thead>
                            <?php if(isset($pengajar['kelas'])) :?>
                                <tr>
                                    <th rowspan=2><center>No</center></th>
                                    <th rowspan=2>Koordinator</th>
                                    <th rowspan=2>Hari</th>
                                    <th rowspan=2>Jam</th>
                                    <th rowspan=2>Tipe</th>
                                    <th rowspan=2>Program</th>
                                    <th colspan=5>Tgl KBM</th>
                                    <th rowspan=2>Jmlh</th>
                                    <th rowspan=2>Pest</th>
                                    <th colspan=5>Pest Hadir</th>
                                    <th rowspan=2>Sesuai</th>
                                    <th rowspan=2>Ganti</th>
                                    <th rowspan=2>Badal</th>
                                    <th rowspan=2>Tempat</th>
                                    <th rowspan=2>Honor</th>
                                    <th rowspan=2>OT</th>
                                </tr>
                                <tr>
                                    <td><center>I</center></td>
                                    <td><center>II</center></td>
                                    <td><center>III</center></td>
                                    <td><center>IV</center></td>
                                    <td><center>V</center></td>
                                    <td><center>I</center></td>
                                    <td><center>II</center></td>
                                    <td><center>III</center></td>
                                    <td><center>IV</center></td>
                                    <td><center>V</center></td>
                                </tr>
                                <?php 
                                    $no = 0;
                                    $total_honor[$key] = 0;
                                    $total_ot[$key] = 0;

                                    if (isset($pengajar['kelas'])) :?>
                                    <?php foreach ($pengajar['kelas'] as $kelas) :?>
                                        <tr>
                                            <td><?= ++$no?></td>
                                            <td><?= $kelas['peserta']?></td>
                                            <td><?= $kelas['hari']?></td>
                                            <td><?= $kelas['jam']?></td>
                                            <td><?= $kelas['tipe_kelas']?></td>
                                            <td><?= $kelas['program_kbm']?></td>

                                            <!-- tgl kbm -->
                                            <?php 
                                                $jumlah_pertemuan = 0;
                                                $kbm_sesuai = 0;
                                                $kbm_ganti = 0;
                                                $kbm_badal = 0;

                                                for ($i=0; $i < 5; $i++) :?>
                                                <?php 
                                                    if(isset($kelas['kbm'][$i])){
                                                        if($kelas['kbm'][$i]['keterangan'] == 'sesuai'){
                                                            $kbm_sesuai += 1;
                                                        } else if($kelas['kbm'][$i]['keterangan'] == 'ganti'){
                                                            $kbm_ganti += 1;
                                                        }

                                                        $jumlah_pertemuan += 1;
                                                        if($kelas['kbm'][$i]['keterangan'] == 'badal'){
                                                            $kbm_badal += 1;
                                                            echo "<td style='background-color: red'> " . date('j', strtotime($kelas['kbm'][$i]['tgl'])) . "</td>";
                                                        } else {
                                                            echo "<td> " . date("j", strtotime($kelas['kbm'][$i]['tgl'])) . "</td>";
                                                        }
                                                    } else {
                                                        echo "<td>-</td>";
                                                    }
                                                ?>
                                            <?php endfor;?>

                                            <td><center><?= $jumlah_pertemuan?></center></td>
                                            <td><center><?= $kelas['jum_peserta']?></center></td>

                                            <!-- peserta hadir -->
                                            <?php for ($i=0; $i < 5; $i++) :?>
                                                <?php 
                                                    if(isset($kelas['kbm'][$i])){
                                                        echo "<td> " . $kelas['kbm'][$i]['peserta'] . "</td>";
                                                    } else {
                                                        echo "<td>-</td>";
                                                    }
                                                ?>
                                            <?php endfor;?>

                                            <td><center><?=$kbm_sesuai?></center></td>
                                            <td><center><?=$kbm_ganti?></center></td>
                                            <td><center><?=$kbm_badal?></center></td>
                                            <td><?=$kelas['tempat']?></td>

                                            <!-- honor -->
                                            <?php $honor = 0;?>
                                            <?php for ($i=0; $i < 5; $i++) :?>
                                                <?php 
                                                    if(isset($kelas['kbm'][$i])){
                                                        if($kelas['kbm'][$i]['keterangan'] != 'badal'){
                                                            $honor += $kelas['kbm'][$i]['biaya'];
                                                        }
                                                    } else {
                                                        $honor += 0;
                                                    }
                                                ?>
                                            <?php endfor;?>
                                            <td><?= rupiah($honor)?></td>
                                            
                                            <!-- ot -->
                                            <?php 
                                                $ot = ot($pengajar['golongan'], $kbm_ganti+$kbm_sesuai, $kelas['ot']);
                                                
                                                // ot nonaktif
                                                $ot = 0;
                                            ?>
                                            <td><?= rupiah($ot)?></td>
                                            
                                            <?php
                                                $total_honor[$key] += $honor;
                                                $total_ot[$key] += $ot;
                                            ?>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                                <tr>
                                    <th colspan=22><center>Total</center></th>
                                    <th><?= rupiah($total_honor[$key])?></th>
                                    <th><?= rupiah($total_ot[$key])?></th>
                                    <?php if(isset($pengajar['kbm_badal'])) :?>
                                    <?php else :?>
                                        <th><?= rupiah($total_honor[$key] + $total_ot[$key])?></th>
                                    <?php endif;?>
                                </tr>
                            <?php endif;?>

                            <?php if(isset($pengajar['kbm_badal'])) :?>
                                <tr>
                                    <th colspan=24><center>KBM Badal</center></th>
                                </tr>
                                <tr>
                                    <th>No</th>
                                    <th>Koordinator</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Tipe</th>
                                    <th>Program</th>
                                    <th colspan=5>Tgl KBM</th>
                                    <th colspan=9>Pengajar Yang Dibadal</th>
                                    <th colspan=2>Kode Badal</th>
                                    <th>Honor</th>
                                    <th>OT</th>
                                </tr>
                                <?php
                                    $no = 0;
                                    $total_honor_badal[$key] = 0;
                                    $total_ot_badal[$key] = 0;
                                    foreach ($pengajar['kbm_badal'] as $badal) :?>
                                        <tr>
                                            <td><?= ++$no?></td>
                                            <td><?= $badal['peserta']?></td>
                                            <td><?= $badal['hari']?></td>
                                            <td><?= $badal['jam']?></td>
                                            <td><?= $badal['tipe_kelas']?></td>
                                            <td><?= $badal['program_kbm']?></td>
                                            <td colspan=5><center><?= date("d-m-Y", strtotime($badal['tgl']))?></center></td>
                                            <td colspan=9><?= $badal['nama_kpq']?></td>
                                            <td colspan=2 style="text-align: left"><?= $badal['id_kbm']?></td>
                                            <td><?= rupiah($badal['biaya'])?></td>
                                            <?php 
                                                $ot = ot($pengajar['golongan'], 1, $badal['oot']);
                                                
                                                // nonaktif ot
                                                $ot = 0;
                                            ?>
                                            <td><?= rupiah($ot)?></td>
                                        </tr>
                                        <?php 
                                            $total_honor_badal[$key] += $badal['biaya'];
                                            $total_ot_badal[$key] += $ot;
                                        ?>
                                <?php endforeach;?>
                                <tr>
                                    <th colspan=22><center>Total</center></th>
                                    <th><?= rupiah($total_honor_badal[$key])?></th>
                                    <th><?= rupiah($total_ot_badal[$key])?></th>
                                    <?php if(!isset($pengajar['kelas']) && isset($pengajar['kbm_badal'])) :?>
                                        <th><?= rupiah($total_honor_badal[$key] + $total_ot_badal[$key])?></th>
                                    <?php endif;?>
                                </tr>
                            <?php endif;?>
                            
                            <?php if(isset($pengajar['kelas']) && isset($pengajar['kbm_badal'])) :?>
                                <tr>
                                    <th colspan=24><center>Honor + Badal</center></th>
                                    <th><?= rupiah($total_honor_badal[$key] + $total_ot_badal[$key] + $total_honor[$key] + $total_ot[$key])?></th>
                                </tr>
                            <?php endif?>
                        </table>
                    </div>
                    <br>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>
<script>
    $("#sidebarRekap").addClass("active");
</script>