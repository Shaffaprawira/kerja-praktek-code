<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/select2/select2.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/summernote/summernote.js';?>"></script>
<!--script src="<?php echo base_url().'assets/plugins/summernote/plugin/summernote-cleaner-master/summernote-cleaner.js';?>"></script-->
<!--script src="<?php echo base_url().'assets/plugins/wysiwyg/wysiwyg.js';?>"></script-->
<!--script src="<?php echo base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js';?>"></script-->
<!--script src="<?php echo base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js';?>"></script-->

<script>
function check_agreement(){
    var agree = $(".agreement").iCheck('update')[0].checked;
    if (agree == false){
        $(".agreement-msg").html('Plase tick the checkbox under Submission Agreement before submitting the manuscript!');
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
function set_coauthor(str){
    _str = str.split('#');
    sub_id = _str[0];
    sa_id = _str[1];
    $("#co_sub_id").val(sub_id);
    $("#co_sa_id").val(sa_id);
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

	$('.summernoteTitle').summernote({
	    'height': '60px',
	    toolbar: [
	        ['font', ['italic','superscript', 'subscript']]
	      ],
	    tabDisable: true,
	    callbacks: {
          onPaste: function(e) {
            console.log('Text styling cleared on paste');
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            var regex = /(<([^>]+)>)/ig;
            var result = bufferText.replace(regex, "");
            var result2 = result.replace(/[\n\r]/g, '');
            document.execCommand('insertText', false, result2);
          }
        }
	});
    $('.summernote').summernote({
        'height': '400px',
        toolbar: [
            // ['cleaner',['cleaner']],
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            // ['color', ['color']],
            // ['para', ['ul', 'ol', 'paragraph']],
            // ['height', ['height']],
            // ['table', ['table']],
            // ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
          ],
          // cleaner:{
              // notTime: 1000, // Time to display Notifications.
              // action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
              // newline: '<br>', // Summernote's default is to use '<p><br></p>'
              // notStyle: 'position:absolute;top:4px;left:2px;opacity:0.9;padding:4px;', // Position of Notification
              // icon: '<i class="note-icon"> Clear External Format </i>',
              // keepHtml: false, // Remove all Html formats
              // keepClasses: false, // Remove Classes
              // badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
              // badAttributes: ['style', 'start'] // Remove attributes from remaining tags
        // }
    });

     $('.references').summernote({
        'height': '300px',
        toolbar: [
            // ['cleaner',['cleaner']],
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
          ],
          // cleaner:{
              // notTime: 1000, // Time to display Notifications.
              // action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
              // newline: '<br>', // Summernote's default is to use '<p><br></p>'
              // notStyle: 'position:absolute;top:4px;left:2px;opacity:0.9;padding:4px;', // Position of Notification
              // icon: '<i class="note-icon"> Clear External Format </i>',
              // keepHtml: true, // Remove all Html formats
              // keepClasses: false, // Remove Classes
              // badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
              // badAttributes: ['start'] // Remove attributes from remaining tags
        // }
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
				beforeSend: function( xhr ) {
					$(".loading-msg").html('Loading...');
					$(".loading-msg").prop("disabled",true);
				},
                success: function(res){
                    if(res.length > 0){
                        $("#user_id").val(res[0].user_id);
                        $(".name").text(res[0].salutation+' '+res[0].first_name+' '+res[0].last_name);
                        $(".email").text(res[0].email);
                        $(".affiliation").text(res[0].affiliation);
                        $(".selected-author").show();
                        $(".search-msg").hide();
                    }else{
                        $(".search-msg").show();
                        $(".selected-author").hide();
                    }
                }, error: function(){
                    alert('Problem with internet connection! Plase try again.');
                }
            }).done(function(){
				$(".loading-msg").html('Search');
				$(".loading-msg").prop("disabled",false);
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
                        $("#sr_id").val(res[0].user_id);
                        $(".name").text(res[0].salutation+' '+res[0].first_name+' '+res[0].last_name);
                        $(".email").text(res[0].email);
                        $(".affiliation").text(res[0].affiliation);
                        $(".selected-reviewer").show();
                        $(".search-msg").hide();
                    }else{
                        $(".search-msg").show();
                        $(".selected-reviewer").hide();
                    }
                }, error: function(){
                    alert('Connection failed! Plase try again.'); //ruki2
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