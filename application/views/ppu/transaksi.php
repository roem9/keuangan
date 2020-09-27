<!-- modal transaksi lain -->
    <div class="modal fade" id="modalTransaksi" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title nama-title" id="exampleModalScrollableTitle">Transaksi PPU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body cus-font">
                    <form action="<?=base_url()?>ppu/add_transaksi" method="post" id="formInput">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control form-control-sm" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Al-Quran">Al-Quran</option>
                                <option value="Ambulance">Ambulance</option>
                                <option value="Infaq">Infaq</option>
                                <option value="P2J">P2J</option>
                                <option value="Waqaf">Waqaf</option>
                                <option value="Zakat">Zakat</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lainnya">Lainnya</label>
                            <input type="text" name="lainnya" id="lainnya" class="form-control form-control-sm" disabled>
                            <small id="" class="form-text text-muted">Form ini wajib diisi jika jenis = Lainnya</small>
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
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control form-control-sm" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nominal_deposit">Nominal</label>
                            <input type="text" name="nominal" id="nominal_deposit" class="form-control form-control-sm" required>
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
                <form action="<?= base_url()?>ppu/edit_transaksi" method="POST" id="form-edit">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control form-control-sm" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Al-Quran">Al-Quran</option>
                            <option value="Ambulance">Ambulance</option>
                            <option value="Infaq">Infaq</option>
                            <option value="P2J">P2J</option>
                            <option value="Waqaf">Waqaf</option>
                            <option value="Zakat">Zakat</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lainnya">Lainnya</label>
                        <input type="text" name="lainnya" id="lainnya" class="form-control form-control-sm" disabled>
                        <small id="" class="form-text text-muted">Form ini wajib diisi jika jenis = Lainnya</small>
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tgl</label>
                        <input type="date" name="tgl" id="tgl" class="form-control form-control-sm" value="<?= date('Y-m-d')?>" required>
                    </div>
                    <div class="form-group">
                        <label for="metode">Metode Pembayaran</label>
                        <input type="text" name="metode" id="metode" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control form-control-sm" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nominal_deposit">Nominal</label>
                        <input type="text" name="nominal" id="nominal_deposit" class="form-control form-control-sm" required>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Edit Transaksi" id="submitModalEditData">
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
<!-- modal edit transaksi -->

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="row ml-2 mb-3">
                <h1 class="h3 mb-0 text-gray-800 mt-3"><?= $title?></h1>
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
                                        foreach ($ppu as $detail) :
                                        ?>
                                            <tr>
                                                <td><center><?= ++$no?></center></td>
                                                <td><?= date("d-M-Y", strtotime($detail['tgl']))?></td>
                                                <td><?= $detail['nama']?></td>
                                                <td><?= $detail['jenis']?></td>
                                                <td><?= rupiah($detail['nominal'])?></td>
                                                <td><?= $detail['metode']?></td>
                                                <?php if($detail['metode'] == "Cash"):?>
                                                    <td><center>-</center></td>
                                                <?php elseif($detail['metode'] == "Transfer"):?>
                                                    <td><a href="<?=base_url()?>ppu/kuitansi_transfer/<?= $detail['id']?>" target=_blank><center><i class="fa fa-print"></i></center></a></td>
                                                <?php endif;?>
                                                <?php if($detail['metode'] == "Cash"):?>
                                                    <td><center><a href="#" class="btn btn-sm btn-outline-success modalEditCash" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id']?>">edit</a></center></td>
                                                <?php elseif($detail['metode'] == "Transfer"):?>
                                                    <td><center><a href="#" class="btn btn-sm btn-outline-success modalEditTransfer" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id']?>">edit</a></center></td>
                                                <?php endif;?>
                                            </tr>
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
    $("#piutang").addClass("active")

    $(".modalTransaksi").click(function(){
        $('#formInput').trigger("reset");
    })

    $("[name = 'jenis']").change(function(){
        var jenis = $(this).val();

        if(jenis == "Lainnya"){
            $("[name = 'lainnya']").attr("disabled", false);
            $("[name = 'lainnya']").prop('required',true);
            $("[name = 'lainnya']").val("");
        } else {
            $("[name = 'lainnya']").attr("disabled", true);
            $("[name = 'lainnya']").prop('required',false);
            $("[name = 'lainnya']").val("");
        }
    })
    
    // modal edit cash
        $(".modalEditCash").click(function(){
            let jenis = ["Al-Quran", "Ambulance","Infaq", "P2J", "Waqaf", "Zakat"];

            $("#modal-edit").html("Edit Transaksi");
            let id = $(this).data("id");

            $.ajax ({
                url : "<?=base_url()?>ppu/get_transaksi",
                method : "POST",
                data : {id_cash: id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $("[name = 'id']").val(data.id);
                    $("[name = 'nama']").val(data.nama);
                    $("[name = 'tgl']").val(data.tgl);
                    $("[name = 'alamat']").val(data.alamat);
                    $("[name = 'metode']").val("Cash");
                    $("[name = 'nominal']").val(formatRupiah(data.nominal, 'Rp. '));

                    if(jenis.includes(data.jenis)){
                        $("[name = 'jenis']").val(data.jenis);
                    } else {
                        $("[name = 'jenis']").val("Lainnya");
                        $("[name = 'lainnya']").val(data.jenis);
                        $("[name = 'lainnya']").attr("disabled", false);
                        $("[name = 'lainnya']").prop('required',true);
                    }
                }
            })
        })
    // modal edit cash
    
    // modal edit transfer
        $(".modalEditTransfer").click(function(){
            let jenis = ["Al-Quran", "Ambulance","Infaq", "P2J", "Waqaf", "Zakat"];
            $("#modal-edit").html("Edit Transaksi");
            let id = $(this).data("id");
            $("#edit_alamat").removeAttr("readonly");

            $.ajax ({
                url : "<?=base_url()?>ppu/get_transaksi",
                method : "POST",
                data : {id_transfer: id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $("[name = 'id']").val(data.id);
                    $("[name = 'nama']").val(data.nama);
                    $("[name = 'tgl']").val(data.tgl);
                    $("[name = 'alamat']").val(data.alamat);
                    $("[name = 'metode']").val("Transfer");
                    $("[name = 'nominal']").val(formatRupiah(data.nominal, 'Rp. '));

                    if(jenis.includes(data.jenis)){
                        $("[name = 'jenis']").val(data.jenis);
                    } else {
                        $("[name = 'jenis']").val("Lainnya");
                        $("[name = 'lainnya']").val(data.jenis);
                        $("[name = 'lainnya']").attr("disabled", false);
                        $("[name = 'lainnya']").prop('required',true);
                    }
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