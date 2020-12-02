<div class="modal fade" id="modal_edit_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body cus-font">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="btn-invoice-1"><i class="fa fa-file"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="btn-invoice-2"><i class="fa fa-pen"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="btn-invoice-3"><i class="fa fa-plus"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="btn-invoice-4"><i class="fa fa-trash"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="<?=base_url()?>kartupiutang/edit_invoice" method="POST" id="data-invoice-1">
                        <input type="hidden" name="aksi" id="aksi-1">
                        <input type="hidden" name="id" id="id-1">
                        <div class="form-group">
                            <label for="nama_invoice_edit">Nama</label>
                            <input type="text" name="nama" id="nama_invoice_edit" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="tgl_invoice_edit">Tanggal</label>
                            <input type="date" name="tgl" id="tgl_invoice_edit" class="form-control form-control-sm">
                        </div>
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-success btn-sm" value="Edit" id="btn-submit-invoice-1">
                        </div>
                    </form>
                    <form action="<?= base_url()?>kartupiutang/edit_invoice" method="POST" id="data-invoice-2">
                        <input type="hidden" name="aksi" id="aksi-2">
                        <input type="hidden" name="id" id="id-2">
                        <div id="data-uraian-edit"></div>
                        <div class="d-flex justify-content-end mt-1">
                            <input type="submit" value="Edit Data" class="btn btn-sm btn-success" id="btn-submit-invoice-2">
                        </div>
                    </form>
                    <form action="<?= base_url()?>kartupiutang/edit_invoice" method="post"  id="data-invoice-3">
                        <input type="hidden" name="aksi" id="aksi-3">
                        <input type="hidden" name="id" id="id-3">
                        <div class="form-group">
                            <label for="uraian">Uraian</label>
                            <input type="text" name="uraian" id="uraian" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="satuan_invoice">Satuan</label>
                            <input type="text" name="satuan" id="satuan_invoice" class="form-control form-control-sm">
                        </div>
                        <div class="form-gro">
                            <label for="nominal">Nominal</label>
                            <input type="text" name="nominal" id="nominal" class="form-control form-control-sm">
                        </div>
                        <div class="d-flex justify-content-end mt-1">
                            <input type="submit" value="Tambah Data" class="btn btn-sm btn-primary" id="btn-submit-invoice-3">
                        </div>
                    </form>
                    <form action="<?= base_url()?>kartupiutang/edit_invoice" method="post" id="data-invoice-4">
                        <input type="hidden" name="aksi" id="aksi-4">
                        <input type="hidden" name="id" id="id-4">
                        <div id="data-uraian-hapus"></div>
                        <div class="d-flex justify-content-end mt-1">
                            <input type="submit" value="Hapus Data" class="btn btn-sm btn-danger" id="btn-submit-invoice-4">
                        </div>
                    </form>
                </div>
            </div>   
        </div>
        <div class="modal-footer">
        </div>
    </div>
  </div>
</div>