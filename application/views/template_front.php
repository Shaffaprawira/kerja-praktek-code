<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123922717-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-123922717-1');
</script>

		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		
		
		<meta name="title" content="<?=isset($meta['title'])?$meta['title']:'IJTech - International Journal Technology'?>">
		<meta name="author" content="<?=isset($meta['authors'])?$meta['authors']:'IJTech - International Journal Technology'?>">
		<meta name="keywords" content="<?php echo isset($meta['keywords']) ? $meta['keywords']: 'IJTech, International journal, Technology, Engineering';?>">
		<meta name="description" content="<?php echo isset($meta['description']) ? $meta['description']:'IJTech - International Journal Technology';?>">
		
		<?php $this->load->view('template/inc/open_graph');?>
		
		<title><?php echo isset($title) ? $title : 'International Journal of Technology';?></title>
		
		<link href="<?php echo site_url().'assets/front/img/ico.png';?>" rel="shortcut icon" type="image/x-icon">
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">

		<link href="<?php echo base_url().'assets/front/css/bootstrap.css';?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/front/css/custom-min.css';?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/front/css/font-awesome.min.css';?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/front/css/lightbox.min.css';?>" rel="stylesheet">
		<link href="<?php echo base_url().'assets/front/css/custom.css';?>" rel="stylesheet">

	<?php
    $meta_page = "default";
    if(isset($page)) $meta_page = $page;
    if(file_exists(APPPATH."views/template/front/meta_top/{$meta_page}.php")) 
        $this->load->view("template/front/meta_top/{$meta_page}");
    ?>
    <style>
    	body{font-family:"Droid Serif"; font-size:14px;}
    	.sidebar-menu{ font-size:13px; }
    	h1, h2, h3, h4, h5, h6{font-family:"Droid Serif", "serif";}
    	h5{ font-weight:bold; }
    </style> 
</head>

<body>
<?php if(GLOBAL_MSG_FRONT!=''){ ?>
    <div style="position:fixed;background: #ffe6c1;z-index: 99;bottom: 0;text-align: center;width: 100%;padding: 10px;border-top: red 1px solid;"><img src="http://ijtech.eng.ui.ac.id/assets/img/red-spinning-stop-sign.gif" style="width:21px"><b style="color:red">NOTICE</b><br><?=GLOBAL_MSG_FRONT?></div>
    <?php } ?>
	<div class="">
		<?php $this->load->view("template/front/header");?>
		<?php
		if (!empty($page))
			if(file_exists(APPPATH."views/template/front/{$page}.php"))
				$this->load->view("template/front/".$page);
		?>
		<?php $this->load->view("template/front/footer");?>

	</div>
	
    <!-- Mainly scripts -->
    <script src="<?php echo base_url().'assets/front/js/jQuery-2.1.4.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/front/js/bootstrap.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/front/js/lightbox-plus-jquery.min.js';?>"></script>
	<?php
    if(file_exists(APPPATH."views/template/front/meta_bottom/{$meta_page}.php"))
        $this->load->view("template/front/meta_bottom/{$meta_page}");
    ?>

    <script>    
		$(function(){
			var segment1 = '<?php echo $this->uri->segment(1);?>';
			var segment2 = '<?php echo $this->uri->segment(2);?>';
			var loff = $(window).width() - ($('.sidebar').offset().left + $('.sidebar').width());
			var swidth = $(".sidebar").width();
			console.log(loff);

			if(segment1 == 'article' && segment2 == 'view'){
				$('nav.navbar').removeClass('navbar-fixed-top');
				$(this).scroll(function(){
					if ($(this).scrollTop() > 160){
						$('.sidebar').addClass('sidebar-static').css({"width":swidth, "right":loff+"px", "top":"0px", "height":"100%"});
					}
					if ($(this).scrollTop() < 160){
						$('.sidebar').css({"top":(160 - $(this).scrollTop())+"px"});
					}
				});
			}else{
				$(this).scroll(function(){
					if ($(this).scrollTop() > 160){
						$('nav.navbar').removeClass('navbar-static-top');
						$('nav.navbar').addClass('navbar-fixed-top').show("slow");
						$('body').css("margin-top", "65px");
					}
					if ($(this).scrollTop() < 160){
						$('nav.navbar').addClass('navbar-static-top');
						$('nav.navbar').removeClass('navbar-fixed-top');
						$('body').css("margin-top", "0px");
					}
				});
				$('.filter').click(function(){
					var by = $(this).attr('data-value');
					$('#by').val(by);
					$('.choice').html(by+ ' <span class="caret"></span>');
				});
			}
		});
    </script>
</body>
</html>