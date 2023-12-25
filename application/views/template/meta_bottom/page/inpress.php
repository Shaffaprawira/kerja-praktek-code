<!-- DataTables -->
<script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
<script src="<?php echo base_url().'assets/plugins/summernote/summernote.js';?>"></script>
<!--script src="<?php echo base_url().'assets/plugins/summernote/plugin/summernote-cleaner-master/summernote-cleaner.js';?>"></script-->
<script src="<?php echo base_url().'assets/plugins/datepicker/bootstrap-datepicker.js';?>"></script>

<script type="text/javascript">

function check_fill(){
    var ask = confirm('Are you sure want to publish this journal?');
    if(ask == true)
        return true;
    else return false;
}

$(function(){

	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%'
	});

	// summernote
    $('.summernote').summernote({
        'height': '400px',
        toolbar: [
            // ['cleaner',['cleaner']],
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
          ],
					//onImageUpload: function(files, editor, welEditable) {sendFile(files[0], editor, welEditable);}
        //   cleaner:{
        //       notTime: 2400, // Time to display Notifications.
        //       action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
        //       newline: '', // Summernote's default is to use '<p><br></p>'
        //       notStyle: 'position:absolute;top:4px;left:2px;opacity:0.9;padding:4px;', // Position of Notification
        //       icon: '<i class="note-icon"> Clear External Format </i>',
        //       keepHtml: false, // Remove all Html formats
        //       keepClasses: false, // Remove Classes
        //       badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
        //       badAttributes: ['style', 'start'] // Remove attributes from remaining tags
        // }
    });
		function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: base_url('dashboard/summernoteUploadImage'),
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    editor.insertImage(welEditable, url);
                }
            });
        }


    $('.datepicker').datepicker({'autoclose':true});

    $('.title').summernote({
        'height': '100px',
        toolbar: [
            ['font', ['bold', 'italic', 'underline', 'clear',]],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['height', ['height']],
            ['table', ['table']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']]
          ],
    });

    $(".submit-journal").click(function(){        
        $("#form-jornal").submit();
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
    
});

function prepare_delete_author(str){
    id = str.split('#');
    var url = '<?php echo site_url().'dashboard/delete/author_migrate/';?>'+id[0]+'/'+id[1];
    $("#deleteAuthor").attr('action', url);
}
function prepare_delete_file(id){
    $("#sf_id").val(id);
}
</script>