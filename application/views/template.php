<!DOCTYPE html>
<html lang="en" class="ng-scope">
<head>
	<title><?php echo isset($title) ? strip_tags($title) : 'IJTech - International Journal of Technology';?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="robots" content="noindex, nofollow, noimageindex, none">
	<link rel="icon" type="image/png" href="<?php echo base_url().'assets/front/img/ico.png';?>">
    <?php if(!isset($hasGC)){ ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
    <?php } ?>
	<meta name="description" content="<?php echo isset($description) ? $description :'IJTech International Journal of Technology';?>">
	<meta name="keywords" content="<?php echo isset($keywords) ? $keywords : 'IJTech, International Journal, Journal of Technology, Universitas Indonesia, University of Indonesia, Faculty of Engineering, Teknik UI, Indonesia, Scopus Indexed, Indexed by Scopus';?>">
	<meta name="author" content="<?php echo isset($author_meta) ? $author_meta : 'IJTech International Journal of Technology';?>">
	
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">

    <?php if(!isset($hasGC)){ ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/font-awesome.min.css';?>">
    <?php } ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/ionicons.min.css';?>">
    <?php if(!isset($hasGC)){ ?>
	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/datepicker/datepicker3.css';?>">
	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.css';?>">
	<?php } ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/toastr/toastr.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/skins/skin-black-light.css';?>">
	<?php
    $meta_page = "default";
    if(isset($page)) $meta_page = $page;
    if(file_exists(APPPATH."views/template/meta_top/{$meta_page}.php")) 
        $this->load->view("template/meta_top/{$meta_page}");
    ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/animate.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/adminLTE.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/custom.css';?>">
    <style>
    	body{font-family:"Droid Serif"; font-size:14px;}
    	.sidebar-menu{ font-size:13px; }
    	h1, h2, h3, h4, h5, h6{font-family:"Droid Serif", "serif";}
    	h5{ font-weight:bold; }
    </style> 
    
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

<?=(isset($additionalScriptHead) ? $additionalScriptHead : '');?>

    
</head>

<body class="hold-transition skin-black-light">
    <?php if(GLOBAL_MSG_DASHBOARD!=''){ ?>
    <div style="position:fixed;background: #ffe6c1;z-index: 99;bottom: 0;text-align: center;width: 100%;padding: 10px;border-top: red 1px solid;"><img src="http://ijtech.eng.ui.ac.id/assets/img/red-spinning-stop-sign.gif" style="width:21px"><b style="color:red">NOTICE</b><br><?=GLOBAL_MSG_DASHBOARD?></div>
    <?php } ?>
    
	<?php if(!$this->lib_view->check_profile($this->session->userdata('user_id'))){?>
		<!--div class="note" style="border-bottom:solid 1px #AAA; width:100%;z-index: 100; font-size: 14px; text-align: center"><i class="fa fa-warning text-warning"></i> Please complete your profile!</div-->
	<?php } ?>
	<div class="wrapper">
		<?php $this->load->view("template/header");?>
		<?php
		if (!empty($page))
			if(file_exists(APPPATH."views/template/{$page}.php"))
				$this->load->view("template/".$page);
		?>
		<?php $this->load->view("template/footer");?>

	</div>
	
    <!-- Mainly scripts -->
    <?php if(!isset($hasGC)){ ?>
    <script src="<?php echo base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js';?>"></script>
    <?php } ?>
    <?= isset($additionalScriptFoot)? $additionalScriptFoot : '' ?>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/plugins/datepicker/bootstrap-datepicker.js';?>"></script>
	<script type="text/javascript">
		$('.usetooltip').tooltip({
			selector: "[data-tooltip=tooltip]",
			container: "body"
		});

		$(function(){
			$('.datepicker').datepicker({
				format:"yyyy-mm-dd",
				todayBtn: "linked",
				keyboardNavigation: false,
				forceParse: false,
				calendarWeeks: false,
				autoclose: true
			});
		});
	</script>

    <script src="<?php echo base_url().'assets/plugins/slimScroll/jquery.slimscroll.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/plugins/fastclick/fastclick.min.js';?>"></script>
	<?php
    if(file_exists(APPPATH."views/template/meta_bottom/{$meta_page}.php"))
        $this->load->view("template/meta_bottom/{$meta_page}");
    ?>
	<!-- toastr message -->
	<?php $this->load->view('template/inc/toastr');?>
    <script src="<?php echo base_url().'assets/js/app.min.js';?>"></script>
</body>
</html>