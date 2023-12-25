<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>D'Office - <?=strip_tags($title)?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/img/ico16.png');?>">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url('assets/bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
  <link rel="stylesheet" href="<?=base_url('assets/bootstrap/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url('assets/bootstrap/css/ionicons.min.css');?>">
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"-->

  <?=(isset($add) ? $add : '');?>

  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url('assets/dist/css/skins/_all-skins.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url('assets/plugins/iCheck/flat/blue.css');?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?=base_url('assets/plugins/morris/morris.css');?>">
  <!-- jvectormap -->
  <!--link rel="stylesheet" href="<?=base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>"-->
  <!-- Date Picker -->
  <!--link rel="stylesheet" href="<?=base_url('assets/plugins/datepicker/datepicker3.css');?>"-->
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <!--link rel="stylesheet" href="<?=base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>"-->

  <!--link rel="stylesheet" href="<?=base_url('assets/plugins/iCheck/square/blue.css');?>"-->
	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/toastr/toastr.min.css';?>">
	
<!--begin dynamics -->
    <?php if (isset($output->css_files)) {
			foreach($output->css_files as $file): ?>
				<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
			<?php endforeach; foreach($output->js_files as $file): ?>
				<script src="<?php echo $file; ?>"></script>
			<?php endforeach;
    } ?>
		
  <?=(isset($forDynModal) ? $forDynModal : '');?>
<!--end dynamics -->
	
	<style>
	.crud-form .container{float:left}
	.table-label{background:none}
	.table-container{border:none}
	.floatR.r5.minimize-maximize-container.minimize-maximize{display:none}
	.floatR.r5.gc-full-width{display:none}
	
	.sortingMenu{
		background: #fff;
		width: auto;
		/* display: none; */
		margin-left: 5px;
		/* position: absolute; */
		/* z-index: 2; */
	}
	/* .thManualSorting th:hover .sortingMenu{display:inline-block} */
	.redBlink{animation:blinkingText 0.8s infinite;}
	@keyframes blinkingText{
		0%  {color:red}
		49% {color:red}
		60% {color:transparent}
		99% {color:transparent}
		100%{color:red}
	}
	</style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
	<?=(isset($add2) ? $add2 : '');?>
</head>