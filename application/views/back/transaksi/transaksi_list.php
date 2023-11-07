<?php $this->load->view('back/meta') ?>
<div class="wrapper">
  <?php $this->load->view('back/navbar') ?>
  <?php $this->load->view('back/sidebar') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $title ?></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><?php echo $module ?></a></li>
        <li class="active"><?php echo $title ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12">
          <div class="box box-primary">
            <div class="box-body">
              <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="text-align: center">No.</th>
                      <th style="text-align: center">Invoice</th>
                      <th style="text-align: center">Atas Nama</th>
                      <th style="text-align: center">Dibuat</th>
                      <th style="text-align: center">Grand Total</th>
                      <th style="text-align: center">Status</th>
                      <!-- <th style="text-align: center">File</th> -->
                      <th style="text-align: center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($get_all as $data) { ?>
                      <tr>
                        <td style="text-align:center"><?php echo $no++ ?></td>
                        <td style="text-align:center"><?php echo $data->id_invoice ?></a></td>
                        <td style="text-align:center"><?php echo $data->name ?></a></td>
                        <td style="text-align:center"><?php echo tgl_indo($data->created_date) ?></td>
                        <td style="text-align:center"><?php echo number_format($data->grand_total) ?></a></td>
                        <td style="text-align:center">
                          <?php if ($data->status_midtrans == '200') { ?>
                            <span class="badge badge-success" style="background-color: green;">Success</span>
                          <?php   } elseif ($data->status_midtrans == '201') {?>
                            <span class="badge bg-warning">Pending</span>
                          <?php   }  else {?>
                            <span class="badge bg-danger">Cancel</span>
                          <?php   } ?>
                        </td>
                        <td style="text-align:center">
                          <?php if ($data->status_midtrans == '201') { ?>
                            <a href="<?php echo base_url('admin/transaksi/set_lunas/') . $data->id_trans ?>">
                              <button name="update" class="btn btn-success"><i class="fa fa-check"></i> Set Lunas</button>
                            </a>
                          <?php } ?>
                          <a href="<?php echo base_url('admin/transaksi/detail/') . $data->id_trans ?>">
                            <button name="update" class="btn btn-primary"><i class="fa fa-search-plus"></i> Detail</button>
                          </a>
                          <a href="<?php echo base_url('admin/transaksi/hapus/') . $data->id_trans ?>">
                            <button name="hapus" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                          </a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!-- ./col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php $this->load->view('back/footer') ?>
</div><!-- ./wrapper -->
<?php $this->load->view('back/js') ?>
</body>

</html>