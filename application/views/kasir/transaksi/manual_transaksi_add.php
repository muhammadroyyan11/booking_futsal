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
            <?php echo validation_errors() ?>
            <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>
            <?php echo form_open_multipart();?>
						  <div class="box box-primary">
                <div class="box-body">
                  <div class="form-group"><label>Pilih Lapangan</label>
					<?php echo form_dropdown('', $ambil_lapangan, '', $lap_id); ?>
				  </div>
                  <?php $no = 1;
					foreach ($cart_data as $cart) { ?>
					<tr>
					<td style="text-align:left"><?php echo $cart->nama_lapangan ?></td>
					<td style="text-align:center" class="harga_per_jam"><?php echo number_format($cart->harga) ?></td>
					<td style="text-align:center">
						<?php echo form_input($tanggal) ?>
						<input type="hidden" name="harga_jual[]" value="<?php echo $cart->harga ?>">
						<input type="hidden" name="lapangan[]" value="<?php echo $cart->lapangan_id ?>">
					    <input type="hidden" name="id_transdet[]" value="<?php echo $cart->id_transdet ?>">
						<input type="hidden" value="<?php echo $cart->lapangan_id; ?>" class="lapangan_id">
					</td>
					<td style="text-align:center">
												<?php echo form_dropdown('', array('' => '- Pilih Tanggal Dulu -'), '', $jam_mulai); ?>
												<span class="loading_container" style="display:none;">
													<img src="<?php echo base_url(); ?>assets/template/frontend/img/loading.gif" style="display:inline;" />&nbsp;memuat data ...</span>
											</td>
											<td style="text-align:center">
												<input type="number" name="durasi[]" class="durasi" min="1">
											</td>
											<td style="text-align:center" class="jam_selesai"></td>
											<td style="text-align:center" class="subtotal"></td>
											<td style="text-align:center">
												<a href="<?php echo base_url('cart/delete/') . $cart->id_transdet ?>" class="btn btn-sm btn-danger"><i class="fa fa-remove"></i></a>
											</td>
										</tr>
									<?php } ?>
                    <div class="form-group"><label>Harga</label>
  				    <?php echo form_input($harga);?>
  				  </div>
                    <div class="form-group"><label>Tanggal</label>
                      <?php echo form_input($tanggal) ?>
						<input type="hidden" name="harga_jual[]" value="<?php echo $cart->harga ?>">
						<input type="hidden" name="lapangan[]" value="<?php echo $cart->lapangan_id ?>">
						<input type="hidden" name="id_transdet[]" value="<?php echo $cart->id_transdet ?>">
						<input type="hidden" value="<?php echo $cart->lapangan_id; ?>" class="lapangan_id">
  				  </div>
                  <div class="form-group"><label>Jam Mulai</label>
                    <?php echo form_input($jam_mulai);?>
                  </div>
                  <div class="form-group"><label>Durasi</label>
                    <?php echo form_input($durasi);?>
                  </div>
                </div>
                <div class="box-footer">
  				<button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button>
  				<button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button>
                </div>
						  </div>
            <?php echo form_close(); ?>
          </div><!-- ./col -->
          <script src="<?php echo base_url('assets/plugins/') ?>datepicker/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript">
			const numberWithCommas = (x) => {
				var parts = x.toString().split(".");
				parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				return parts.join(".");
			}

			$(function() {
				$(document).on("focus", ".tanggal", function() {
					$(this).datepicker({
						startDate: '0',
						autoclose: true,
						todayHighlight: true,
						format: 'yyyy-mm-dd'
					});
				});

				$('.tanggal').on('changeDate', function(ev) {
					tanggal_el = $(this);
					tanggal_val = $(this).val();
					jam_mulai_el = tanggal_el.parent().parent().find(".jam_mulai");
					durasi_el = tanggal_el.parent().parent().find(".durasi");
					jam_selesai_el = durasi_el.parent().parent().find(".jam_selesai");
					loading_container_el = tanggal_el.parent().parent().find(".loading_container");
					lapangan_id_el = tanggal_el.parent().parent().find(".lapangan_id");

					jam_mulai_el.hide();
					loading_container_el.show();

					$.post('<?php echo base_url(); ?>Cart/getJamMulai', {
							tanggal: tanggal_val,
							lapangan_id: lapangan_id_el.val()
						}, function(data) {
							jam_mulai_el.show();
							loading_container_el.hide();
							jam_mulai_el.html("");

							jam_mulai_el.append("<option value='' selected='selected'>- Pilih Jam Mulai -</option>");

							count = 0;

							data.forEach(function(item, index) {
								// console.log(item);
								jam_mulai_el.append("<option durasi='" + item.durasi + "'>" + item.jam_mulai + "</option>");
								count++;
							});

							durasi_el.val(0);
							jam_selesai_el.html("");

							if (count == 0) {
								jam_mulai_el.html("");
								jam_mulai_el.append("<option value='' selected='selected'>- Tidak ada pilihan -</option>");
							}

						},
						'json'
					);
				});

				$(document).on("change", ".jam_mulai", function() {
					jam_mulai_el = $(this);
					durasi_el = jam_mulai_el.parent().parent().find(".durasi");
					durasi_el.val(jam_mulai_el.find(":selected").attr("durasi")).change();
				});

				$(document).on("change keyup", ".durasi", function() {
					durasi_el = $(this);
					durasi = $(this).val();

					if (durasi == "") {
						durasi = 0;
						durasi_el.val(durasi);
					}

					jam_mulai_el = durasi_el.parent().parent().find(".jam_mulai");
					jam_selesai_el = durasi_el.parent().parent().find(".jam_selesai");

					harga_per_jam_el = durasi_el.parent().parent().find(".harga_per_jam");
					subtotal_el = durasi_el.parent().parent().find(".subtotal");

					if (jam_mulai_el.val() != "") {
						jam_selesai = moment("01-01-2018 " + jam_mulai_el.val(), "MM-DD-YYYY HH:mm:ss").add(parseInt(durasi), 'hours').format('HH:mm:ss');
						jam_selesai_el.html(jam_selesai);

						harga_per_jam = harga_per_jam_el.html().replace(/,/g, '');
						harga_per_jam_int = parseInt(harga_per_jam);

						subtotal_el.html(numberWithCommas(harga_per_jam_int * parseInt(durasi)));

						subtotal_bawah = 0;
						$('.subtotal').each(function(i, obj) {
							a_subtotal_html = $(this).html().trim().replace(/,/g, '');
							if (a_subtotal_html == "") {
								a_subtotal_html = "0";
							}

							a_subtotal_html_int = parseInt(a_subtotal_html);
							subtotal_bawah += a_subtotal_html_int;
						});
						
						<?php if ($this->session->userdata('usertype') == '3') {
							echo "var disc = '" . $diskon['harga'] . "';"; ?>
						<?php } else {
							echo "var disc = '0';";
						} ?>

						var diskon = $('#diskon').val();

						$("#subtotal_bawah").html(numberWithCommas(subtotal_bawah));
						//var disc = ((disc / 100) * subtotal_bawah);
						$("#diskon").html(numberWithCommas(disc));
						var gtotal = (subtotal_bawah - disc);
						$("#grandtotal").html(numberWithCommas(gtotal));
					}
				});
			});
		</script>
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php $this->load->view('kasir/footer') ?>
  </div><!-- ./wrapper -->
  <?php $this->load->view('kasir/js') ?>
</body>
</html>
