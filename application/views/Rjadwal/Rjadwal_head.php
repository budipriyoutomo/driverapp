

  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper"> 
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Schedule
        <small>Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report Schedule </li>
      </ol>
    </section>
<!-- Main content -->
    <section class="content">
	      <div class="row">
        <div class="col-xs-12">
        

          <div class="box">
            <div class="box-header">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	
      
		
		
		<form action="<?php echo base_url(); ?>rjadwal/hitung" method="post">
		
		              <!-- Date range -->
              <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="tanggal" name="tanggal">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
			  
		
	    	    
		
		  <div style="margin-bottom: 20px" class="col-md-12 text-right">
             <button type="submit" class="btn btn-primary"  ><?php echo "Generate";?></button>
			</div>
		
		</form>
    
    <div class="col-xs-12">
		<h4 class="text-center">
    <?php 
    if (isset($dari) and isset($sampai)){
      echo "<b>Jadwal Driver Per ( ".$dari. " ) s/d ( ". $sampai ." )</b>";
    }
		
		
		?>
		</h4>
	  </div>
  
	
    <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                <?php 
                if (isset($dari)and isset($sampai)){
                  
                  echo "<th></th>";
                      
                      while (strtotime($dari) <= strtotime($sampai)) {
                        echo "<th>".date("l",strtotime($dari))."<br>";
                        echo date("d-m-Y",strtotime($dari))."</th>";
                      $dari = date ("Y-m-d", strtotime("+1 day", strtotime($dari)));
                      }
                }
                
                ?>
                </tr>
            </thead>