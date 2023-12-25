<?php

/**
 * @package    Journal - IJTech FTUI /libraries - 2016
 * @author     Sabbana
 * @copyright  sstud-io.net / pajon.co.id
 * @version    1.0
 */

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_view {

    private $ci;

    function __construct() {
        $this->ci =&get_instance();
        $this->ci->load->model('Mdl_cms','cms');
        $this->ci->load->model('Mdl_front','front');
    }

    public function gen_manuscript_name($sub_id){
        $data = $this->ci->cms->current_submission($sub_id);
        $format = $data[0]['section_abv'].'-'.$sub_id.'-'.date('YmdHis');
        if($data[0]['round'] > 1)
            $format = 'R'.($data[0]['round']-1).'-'.$format;
        return $format;
    }

    public function author_submission($sub_id, $mode=null){
        $res = array();
        $data = $this->ci->cms->get_author_submission($sub_id);
        switch($mode){
            case 1:{
                if(!empty($data)){
                    foreach($data as $a){
                        array_push($res, $a['first_name'].' '.$a['last_name'].'<i>('.$a['email'].')</i> - '.strip_tags($a['affiliation']).', '.strip_tags($a['country']));
                    }
                }
            } break;

            default:{
                if(!empty($data)){
                    foreach($data as $a){
                        array_push($res, $a['first_name'].' '.$a['last_name']);
                    }
                }
            } break;
        }
        
        return implode (', ', $res);
    }

    public function reviewer_submission($sub_id, $mode=null){
        $res = array();
        $data = $this->ci->cms->get_reviewers($sub_id);
        switch($mode){
            case 1:{
                if(!empty($data)){
                    foreach($data as $a){
                        array_push($res, $a['fullname'].'<i>('.$a['email'].')</i> - '.strip_tags($a['affiliation']));
                    }
                }
            } break;

            default:{
                if(!empty($data)){
                    foreach($data as $a){
                        array_push($res, $a['fullname']);
                    }
                }
            } break;
        }
        
        return implode (', ', $res);   
    }
    
    public function author_submission_full($sub_id){
        $res = array();
        $data = $this->ci->cms->get_author_submission($sub_id);
        if(!empty($data)){
            $ca = array();
            foreach($data as $a){
                if($a['corresponding'] == 1)
                    array_push($ca, '1');
            }
            $no=0;
            foreach($data as $a){ $no++;
                $name = $a['salutation'].' '.$a['first_name'].' '.$a['last_name']. ' <a href="mailto:'.$a['email'].'"><i><i class="fa fa-envelope"></i> '.$a['email']."</i></a>".(!empty($ca) ? ($a['corresponding'] == 1 ? ' <i class="fa fa-check-circle text-success" title="corresponding author"></i>':'') : ($no == 1? ' <i class="fa fa-check-circle text-success" title="corresponding author"></i>':''));
                $aff = $a['affiliation'] !== "" ? '<br/>'.strip_tags($a['affiliation']):'';
                array_push($res, ''.$name.$aff);
            }
        }
        $str = '<ol>';
        for($a=0; $a<count($res); $a++){
            $str .= '<li>'.$res[$a].'</li>';
        }
        $str .= '</ul>';
        return $str;
    }

    public function first_submit_date($sub_id){
        $data = $this->ci->cms->get_submit_date_history($sub_id);
        if(!empty($data))
            return $data[0]['date_log'];
        return null;
    }

    public function count_submission_issue($issue_id){
        return $this->ci->cms->count_submission_issue($issue_id);
    }

    public function get_issue($issue_id){
        $data = $this->ci->front->get_issue($issue_id);
        if(!empty($data))
            return "VOL ".$data[0]['volume'].", NO ".$data[0]['issue_number']." (".$data[0]['year'].")";
        else return "VOL 0, NO 0 (0000)";
    }

    public function check_input($sub_id, $param){
        $data = $this->ci->cms->current_submission($sub_id);
        $res = "<i class='fa fa-times text-danger'></i>";
        switch ($param){
            case "meta" : {
                if ($data[0]['section_id'] !== "" && 
                    $data[0]['sub_title'] !== "" && 
                    $data[0]['abstract'] !== "" && 
                    $data[0]['keywords'] !== "" &&
                    $data[0]['sub_references'] !== ""){
                    $res = "<i class='fa fa-check text-success'></i>";                    
                }                
            } break;
            case "author" : {
                $data = $this->ci->cms->get_author_submission($sub_id);
                if (count($data) > 0)
                    $res = "<i class='fa fa-check text-success'></i>";
            } break;
            case "reviewer": {
                $data = $this->ci->cms->get_submission_reviewer($sub_id);
                if (count($data) >= 3)
                    $res = "<i class='fa fa-check text-success'></i>";
            } break;
            case "detail" : {
                $cover = strip_tags($data[0]['cover_letter']);
                if(($cover !== "" && $cover !== null) && $data[0]['not_publish'] == 1 && $data[0]['read_ethics'] == 1)
                    $res = "<i class='fa fa-check text-success'></i>";
            } break;
            case "file" : {
                $doc = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 1);
                $pdf = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 2);
                $letter = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 4);
                $image = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 0);
                if($data[0]['round'] > 1){
                    if((count($doc) > 0) && (count($pdf) > 0) && count($image) > 0 && count($letter) > 0)
                        $res = "<i class='fa fa-check text-success'></i>";
                }else{
                    if((count($doc) > 0) && (count($pdf) > 0) && count($image) > 0)
                        $res = "<i class='fa fa-check text-success'></i>";
                }
            } break;
            case "submit" : {                
                if($data[0]['sub_status'] != 0 && $data[0]['sub_status'] != 7)
                    $res = "<i class='fa fa-check text-success'></i>";                
            } break;
        }
        return $res;
    }

    public function check_input_status($sub_id, $param){
        $data = $this->ci->cms->current_submission($sub_id);
        $res = 0;
        switch ($param){
            case "meta" : {
                if ($data[0]['section_id'] !== "" && 
                    $data[0]['sub_title'] !== "" && 
                    $data[0]['abstract'] !== "" && 
                    $data[0]['keywords'] !== "" &&
                    $data[0]['sub_references'] !== ""){
                    $res = 1;
                }                
            } break;
            case "author" : {
                $data = $this->ci->cms->get_author_submission($sub_id);
                if (count($data) > 0)
                    $res = 1;
            } break;
            case "reviewer": {
                $data = $this->ci->cms->get_submission_reviewer($sub_id);
                if (count($data) >= 3)
                    $res = 1;
            } break;
            case "detail" : {
                $cover = strip_tags($data[0]['cover_letter']);
                if($cover !== "" && $cover !== null)
                    $res = 1;
            } break;
            case "file" : {
                $doc = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 1);
                $pdf = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 2);
                $image = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 0);
                $letter = $this->ci->cms->get_manuscript_file_type($sub_id, $data[0]['round'], 4);
                if($data[0]['round'] > 1){
                    if((count($doc) > 0) && (count($pdf) > 0) && count($image) > 0 && count($letter) > 0)
                        $res = 1;
                }else{
                    if((count($doc) > 0) && (count($pdf) > 0) && count($image) > 0)
                        $res = 1;
                }
            } break;
            case "submit" : {                
                if($data[0]['sub_status'] != 0 && $data[0]['sub_status'] != 7)
                    $res = 1;
            } break;
        }
        return $res;
    }

    public function preview_image($sub_id){
        $img = base_url().'assets/front/img/cover-mini.gif';
        $data = $this->ci->front->get_preview_image($sub_id);
        if(!empty($data))
            $img = base_url().$data[0]['file_url'];
        return $img;
    }

    public function get_supplement_files($sub_id){
        return '';
    }

    public function user_signal($uid){
        $role = $this->ci->cms->get_role_user($uid);
        $res = '';
        if (in_array(1, $role) || in_array(2, $role))
            $res = '<sup><i class="fa fa-star text-warning"></i></sup>';
        return $res;
    }

    public function gen_roles($uid){
        $role = $this->ci->cms->get_role_user($uid);
        $res = array();
        if(!empty($role)){
            foreach ($role as $r){
                array_push($res, $r['role_name']);
            }
        }
        return implode(', ', $res);
    }

    public function check_valid_reviewer($sub_id){
        $user_email = $this->ci->session->userdata('email');
        $reviewer = $this->get_reviewers($sub_id);
        $emails = array();
        if(!empty($reviewer)){
            foreach ($reviewer as $r) {
                array_push($emails, $r['email']);
            }
        }
        $res = False;
        if (in_array($user_email, $emails))
            $res = True;
        return $res;
    }

    public function check_enable_decision_review($sub_id, $round = 1){
        $email = $this->ci->session->userdata('email');
        $data = $this->ci->cms->get_review_item($sub_id, $round, $email);
        $res = false;
        if($data[0]['date_review'] !== NULL)
            $res = True;
        return $res;
    }

    public function gen_name_reviewer($sub_id, $email){
        $data = $this->ci->cms->get_reviewers($sub_id, $email);
        if(!empty($data))
            return $data[0]['fullname'];
        else return 'Unregistered';
    }

    public function submission_screening($sub_id, $round = ''){
        return $this->ci->cms->get_submission_screening($sub_id);
        if($round !== '')
            return $this->ci->cms->get_submission_screening($sub_id, $round);
    }

    public function get_section_editor($sec_id){
        return $this->ci->cms->get_section_editor($sec_id);
    }

    public function get_reviewers($sub_id, $status = null){
        if($status == 1)
            return $this->ci->cms->get_reviewers_active($sub_id);            
        return $this->ci->cms->get_reviewers($sub_id);
    }
    public function get_submission_file($sub_id, $round = 1){
        return $this->ci->cms->get_submission_file($sub_id, $round);
    }

    public function count_submission_by_user($user_id, $sts){
        return $this->ci->cms->count_submission_status_by_user($user_id, $sts);
    }

    public function count_submission_status($sts){
        return $this->ci->cms->count_submission_status($sts);
    }

    public function count_submission_section($sec, $sts = null){
        return $this->ci->cms->count_submission_status_by_section($sec, $sts);
    }

    public function show_suggest_reviewer($sub_id){
        return $this->ci->cms->check_show_suggest_reviewer($sub_id);
    }

    public function log_submission_status($sub_id, $round = ''){ //27jan2021: kata-kata di sini masih ambigu, shg kurang sinkron dg tampilan history screening di bawahnya
        $is_author = in_array(5, $this->ci->session->userdata('role')) ? true: false;
        $CI = &get_instance();
        $data = $this->ci->cms->get_log_submission_status($sub_id); //select * from submission_log_status where sub_id = '$sub_id' order by date_log ASC
        $thisSubStatus = $CI->db->query("select coalesce(NULL,sub_status) c from submission where sub_id = ?",[$sub_id])->row()->c;
        if ($is_author){ //if role=author, show the last status only
            echo in_array($data[(count($data)-1)]['sub_status'], array(3,4,5)) ? 'Review Process': submission_status($data[(count($data)-1)]['sub_status'], $round, $thisSubStatus);
			if($data[(count($data)-1)]['sub_status']==1||$data[(count($data)-1)]['sub_status']==2){ //if there is only 1 or 2 entries in submission_log_status (10jun2021 by ruki)
				
				$showOrNot = $CI->db->query("select count(*) c 
				    from submission_screening 
				    where sub_id = ? 
				    and date_input > (
				        select date_log 
				        from submission_log_status 
				        where sub_id = ? 
				        order by sub_log_id desc limit 1
				    ) 
				    order by screening_id desc limit 1"
				,[$sub_id,$sub_id])->row()->c; //hitung jml decision (jml entry di submission_screening) yg diberikan setelah log terakhir, karena ada kalanya decision diberikan namun tidak masuk ke log (bener gak sih?)
				if($showOrNot>0){
    				$screeningResult = $CI->db->query("select status 
    				    from submission_screening 
    				    where sub_id = ? 
    				    order by screening_id desc limit 1"
    				,[$sub_id])->row()->status; //cek decision terakhir
    				switch($screeningResult){ //0=blm ada decision, 1=proceed, 2=revise, 3=reject
    					case 1: echo " <div class='badge label-success'>Passed</div>";break;
    					case 2:
    					    $askDate = $CI->db->query("select date_input x 
    					        from submission_screening 
    					        where sub_id = ? 
    					        order by screening_id desc limit 1"
					        ,[$sub_id])->row()->x; //date when author is asked to revise. ini pasti ada
    					    $reviseDate = $CI->db->query("select date_log x 
    					        from submission_log_status
    					        where sub_id = ? 
    					        and (sub_status = 1 or sub_status = 2) 
    					        order by sub_log_id desc limit 1"
					        ,[$sub_id])->row()->x; //date when author submit revision. ini mungkin null
    					    if(is_null($reviseDate) || strtotime($askDate) >= strtotime($reviseDate)){ //author blm submit revision
    					        echo " <div class='badge label-warning'>Need revision</div>";
    					    }else{
    					        echo " <div class='badge label-default'>Screening the submitted revision</div>";
    					    }
    					    break; //ini kalo di IEEE: rejected, resubmission allowed
    					case 3: echo " <div class='badge label-danger'>Rejected</div>";break;
    					default: echo " "; break;
    				}
				}
				
			}
        }else{ //if role is not author, show list of history
            if(!empty($data)){
//                echo "<div style='display:none'><pre>".print_r($data)."</pre></div>";
                
                echo "<table class='table-striped' width='100%'>";
                $no=0;
                $curRound = 0;
                $curRound = $CI->db->query("select round x from submission where sub_id = ?",[$sub_id])->row()->x;
                $nScreeningBySC  = 0;
                $nScreeningByEiC = 0;
                foreach ($data as $log){
                    $no++;
                    $done = 0;
                    if($log['sub_status']==1){ 
                        $nScreeningByEiC++; 
                        if($nScreeningByEiC>1){
                            echo "<tr><td>Revision submitted. Screening by editor started.</td><td width='120'><small>".date('d M Y - H:i', strtotime($log['date_log']))."</small></td></tr>";
                            //todo: solve problem: status ini ga bisa membedakan revision pada tahap screening atau review 
                            $done=1;
                        }
                    }elseif($log['sub_status']==2){
                        $nScreeningBySC++;
                        if($nScreeningBySC>1){
                            //Screening the revision by Secretariat
                            echo "<tr><td>Revision submitted. Screening by secretariat started.</td><td width='120'><small>".date('d M Y - H:i', strtotime($log['date_log']))."</small></td></tr>";
                            //todo: solve problem: status ini ga bisa membedakan revision pada tahap screening atau review 
                            $done=1;
                        }
                    }
                    if($done==0){
                        echo "<tr><td>".( $no != 2 && $log['sub_status'] == 1 ? 'Revise screening by secretariat': submission_status($log['sub_status'],$curRound))."</td><td width='120'><small>".date('d M Y - H:i', strtotime($log['date_log']))."</small></td></tr>";
                    }
                }
                echo "</table>";
            }else{
                echo "None (because data migration)";
            }
        }
    }

    public function check_enable_screening($sub_id){
        return $this->ci->cms->check_enable_screening($sub_id);
    }

    public function check_enable_confirm_revise($sub_id){
        return $this->ci->cms->check_enable_confirm_revise($sub_id);
    }

    public function email_corrensponding($sub_id){
        $author = $this->ci->cms->get_coauthor_submission($sub_id);
        if (!empty($author))
            return $author[0]['email'];
        else{
            $author = $this->ci->cms->get_author_submission($sub_id);
            return $author[0]['email'];
        }
    }

    public function get_author_affiliation($sub_id){
        $res = '';
        $data = $this->ci->cms->get_author_submission($sub_id);
        if(!empty($data)){
            $res .= "<table class='table table-striped'>";
            foreach($data as $a){
                $res .= "<tr>
                    <td width='200'>".$a['first_name']." ".$a['last_name']."</td>
                    <td>".$a['affiliation']."</td>
                </tr>";
            }
            $res .= "</table><a href='mailto:".$this->email_corrensponding($sub_id)."''> <i class='fa fa-envelope-o'></i> Email to Corresponding Author</a>";
        }
        return $res;
    }
    
    public function getBibtex($sub_id){
			$CI = &get_instance();
			$r = $CI->db->query("SELECT 
				j.title,
				j.pages,
				year(j.date_publish) as year,
				date_format(j.date_publish,'%b') as month,
				j.doi_url as DOI,
				i.volume,
				i.issue_number as number,
				group_concat(concat(sa.first_name,' ',sa.last_name)) as author
				from journal j 
				join submission_author sa on sa.sub_id = j.sub_id
				join issue i on i.issue_id = j.issue_id
				where j.sub_id = $sub_id
				group by j.sub_id
				")->row();
			return "@article{ijtech-$sub_id, title={" . $r->title . "}, author={" . $r->author . "}, volume={" . $r->volume . "}, number={" . $r->number . "}, year={" . $r->year . "}, month={" . $r->month . "}, pages={" . $r->pages . "}, DOI={" . $r->DOI . "}, journal={International Journal of Technology}, ISSN={2087-2100}}";
    }
	public function getRIS($sub_id){
			$CI = &get_instance();
			$r = $CI->db->query("SELECT 
				j.sub_id,
				j.title,
				j.pages,
				year(j.date_publish) as year,
				date_format(j.date_publish,'%m') as month,
				date_format(j.date_publish,'%d') as day,
				j.doi_url as DOI,
				i.volume,
				i.issue_number as number,
				group_concat(concat(sa.first_name,' ',sa.last_name)) as author
				from journal j 
				join submission_author sa on sa.sub_id = j.sub_id
				join issue i on i.issue_id = j.issue_id
				where j.sub_id = $sub_id
				group by j.sub_id
				")->row();
			return "TY  - JOUR
				T1  - $r->title
				AU  - $r->author
				JO  - International Journal of Technology
				VL  - $r->volume
				IS  - $r->number
				SP  - 291
				EP  - 319
				PY  - $r->year
				DA  - $r->year/$r->month/$r->day
				SN  - 2087-2100
				DO  - $r->DOI
				UR  - https://ijtech.eng.ui.ac.id/article/view/$r->sub_id
			";
	}

    public function default_citation($sub_id){
        $theauthors = '';
        $authors = $this->ci->cms->get_author_submission($sub_id);
        $sub = $this->ci->cms->get_current_journal($sub_id);
        $x = 0; 
        foreach ($authors as $a) { $x++;
            if ($x < count($authors)){
                if($a['last_name'] !== ''){
                    $fn = explode(' ', $a['first_name']);
                    $_fn = '';
                    for($x=0; $x < count($fn); $x++)
                        $_fn .= strtoupper(substr($fn[$x], 0,1)).'.';

                    $theauthors .= $a['last_name'].', '.$_fn.', ';
                }
                else $theauthors .= $a['first_name'].'., ';
            }else{
                $fn = explode(' ', $a['first_name']);
                $_fn = '';
                for($x=0; $x < count($fn); $x++)
                    $_fn .= strtoupper(substr($fn[$x], 0,1)).'.';

                if($a['last_name'] !== '')
                    $theauthors .= (count($authors) > 1 ? '& ':'').$a['last_name'].', '.$_fn;
                else $theauthors .= (count($authors) > 1 ? '& ':'').$a['first_name'];
            }
        }
        return $theauthors.' '.date('Y', strtotime($sub[0]['date_accept'])).'. '.$sub[0]['title'].'. <i>International Journal of Technology</i>. Volume '.$sub[0]['volume'].'('.$sub[0]['issue_number'].')'.', pp.'.$sub[0]['pages'];
    }

    public function check_profile($user_id){
        $data = $this->ci->cms->get_user($user_id);
        $res = true;
        if($data[0]['affiliation'] == '' || $data[0]['section_id'] == 0)
            $res = false;
        return $res;
    }

    public function check_revise($sub_id){
        return $this->ci->cms->is_send_back($sub_id);
    }

    public function get_user_submit($user_id){
        $author = $this->ci->cms->get_user($user_id);
        if(!empty($author))
            return $author[0]['salutation'].' '.$author[0]['first_name'].' '.$author[0]['last_name'].' <i>('.$author[0]['email'].')</i>';
        else return '---';
    }

}