
	<!--
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
      -->        
		
            <?php 
              if (isset($query)){
                if (is_array($query) || is_object($query)){ 
                    $driver = '';
					foreach($query as $row){
                        
                        if ( $row->Driver != $driver ) {
                            echo "<tr><td>".$row->Driver ."</td>";
                            if ( $row->Tipe == 'Masuk' ) {
                                echo "<td>". date("H:i",strtotime($row->Masuk)) . " - " . date("H:i",strtotime($row->Pulang))." <br>";
                                 echo "".$row->jam."<br>";
                                 echo " ".$row->tujuan."<br></td>";
                                
                            }else {
                                echo "<td>".  $row->Tipe ."</td>";
                            }
                        }else{
                            if ( $row->Tipe == 'Masuk' ) {
                                echo "<td>". date("H:i",strtotime($row->Masuk)) . " - " . date("H:i",strtotime($row->Pulang))."<br>";
                                echo "".$row->jam."<br>";
                                 echo " ".$row->tujuan."<br></td>";
                                
                            }else {
                                echo "<td>".  $row->Tipe ."</td>";
                            }
    
                            
                            
                        }

                        $driver = $row->Driver;
					
                    }
			    }
             }
			 
			?> 
		    
	    
        </table>
		<div class="row" style="margin-bottom: 10px; margin-top: 20px">
        
            <div class="col-md-6">
                

		<?php echo anchor(site_url('rdriver/excel'), '<i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php echo anchor(site_url('rdiver/word'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-info btn-sm"'); ?>
	    </div>            
</div>


			</div>
            <!-- /.box-body -->    
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
		
		</section>
		</div>
		
        <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
       <script type="text/javascript">
        /*     $(document).ready(function() {
                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                {
                    return {
                        "iStart": oSettings._iDisplayStart,
                        "iEnd": oSettings.fnDisplayEnd(),
                        "iLength": oSettings._iDisplayLength,
                        "iTotal": oSettings.fnRecordsTotal(),
                        "iFilteredTotal": oSettings.fnRecordsDisplay(),
                        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                    };
                };

                var t = $("#mytable").dataTable({
                    initComplete: function() {
                        var api = this.api();
                        $('#mytable_filter input')
                                .off('.DT')
                                .on('keyup.DT', function(e) {
                                    if (e.keyCode == 13) {
                                        api.search(this.value).draw();
                            }
                        });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {"url": "rdriver/json", "type": "POST"},
                    columns: [
                        {"data": "Tanggal"},{"data": "Jam"},{"data": "Tujuan"},{"data": "driver"},{"data": "pengguna"}
                        
                    ],
                    order: [[0, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
            });   */
        </script>