<?php if(!isset($simple)) { ?>
	</div>

  <!-- /.content-wrapper -->
  <!--footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.2
    </div>
    <strong>Copyright &copy; 2019 <a href="#">Ruki</a>.</strong> All rights
    reserved.
  </footer-->
	
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php } ?>

<!-- jQuery 2.2.3 -->
<!--script src="<?=asset_url('plugins/jQuery/jquery-2.2.3.min.js');?>"></script-->
<?php if(@$jQueryui !== false) { ?>
<!-- jQuery UI 1.11.4 -->
<!--script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!--script>
  $.widget.bridge('uibutton', $.ui.button);
</script-->
<?php } ?>

<?php if (!isset($output) && !isset($output->js_files)) { ?>
<!-- jQuery 2.1.4 -->
<script src="<?=asset_url('plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<?php } ?>
<!--script>
	$.widget.bridge('uibutton', $.ui.button);
</script-->

<?php 
$on_ready = '';
if(isset($usingSummernote)){
	if($numTxArea>0){
		echo "<script src='".base_url()."assets/js/summernote.js'></script>";
		$count = 0; 
		foreach ($fields as $field){
			if($jenis_text[$count]=='textarea'){
				$theField = preg_replace("/(\W)+/", "", $field);
				$on_ready .= "$('#$theField').summernote({ height: 300, weight: 150 });";
				if(isset($isi_fields[$count]) && $isi_fields[$count] != ''){
					// $on_ready .= "$('#$field').summernote('editor.insertText', '$isi_fields[$count]');"; //bisa apke editor.pasteHTML
					$on_ready .= "$('#$theField').summernote('code', '$isi_fields[$count]');";
				}else{
					if(isset($hint[$count])){
						// $on_ready .= "$('#$field').summernote('editor.insertText', '$hint[$count]');";
						$on_ready .= "$('#$theField').summernote('code', '$hint[$count]');";
					}
				}
			}
			$count++;
		}
	}
} ?>

<!-- Bootstrap 3.3.6 -->
<script src="<?=asset_url('bootstrap/js/bootstrap.min.js');?>"></script>
<!-- Morris.js charts -->
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script-->
<script src="<?=asset_url('plugins/morris/morris.min.js');?>"></script>
<!-- Sparkline -->
<script src="<?=asset_url('plugins/sparkline/jquery.sparkline.min.js');?>"></script>
<!-- jvectormap -->
<!--script src="<?=asset_url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');?>"></script-->
<!--script src="<?=asset_url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js');?>"></script-->
<!-- jQuery Knob Chart -->
<script src="<?=asset_url('plugins/knob/jquery.knob.js');?>"></script>
<!-- daterangepicker -->
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script-->
<script src="<?=asset_url('plugins/daterangepicker/moment.min.js');?>"></script>
<script src="<?=asset_url('plugins/daterangepicker/daterangepicker.js');?>"></script>
<!-- datepicker -->
<!--script src="<?=asset_url('plugins/datepicker/bootstrap-datepicker.js');?>"></script-->
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=asset_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
<!-- Slimscroll -->
<script src="<?=asset_url('plugins/slimScroll/jquery.slimscroll.min.js');?>"></script>
<!-- FastClick -->
<script src="<?=asset_url('plugins/fastclick/fastclick.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?=asset_url('dist/js/app.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<!--script src="<?=asset_url('dist/js/demo.js');?>"></script-->
<script type="text/javascript" class="fhrz">
    $(document).ready(function(){      

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
			<?=$on_ready?>
    });  
</script>
<script>
$('.sidebar-toggle').click(function(){ //remember sidebar collapse state
	hideSide=1;
	if($('body').hasClass('sidebar-collapse')){hideSide=0;} //status just before the toggle is clicked
  $.ajax({type: "POST",url: "<?=base_url()?>users/sesData/hideSide/"+hideSide});
});
</script>

<?=(isset($add) ? $add : '');?>
<?php $this->load->view('parts/toastr');?>

</body>
</html>
