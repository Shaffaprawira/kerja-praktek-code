<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/select2/select2.min.js';?>"></script>
<script>

	$(function(){	
		$(".select").select2({
			placeholder:"Select reviewer(s)"
		});

		$("#c_section").on('click', function(){
			if($(this).is(':checked'))
				$("#s_section").attr('disabled', false);
			else $("#s_section").attr('disabled', true);
		});
		
		$(".decision").on('change', function(){
			var dec = $(this).val();
			if(dec == 2 || dec == 3)
				$("#decision").slideDown();
			else
				$("#decision").slideUp();
		});
		
		$(".decision_eic").on('change', function(){
			var dec = $(this).val();
			if(dec == 2 || dec == 3){
				$("#decision_eic").slideDown();
				$("#notes_for_secretariat").slideUp();
			}else{
				$("#decision_eic").slideUp();
				$("#notes_for_secretariat").slideDown();
			}
		});
		
		$(".decision-modal").on('change', function(){
			var dec = $(this).val();
			if(dec == 2 || dec == 3)
				$("#decision-modal").slideDown();
			else
				$("#decision-modal").slideUp();
		});

		$(".btn-references").click(function(){
			elm = $('.references');
			if (elm.is(':hidden'))
				$(this).html('<i class="fa fa-file-text-o"></i> Hide References');
			else
				$(this).html('<i class="fa fa-file-text-o"></i> Show References');
			$(".references").slideToggle();
		});

		$(".decision-modal").on('change', function(){
			decision = $(this).val();
			if (decision == 2)
				$("#revise_days").slideDown();
			else $("#revise_days").slideUp();
		});

	});

	function prepare_publish(id){
		$.ajax({
			method : 'GET',
			url : '<?php echo site_url()."dashboard/get_submission_json/";?>'+id,
			success: function(data){			
				$("#sub_id_publish").val(data[0].sub_id);
				$("#manuscript_title").html(data[0].sub_title);
			}
		});
	}

	function view_review_result(str){
		param = str.split('#');
		id = param[1];
		round = param[0];
		$.ajax({
			type : 'POST',
			url : '<?php echo site_url().'dashboard/review_result';?>',
			data : {'sub_id': id, 'round': round},
			success: function(res){				
				$("#reviewResultData").html(res);
			}, error: function(){
				alert('Missing internet connection, plase check your connection');
			}
		});
	}
	
	function show_review(str){
		param = str.split('#');
		id = param[0];
		round = param[1];
		// alert(str);
		$.ajax({
			type : 'POST',
			url : '<?php echo site_url().'dashboard/review_result';?>',
			data : {'sub_id': id, 'round': round},
			success: function(res){				
				$("#contentReviewHistory").html(res);
			}, error: function(){
				alert('Missing internet connection, plase check your connection');
			}
		});
	}
	
	function set_reviewer(str){
		str = str.split('#');
		sub_id = str[0];
		sr_id = str[1];
		status = str[2];
		// set values
		$("#item_id").val(sub_id);
		$("#reviewer").val(sr_id);
		$("#status").val(status);
		if(status == 2){ //invite sugested reviewer
			$(".icon").removeClass('fa fa-user-times').addClass('fa fa-user-plus');
			$(".set-header").html('Before sending invitation...'); //ruki
			$(".set-header-label").html('');
			$('.reviewer_search_field').blur();
			$('.search_reviewer').hide();
			$(".msg").html('<span style="color:red"><br>Not any above? You can create new account and invite this reviewer.</span>');
			$(".action").val('Create Account and Invite');
		}else if(status == 20){ //add new reviewer (fron DB or add new)
			$(".icon").removeClass('fa fa-user-times').addClass('fa fa-user-plus');			
			$(".set-header").html('Add a candidate reviewer'); //ruki
			$(".set-header-label").html('Search an existing reviewer or create a new account for the reviewer you wish to add.');
			$(".reviewer-container").hide();
			$('#formreviewer').hide();
			$('#form_manually_add_new_reviewer').show();
			$(".action").val('Create Account');
		}else if(status == 21){ //invite the added new reviewer (fron DB or add new)
			$("#status").val(2);
			$(".icon").removeClass('fa fa-user-times').addClass('fa fa-user-plus');			
			$(".set-header").html('Send Email Invitation'); //ruki
			$(".set-header-label").html('');
			$('.search_reviewer').hide();
			$(".reviewer-container").hide();
			$('#formreviewer').show();
			$('#form_manually_add_new_reviewer').hide();
			$(".msg").html('<i class="fa fa-info-circle"></i> Are you sure? The invitation email will contains title and abstract from this article, and buttons to accept or decline this invitation.');
			$(".action").val('Send Email Invitation');
		}else{ //remove from list (if not invited yet)
			$(".reviewer-container").hide();
			$(".reviewer-container-check").hide();
			$(".search_reviewer").hide();
			$(".set-header").html('Remove Candidate Reviewer');
			$(".set-header-label").html('Remove this candidate reviewer from this list');
			$(".msg").html('<i class="fa fa-info-circle"></i> This reviewer is not invited yet, so it is OK to delete. Just FYI, you can still add him/her again after this removal.');
			$(".action").removeClass('btn-info').addClass('btn-danger').val('Remove');
			$(".icon").removeClass('fa fa-user-plus').addClass('fa fa-user-times');
		}

	}

	function add_reviewer(reviewer,detail){
		$('.reviewer-container').html(detail);
		$('.reviewer_search_field').val(reviewer);
		$('.reviewer-container-check').html('<br>Maybe the reviewer you are trying to invite is already in our database<br>(but with different email):')
	}

	function revise_agreement(str){
		var id = str.split('#');
		$("#sub_item_id").val(id[0]);
		$("#round").val(id[1]);
	}

	$(".reviewer_search_field").on('blur', function(){
        var key = $(this).val();
        var id = $("#sub_id_reviewer").val();
        if (key){
        	if (key.length >= 3){
        	    $(".result-reviwer").html("Loading...");
	            $.ajax({
	                type : 'POST',
	                url : '<?php echo site_url()."dashboard/get_reviewer_by_keywords_html";?>',
	                data: {'key': key, 'sub_id': id},
	                success: function(res){
	                    $(".result-reviwer").html(res);
	                    $(".data-table-reviewer").DataTable({"pageLength": 10, "searching": false, "lengthChange": false});
	                }, error: function(){
	                    $(".result-reviwer").html("Connection lost! Plase try again.");
	                }
	            });
	        }else{
	        	$(".result-reviwer").html('<span class="text-warning">Please type a keywords at least 3 characters...</span>');
	        }
        }
    });
		
		$('#modalReviewer').on('hidden.bs.modal', function () {
			$('.result-reviwer').html('');
			$('.reviewer_search_field').val('');
			$(".reviewer-container").html('');
			$(".reviewer-container").show();
			$(".reviewer-container-check").html('');
			$(".reviewer-container-check").show();
			$(".search_reviewer").show();
			$(".action").removeClass('btn-danger').addClass('btn-info');
			$(".set-header-label").html('');
			$('#formreviewer').show();
		});
		
</script>