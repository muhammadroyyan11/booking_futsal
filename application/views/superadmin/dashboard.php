<?php $this->load->view('superadmin/meta') ?>
<?php $this->load->view('superadmin/navbar') ?>
<?php $this->load->view('superadmin/sidebar') ?>
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo $title ?></h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active"><?php echo $title ?></li>
        </ol>
      </section>
      <!-- Main content -->
      <?php $this->load->view('superadmin/record'); ?>
      <?php $this->load->view('superadmin/stats'); ?>
    </div><!-- /.content-wrapper -->
    <?php $this->load->view('superadmin/footer') ?>
  </div><!-- ./wrapper -->
  <?php $this->load->view('superadmin/js') ?>
</body>
</html>
