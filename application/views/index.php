  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Calendar

        <small>Control panel</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Calendar</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-md-3">

		 <div class="box box-solid">

            <div class="box-header with-border">

            <h4 class="box-title">Inbound Driver</h4>

            </div>

			<div class="box-body">

              <?php 
        $tgl = "";
			  foreach($query as $row){

				if ($tgl != $row->Tanggal)  {
          echo $row->Tanggal." ";
        }elseif($tgl == $row->Tanggal){
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }

          
          
          echo $row->Nama." ";
          
          if ($row->Tipe=="Masuk"){
            echo "In ".date("H:i",strtotime($row->Masuk))." ";
            echo "Out ".date("H:i",strtotime($row->Pulang));
          }else{
            echo $row->Tipe;
          }
				  $tgl = $row->Tanggal;
				  echo "<br>";

			  }

			  ?>

                 

            </div>

		 </div>

        </div>

        <!-- /.col -->

        <div class="col-md-9">

          <div class="box box-primary">

            <div class="box-body no-padding">

              <!-- THE CALENDAR -->

              <div id="calendar"></div>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /. box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

	



  </div>

  <!-- /.content-wrapper -->

