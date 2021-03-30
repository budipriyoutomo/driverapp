

  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper"> 
<!-- Content Header (Page header) -->
 <section class="content-header">
      <h1>
        Tschedule 
        <small>Update/Create Data</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tschedule </li>
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
				<div class="bootstrap-timepicker">
                  <label for="time">Jam <?php echo form_error('Jam') ?></label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="Jam" id="Jam" placeholder="Jam" value="<?php echo date("h:i A",strtotime($Jam)); ?>" >
					
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>	  

	    <div class="form-group">
            <label for="Tujuan">Tujuan <?php echo form_error('Tujuan') ?></label>
            <textarea class="form-control" rows="3" name="Tujuan" id="Tujuan" placeholder="Tujuan"><?php echo $Tujuan; ?></textarea>
        </div>
	    
		<?php 
		$level = $this->session->userdata('role') ; 
	
		if ($level!='User')
		{
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
		
		
		}
		
		
		?>
			  
		 <div class="form-group">
            <label for="int"><?php echo form_error('User') ?></label>
            <input type="hidden" class="form-control" name="User" id="User" placeholder="User" value="<?php echo $this->session->userdata('id'); ?>" />
        </div>
		<?php 
		$level = $this->session->userdata('role'); 
	
		if ($level!='User') 	
		{
			echo "<div class='form-group'>";
			echo "<div class='checkbox'>";
			echo "<label>";
			echo "<input type='checkbox' name='Status' id='Status' value=1";
				if($Status==1){ echo "checked";};
			echo "> Status";
			echo "</label>";
			echo "</div>";
			echo "</div>";
		}
		?>
		<input type="hidden" name="ID" value="<?php echo $ID; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tschedule') ?>" class="btn btn-default">Cancel</a>
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