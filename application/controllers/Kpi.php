<?php
/**
 * @author: Ruki
 * @date: 12-08-2019 (start)
 */
class Kpi extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('grocery_CRUD');
	}
	function kinerja(){
	    sleep(7);
        $from = $this->input->get('from');
        $to   = $this->input->get('to'  );
        $edisi = $this->input->get('edisi');
        if(!isset($from)){ $from = $this->session->kerja_from; }
        if(!isset($to  )){ $to   = $this->session->kerja_to;   }
        if(!isset($edisi)){ $edisi = $this->session->kerja_edisi; }
        if(!validateDate($from)){ $from = date("Y-m-d", time() - 60*60*24*30); }
        if(!validateDate($to  )){ $to   = date("Y-m-d", time() + 60*60*24*30); }
        if($from > $to){
        	$from = date("Y-m-d", time() - 60*60*24*30*2);
        	$to   = date("Y-m-d", time());
        }
        $this->session->set_userdata(['kerja_from'=>$from,'kerja_to'=>$to,'kerja_edisi'=>$edisi]);
        
        $opt_edisi = "";
        $edisis_ = $this->db->query("select * from editions")->result();
	    foreach($edisis_ as $e){
	        $opt_edisi .= "<label><input type='checkbox' ".( in_array($e->id,$edisi)? " checked ":"")." name='edisi[]' value='".$e->id."'> ".$e->abv."</label>"; 
	    }
	    $this->data['beforeGC']= "
			<div style='margin-bottom:-10px'>
				<div class='row' style='margin-bottom: 40px'>
					<div class='col-md-6'>
						<form method='get'>
						    <h5>Filter tanggal mulai, akhir, dan edisi:</h5>
							<div class='row'>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$from' name='from'>
								</div>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$to' name='to'>
								</div>
								<div class='col-lg-4'>
									".$opt_edisi."
								</div>
								<div class='col-lg-4'>
									<input type='submit' class='btn btn-primary' value='Filter'>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>";
	    
	    $cost = $this->db->query("select kode,val from cost_unit where active=1")->result_array();
        $cost = array_combine(array_column($cost,'kode'),array_column($cost,'val'));
	    
	    $u_ = $this->db->query("select se.user_id, se.emails, se.ids, u.salutation, u.first_name, u.last_name
	      from section_editor se 
	      left join users u on u.user_id = se.user_id
	      where se.active = 1")->result();
	    $d = array();
	    $tb1="<table id='tb1' class='table table-bordered table-hover'>
<thead style='font-weight:bold;text-align:center;background:#158cba;color:#fff'>
<tr>
<td rowspan='2'>No</td>
<td rowspan='2'>Name</td>
<td colspan='3'>Making Decision</td>
<td colspan='5'>Managing Reviewers</td>
<td colspan='3'>Giving Review</td>
<td rowspan='2'>Revenue (IDR)</td>
</tr>
<tr>
<td>Screening</td>
<td>Peer Review (round 1)</td>
<td>Peer Review (round &gt;1)</td>
<td>Adding</td>
<td>Inviting</td>
<td>Invited &amp; refused</td>
<td>Invited &amp; willing</td>
<td>Invited &amp; give review</td>
<td>Accept</td>
<td>Revise</td>
<td>Reject</td>
</tr>
</thead>
<tbody>";
$modals = "";
$m1 = "<div class='modal fade' tabindex='-1' role='dialog' id='modal-detilEditor";
//no
$m2 = "'>
  <div class='modal-dialog'>
    <div class='modal-content'>
     <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
      <h4 class='modal-title'>";
//nama editor
$m3 = " - Performance log</h4>
     </div>
     <div class='modal-body'>";
//content
$m4 = "</div>
     <div class='modal-footer'>
      <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Close</button>
     </div>
    </div>
  </div>
</div>";
        $no=0;
	    foreach($u_ as $u){
	     $no++;
	     $tb1.="<tr><td>$no</td><td><a data-toggle='modal' data-target='#modal-detilEditor$no' href>".trim(implode(' ',[$u->salutation, $u->first_name, $u->last_name]))."</a></td>";
         $ids = explode(',',$u->ids);
         $tmp = array();
         foreach($ids as $i){ $tmp[] = "'".trim($i)."'"; }
         $ids_ = implode(",",$tmp);
         
         $es = explode(',',$u->emails);
         $tmp = array();
         foreach($es as $e){ $tmp[] = "'".trim($e)."'"; }
         $es_ = implode(",",$tmp);
         
         $d[$u->user_id] = array(
          'decisionScreening' => 0,
          'decisionReview1' => 0,
          'decisionReview2dst' => 0,
          'reviewerAdd' => 0,
          'reviewerInvite' => 0, //termasuk yg waiting, cancelled, expired
          'reviewerRefuse' => 0,
          'reviewerWilling' => 0,
          'reviewerDone' => 0, //ini blm bisa dihitung
          'doRevAccept' => 0,
          'doRevRevise' => 0,
          'doRevReject' => 0
         );
         
         //cari record ngasih decision, baik di tahap screening maupun peer review
         $t = "select ss.sub_id, ss.type, ss.round, ss.status, ss.section_id, ss.eic, ss.date_input 
            from submission_screening ss
            join submission s on s.sub_id = ss.sub_id
            where ss.user_id in (".$ids_.") 
            and s.edition in (".implode(',',$edisi).")
            and ss.date_input >= '".$from."' and ss.date_input <= '".$to."' ";
         $q = $this->db->query($t)->result();
         // kolom section_id dan eic ga tau buat apa
$modals .= $m1.$no.$m2.trim(implode(' ',[$u->salutation, $u->first_name, $u->last_name])).$m3."<h5>Making Decision:</h5><table class='table table-bordered table-striped'><thead><tr>
 <th>Paper ID</th>
 <th>Stage</th>
 <th>Decission</th>
 <!--th>change section</th>
 <th>eic</th-->
 <th>Date</th>
 </tr></thead><tbody>";

         foreach($q as $w){
          $dec_type = "none"; //0=blm, 1=proceed, 2=revise, 3=reject
          switch($w->status){
            case 1:$dec_type = "pass"  ;break;
            case 2:$dec_type = "revise";break;
            case 3:$dec_type = "reject";break;
          }
          if($w->type == 0){
            $d[$u->user_id]['decisionScreening']++;
          }else{
            if($w->round==1){ $d[$u->user_id]['decisionReview1']++; }
            else{ $d[$u->user_id]['decisionReview2dst']++; }
          }
          $step = $w->type == 0 ? "screening" : "peer review";
$modals .= "<tr>
<td><a href='".base_url()."dashboard/detail/submission/".$w->sub_id."' target='_blank'>".$w->sub_id."</td>
<td>".$step." ".($w->type==0?"":$w->round)."</td>
<td>$dec_type</td>
<!--td>$w->section_id</td>
<td>$w->eic</td-->
<td>$w->date_input</td>
</tr>";
         }
$modals .= "</tbody></table><br><br>";
         $tb1.="<td>".$d[$u->user_id]['decisionScreening']."</td>";
         $tb1.="<td>".$d[$u->user_id]['decisionReview1']."</td>";
         $tb1.="<td>".$d[$u->user_id]['decisionReview2dst']."</td>";
         
         //cari record memilih, invite, assign reviewer (dari sini blm bisa tau apakah reviewernya beneran kerja)
         $t = "select 
            srr.sub_id, srr.email, srr.date_input, srr.date_invite, srr.date_respond, srr.status
            from submission_reviewer srr
            join submission s on s.sub_id = srr.sub_id
            where srr.user_id in (".$ids_.") 
            and srr.email not in (".$es_.")
            and s.edition in (".implode(',',$edisi).")
            and srr.date_input >= '".$from."' and srr.date_input <= '".$to."' ";
         $q = $this->db->query($t)->result();
$modals .= "<h5>Managing Reviewers</h5><table class='table table-bordered table-striped'><thead><tr>
  <th>Paper ID</th>
  <th>Reviewer's email</th>
  <th>Date input</th>
  <th>Date invite</th>
  <th>Date respond</th>
  <th>Reviewer's response</th>
  </tr></thead><tbody>";
         foreach($q as $w){
          $res = "not invited yet"; //0=blmDikirimiEmail 1=bersedia 2=waitingConfirmation 3=refused 4=removed 6=expired
          switch($w->status){
              case 1:
               $res = "willing";
               $d[$u->user_id]['reviewerWilling']++;
               break;
              case 2:
               $res = "-"  ;
               $d[$u->user_id]['reviewerInvite']++;
               break;
              case 3:
               $res = "refused";
               $d[$u->user_id]['reviewerRefuse']++;
               break;
              case 4:
               $res = "canceled";
               $d[$u->user_id]['reviewerInvite']++;
               break;
              case 6:
               $res = "expired";
               $d[$u->user_id]['reviewerInvite']++;
               break;
              default:
               $d[$u->user_id]['reviewerAdd']++;
          }
          //$d[$u->user_id]['reviewerDone']++;
$modals .= "<tr>
<td><a href='".base_url()."dashboard/detail/submission/".$w->sub_id."' target='_blank'>".$w->sub_id."</td>
<td>$w->email</td>
<td>$w->date_input</td>
<td>$w->date_invite</td>
<td>$w->date_respond</td>
<td>$res</td>
</tr>";
         }
$modals .= "</tbody></table><br><br>";
         $tb1.="<td>".$d[$u->user_id]['reviewerAdd']."</td>";
         $tb1.="<td>".$d[$u->user_id]['reviewerInvite']."</td>";
         $tb1.="<td>".$d[$u->user_id]['reviewerRefuse']."</td>";
         $tb1.="<td>".$d[$u->user_id]['reviewerWilling']."</td>";
         $tb1.="<td>?</td>";
         
         //cari record mereview
         $t = "select 
           sr.sub_id, sr.round, sr.review_result, sr.date_review
           -- ,(CHARACTER_LENGTH(sr.introduction_comment)+CHARACTER_LENGTH(sr.methodology_comment)+CHARACTER_LENGTH(sr.result_comment)+CHARACTER_LENGTH(sr.discussion_comment)+CHARACTER_LENGTH(sr.references_comment)+CHARACTER_LENGTH(sr.other_comment)+CHARACTER_LENGTH(sr.additional_comment)) len 
           from submission_review sr
           join submission s on s.sub_id = sr.sub_id
           where sr.reviewer_email in ($es_) and sr.date_review >= '".$from."' and sr.date_review <= '".$to."' 
           and s.edition in (".implode(',',$edisi).") 
           and sr.review_result is not null";
         $q = $this->db->query($t)->result();
$modals .= "<h5>Giving Review</h5><table class='table table-bordered table-striped'><thead><tr>
<th>Paper ID</th>
<th>Review round</th>
<th>Suggestion</th>
<!--th>comment's length (# char)</th-->
<th>Date review</th>
</tr></thead><tbody>";
         foreach($q as $w){
          $sugg = "?";
          switch($w->review_result){
           case 1:
            $sugg = "accept";
            $d[$u->user_id]['doRevAccept']++;
            break;
           case 2:
            $sugg = "revise";
            $d[$u->user_id]['doRevRevise']++;
            break;
           case 3:
            $sugg = "reject";
            $d[$u->user_id]['doRevReject']++;
            break;
          }
$modals .= "<tr>
<td><a href='".base_url()."dashboard/detail/submission/".$w->sub_id."' target='_blank'>".$w->sub_id."</td>
<td>$w->round</td>
<td>$sugg</td>
<!--td></td-->
<td>$w->date_review</td>
</tr>"; //$w->len
         }
$modals .= "</tbody></table>".$m4;
         $tb1.="<td>".$d[$u->user_id]['doRevAccept']."</td>";
         $tb1.="<td>".$d[$u->user_id]['doRevRevise']."</td>";
         $tb1.="<td>".$d[$u->user_id]['doRevReject']."</td>";
         $revenue = ($d[$u->user_id]['decisionScreening'] * $cost['decisionScreening'])
          + ($d[$u->user_id]['decisionReview1'] * $cost['decisionReview1'])
          + ($d[$u->user_id]['decisionReview2dst'] * $cost['decisionReview2dst'])
          + ($d[$u->user_id]['reviewerAdd'] * $cost['reviewerAdd'])
          + ($d[$u->user_id]['reviewerInvite'] * $cost['reviewerInvite'])
          + ($d[$u->user_id]['reviewerRefuse'] * $cost['reviewerRefuse'])
          + ($d[$u->user_id]['reviewerWilling'] * $cost['reviewerWilling'])
          + ($d[$u->user_id]['reviewerDone'] * $cost['reviewerDone'])
          + ($d[$u->user_id]['doRevAccept'] * $cost['doRevAccept'])
          + ($d[$u->user_id]['doRevRevise'] * $cost['doRevRevise'])
          + ($d[$u->user_id]['doRevReject'] * $cost['doRevReject']);
         $tb1.="<td>$revenue</td></tr>";
        }
        $tb1.="</tbody></table>";
        //echo "===========<pre>";print_r($d);die();
        
        $this->data['replaceGC'] = $tb1."<div>".$modals."</div>";
        $this->data['additionalScriptHead'] = "<link rel='stylesheet' href='".base_url()."assets/plugins/datatables/dataTables.bootstrap.css'>";
        $this->data['additionalScriptFoot'] = '<script src="'.base_url().'assets/plugins/datatables/jquery.dataTables.min.js"></script>
          <script src="'.base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
          <script>$(function () {$("#tb1").DataTable()})</script>';
        $this->data['title'] = 'Team Workload';
        $this->data['page'] = 'page/common_crud2';
        $this->load->view('template', $this->data);
	}
	function accounts(){
	  $c = new grocery_CRUD();
	  $c->set_table('section_editor');
	  $c->unset_add()->unset_delete()->unset_clone()->unset_read();
	  $c->edit_fields('user_id','emails','ids')
	   ->display_as('emails','Alamat email untuk mereview (dipisah koma bila banyak)')
	   ->display_as('ids','ID (dipisah koma bila banyak))');
	  $c->display_as('user_id','Name')->set_relation('user_id','users','{first_name} {last_name}')->field_type('user_id','readonly');
	  $c->columns('user_id','emails','ids');
	  $this->data['output'] = $c->render();
	  $this->data['hasGC'] = 1;
	  $this->data['title'] = 'Manage Editor Email Addresses';
	  $this->data['page'] = 'page/common_crud2';
	  $this->load->view('template', $this->data);
	}
	function cost(){
	  $c = new grocery_CRUD();
	  $c->set_table('cost_unit');
	  $c->unset_add()->unset_delete()->unset_clone()->unset_read();
	  $c->edit_fields('ket','val')->display_as('kode','Unit')->display_as('val','Cost (IDR)')->display_as('ket','Keterangan');
	  $c->field_type('ket','readonly');
	  $c->unset_columns('active','kode');
	  $this->data['output'] = $c->render();
	  $this->data['hasGC'] = 1;
	  $this->data['title'] = 'Manage Unit Cost';
	  $this->data['page'] = 'page/common_crud2';
	  $this->load->view('template', $this->data);
	}
	
	function fromChart($r=''){
	    if($r=='reset'){ $this->session->set_userdata(['status'=>null,'author'=>null]); redirect('kpi/ed1'); }
	    if($_GET['status']==$this->session->status && $_GET['author']==$this->session->author){
	        $this->session->set_userdata(['status'=>null,'author'=>null]);
	    }else{
	        $this->session->set_userdata(['status'=>$_GET['status'],'author'=>$_GET['author']]);
	    }
	    redirect('kpi/ed1');
	}
	function _callback_column_id($value, $r){
	    $x = $this->db->query('select section_abv x from section where section_id = ?',[$r->section_id])->row()->x;
        return "<a href='".site_url('dashboard/detail/submission/'.$r->sub_id)."'>R$r->round-$x-$r->sub_id</a>";
    }
	function ed1($a='',$b=''){
	    sleep(4);
	  // $this->data['replaceGC'];
	  
        $from = $this->input->get('from');
        $to   = $this->input->get('to'  );
        $sect = $this->input->get('sect');
        $se   = $this->input->get('se'  );
        if(!isset($from)){ $from = $this->session->bagan_from; }
        if(!isset($to  )){ $to   = $this->session->bagan_to;   }
        if(!isset($sect)){ $sect = $this->session->bagan_sect; }
        if(!isset($se  )){ $se   = $this->session->bagan_se;   }
        if(!validateDate($from)){ $from = date("Y-m-d", time() - 60*60*24*30); }
        if(!validateDate($to  )){ $to   = date("Y-m-d", time() + 60*60*24*30); }
        if($from > $to){
        	$from = date("Y-m-d", time() - 60*60*24*30);
        	$to   = date("Y-m-d", time() + 60*60*24*30);
        }
        $this->session->set_userdata(['bagan_from'=>$from,'bagan_to'=>$to,'bagan_sect'=>$sect,'bagan_se'=>$se]);
        
        $opt_section = "";
        $sections_ = $this->db->query("select section_id i, section_title t, section_abv a from section")->result();
	    foreach($sections_ as $s){
	        $opt_section .= "<option ".($s->i==$sect? " selected ":"")." value='".$s->i."'>".$s->t." (".$s->a.")</option>"; 
	    }
	    $this->data['beforeGC']= "
			<div style='margin-bottom:-10px'>
				<div class='row' style='margin-bottom: 40px'>
					<div class='col-md-6'>
						<form method='get'>
						    <h5>Filter tanggal submit (mulai dan akhir), section, dan edisi:</h5>
							<div class='row'>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$from' name='from'>
								</div>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$to' name='to'>
								</div>
								<div class='col-lg-4'>
									<select class='form-control' name='sect'><option value='0'>All sections</option>".$opt_section."</select>
								</div>
								<div class='col-lg-4'>
								    <select class='form-control' name='se'>
								        <option ".($se=='a'?"selected":"")." value='a'>All editions</option>
								        <option ".($se=='r'?"selected":"")." value='r'>Regular editions</option>
								        <option ".($se=='s'?"selected":"")." value='s'>Special editions</option>
								    </select>
									<!--label><input type='checkbox' name='se' value='1' ".($se==1?" checked ":"")."> Include SE</label-->
								</div>
								<div class='col-lg-4'>
									<input type='submit' class='btn btn-primary' value='Filter'>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>";
			
	  $tmp = $this->kpiPage2(" s.date_submit >= '$from' and s.date_submit <= '$to' ",$sect,$se);
	  $this->data['beforeGC'] .= $tmp[1];
	  $this->data['additionalScriptHead'] = $tmp[0];
	  
      $i = array();
      $w = " s.date_submit >= '$from' and s.date_submit <= '$to' ";
      switch ($this->session->status){
          case 0: break;
          case 1: $w.=" and s.sub_status >= 2"; break;
          case 2: $w.=" and s.sub_status >= 3"; break;
          case 3: $w.=" and s.sub_status in (3,4,5,6) "; break;
          case 4: $w.=" and s.sub_status = 7 "; break;
          case 5: $w.=" and s.sub_status = 8 "; break;
          case 6: $w.=" and s.sub_status = 10"; break;
          case 7: $w.=" and s.sub_status = 99"; break;
      }
      if    ($se=='r'){$w.=" and edition=1 ";}
      elseif($se=='s'){$w.=" and edition!=1 ";}
      else            {$w.="";}
      $w.= $sect==0? "" : " and section_id = ".$sect." ";
          
      if($this->session->author=='b'){ //lansung ambil i nya, jadiin array
          $q = "select s.sub_id i
              from submission s join submission_author a on s.sub_id = a.sub_id
              where $w ";
          $i = array_column($this->db->query($q)->result_array(),'i');
      }else{ //query harus cari tau LN dan DN
          $q = "select s.sub_id i,
              concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
              from submission s join submission_author a on s.sub_id = a.sub_id
              where $w group by s.sub_id";
          foreach($this->db->query($q)->result() as $v){
              if($this->session->author=='.dn'){
                  if(array_sum(explode(',',$v->isID)) > 0){ $i[]=$v->i; }
              }elseif($this->session->author=='.mx'){
                  if(array_sum(explode(',',$v->isID)) ==0){ $i[]=$v->i; }
              }else{
                  $i[]=$v->i;
              }
          }
      }
      if(empty($i)){ 
          // echo $q."<pre>"; print_r($i); die();
          $this->session->bagan_sect = 0;
          $this->session->bagan_se = 'a';
          $this->session->bagan_from = '2023-01-01';
          $this->session->bagan_to = '2023-05-30';
          $this->session->set_flashdata('error','Filter returns 0 result. Applying default filter now.');
          redirect('kpi/ed1'); 
      }
          
          
      
      $ids = implode(',',$i);
	  
	  $setRedCircle = "";
	  if($this->session->status>=0 && $this->session->status<=7 && ($this->session->author=='b' || $this->session->author=='.dn' || $this->session->author=='.mx')){
	    $setRedCircle = "$($('#bagan ".$this->session->author."')[".$this->session->status."]).css({'border':'3px solid red','padding':'3px','border-radius':'13px'});";
	  }
	  
	  $this->data['afterGC'] = "<script>
        $(document).ready(function(){
          $('#bagan .c b').css('cursor', 'pointer').on('click',function(){
            window.location.href = window.location.origin + '/kpi/fromChart?status=' + $(this).parent().attr('stat') + '&author=b';
          });
          $('#bagan .c .dn').css('cursor', 'pointer').on('click',function(){
            if($(this).html()==0){alert('No paper.');return 0;}
            window.location.href = window.location.origin + '/kpi/fromChart?status=' + $(this).parent().attr('stat') + '&author=.dn';
          });
          $('#bagan .c .mx').css('cursor', 'pointer').on('click',function(){
            if($(this).html()==0){alert('No paper.');return 0;}
            window.location.href = window.location.origin + '/kpi/fromChart?status=' + $(this).parent().attr('stat') + '&author=.mx';
          });
          $setRedCircle
        });
        </script>";
	  // id, section, submit date, ln/dn, author, title, status, round
	  $c = new grocery_CRUD();
	  $c->set_table('submission');
	  $c->unset_add()->unset_edit()->unset_delete()->unset_clone()->unset_read();
	  
	  $c->columns('sub_id','edition','section_id','sub_title','authors','affiliations','date_submit','round','last_event');
	  
	  /*
	  if($sect!=0){
	      $c->unset_columns('section_id');
	  }else{
	      $c->set_relation('section_id','section','{section_abv}');
	      $c->display_as('section_id','Section');
	  }
	  if($se=='r'){
	      $c->unset_columns('edition');
	  }else{
	      $c->set_relation('edition','editions','{abv}');
	  }
	  */
	  
	  
	  if($sect!=0){
	      if($se=='r'){
	        $c->unset_columns('edition','section_id');
	      }else{
	        $c->unset_columns('section_id');
	        $c->set_relation('edition','editions','{abv}');
	      }
	  }else{
	      if($se=='r'){
	        $c->unset_columns('edition');
	        $c->set_relation('section_id','section','{section_abv}')->display_as('section_id','Section');
	      }else{
	        $c->set_relation('section_id','section','{section_abv}')->display_as('section_id','Section');
	        $c->set_relation('edition','editions','{abv}');
	      }
	  }
	  
	  
	  
	  $c->display_as('sub_id','ID')->display_as('sub_title','Title')->display_as('round','# File versions');
	  $c->columnNoSearch( 'authors','affiliations','last_event');
	  $c->columnNoSorting('authors','affiliations','last_event');
	  $c->add_action('','',base_url().'dashboard/detail/submission/','fa-info-circle');
	  //$c->callback_column('sub_id',array($this,'_callback_column_id'));
	  $c->callback_column('authors',array($this,'_callback_column_authors'));
	  $c->callback_column('affiliations',array($this,'_callback_column_affiliations'));
	  $c->callback_column('last_event',array($this,'_callback_column_last_event'));
	  
	  //////// START percobaan biar bisa search di kolom authors 
	  /*
 	  $state = $c->getState();
      $info = $c->getStateInfo();
      $ids_ = "";
      if($state == 'ajax_list'){
          $id_found = array();
          if(isset($info->search['authors']) && $info->search['authors']!='' ){
              $ketemu = $this->db->query("select s.sub_id i
                from submission s 
                join submission_author a on a.sub_id = s.sub_id 
                where (a.first_name like '%".$info->search['authors']."%' or a.last_name like '%".$info->search['authors']."%') 
                and s.sub_id in ($ids) group by s.sub_id")->result_array();
              $ketemu = array_column($ketemu,'i');
              $ids_ = implode(',',$ketemu);
              // echo "k: ".$ids_;
              $c->ajaxWhere(" sub_id in (".$ids_.") "); //this will output a json and not continue executing below codes
              die();
          }
      }
      $ids = $ids_==""? $ids : $ids_;
      */
      //////// END percobaan biar bisa search di kolom authors 
      
      $c->where("sub_id in ($ids)");
	  
// se.section_abv(s.section_id) s.sub_id s.round
// s.article_type
// s.sub_title
// a.first_name, a.last_name
// a.affiliation
// s.date_submit aslinya?
// submission_log_status.date_log submission_log_status.log_desc
	  
	  //die('ctl sblm render');
	  $this->data['output'] = $c->render();
	  $this->data['hasGC'] = 1;
	  $this->data['title'] = 'Paper Bank';
	  $this->data['page'] = 'page/common_crud2';
	  $this->load->view('template', $this->data);
	}
	function _callback_column_authors($v,$r){ 
	    return $this->db->query("select group_concat(concat('- ',first_name,' ',last_name) separator '<br>') n from submission_author where sub_id = ? group by sub_id order by sort",[$r->sub_id])->row()->n;
	}
	function _callback_column_affiliations($v,$r){
	    return $this->db->query("select group_concat(concat('- ',affiliation) separator '<br>') n from submission_author where sub_id = ? group by sub_id order by sort",[$r->sub_id])->row()->n;
	}
	function _callback_column_last_event($v,$r){
        $q = $this->db->query("select
	        concat(log_desc,' <small>(',date_log,')</small>') n, sub_status, date_log 
	        from submission_log_status 
	        where sub_id = ? order by sub_log_id desc limit 1",[$r->sub_id])->row();
	    if($q->sub_status == 2 && $r->sub_status == 7){
	        return "Screening decision: Resubmit required <small>(".$q->date_log.")</small>";
	    }
	    return $q->n;
	    /* return $this->db->query("select
	        concat(log_desc,' <small>(',date_log,')</small>') n 
	        from submission_log_status 
	        where sub_id = ? order by sub_log_id desc limit 1",[$r->sub_id])->row()->n; */
	}
  private function subtract($a,$b){ return $a-$b; } //dipanggil oleh getKpiDataNegara()
  function delay(){
    sleep(7);
        $from = $this->input->get('from');
        $to   = $this->input->get('to'  );
        $sect = $this->input->get('sect');
        $se   = $this->input->get('se'  );
        if(!isset($from)){ $from = $this->session->delay_from; }
        if(!isset($to  )){ $to   = $this->session->delay_to;   }
        if(!isset($sect)){ $sect = $this->session->delay_sect; }
        if(!isset($se  )){ $se   = $this->session->delay_se;   }
        if(!validateDate($from)){ $from = date("Y-m-d", time() - 60*60*24*30); }
        if(!validateDate($to  )){ $to   = date("Y-m-d", time() + 60*60*24*30); }
        if($from > $to){
        	$from = date("Y-m-d", time() - 60*60*24*30);
        	$to   = date("Y-m-d", time() + 60*60*24*30);
        }
        $this->session->set_userdata(['delay_from'=>$from,'delay_to'=>$to,'delay_sect'=>$sect,'delay_se'=>$se]);
        
        $opt_section = "";
        $sections_ = $this->db->query("select section_id i, section_title t, section_abv a from section")->result();
	    foreach($sections_ as $s){
	        $opt_section .= "<option ".($s->i==$sect? " selected ":"")." value='".$s->i."'>".$s->t." (".$s->a.")</option>"; 
	    }
	    $this->data['beforeGC']= "
			<div style='margin-bottom:-10px'>
				<div class='row' style='margin-bottom: 40px'>
					<div class='col-md-6'>
						<form method='get'>
						    <h5>Filter tanggal submit (mulai dan akhir), section, dan edisi:</h5>
							<div class='row'>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$from' name='from'>
								</div>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$to' name='to'>
								</div>
								<div class='col-lg-4'>
									<select class='form-control' name='sect'><option value='0'>All sections</option>".$opt_section."</select>
								</div>
								<div class='col-lg-4'>
								    <select class='form-control' name='se'>
								        <option ".($se=='a'?"selected":"")." value='a'>All editions</option>
								        <option ".($se=='r'?"selected":"")." value='r'>Regular editions</option>
								        <option ".($se=='s'?"selected":"")." value='s'>Special editions</option>
								    </select>
									<!--label><input type='checkbox' name='se' value='1' ".($se==1?" checked ":"")."> Include SE</label-->
								</div>
								<div class='col-lg-4'>
									<input type='submit' class='btn btn-primary' value='Filter'>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>";
        if    ($se=='r'){$se_=" and s.edition=1 ";}
        elseif($se=='s'){$se_=" and s.edition!=1 ";}
        else            {$se_="";}
        $sect_ = $sect==0? "" : " and s.section_id = ".$sect." ";
			
			
		$tb1="";$modals="";
		$tb1="
<table class='table table-bordered table-stripped'>
<thead>
<tr>
<td colspan='2'>Proses</td>
<td colspan='3'>Durasi (days, rounded up)</td>
<td rowspan='2'>Jumlah kejadian</td>
</tr>
<tr>
<td>Dari</td>
<td>Sampai</td>
<td>Min.</td>
<td>Average</td>
<td>Max.</td>
</tr>
</thead>";
    
    //==== mencari paper id yg disubmit pada rentang tanggal tertentu
    $q0 = $this->db->query("select distinct l.sub_id
        from submission_log_status l
        join submission s on s.sub_id = l.sub_id
        where 
        l.sub_status = 1 
        and l.date_log >= '$from' 
        and l.date_log <= '$to'
        $sect_
        $se_")->result_array();
    if(count($q0)==0){ die('no paper'); }
    
    //di sini, mungkin masih ada paper yg sebenernya submit initial nya sebelum range tgl tsb. makanya mari kita saring lagi:
    $q1 = $this->db->query("select distinct l.sub_id
        from submission_log_status l
        where sub_status = 1
        and l.sub_id in (".implode(',',array_column($q0,'sub_id')).")
        and l.date_log < '$from' ")->result_array();
    if(count($q1)>0){
        // echo "ada yg harus dikurangi<br>";
        $idPapers = array_diff( array_column($q0,'sub_id') , array_column($q1,'sub_id') );
    }else{
        $idPapers = array_column($q0,'sub_id');
    }

    //===== lalu cari rentetan event utk tiap paper tsb, dan urutkan waktunya
    $q = $this->db->query("select l.sub_id
        ,group_concat(concat(l.date_log,'|',l.sub_status)) log_time_stat
        from submission_log_status l
        where 
        (l.sub_status in (1,3,7,8,9,10)
        or (l.sub_status = 2 and l.log_desc like '%ubmit%')
        or (l.sub_status = 4 and l.log_desc like '%ubmit%')
        )
        and l.sub_id in (".implode(',',$idPapers).")
        group by l.sub_id")->result();
    /*
    durasi screening, dari status
      1/2 ke 3 bila lolos
      1/2 ke 7 bila disuruh resubmit
      1/2 ke 10 bila reject
    durasi peer review, dari status
      3/4 ke 7 bila revise
      3/4 ke 8 bila accept
      3/4 ke 10 bila reject
    durasi persiapan publish, dari status
      8 ke 9
      
    ternyata kalo dari tabel submission_log_status, submit itu ga cuma sub_status=1, 
        tapi ada juga yg sub_status=2 and log_desc like '%ubmit%', 
        dan sub_status=4 and log_desc like '%ubmit%'
    */
    $t13 = array(); //nantinya diisi durasi (hari) utk tiap kejadian transisi dari status 1 ke 3
    $t17 = $t13;
    $t110 = $t13;
    $t37 = $t13;
    $t38 = $t13;
    $t310 = $t13;
    $t89 = $t13;
    
    // echo "<pre>";
    // print_r($q);
    
    foreach($q as $r){ //for each paper
        // echo "<br><b>".$r->sub_id."</b><br>";
        $l = explode(',',$r->log_time_stat);
        if(count($l)>1){
            // echo "<br>".$r->sub_id."<br>".$r->log_time_stat."<br>&nbsp;&nbsp;&nbsp;";
            asort($l); //urutkan dari yg ter-awal
            // echo implode(',',$l)."<br>";
        }
        $pState = 0; $pTime = "";
        foreach($l as $t_){ //for each event/log
            $t = explode('|',$t_); // bagi t_ dengan |, menjadi $t, jadi $t[0] isinya waktu, $t[1] isinya status paper.
            // echo "<br>    ".$t[0]." -- ".$t[1];
            
            if($t[1]==$pState){ continue; }
            
            if(in_array($t[1],[1,2,3,4,8])){
                if($pState==2 && $t[1]==3){ // tapi kalo sekarang 3 dan prev 2, harusnya menghitung t13
                    $t13[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ; //60*60*24
                    // echo " -- hitung t13: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState = 3; $pTime = $t[0];
                }else{
                    $pState = $t[1]; $pTime = $t[0];
                    // echo " -- pStete=".$pState;
                }
            }
            
            if($t[1]==3){
                if($pState==1||$pState==2){
                    $t13[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t13: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }
            }elseif($t[1]==7){
                if($pState==1||$pState==2){
                    $t17[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t17: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }elseif($pState==3||$pState==4){
                    $t37[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t37: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }
            }elseif($t[1]==8){
                if($pState==3||$pState==4){
                    $t38[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t38: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }
            }elseif($t[1]==9){
                if($pState==8){
                    $t89[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t89: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }
            }elseif($t[1]==10){
                if($pState==1||$pState==2){
                    $t110[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t110: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }elseif($pState==3||$pState==4){
                    $t310[] = (strtotime($t[0]) - strtotime($pTime)) / 86400 ;
                    // echo " -- hitung t310: ".((strtotime($t[0]) - strtotime($pTime)) / 86400);
                    $pState=0;
                }
            }
        }
    }
    /*
    echo "===== t13: <br><pre>";print_r($t13) ;echo "</pre>";
    echo "===== t17: <br><pre>";print_r($t17) ;echo "</pre>";
    echo "===== t110:<br><pre>";print_r($t110);echo "</pre>";
    echo "===== t37: <br><pre>";print_r($t37) ;echo "</pre>";
    echo "===== t38: <br><pre>";print_r($t38) ;echo "</pre>";
    echo "===== t310:<br><pre>";print_r($t310);echo "</pre>";
    echo "===== t89: <br><pre>";print_r($t89) ;echo "</pre>";
    */
    $s13  = count($t13 )>0? [round(min($t13 ),1) , round(array_sum($t13 )/count($t13 ),1) , round(max($t13 ),1)] : null;
    $s17  = count($t17 )>0? [round(min($t17 ),1) , round(array_sum($t17 )/count($t17 ),1) , round(max($t17 ),1)] : null;
    $s110 = count($t110)>0? [round(min($t110),1) , round(array_sum($t110)/count($t110),1) , round(max($t110),1)] : null;
    $s37  = count($t37 )>0? [round(min($t37 ),1) , round(array_sum($t37 )/count($t37 ),1) , round(max($t37 ),1)] : null;
    $s38  = count($t38 )>0? [round(min($t38 ),1) , round(array_sum($t38 )/count($t38 ),1) , round(max($t38 ),1)] : null;
    $s310 = count($t310)>0? [round(min($t310),1) , round(array_sum($t310)/count($t310),1) , round(max($t310),1)] : null;
    $s89  = count($t89 )>0? [round(min($t89 ),1) , round(array_sum($t89 )/count($t89 ),1) , round(max($t89 ),1)] : null;
    /*
    echo "------- s13: <br><pre>";print_r($s13) ;echo "</pre>";
    echo "------- s17: <br><pre>";print_r($s17) ;echo "</pre>";
    echo "------- s110:<br><pre>";print_r($s110);echo "</pre>";
    echo "------- s37: <br><pre>";print_r($s37) ;echo "</pre>";
    echo "------- s38: <br><pre>";print_r($s38) ;echo "</pre>";
    echo "------- s310:<br><pre>";print_r($s310);echo "</pre>";
    echo "------- s89: <br><pre>";print_r($s89) ;echo "</pre>";
    */
$tb1 .= "<tbody>
<tr>
<td>submit</td>
<td>dinyatakan lolos dari screening</td>
<td>$s13[0]</td>
<td>$s13[1]</td>
<td>$s13[2]</td>
<td></td>
</tr>
<tr>
<td></td>
<td>diminta revise pasca screening</td>
<td>$s17[0]</td>
<td>$s17[1]</td>
<td>$s17[2]</td>
<td></td>
</tr>
<tr>
<td></td>
<td>dinyatakan reject pasca screening</td>
<td>$s110[0]</td>
<td>$s110[1]</td>
<td>$s110[2]</td>
<td></td>
</tr>
<tr>
<td>lolos screening</td>
<td>diminta revise pasca peer review</td>
<td>$s37[0]</td>
<td>$s37[1]</td>
<td>$s37[2]</td>
<td></td>
</tr>
<tr>
<td></td>
<td>dinyatakan accept pasca peer review</td>
<td>$s38[0]</td>
<td>$s38[1]</td>
<td>$s38[2]</td>
<td></td>
</tr>
<tr>
<td></td>
<td>dinyatakan reject pasca peer review</td>
<td>$s310[0]</td>
<td>$s310[1]</td>
<td>$s310[2]</td>
<td></td>
</tr>
<tr>
<td>accepted</td>
<td>published</td>
<td>$s89[0]</td>
<td>$s89[1]</td>
<td>$s89[2]</td>
<td></td>
</tr>
</tbody>
</table>
		";
        $this->data['replaceGC'] = $tb1."<div>".$modals."</div>";
        $this->data['additionalScriptHead'] = "<link rel='stylesheet' href='".base_url()."assets/plugins/datatables/dataTables.bootstrap.css'>";
        $this->data['additionalScriptFoot'] = '<script src="'.base_url().'assets/plugins/datatables/jquery.dataTables.min.js"></script>
          <script src="'.base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
          <script>$(function () {$("#tb1").DataTable()})</script>';
        $this->data['title'] = 'Team Performance';
        $this->data['page'] = 'page/common_crud2';
        $this->load->view('template', $this->data);

  }
  private function getKpiDataNegara($tRange,$sect,$se){ //count entries in db. dipanggil oleh kpiPage2()
    //halt bila trange kosong
    $r = array();
    $r['paper_masuk'] = [[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0],[0,0]]; //per section. DN dlu, baru LN
    $r['lolos_screening_EiC'] = $r['paper_masuk'];
    $r['lolos_screening_sekre'] = $r['paper_masuk'];
    $r['sudah_dikomentari_dan_belum_dikasih_decision'] = $r['paper_masuk'];
    $r['accepted'] = $r['paper_masuk'];
    $r['rejected'] = $r['paper_masuk'];
    $r['withdraw'] = $r['paper_masuk'];
    $r['perlu_diurus_reviewnya'] = $r['paper_masuk'];
    $r['stat_7dst'] = $r['paper_masuk'];
    
    $tm = $r; //veriable utk menyimpan durasi rerata
      
    if    ($se=='r'){$se_=" and edition=1 ";}
    elseif($se=='s'){$se_=" and edition!=1 ";}
    else            {$se_="";}
    $sect_ = $sect==0? "" : " and section_id = ".$sect." ";
    
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where ".$tRange.$se_.$sect_." group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['paper_masuk'][$v->section_id][0]++; }
      else{ $r['paper_masuk'][$v->section_id][1]++; }
      //echo "<br>".$v->sub_id." : ".$v->section_id." : ".$v->isID;
    }
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status >= 2 $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['lolos_screening_EiC'][$v->section_id][0]++; }
      else{ $r['lolos_screening_EiC'][$v->section_id][1]++; }
    }
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status >= 3 $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['lolos_screening_sekre'][$v->section_id][0]++; }
      else{ $r['lolos_screening_sekre'][$v->section_id][1]++; }
    }
    
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status >= 7 $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['stat_7dst'][$v->section_id][0]++; }
      else{ $r['stat_7dst'][$v->section_id][1]++; }
    }
    for($cnt=0;$cnt<count($r['stat_7dst']);$cnt++){
        $r['perlu_diurus_reviewnya'][$cnt] = array_map(array($this, 'subtract'),$r['lolos_screening_sekre'][$cnt],$r['stat_7dst'][$cnt]);
    }
    
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status = 7 $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['sudah_dikomentari_dan_belum_dikasih_decision'][$v->section_id][0]++; }
      else{ $r['sudah_dikomentari_dan_belum_dikasih_decision'][$v->section_id][1]++; }
    }
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status in (8,9) $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['accepted'][$v->section_id][0]++; }
      else{ $r['accepted'][$v->section_id][1]++; }
    }
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status = 10 $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['rejected'][$v->section_id][0]++; }
      else{ $r['rejected'][$v->section_id][1]++; }
    }
    $tmp = $this->db->query("select s.section_id, 
      concat(group_concat((a.email regexp '\\.id$')),',',group_concat((case when a.country = 'Indonesia' then 1 else 0 end))) isID
      from submission s join submission_author a on s.sub_id = a.sub_id
      where $tRange and s.sub_status = 99 $se_ $sect_ group by s.sub_id")->result();
    foreach ($tmp as $v){
      if(array_sum(explode(',',$v->isID)) > 0){ $r['withdraw'][$v->section_id][0]++; }
      else{ $r['withdraw'][$v->section_id][1]++; }
    }
    unset($r['stat_7dst']);
    return $r;
    //echo "<pre>";print_r($r);
  }
  private function kpiPage2($tRange,$sect=0,$se=0){ //draw the chart. dipanggil oleh ed1()
    $maxHeight = 300;
    /*
    $d  = [100,80,75,  10,15,5,20,  25]; //total
    $d1 = [40,30,25,  4,5,3,10,  15]; //DN
    $d2 = [30,30,25,  3,5,1,5,  5]; //LN atay mix
    */
    $d_ = $this->getKpiDataNegara($tRange,$sect,$se);
    
    $dn = array_sum(array_column($d_['paper_masuk'],0));
    $ln = array_sum(array_column($d_['paper_masuk'],1));
    //echo $dn."|" .$ln;die();
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['lolos_screening_EiC'],0));
    $ln = array_sum(array_column($d_['lolos_screening_EiC'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['lolos_screening_sekre'],0));
    $ln = array_sum(array_column($d_['lolos_screening_sekre'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['perlu_diurus_reviewnya'],0));
    $ln = array_sum(array_column($d_['perlu_diurus_reviewnya'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['sudah_dikomentari_dan_belum_dikasih_decision'],0));
    $ln = array_sum(array_column($d_['sudah_dikomentari_dan_belum_dikasih_decision'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['accepted'],0));
    $ln = array_sum(array_column($d_['accepted'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['rejected'],0));
    $ln = array_sum(array_column($d_['rejected'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    $dn = array_sum(array_column($d_['withdraw'],0));
    $ln = array_sum(array_column($d_['withdraw'],1));
    $d[] = $dn+$ln; $d1[] = $dn; $d2[] = $ln;
    
    //echo "<pre>";print_r($d);die();
        
    //$l = ["Masuk", "Lolos screening EiC", "Lolos screening sekre.", "Need resubmit/revision", "Accepted", "Rejected", "Withdrawn", "Need Revision"];
    $l = ["Masuk", "Lolos screening EiC", "Lolos screening sekre.", "Under review", "Need resubmit/revision", "Accepted/Published", "Rejected", "Withdrawn", "Need Revision"];
    $css = "<style>
        #bagan{width:720px;line-height: 14px;font-size: 14px;font-family: 'Arial Narrow'}
        #bagan .c{height:".$maxHeight."px;width:100px;float:left}
        #bagan .b{border:0px solid #000;overflow:hidden;display:flex;align-items:center;justify-content:center}
        #bagan .b2{border:0px solid #000;border-left:none;border-top:none;display:flex;align-items:center;justify-content:center}
        #bagan .c_{width:100px;padding:5px 10px;float:left;text-align:center;overflow:hidden}
        #bagan .l{display:flex;align-items:center}
        #bagan i{font-style:normal;font-weight:normal}
        #bagan .dn{color:red}
        #bagan .mx, #bagan .ln{color:blue}
        .gc-container .table-label{background:none !important}
    </style>";
    if($d[0]==0){
        return [$css,"<div id='bagan'>No chart to show.<br>No submission in this period.</div>",null];
    }
    $bagan = "<div style='overflow:scroll;padding:0 10px 20px 20px'><div id='bagan'>
      <div style='height:".($maxHeight+22)."px;border-bottom:1px solid #000;border-left:1px solid #000;padding-top:20px'>
       <div style='position: absolute;text-orientation: sideways;width: 10px;height: 300px;writing-mode: vertical-lr;text-align: center;margin-left: -18px'>Number of papers</div>
       <div class='c'><div class='b' style='background:#ddddff;height:".$maxHeight."px' stat='0'><b>".$d[0]."</b> (<i class='dn'>".$d1[0]."</i>, <i class='mx'>".$d2[0]."</i>)</div></div>
       <div class='c'><div class='b' style='background:#ddfdff;height:".($maxHeight*$d[1]/$d[0])."px;margin-top:".($maxHeight*($d[0]-$d[1])/$d[0])."px;border-left:none' stat='1'><b>".$d[1]."</b> (<i class='dn'>".$d1[1]."</i>, <i class='mx'>".$d2[1]."</i>)</div></div>
       <div class='c'><div class='b' style='background:#e9ffdd;height:".($maxHeight*$d[2]/$d[0])."px;margin-top:".($maxHeight*($d[0]-$d[2])/$d[0])."px;border-left:none' stat='2'><b>".$d[2]."</b> (<i class='dn'>".$d1[2]."</i>, <i class='mx'>".$d2[2]."</i>)</div></div>
       <div class='c'>
        <!--div class='b' style='height:".($maxHeight*(($d[0]-$d[3]-$d[4]-$d[5]-$d[6])/$d[0]))."px'></div-->";
       $bagan .= "<div class='b'  style='".($d[3]==0?"display:none;":"")."background:#bbe5a5;height:".($maxHeight*$d[3]/$d[0])."px;border-left:none;overflow:visible' stat='3'><b>".$d[3]."</b> (<i class='dn'>".$d1[3]."</i>, <i class='mx'>".$d2[3]."</i>)</div>";
       $bagan .= "<div class='b2' style='".($d[4]==0?"display:none;":"")."background:#a5b3e5;height:".(($maxHeight*$d[4]/$d[0]))."px' stat='4'><b>".$d[4]."</b> (<i class='dn'>".$d1[4]."</i>, <i class='mx'>".$d2[4]."</i>)</div>";
       $bagan .= "<div class='b2' style='".($d[5]==0?"display:none;":"")."background:#e5a5d0;height:".(($maxHeight*$d[5]/$d[0]))."px' stat='5'><b>".$d[5]."</b> (<i class='dn'>".$d1[5]."</i>, <i class='mx'>".$d2[5]."</i>)</div>";
       $bagan .= "<div class='b2' style='".($d[6]==0?"display:none;":"")."background:#e5e0a5;height:".(($maxHeight*$d[6]/$d[0]))."px' stat='6'><b>".$d[6]."</b> (<i class='dn'>".$d1[6]."</i>, <i class='mx'>".$d2[6]."</i>)</div>";
       $bagan .= "<div class='b2' style='".($d[7]==0?"display:none;":"")."background:#e5e0ff;height:".(($maxHeight*$d[7]/$d[0]))."px' stat='7'><b>".$d[7]."</b> (<i class='dn'>".$d1[7]."</i>, <i class='mx'>".$d2[7]."</i>)</div>";
       $bagan .= "</div>
       <div class='c' style='width:150px;padding-left:4px'>
        <!--div class='l' style='height:".($maxHeight*(($d[0]-$d[3]-$d[4]-$d[5]-$d[6])/$d[0]))."px'></div-->";
        $bagan.= "<div class='l' style='".($d[3]==0?"display:none;":"")."height:".($maxHeight*$d[3]/$d[0])."px'>".$l[3]."</div>";
        $bagan.= "<div class='l' style='".($d[4]==0?"display:none;":"")."height:".(($maxHeight*$d[4]/$d[0])-1)."px'>".$l[4]."</div>";
        $bagan.= "<div class='l' style='".($d[5]==0?"display:none;":"")."height:".(($maxHeight*$d[5]/$d[0])-1)."px'>".$l[5]."</div>";
        $bagan.= "<div class='l' style='".($d[6]==0?"display:none;":"")."height:".(($maxHeight*$d[6]/$d[0])-1)."px'>".$l[6]."</div>";
        $bagan.= "<div class='l' style='".($d[7]==0?"display:none;":"")."height:".(($maxHeight*$d[7]/$d[0])-1)."px'>".$l[7]."</div>";
       $bagan .= "</div>
       <div style='float:right;border:1px solid;padding:5px;background:#eee'><b>XXX</b>: DN + campur + LN<br><i class='dn'>XXX</i>: Jumlah DN<br><i class='mx'>XXX</i>: Jumlah LN + campur<br><br>Klik angka untuk memfilter<br>atau menghapus filter tabel</div>
      </div>
      <div>
       <div class='c_'>".$l[0]."</div>
       <div class='c_'>".$l[1]."</div>
       <div class='c_'>".$l[2]."</div>
       <div class='c_'>Other states...</div>
      </div>
    </div></div>"; //tadinya legendnya punya style ini: position:relative;margin-top:-300px
    return [$css,$bagan,implode(',',[6752,6753])];
  }
  public function timeline($a='',$b=''){
        $from = $this->input->get('from');
        $to   = $this->input->get('to'  );
        $sect = $this->input->get('sect');
        $se   = $this->input->get('se'  );
        $tu   = $this->input->get('tu'  );
        if(!isset($from)){ $from = $this->session->timeline_from; }
        if(!isset($to  )){ $to   = $this->session->timeline_to;   }
        if(!isset($sect)){ $sect = $this->session->timeline_sect; }
        if(!isset($se  )){ $se   = $this->session->timeline_se;   }
        if(!isset($tu  )){ $tu   = $this->session->timeline_tu;   }
        if(!validateDate($from)){ $from = date("Y")."-01-01"; }
        if(!validateDate($to  )){ $to   = date("Y-m-d"); }
        if($from > $to){
        	$from = date("Y")."-01-01";
        	$to   = date("Y-m-d");
        }
        $tu = $tu=="month"? "month" : "yearweek";
        $this->session->set_userdata(['timeline_from'=>$from,'timeline_to'=>$to,'timeline_sect'=>$sect,'timeline_se'=>$se,'timeline_tu'=>$tu]);
        
        $opt_section = "";
        $sections_ = $this->db->query("select section_id i, section_title t, section_abv a from section")->result();
	    foreach($sections_ as $s){
	        $opt_section .= "<option ".($s->i==$sect? " selected ":"")." value='".$s->i."'>".$s->t." (".$s->a.")</option>"; 
	    }
	    $this->data['beforeGC']= "
			<div style='margin-bottom:-10px'>
				<div class='row' style='margin-bottom: 40px'>
					<div class='col-md-6'>
						<form method='get'>
						    <h5>Filter tanggal submission (mulai dan akhir), section, dan edisi:</h5>
							<div class='row'>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$from' name='from'>
								</div>
								<div class='col-lg-4'>
									<input class='form-control' type='date' value='$to' name='to'>
								</div>
								<div class='col-lg-4'>
									<select class='form-control' name='sect'><option value='0'>All sections</option>".$opt_section."</select>
								</div>
								<div class='col-lg-4'>
								    <select class='form-control' name='se'>
								        <option ".($se=='a'?"selected":"")." value='a'>All editions</option>
								        <option ".($se=='r'?"selected":"")." value='r'>Regular editions</option>
								        <option ".($se=='s'?"selected":"")." value='s'>Special editions</option>
								    </select>
									<!--label><input type='checkbox' name='se' value='1' ".($se==1?" checked ":"")."> Include SE</label-->
								</div>
								<div class='col-lg-4'>
								    <select class='form-control' name='tu'>
								        <option ".($tu=='month'?"selected":"")." value='month'>Monthly</option>
								        <option ".($tu=='yearweek'?"selected":"")." value='yearweek'>Weekly</option>
								    </select>
								</div>
								<div class='col-lg-4'>
									<input type='submit' class='btn btn-primary' value='Filter'>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>";
			
			
/*
0 :diAuthorTertulisCompletedManuscript
1 :screeningEIC
2 :screeningSC
    3 :reviewAssignment
4 :reviewProcess(reviewerygagreesudahlogindanmelihatformreview)
5 :reviewReceived
7 :revisionProcess
    8 :accepted
9 :archived(published)
10 :arcived(rejected)
11 :inPress
12 :lineEditing
99 :withdraw
*/
        $w_section = $sect==0 ? "" : " and s.section_id = ".$sect." ";
        $w_edition = "";
        if($se == 'r'){
            $w_edition = " and s.edition = 1 ";
        }elseif($se == 's'){
            $w_edition = " and s.edition != 1 ";
        }
        $timeUnit = $tu;
        
        $tt = "select count(*) numPaper, $timeUnit(l.date_log) as timeUnit
            from submission_log_status l
            join submission s on s.sub_id = l.sub_id
            where l.sub_status = 1
            $w_edition $w_section
            and l.date_log >= '$from' and l.date_log <= '$to'
            group by $timeUnit(l.date_log)";
		$q1 = $this->db->query($tt)->result_array(); //butuh discreening
        $q2 = $this->db->query("select count(*) numPaper, $timeUnit(l.date_log) as timeUnit
            from submission_log_status l
            join submission s on s.sub_id = l.sub_id
            where l.sub_status in (3,4,5)
            $w_edition $w_section
            and l.date_log >= '$from' and l.date_log <= '$to'
            group by $timeUnit(l.date_log)")->result_array();  //butuh dikawal proses reviewnya
            $q2a = $this->db->query("select count(*) numPaper, $timeUnit(l.date_log) as timeUnit
                from submission_log_status l
                join submission s on s.sub_id = l.sub_id
                where l.sub_status in (3,4,5) and s.round = 1
                $w_edition $w_section
                and l.date_log >= '$from' and l.date_log <= '$to'
                group by $timeUnit(l.date_log)")->result_array(); //butuh dikawal proses reviewnya, round pertama
            $q2b = $this->db->query("select count(*) numPaper, $timeUnit(l.date_log) as timeUnit
                from submission_log_status l
                join submission s on s.sub_id = l.sub_id
                where l.sub_status in (3,4,5) and s.round > 1
                $w_edition $w_section
                and l.date_log >= '$from' and l.date_log <= '$to'
                group by $timeUnit(l.date_log)")->result_array(); //butuh dikawal proses reviewnya, round kedua atau lebih
        $q3 = $this->db->query("select count(*) numPaper, $timeUnit(l.date_log) as timeUnit
            from submission_log_status l
            join submission s on s.sub_id = l.sub_id
            where l.sub_status = 7
            $w_edition $w_section
            and l.date_log >= '$from' and l.date_log <= '$to'
            group by $timeUnit(l.date_log)")->result_array(); //butuh ditungguin biar author submit revisi
        $q4 = $this->db->query("select count(*) numPaper, $timeUnit(l.date_log) as timeUnit
            from submission_log_status l
            join submission s on s.sub_id = l.sub_id
            where l.sub_status = 8
            $w_edition $w_section
            and l.date_log >= '$from' and l.date_log <= '$to'
            group by $timeUnit(l.date_log)")->result_array(); //butuh diproses menuju publikasi
      
        //judul grafik: number of new paper... sb x: time, y: jml paper, z/color: to be screened, to be reviewed (blm dapat 2 reviewer), to be reviewed again, to be published
        $this->data['replaceGC'] = "<canvas id='chart1' style='width:100%;height:400px'></canvas>";
        $this->data['additionalScriptHead'] = "<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js'></script>";
        
// bila timeUnit = month
echo "<pre>";
$ar1 = [$q1[0]['timeUnit'],
    $q2[0]['timeUnit'],
    $q2a[0]['timeUnit'],
    $q2b[0]['timeUnit'],
    $q3[0]['timeUnit'],
    $q4[0]['timeUnit']];
print_r($ar1);
sort($ar1);
$minX = $ar1[0];
print_r($minX);

$ar2 = [end($q1 )['timeUnit'],
  end($q2 )['timeUnit'],
  end($q2a)['timeUnit'],
  end($q2b)['timeUnit'],
  end($q3 )['timeUnit'],
  end($q4 )['timeUnit']];
print_r($ar2);
sort($ar2);
$maxX = end($ar2);
print_r($maxX);
echo "</pre>";
        
        $this->data['additionalScriptFoot'] = "<script>
x  = [".implode(',',array_column($q1,'timeUnit'))."];
y1 = [".implode(',',array_column($q1,'numPaper'))."];
y2 = [".implode(',',array_column($q2,'numPaper'))."];
y3 = [".implode(',',array_column($q3,'numPaper'))."];
y4 = [".implode(',',array_column($q4,'numPaper'))."];

y2a = [".implode(',',array_column($q2a,'numPaper'))."];
y2b = [".implode(',',array_column($q2b,'numPaper'))."];

new Chart('chart1', {
  type: 'line',
  data: {
    labels: x,
    datasets: [{ label: 'To be screened',
      backgroundColor: 'rgba(0, 0, 0, 1)', borderColor: 'rgba(0, 0, 0, 1)',
      fill: false, lineTension: 0.1,
      data: y1
    },{ label: 'In peer review stage',
      backgroundColor: 'rgba(255, 0, 0, 1)', borderColor: 'rgba(255, 0, 0, 1)',
      fill: false, lineTension: 0.1,
      data: y2
    },{ label: 'In peer review round 1',
      backgroundColor: 'rgba(255, 255, 0, 1)', borderColor: 'rgba(255, 255, 0, 1)',
      fill: false,lineTension: 0.1, 
      data: y2a
    },{ label: 'In peer review round 2 or more',
      backgroundColor: 'rgba(255, 0, 255, 1)', borderColor: 'rgba(255, 0, 255, 1)',
      fill: false,lineTension: 0.1,
      data: y2b
    },
    { label: 'Waiting revision',
      backgroundColor: 'rgba(0, 255, 0, 1)', borderColor: 'rgba(0, 255, 0, 1)',
      fill: false, lineTension: 0.1,
      data: y3
    },{ label: 'To be processed for publication',
      backgroundColor: 'rgba(0, 0, 255, 1)', borderColor: 'rgba(0, 0, 255, 1)',
      fill: false, lineTension: 0.1,
      data: y4
    }]
  },
  options: {
    legend: {
      display: true,
      position: 'top',
      align: 'center'
    },
    title: {
      display: true,
      text: 'Number of new papers...'
    },
    options: {
        scales: {
            yAxes: {
                ticks: {
                    min: 0, suggestedMin: 0, beginAtZero: true
                }
            },
            yAxes: {
                min: 0, suggestedMin: 0, beginAtZero: true
            },
            y: {
                suggestedMin: 0
            }
        }
    }
  }
});</script>
        ";
        $this->data['title'] = 'Paper Histogram';
        $this->data['page'] = 'page/common_crud2';
        $this->load->view('template', $this->data);
  }
  	public function timing(){ //2023: display a page for secretariat to manage timing for automated action
	  $c = new grocery_CRUD();
	  $c->set_table('auto_timer');
	  $c->unset_add()->unset_delete()->unset_clone()->unset_read();
	  $c->edit_fields('ket','days')->display_as('ket','Keterangan')->display_as('days','Delay (hari)');
	  $c->field_type('ket','readonly');
	  $c->unset_columns('kode');
	  $this->data['output'] = $c->render();
	  $this->data['hasGC'] = 1;
	  $this->data['title'] = 'Timer for Automated Actions';
	  $this->data['page'] = 'page/common_crud2';
	  $this->load->view('template', $this->data);	    
	}
}
