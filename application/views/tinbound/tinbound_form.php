

  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper"> 
<!-- Content Header (Page header) -->
 <section class="content-header">
      <h1>
        Tinbound 
        <small>Update/Create Data</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tinbound </li>
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
	
		
        
        <form action="<?php echo $action; ?>" method="post">
	    <?php 
		
			echo "<div class='form-group'>";
			echo "<label for='int'>Iddriver "; 
			echo form_error('iddriver');
			echo "</label>";
			echo "<select class='form-control select2' style='width: 100%;' name='iddriver' id='iddriver' onchange='getdriver(this);'>";
			echo "<option selected='selected' value=";
			echo $iddriver.">";
			if($iddriver!=null){ echo $namadriver;}else{ echo "";};
			echo "</option>";
		
			
				
					foreach($query as $row){
						
						echo "<option value=";
						echo $row->iddriver; 
						echo ">";
						echo $row->Nama; 
						echo "</option>";
					
					}
				
				
                   echo "</select >";
        echo "</div>";
		?>
		
		 <div class="form-group">
                <label for="date">Tanggal <?php echo form_error('Tanggal') ?></label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="Tanggal" placeholder="Tanggal" value="<?php if($Tanggal!=null){ echo date("m/d/Y",strtotime($Tanggal));}else{ echo $Tanggal; }  ?>" />
				 
                </div>
                <!-- /.input group -->
        </div>
              <!-- /.form group -->
			  
		<!-- time Picker -->
    <div class="form-group">
              <label for="enum">Tipe <?php echo form_error('Tipe') ?></label>
  			<select class="form-control select2" style="width: 100%;" name="tipe" id="tipe" >
                    <option >Masuk</option>
                    <option>OFF</option>
                    <option>CUTI</option>
                    <option>CP</option>
                  </select>
          </div>
                <div class="form-group">
				<div class="bootstrap-timepicker">
                  <label for="time">Masuk <?php echo form_error('Masuk') ?></label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="Masuk" id="Masuk" placeholder="Masuk" value="<?php echo date("h:i A",strtotime($Masuk)); ?>" >
					
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
			  
			<div class="form-group">
				<div class="bootstrap-timepicker">
                  <label for="time">Pulang <?php echo form_error('Pulang') ?></label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="Pulang" id="Pulang" placeholder="Pulang" value="<?php echo date("h:i A",strtotime($Pulang)); ?>" >
					
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
			  
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tinbound') ?>" class="btn btn-default">Cancel</a>
	</form>
    
	
			</div>
            <!-- /.box-body -->    
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
	  </div>