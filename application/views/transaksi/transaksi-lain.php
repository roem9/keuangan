<!-- modal transaksi lain -->
    <div class="modal fade" id="modalTransaksi" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title nama-title" id="exampleModalScrollableTitle">Transaksi Lainnya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=base_url()?>transaksi/add_transaksi_lain" method="post">
                        <input type="hidden" name="tipe" id="" value="Lainnya">
                        <input type="hidden" name="pengajar" value="-">
                        <div class="form-group">
                            <label for="nama_pembayaran">Nama</label>
                            <input type="text" name="nama_pembayaran" id="nama_pembayaran" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="untuk">Pembayaran Untuk?</label>
                            <select name="keterangan" id="untuk" class="form-control form-control-sm" required>
                                <option value="">Pilih Pembayaran Untuk</option>
                                <option value="Buku">Buku</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl">Tgl</label>
                            <input type="date" name="tgl" id="tgl" class="form-control form-control-sm" value="<?= date('Y-m-d')?>" required>
                        </div>
                        <div class="form-group">
                            <label for="metode">Metode Pembayaran</label>
                            <select name="metode" id="metode" class="form-control form-control-sm" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="uraian">Keterangan</label>
                            <textarea name="uraian" id="uraian" class="form-control form-control-sm" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nominal_deposit">Nominal</label>
                            <input type="text" name="nominal" id="nominal_deposit" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group" id="formAlamat">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <input type="submit" value="Tambah Transaksi" class="btn btn-sm btn-primary" id="submitModalAddData">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- modal transaksi lain -->

<!-- modal edit transaksi -->
    <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body cus-font">
                <form action="" method="POST" id="form-edit">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="tgl_transaksi">Tanggal</label>
                    <input type="date" name="tgl" id="tgl_transaksi" class="form-control form-control-sm" readonly>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="uraian" id="keterangan" rows="2" class="form-control form-control-sm"></textarea>
                </div>
                <div class="form-group">
                    <label for="nominal_uang">Nominal</label>
                    <input type="text" name="nominal" id="nominal_uang" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="edit_alamat">Alamat</label>
                    <input type="text" name="alamat" id="edit_alamat" class="form-control form-control-sm" readonly>
                </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-success btn-sm" value="Edit" id="submitModalEditData">
                </div>
            </form>
            </div>
        </div>
    </div>
<!-- modal edit transaksi -->

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="row ml-2 mb-3">
                <h1 class="h3 mb-0 text-gray-800 mt-3"><?= $header?></h1>
            </div>
            <div class="row">
                <?php if( $this->session->flashdata('pesan') ) : ?>
                    <div class="col-6">
                        <?= $this->session->flashdata('pesan');?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a href="#" class='nav-link active'>Transaksi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class='nav-link bg-success text-light modalTransaksi' data-toggle="modal" data-target="#modalTransaksi">Tambah Transaksi</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm cus-font" id="dataTable">
                                <thead>
                                    <th><center>No</center></th>
                                    <th>Tgl</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Print</th>
                                    <th>Edit</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($detail as $detail) :
                                            if($detail['nama'] != "" || ($detail['nama'] == "" && $detail['nominal'] != 0)) :
                                        ?>
                                                <tr>
                                                    <td><center><?= ++$no?></center></td>
                                                    <td><?= date("d-M-Y", strtotime($detail['tgl']))?></td>
                                                    <td><?= $detail['nama']?></td>
                                                    <td><?= $detail['uraian']?></td>
                                                    <td><?= rupiah($detail['nominal'])?></td>
                                                    <td><?= $detail['metode']?></td>
                                                    <?php if($detail['metode'] == "Cash"):?>
                                                        <td><center>-</center></td>
                                                    <?php elseif($detail['metode'] == "Transfer"):?>
                                                        <td><a href="<?=base_url()?>kartupiutang/kwitansi_transfer/<?= $detail['id_transfer']?>" target=_blank><center><i class="fa fa-print"></i></center></a></td>
                                                    <?php endif;?>
                                                    <?php if($detail['metode'] == "Cash"):?>
                                                        <td><center>-</center></td>
                                                    <?php elseif($detail['metode'] == "Transfer"):?>
                                                        <td><center><a href="#" class="badge badge-success modalEditTransfer" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id_transfer']?>">edit</a></center></td>
                                                    <?php endif;?>
                                                </tr>
                                            <?php endif;?>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#lain").addClass("active")

    $("#metode").change(function(){
        let metode = $(this).val();
        if(metode == "Transfer"){
            $("#formAlamat").show();
        } else {
            $("#formAlamat").hide();
        }
    })
    
    // modal edit cash
        $(".modalEditCash").click(function(){
            $("#modal-edit").html("Edit Pembayaran");
            let id = $(this).data("id");
            $("#form-edit").attr("action", "<?=base_url()?>kartupiutang/edit_pembayaran_cash")
            $("#edit_alamat").attr("readonly", "readonly");
            $("#edit_alamat").val("");

            $.ajax ({
                url : "<?=base_url()?>kartupiutang/get_data_pembayaran",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $("#transaksi").val("pembayaran");
                    $("#id").val(data.id_pembayaran);
                    $("#nama").val(data.nama_pembayaran);
                    $("#tgl_transaksi").val(data.tgl_pembayaran);
                    $("#keterangan").val(data.uraian);
                    $("#nominal_uang").val(data.nominal);
                }
            })
        })
    // modal edit cash
    
    // modal edit transfer
        $(".modalEditTransfer").click(function(){
            $("#modal-edit").html("Edit Pembayaran");
            let id = $(this).data("id");
            $("#form-edit").attr("action", "<?=base_url()?>kartupiutang/edit_pembayaran_transfer")
            $("#edit_alamat").removeAttr("readonly");

            $.ajax ({
                url : "<?=base_url()?>kartupiutang/get_data_pembayaran_transfer",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $("#edit_alamat").val(data.alamat);
                    $("#id").val(data.id_transfer);
                    $("#nama").val(data.nama_transfer);
                    $("#tgl_transaksi").val(data.tgl_transfer);
                    $("#keterangan").val(data.uraian);
                    $("#nominal_uang").val(data.nominal);
                }
            })
        })
    // modal edit transfer

    // validasi
        $("input[name='nominal']").keyup(function(){
            $(this).val(formatRupiah(this.value, 'Rp. '))
        })
    // validasi

    // submit
        $("#submitModalAddData").click(function(){
        var c = confirm("Yakin akan menambahkan transaksi?");
        return c;
        })

        $("#submitModalEditData").click(function(){
            var c = confirm("Yakin akan mengubah data transaksi?");
            return c;
        })
    // submit
</script>