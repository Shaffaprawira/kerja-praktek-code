<!DOCTYPE html>
<html lang="eng">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?php echo isset($meta['description']) ? $meta['description']:'Sistem Journal Fakultas Teknik Universitas Indonesia';?>">
		<meta name="keywords" content="<?php echo isset($meta['keywords']) ? $meta['keywords']: 'International journal, Technology, Engineering, FTUI';?>">
		<meta name="author" content="IJTech">
		<link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">		
		<link href="<?php echo base_url().'assets/front/css/font-awesome.min.css';?>" rel="stylesheet">		
		<style type="text/css">
			body{
				background-color: #F7F7F7;				
			}
			h2{ color: #555; }
			.box, .footer{
				font-family: "Roboto Slab";
				border: solid 1px #DDD;
				width:400px;
				background-color: #FFF;				
				margin:auto;
				margin-top: 100px;
				padding: 20px;
				font-size: 14px;				
			}
			.footer{
				margin-top: 0px;
				border-top:none;
				padding-top: 7px;
				padding-bottom: 7px;
				font-size: 0.7em;
				background-color: #0c649b;
				color: #fff;
				border-color: #0c649b;
			}
		</style>
</head>
<body>
	<div class="box">
		<h2><i class="fa fa-warning"></i> Manuscript out of review process!</h2>
		<p>We are sorry to inform you that manuscript entitled 
			<div style="padding: 10px; border-left:solid 4px #DDD"><?php echo $sub[0]['sub_title'];?></div>
		<br/>has been out of review process.</p>
		<p>Thank you for your feedback.</p>
		
	</div>
	<div class="footer">
		International Journal of Technology (IJTech).
		<span class="pull-right" style="margin-top: -3px"><a href="<?php echo site_url();?>" style="color:#FFF"><i class="fa fa-2x fa-home"></i></a></span>
	</div>

</body>
</html> 