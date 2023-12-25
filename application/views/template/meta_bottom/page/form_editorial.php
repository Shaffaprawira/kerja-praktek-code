<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/select2/select2.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/summernote/summernote.js';?>"></script>

<script>
function check_agreement(){
    var agree = $(".agreement").iCheck('update')[0].checked;
    if (agree == false){
        $(".agreement-msg").html('Plase check journal agreement before submit the manuscript!');
        $(".agreement-btn").hide();
    }else{
        $(".agreement-msg").html('Are you sure want to submit the manuscript?');
        $(".agreement-btn").show();
    }
}

function prepare_delete_file(id){
    $("#sf_id").val(id);
}
function prepare_delete_funder(id){
    $("#sfunder_id").val(id);
}
function prepare_delete_author(str){
    id = str.split('#');
    var url = '<?php echo site_url().'dashboard/delete/author/';?>'+id[0]+'/'+id[1];
    $("#deleteAuthor").attr('action', url);
}
function prepare_delete_reviewer(str){
    id = str.split('#');
    var url = '<?php echo site_url().'dashboard/delete/reviewer/';?>'+id[0]+'/'+id[1];
    $("#deleteReviewer").attr('action', url);
}

$(function(){
	$(".data-table").DataTable();
	$(".select").select2();
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%'
	});

	// summernote
    $('.summernote').summernote({
        'height': '200px',
        toolbar: [
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['height', ['height']],
            ['table', ['table']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']]
          ],
    });

    $('.affiliation-form').summernote({
        'height': '100px',
        toolbar: [
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['help', ['help']]
          ],
    });
    
    $('.cover').summernote({
        'height': '100px'
    });
    
    $(".checkbox.funder").on('ifClicked',function(){
    	$(this).iCheck('checked');
    	$(".list-funder").slideDown();
    });

    $(".checkbox.nofunder").on('ifClicked',function(){
        $("#modalClearFunder").modal();
        $(".yes").click(function(){
            $('.checkbox.nofunder').iCheck('unchecked');
            $(".list-funder").slideUp();
        });
        $(".no").click(function(){
            $('.checkbox.funder').iCheck('check', true);
            $(".list-funder").slideDown();
        });        
       
    });
	
    $('.sort').on('change', function(){
        var page = $(this).attr('data-page');
        var id = $(this).attr('data-id');
        var sort = $(this).val();
        $.ajax({
            url : '<?php echo site_url()."dashboard/update/sort_author/";?>',
            data : {'id': id, 'sort': sort, 'page': page},
            method : 'POST',
            success: function (data){
                $(".sort-message-success").slideDown('fast').html('Sorting author successfully');
            }, error: function(){
                $(".sort-message-failed").slideDown('fast').html('Sorting author failed');                
            }
        });
    });

    // find using email address
    $("#authors").on('blur', function(){
        var email = $(this).val();
        var id = $("#sub_id_author").val();        
        if (email){
            $.ajax({
                type : 'POST',
                url : '<?php echo site_url()."dashboard/get_author_by_email_address_json";?>',
                data: {'email': email, 'sub_id': id},
                success: function(res){
                    if(res.length > 0){
                        $("#user_id").val(res[0].user_id);
                        $(".name").text(res[0].first_name+' '+res[0].last_name);
                        $(".email").text(res[0].email);
                        $(".affiliation").text(res[0].affiliation);
                        $(".selected-author").show();
                        $(".search-msg").hide();
                    }else{
                        $(".search-msg").show();
                        $(".selected-author").hide();
                    }
                }, error: function(){
                    alert('Connection error! Plase try again.'); //ruki2
                }
            });
        }

    });

    // find using email address
    $("#reviewers").on('blur', function(){
        var email = $(this).val();
        var id = $("#sub_id_reviewer").val();

        if (email){
            $.ajax({
                type : 'POST',
                url : '<?php echo site_url()."dashboard/get_reviewer_by_email_address_json";?>',
                data: {'email': email, 'sub_id': id},
                success: function(res){
                    if(res.length > 0){
                        $("#sr_id").val(res[0].sr_id);
                        $(".name").text(res[0].fullname);
                        $(".email").text(res[0].email);
                        $(".affiliation").text(res[0].affiliation);
                        $(".selected-reviewer").show();
                        $(".search-msg").hide();
                    }else{
                        $(".search-msg").show();
                        $(".selected-reviewer").hide();
                    }
                }, error: function(){
                    alert('Something wrong! Plase try again.'); //ruki2
                }
            });
        }
    });

    function konfirm(note){
        var conf = prompt(note);
        if(conf == 1)
            return true;
        else return false;
    }

    $(".action-add-funder").click(function(){
        $.ajax({
            method : 'POST',
            url : '<?php echo base_url().'dashboard/insert/funder';?>',
            data: {},
            success:function(res){

            }
        });
    });

});
</script>