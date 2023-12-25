<!DOCTYPE html>
<html lang="en" class="ng-scope">
<head>
	<title><?php echo isset($title) ? $title : 'IJTech - International Journal of Technology';?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" type="image/png" href="<?php echo base_url().'assets/front/img/icon_ijtech.png';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
</head>
<body style="margin: 50px">
	<h4>Cover Letter</h4>
	<?php echo $sub[0]['cover_letter'];?>

	<?php if(!empty($cover)){?>
	<hr/>
	<a href="<?php echo site_url().$cover[0]['file_url'];?>">Click to preview file</a>
	<?php } ?>
</body>
</html>