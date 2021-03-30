
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login Form</title>
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>temp/uploads/config/31572-2.jpg" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="<?php echo base_url(); ?>temp/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>temp/plugins/iCheck/square/blue.css">
    </head>
    <body class="hold-transition login-page">
  
        <div class="login-box">
            
			<a class="login-logo text-center">Driver Schedule System </a>
            
            
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in </p>
                <form action="" method="post" accept-charset="utf-8">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button name="submit" type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>

                        </div>
                        <!-- /.col -->
                    </div>
                </form>                <br>
                <!-- /.social-auth-links -->
                <a href="#">I forgot my password</a>
                <br><br>
				  <a href="#">Copyright &copy; 2018 Budi Priyo Utomo</a><br>
				
				
                <!-- <a href="" class="text-center">Register a new membership</a> -->
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <!-- MODALS WINDOWS 8 -->

        <!-- jQuery 2.2.0 -->
        <script src="<?php echo base_url(); ?>temp/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>temp/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>temp/plugins/iCheck/icheck.min.js"></script>
        <script src="<?php echo base_url(); ?>temp/costume.js"></script>
    </body>
</html>