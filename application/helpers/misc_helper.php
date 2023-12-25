<?php  

/**
 * @package    ijtech / 2016
 * @author     Sabbana - sstud-io.net
 * @copyright  journal
 * @version    1.0
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function UR_exists($url){
	if($url != ''){
		$headers=get_headers($url);
		return stripos($headers[0],"200 OK")?true:false;
	}else
		return false;
}

function image_url($url){
	if($url != "")
		$img = $url;
	else
		$img = site_url().'assets/img/foto/default.png';
	return $img;
}

function set_image($url, $param = null){
	$res = base_url().'assets/img/user.jpg';
	if($url !== null & $url!='')
		$res = base_url().$url;
	return $res;		
}

function generatePassword($length, $strength){
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1)
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    if ($strength & 2) 
        $vowels .= "AEUY";
    if ($strength & 4) 
        $consonants .= '23456789';
    if ($strength & 8) 
        $consonants .= '@#$%';

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++){
        if ($alt == 1){
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        }else{
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

function gen_url($str){
	if($str == "")
		$str = 'untitled';
	
	$str = str_replace('+','-', urlencode($str));
	return strtolower($str);
}

function submission_status($sts, $round=null, $sub_statusAtTblSubmission=null){ //translate the sub_status recorded table submission_log_status
	switch ($sts){
		case '0' : $label = 'Author starting submission.'; break;
		case 'completed' : $label = 'Completed Manuscript'; break;
		case '1' :
			$label = 'Manuscript submitted. Screening by editor started.'; 
			if ($round > 1) $label = 'Revision submitted. Screening by editor started.';
		    break;
		case '2' : 
		    $label = 'Screened by editor'; 
		    if ($round > 1) $label = 'Revision screened by editor';
            if($sub_statusAtTblSubmission==7){
		        $label .= ': Need revision';
		    }else{
		        $label .= '.'; //setelah screening by eic, blm tentu langsung screening by secre. bisa aja need revision
		    }
		    break;
		case '3' : $label = 'Reviewer assignment'; break;
		case '4' : $label = 'Review Process'; break;
		case '5' : $label = 'Review received'; break;
		case '6' : $label = 'Decision by Editor'; break; //6 ga ada di tabel submisssion.sub_status
		case '7' : { //di sini harusnya ada "author needs to submit a revision". saat author udh submit revisi, otomatis submission statusnya kembali ke step di mana dia diminta revisi (bisa kembali ke screening sekre, screening eic, atau peer review)
			$label = 'Decision: need revision. Author agree to revise.'; //Revise (Send back to author)'; 
			//if ($round > 1) $label = 'Revise'; 
		} break;
		case '8' : $label = 'Accepted'; break;
		case '9' : $label = 'Published'; break;
		case '10' : $label = 'Completed Manuscript'; break;
		case '11' : $label = 'In Press'; break;
		case '12' : $label = 'Inline editing'; break;
		case '13' : $label = 'Proofreading'; break;
		case '14' : $label = 'Copyrighting'; break;
		case '99' : $label = 'Withdrawn'; break;
		case '100' : $label = 'Retracted'; break;
		default : $label = 'All Manuscript'; break;
	}
	return $label;
}

function manuscript_type($type){
	switch ($type){
		case 0 : $label = 'Graphical Abstract'; break;
		case 1 : $label = 'Manuscript File - DOC/DOCX'; break;
		case 2 : $label = 'Manuscript File - PDF'; break;
		case 3 : $label = 'Supplementary File - DOC/PDF/JPG/PNG'; break;
		case 4 : $label = 'Response Letter - PDF'; break;
		case 5 : $label = 'Cover Letter - PDF'; break;
	}
	return $label;
}

function reviewer_decision_label($type){
    $label = "";
	switch ($type){
		case 0 : $label = '<div class="badge label-default">Waiting Editor Decision</div>'; break;
		case 1 : $label = '<div class="badge label-success">Agree to do review</div>'; break;
		case 2 : $label = '<div class="badge label-info">Invited<br>Waiting Confirmation</div>'; break;
		case 3 : $label = '<div class="badge label-error">Refuse to review</div>'; break;
		case 4 : $label = '<div class="badge label-error">Task Expired</div>'; break;
		case 5 : $label = '<div class="badge label-warning">Done</div>'; break; //ruki 24aug2018
		case 6 : $label = '<div class="badge label-error">Invitation Expired</div>'; break; //ruki 24aug2018
		case 7 : $label = '<div class="badge label-error">Task Expired</div>'; break; //ruki 24aug2018
	}
	return $label;
}

function status_people($type){
	switch ($type){
		case 1 : $label = '<div class="badge label-danger">Editor In Chief</div>'; break;
		case 2 : $label = '<div class="badge label-success">Managing Editor</div>'; break;
		case 3 : $label = '<div class="badge label-defult">Member</div>'; break;
	}
	return $label;
}

function review_result($type){
	switch ($type){
		case 0 : $label = '<div class="badge label-default">Not done yet</div>'; break;
		case 1 : $label = '<div class="badge label-success">Done, Accept</div>'; break;
		case 2 : $label = '<div class="badge label-info">Done, Revisions Required</div>'; break;
		case 3 : $label = '<div class="badge label-danger">Done, Reject</div>'; break;
		default : $label = '<div class="badge label-default">Not done yet</div>'; break;
	}
	return $label;
}

function decision_status($status, $type, $isReasonNull=null){ //isReasonNull: null=tak diketahui, 1:berarti ini entry karena author, 0:berarti ini entry karena EiC atau Sekre
	if($type == 0){
		switch ($status){
			case 0 : $label = '<div class="badge label-default">Not decided yet</div>'; break;
			case 1 : $label = '<div class="badge label-default">Accepted - Proceed to screening by Secretariat</div>'; break;
			case 2 : $label = '<div class="badge label-info">Revise - Send back to Author</div>'; break;
			case 3 : $label = '<div class="badge label-danger">Rejected</div>'; break;
			default : $label = '<div class="badge label-default">Not decide yet</div>'; break;
		}
	}else if($type == 1){
		switch ($status){
			case 0 : $label = '<div class="badge label-default">Not decided yet</div>'; break;
			case 1 : $label = '<div class="badge label-success">Accepted - Proceed to reviewer</div>'; break;
			case 2 : $label = '<div class="badge label-info">Revise - Send back to Author</div>'; break;
			case 3 : $label = '<div class="badge label-danger">Rejected</div>'; break;
			default : $label = '<div class="badge label-default">Not decide yet</div>'; break;
		}
	}else{
		switch ($status){
			case 0 : $label = '<div class="badge label-default">Not decided yet</div>'; break;
			case 1 : $label = '<div class="badge label-success">Accepted</div>'; break;
			case 2 : $label = '<div class="badge label-info">Revisions Required</div>'; break;
			case 3 : $label = '<div class="badge label-danger">Reject Submission</div>'; break;
			default : $label = '<div class="badge label-default">Not decide yet</div>'; break;
		}
	}
	return $label;
}

function screening_status($type){
	switch ($type){
		case 1 : $label = '<div class="badge label-success">Accepted - Process to review</div>'; break;
		case 2 : $label = '<div class="badge label-info">Revise - Send Back to Author</div>'; break;
		case 3 : $label = '<div class="badge label-danger">Reject Manuscript</div>'; break;
		default : $label = '<div class="badge label-default">Not decide yet</div>'; break;
	}
	return $label;
}

function due_date($day, $date){
    $date = strtotime("+".$day." days", strtotime($date));
    return  date("Y-m-d", $date);
}

function chief_data(){
    $CI =& get_instance();
    return $CI->db->query("select concat(salutation,' ',fullname) n, email e from people where status = 1 order by pid limit 1")->row();
}
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
?>