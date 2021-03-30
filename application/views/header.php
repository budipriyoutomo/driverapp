<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Driver Schedule System</title>

  <link rel="stylesheet" href="themes/base/jquery.ui.all.css">

<!--        <style>

            .dataTables_wrapper {

                min-height: 500px

            }

            

            .dataTables_processing {

                position: absolute;

                top: 50%;

                left: 50%;

                width: 100%;

                margin-left: -50%;

                margin-top: -25px;

                padding-top: 20px;

                text-align: center;

                font-size: 1.2em;

                color:grey;

            }

            body{

                padding: 15px;

            }

        </style>-->

<!-- <link href="<?php echo base_url();?>datepicker/jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet" />

  <script src="<?php echo base_url();?>datepicker/jquery-ui-1.11.4/external/jquery/jquery.js"></script>

  <script src="<?php echo base_url();?>datepicker/jquery-ui-1.11.4/jquery-ui.js"></script>

  <script src="<?php echo base_url();?>datepicker/jquery-ui-1.11.4/jquery-ui.min.js"></script>

  <link rel="stylesheet" href="<?php echo base_url();?>datepicker/jquery-ui-1.11.4/jquery-ui.theme.css">

  <script>

   $(document).ready(function(){

    $("#tanggal_lahir").datepicker({

    })

   })

  </script> -->



  <!-- Tell the browser to be responsive to screen width -->

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->

  <link rel="stylesheet" href="<?=base_url();?>temp/bootstrap/css/bootstrap.min.css">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <!-- DataTables -->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/datatables/dataTables.bootstrap.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="<?=base_url();?>temp/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins

       folder instead of downloading all of them to reduce the load. -->

  <link rel="stylesheet" href="<?=base_url();?>temp/dist/css/skins/_all-skins.min.css">



  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/daterangepicker/daterangepicker.css">

  <!-- bootstrap datepicker -->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/datepicker/datepicker3.css">

  <!-- iCheck for checkboxes and radio inputs -->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/iCheck/all.css">

  <!-- Bootstrap Color Picker -->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/colorpicker/bootstrap-colorpicker.min.css">

  <!-- Bootstrap time Picker -->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/timepicker/bootstrap-timepicker.min.css">

  <!-- Select2 -->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/select2/select2.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="<?=base_url();?>temp/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins

       folder instead of downloading all of them to reduce the load. -->

  <link rel="stylesheet" href="<?=base_url();?>temp/dist/css/skins/_all-skins.min.css">



 <!-- fullCalendar 2.2.5-->

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/fullcalendar/fullcalendar.min.css">

  <link rel="stylesheet" href="<?=base_url();?>temp/plugins/fullcalendar/fullcalendar.print.css" media="print">



</head>

 



