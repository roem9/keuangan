    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Keuangan</div>
      </a>

      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Keuangan
      </div>

      <li class="nav-item" id="civitas">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dropone" aria-expanded="true" aria-controls="dropone">
          <i class="fas fa-fw fa-user-tie"></i>
          <span>Civitas</span>
        </a>
        <div id="dropone" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-primary py-2 collapse-inner rounded">
            <h6 class="collapse-header text-light">Civitas</h6>
            <a class="collapse-item text-light" href="<?=base_url()?>civitas/karyawan">Karyawan</a>
            <a class="collapse-item text-light" href="<?=base_url()?>civitas/kpq">KPQ</a>
          </div>
        </div>
      </li>

      <li class="nav-item" id="rekap">
        <a class="nav-link" href="<?=base_url()?>rekap/honor">
          <i class="fas fa-fw fa-money-bill-alt"></i>
          <span>Rekap Honor</span></a>
      </li>
      
      <li class="nav-item" id="piutang">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#droptwo" aria-expanded="true" aria-controls="droptwo">
          <i class="fas fa-fw fa-money-check-alt"></i>
          <span>Transaksi</span>
        </a>
        <div id="droptwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-primary py-2 collapse-inner rounded">
            <h6 class="collapse-header text-light">Transaksi</h6>
            <a class="collapse-item text-light" href="<?=base_url()?>piutang/reguler">Piutang Reguler</a>
            <a class="collapse-item text-light" href="<?=base_url()?>piutang/pvkhusus">Piutang PV Khusus</a>
            <a class="collapse-item text-light" href="<?=base_url()?>piutang/pvluar">Piutang PV Luar</a>
            <a class="collapse-item text-light" href="<?=base_url()?>piutang/kpq">Piutang Civitas</a>
            <a class="collapse-item text-light" href="<?=base_url()?>transaksi/lainnya">Transaksi Lainnya</a>
            <a class="collapse-item text-light bg-danger" onclick="return confirm('Apakah Anda yakin akan mengenerate piutang?')" href="<?=base_url()?>piutang/generatepiutang">Generate Piutang</a>
          </div>
        </div>
      </li>

      <li class="nav-item" id="laporan">
        <a class="nav-link" href="#modal-laporan" data-toggle="modal">
          <i class="fas fa-fw fa-money-check-alt"></i>
          <span>laporan</span></a>
      </li>
      
      <!-- <li class="nav-item" id="laporan">
        <a class="nav-link" href="<?= base_url()?>piutang/generatepiutang" onclick="return confirm('Apakah Anda yakin akan mengenerate piutang?')">
          <i class="fas fa-fw fa-flag"></i>
          <span>Generate Piutang</span></a>
      </li> -->
      
      <li class="nav-item" id="Peserta">
        <a class="nav-link" href="<?= base_url()?>login/logout">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Keluar</span></a>
      </li>
    </ul>
    <!-- End of Sidebar -->
