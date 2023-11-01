<?php $this->load->view('kasir/meta') ?>
  <div class="wrapper">
    <?php $this->load->view('kasir/navbar') ?>
    <?php $this->load->view('kasir/sidebar') ?>
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
								<?php echo validation_errors() ?>
								<?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>
								<?php echo form_open($action);?>
                  <table id="datatable myTable" class="table order-list">
                    <thead>
                      <tr>
                        <th style="text-align: center">Nama Barang</th>
                        <th style="text-align: center">Stok</th>
                        <th style="text-align: center">Harga Jual</th>
                        <th style="text-align: center">Qty</th>
                        <th style="text-align: center">Total</th>
                        <th style="text-align: center">Keterangan</th>
                        <th style="text-align: center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select name="nama_barang[]" id="nama_barang" onchange="changeValue(this.value,'')" class="form-control namaBarang" required>
                            <option value="">-Pilih Barang-</option>
                          </select>
                        </td>
                        <td>
                          <input class="form-control" name="stok[]" id="stok" type="text" readonly value="<?php echo set_value('kd_barang[0]') ?>"/>
                          <input class="form-control" name="kd_barang[]" id="kd_barang" type="hidden" readonly value="<?php echo set_value('kd_barang[0]') ?>"/>
                        </td>
                        <td><input class="form-control" name="harga_jual[]" id="harga_jual" type="text" readonly value="<?php echo set_value('harga_jual[0]') ?>"/></td>
                        <td><input class="form-control qty" name="qty[]" id="qty" type="number" placeholder="Isi angka saja" onkeyup="count('');" onchange="count('');" onclick="count('');" value="<?php echo set_value('qty[0]') ?>" min="1" required/></td>
                        <td><input class="form-control total" name="total[]" id="total" type="text" readonly/></td>
                        <td><input class="form-control" name="catatan[]" id="catatan" type="text" value="<?php echo set_value('catatan[0]') ?>"/></td>
                        <td><button type="button" class="btn btn-primary" id="addrow"/><i class="fa fa-plus"></i></button></td>
                      </tr>
                    </tbody>
                  </table>
									<button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button>
									<button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button>
								<?php echo form_close(); ?>
							</div>
						</div>
          </div><!-- ./col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php $this->load->view('kasir/footer') ?>
  </div><!-- ./wrapper -->
  <?php $this->load->view('kasir/js') ?>
  <link href="<?php echo base_url('assets/plugins/')?>datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="<?php echo base_url('assets/plugins/')?>datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript">
  <?php
    $jsArray = "var prdName = new Array();\n";
    foreach ($get_all as $barang)
    {
      $jsArray .= "prdName['".$barang->id_lapangan."'] =
      {
        stok:'".addslashes($barang->stok)."',
        kd_barang:'".addslashes($barang->kd_barang)."',
        harga_jual:'".addslashes($barang->harga_jual)."',
      };\n";
    }
    echo $jsArray;
  ?>
  </script>
</body>
</html>
