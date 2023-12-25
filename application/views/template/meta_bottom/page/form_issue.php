<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datepicker/bootstrap-datepicker.js';?>"></script>
<script type="text/javascript">
	$(function(){
		$('.datepicker').datepicker({'autoclose':true});
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%'
		});
	});
</script>