<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">



  <header class="main-header">

    <!-- Logo -->

    <a href="<?=base_url();?>temp/index2.html" class="logo">

      <!-- mini logo for sidebar mini 50x50 pixels -->

      <span class="logo-mini"><b>D</b>Sys</span>

      <!-- logo for regular state and mobile devices -->

      <span class="logo-lg"><b>DriverSchedule </b>System</span>

    </a>

    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">

      <!-- Sidebar toggle button-->

      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

        <span class="sr-only">Toggle navigation</span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

      </a>



      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">

		 	<!-- Notifications: style can be found in dropdown.less -->

          <li id="notif" class="dropdown notifications-menu">

            

          </li> 

		 

          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <img src="<?=base_url();?>folderfoto/<?php echo $this->session->userdata('pp'); ?>" class="user-image" alt="User Image">

              <span class="hidden-xs">Welcome, <?php echo $this->session->userdata('username'); ?></span>

            </a>

            <ul class="dropdown-menu">

              <!-- User image -->

              <li class="user-header">

                <img src="<?=base_url();?>folderfoto/<?php echo $this->session->userdata('pp'); ?>" class="img-circle" alt="User Image">



                <p>

                  <?php echo $this->session->userdata('nama'); ?>

                  <small><?php echo $this->session->userdata('role'); ?></small>

                </p>

              </li>

             

              <!-- Menu Footer-->

              <li class="user-footer">

                <div class="pull-left">

                  <a href="#" class="btn btn-default btn-flat">Profile</a>

                </div>

                <div class="pull-right">

                  <a href="<?php echo base_url(); ?>auth/logout" class="btn btn-default btn-flat">Sign out</a>

                </div>

              </li>

            </ul>

          </li>

          <!-- Control Sidebar Toggle Button -->

          <li>

            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>

          </li>

        </ul>

      </div>

    </nav>

  </header>

  <!-- Left side column. contains the logo and sidebar -->

  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->

    <section class="sidebar">

      <!-- Sidebar user panel -->

      <div class="user-panel">

        <div class="pull-left image">

          <img src="<?=base_url();?>folderfoto/<?php echo $this->session->userdata('pp'); ?>"  class="img-circle" alt="User Image">

        </div>

        <div class="pull-left info">

          <p><?php echo $this->session->userdata('nama'); ?></p>

          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

        </div>

      </div>

      <!-- search form -->

      <form action="#" method="get" class="sidebar-form">

        <div class="input-group">

          <input type="text" name="q" class="form-control" placeholder="Search...">

              <span class="input-group-btn">

                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>

                </button>

              </span>

        </div>

      </form>

      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu">

      <li class="header">MAIN</li>

      <li class="treeview">

          <a href="<?php echo base_url(); ?>dashboard.html">

            <i class="fa fa-dashboard"></i> <span>Dashboard</span>

          </a>

        </li>

		

	

		

		

    <!-- batas akhir authentification -->

        <?php if ($this->session->userdata('role')=='User') { ?>

		

					<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Transaction</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

			<li><a href="<?php echo base_url(); ?>Tschedule.html"><i class="fa fa-circle-o"></i> Schedule</a></li>

          </ul>

        </li> 

			<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Report</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url(); ?>Rdriver.html"><i class="fa fa-circle-o"></i> Schedule Driver</a></li>


            </ul>

        </li> 

		<?php } else if($this->session->userdata('role')=='Admin'){ ?>

			

			

		<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Master</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

			<li><a href="<?php echo base_url(); ?>Tdriver.html"><i class="fa fa-circle-o"></i> Driver</a></li>

          </ul>

        </li> 

		

		<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Transaction</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url(); ?>Tschedule.html"><i class="fa fa-circle-o"></i> Schedule</a></li>

			<li><a href="<?php echo base_url(); ?>Tinbound.html"><i class="fa fa-circle-o"></i> Inbound Driver</a></li>

            </ul>

        </li> 

		

		<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Report</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url(); ?>Rdriver.html"><i class="fa fa-circle-o"></i> Schedule Driver</a></li>

			<li><a href="<?php echo base_url(); ?>Rweek.html"><i class="fa fa-circle-o"></i> Schedule</a></li>
      <li><a href="<?php echo base_url(); ?>Rjadwal.html"><i class="fa fa-circle-o"></i> Schedule Weekly </a></li>

            </ul>

        </li> 

		

		

		

	    <?php } else if($this->session->userdata('role')=='SuperAdmin'){ ?>

			

			

		<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Master</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

			<li><a href="<?php echo base_url(); ?>user.html"><i class="fa fa-circle-o"></i> User</a></li>

			<li><a href="<?php echo base_url(); ?>Tdriver.html"><i class="fa fa-circle-o"></i> Driver</a></li>

          </ul>

        </li> 

		

		<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Transaction</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url(); ?>Tschedule.html"><i class="fa fa-circle-o"></i> Schedule</a></li>

			<li><a href="<?php echo base_url(); ?>Tinbound.html"><i class="fa fa-circle-o"></i> Inbound Driver</a></li>

            </ul>

        </li> 

		

		<li class="treeview">

          <a href="#">

            <i class="fa fa-book"></i>

            <span>Report</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="<?php echo base_url(); ?>Rdriver.html"><i class="fa fa-circle-o"></i> Schedule Driver</a></li>

			<li><a href="<?php echo base_url(); ?>Rweek.html"><i class="fa fa-circle-o"></i> Schedule </a></li>
      <li><a href="<?php echo base_url(); ?>Rjadwal.html"><i class="fa fa-circle-o"></i> Schedule Weekly </a></li>

            </ul>

        </li> 

		

	    <?php }

         ?>





        

      </ul>

    </section>

    <!-- /.sidebar -->

  </aside>



    