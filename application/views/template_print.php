<!DOCTYPE html>
<html class="ng-scope">
<head>
	<title><?php echo isset($title) ? $title : 'Reserch FTUI';?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" type="image/png" href="<?php echo base_url().'assets/public/img/Makara_FTUI.png';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/adminLTE.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/custom.css';?>">
</head>

<body onload="window.print();">
	<div class="wrapper">
		<section class="invoice">
			<?php
			if (!empty($page))
				if(file_exists(APPPATH."views/template/{$page}.php"))
					$this->load->view("template/".$page);
			?>
		</section>
	</div>
</body>
</html>