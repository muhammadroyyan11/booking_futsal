<aside class="main-sidebar">
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image"><img src="<?php echo base_url()?>assets/images/user/<?php echo $this->session->userdata('photo').$this->session->userdata('photo_type') ?>" class="img-circle" alt="User Image"/></div>
      <div class="pull-left info">
        <p><?php echo $this->session->userdata('name'); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li class="header"><font style="font-size: 16px;color: white; font-weight: bold">MENU UTAMA</font></li>
      <li class="treeview">
        <a href="http://localhost/mm/futsal/kasir/front/home" target="_blank">
        <!-- <a href="<?php echo base_url() ?>" target="_blank"> -->
          <i class="fa fa-globe"></i> <span>Lihat Website</span>
        </a>
      </li>
      <li <?php if($this->uri->segment(2)=="transaksi" && $this->uri->segment(3)!="update_diskon"){echo "class='active'";} ?>>
        <a href="<?php echo base_url('kasir/transaksi') ?>">
          <i class="fa fa-book"></i> <span>Transaksi</span>
        </a>
      </li>
      <li <?php if($this->uri->segment(2) == "transaksi_2"){echo "class='active'";} ?>>
        <a href='#'><i class='fa fa-list'></i><span> Transaksi_2 </span><i class='fa fa-angle-left pull-right'></i></a>
        <ul class='treeview-menu'>
          <li <?php if($this->uri->segment(2) == "transaksi_2" && $this->uri->segment(3) == "create"){echo "class='active'";} ?>><a href='<?php echo base_url('kasir/transaksi/create_manual') ?>'><i class='fa fa-circle-o'></i> Tambah Transaksi </a></li>
          <li <?php if($this->uri->segment(2) == "transaksi_2" && $this->uri->segment(3) == ""){echo "class='active'";} ?>><a href='<?php echo base_url('kasir/transaksi') ?>'><i class='fa fa-circle-o'></i> Data Transaksi </a></li>
        </ul>
      </li>
      <li class="header"><font style="font-size: 16px;color: white; font-weight: bold">PENGATURAN</font></li>
      <li <?php if($this->uri->segment(3) == "edit_user"){echo "class='active'";} ?>>
        <a href='<?php $user_id = $this->session->userdata('user_id'); echo base_url('kasir/auth/edit_user/'.$user_id.'') ?>'>
          <i class='fa fa-edit'></i><span> Edit Akun </span>
        </a>
      </li>
      <li> <a href='<?php echo base_url() ?>kasir/auth/logout'> <i class="fa fa-sign-out"></i> <span>Logout</span> </a> </li>
    </ul>

  </section>
</aside>
