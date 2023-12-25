<!DOCTYPE html>
<html class="ng-scope">
<head>
	<title><?php echo isset($title) ? $title : 'IJTech FTUI - Login';?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" type="image/png" href="<?php echo base_url().'assets/public/img/Makara_FTUI.png';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/font-awesome.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/adminLTE.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/iCheck/square/blue.css';?>">
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
	<style>
		.login-title{border-top:solid 1px #AAA; text-align:center; color:#222; padding:10px; background:#EEE;}
	</style>
</head>
<body class="hold-transition login-page" style="font-family:'Roboto condensed'">
	<div class="login-box">
		<div class="login-box-body">
			<a href="<?php echo site_url();?>"><img src="<?php echo site_url().'assets/front/img/ijtech.jpg';?>" alt="Research FTUI"></a>
			<h4 class="login-title"><i class="fa fa-lock"></i> LOGIN</h4>
			<p class="login-box-msg">Login with your username and password.</p>
			<?php echo $this->session->flashdata('invalid');?>
			<form action="<?php echo site_url().'login/auth';?>" method="post">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" name="username" placeholder="Username">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" name="password" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label><input type="checkbox"> Remember Me</label>
						</div>
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
					</div>
				</div>
			</form>
			<hr/>
			<a href="<?php echo site_url().'login/reset';?>"><i class="fa fa-question-circle"></i> I forgot my password</a><br>
			<a href="<?php echo site_url().'login/register';?>"><i class="fa fa-user"></i> Register new researcher</a>

		</div>
	</div>

    <script src="<?php echo base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
	<script>
	  $(function () {
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%' // optional
		});
	  });
	</script>
</body>
</html>
