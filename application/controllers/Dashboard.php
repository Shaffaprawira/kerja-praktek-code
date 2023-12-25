<?php

/**
 * @author: Sabbana 
 * @corp: pajon/sstud-io.net
 * @date: 20-09-2016
 */

class Dashboard extends CI_Controller{

	var $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->model('Mdl_cms','cms');
		$this->load->library('Lib_cms');
	}
	
	// function coba1234567890(){ $this->load->view("template/mailer/author/coba"); } //untuk coba2, pake template view tsb.

	private function allow_access($roles= array()){
		$user_roles = $this->session->userdata('role');
		if(empty($user_roles)) redirect('login');
		if(empty($roles))
			redirect('dashboard');
		else{
			$is_rules = array_intersect($user_roles, $roles);
			if(empty($is_rules))
				redirect('dashboard');
		}		
	}
	
	public function summernoteUploadImage(){
		$user_roles = $this->session->userdata('role');
		if(empty($user_roles)) redirect('login');
		
		if ($_FILES['file']['name']) {
				if (!$_FILES['file']['error']) {
						$name = md5(rand(100, 200));
						$ext = explode('.', $_FILES['file']['name']);
						$filename = $name . '.' . $ext[1];
						$destination = '/assets/txtimg/' . $filename; //change this directory
						$location = $_FILES["file"]["tmp_name"];
						move_uploaded_file($location, $destination);
						echo base_url().'/assets/txtimg/' . $filename;//change this URL
				}
				else
				{
					echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
				}
		}

		
	}
	
	public function unexpirerev($id,$e){
	    //echo 'Maaf fitur ini belum tersedia';
	    $this->db->query("update submission_reviewer set status=0, date_invite=null, date_respond=null where sub_id = ? and email = ?",[$id, $e]);
	    $this->session->set_flashdata('success','Done. Now you can invite him/her again');
	    redirect('dashboard/detail/submission/'.$id);
	}
	public function unexpirerevtask($id,$e){
	    //notify reviewer that it is now no longer expired
        $s = $this->db->query("select
        	s.sub_title title, s.round, sc.section_abv
        	from submission s
        	join section sc on sc.section_id = s.section_id
        	where s.sub_id = $id ")->row();
        $name = $this->db->query("select
        	concat(salutation,' ',fullname) name
        	from submission_reviewer
        	where email = '$e' and sub_id = $id")->row()->name;
        if(!isset($name) || is_null($name) || !isset($s) || is_null($s)){
        	die("Error when fecthing paper and reviewer's data. Please go back and contact system administrator.");
        }
        $journal_id = ($s->round > 1 ? 'R'.($s->round-1).'-':'').$s->section_abv.'-'.$id;
        $mail_data = ['journal_id' => $journal_id,
        							'name'	=> $name,
        							'title'	=> $s->title,
        							'email'	=> $e];
        $this->db->insert('sendmail_log', ['to' => $e,
            				'subject' => 'Re: [IJTech] Review reminder for manuscript #'.$journal_id,
            				'body' => $this->load->view('template/mailer/reviewer/unexpireReviewJob', $mail_data, TRUE),
            				'time' => date('Y-m-d H:i:s')
            			]);
        //update database
        $this->db->query("update submission_reviewer set status=1 where sub_id = ? and email = ?",[$id, $e]);
	    $this->db->query("update reminder set attempt=0, confirm=0, date_confirm=null, date_cancel=null where sub_id=? and email_destination=? and type=3",[$id,$e]);
	    $this->session->set_flashdata('success','Done. Now reviewer can access the paper and give comment');
	    redirect('dashboard/detail/submission/'.$id);
	}
	
	public function test($sub_id){
		echo "Pass screening by EIC : ";
		var_dump($this->cms->is_pass_screening_by_eic($sub_id));
	}

	private function log_submission($sub_id, $status, $desc){
		$role = $this->session->userdata('role');
		// if(empty($role)) redirect('login'); //disabled by Ruki14sep2018 since it creates problem when newly-added reviewer accept a review invitation
		return $this->cms->log_submission($sub_id, $status, $desc);
	}

	private function log($event, $table, $key){
		return $this->cms->log($this->session->userdata('user_id'), $event, $table, $key);
	}

	public function index(){
		$role = $this->session->userdata('role');
		$section = $this->session->userdata('editor_section');

		if(empty($role)) redirect('login');
		$email = $this->session->userdata('email');
		$this->data['page'] = 'page/home';
		$this->data['all'] = $this->cms->count_submission_status();
		$this->data['screening'] = $this->cms->count_submission_status(1);
		$this->data['published'] = $this->cms->count_submission_status(9);
		$this->data['revise'] = $this->cms->count_submission_status(7);
		$this->data['new'] = $this->cms->count_submission_status(1);
		$this->data['received'] = $this->cms->count_submission_status(5);
		$this->data['accepted'] = $this->cms->count_submission_status(8);
		$this->data['inpress'] = $this->cms->count_submission_status(11);
		$this->data['completed'] = $this->cms->count_submission_status('completed');


		$this->data['last_submitted'] = $this->cms->get_submission_status_limit(1, 5);
		$this->data['last_accepted'] = $this->cms->get_submission_status_limit(8, 5);
		$this->data['submission_review'] = $this->cms->get_journal_review_user($email);

		if(in_array(4, $role)){			
			$this->data['new'] = $this->cms->count_submission_status_by_section($section, 1);
			$this->data['received'] = $this->cms->count_submission_status_by_section($section, 5);
			$this->data['completed'] = $this->cms->count_submission_status_by_section($section, 'completed');			
		}

		if(count($role) == 1 && in_array(6, $role)){
			$this->data['review_active'] = count($this->cms->get_journal_review_user($email, 'active'));
			$this->data['review_archive'] = count($this->cms->get_journal_review_user($email, 'archive'));
		}		

		if(in_array(1, $role) || in_array(2, $role)){
			$this->data['alluser'] = $this->cms->count_user();
			$this->data['editor'] = $this->cms->count_user(3);
			$this->data['section_editor'] = $this->cms->count_user(4);
			$this->data['author'] = $this->cms->count_user(5);
			$this->data['reviewer'] = $this->cms->count_user(6);
      
			/*tambahan 22 august 2018 BEGIN*/
			$publish = $this->cms->get_time_to_pub();
			
			$days = 0;
			foreach ($publish as $row) {
				$days += $row['waktu'];
			}
			$total_pub = count($publish);
			$avg = $days/$total_pub;
			
			$acc_rates = 0;
			$acc = $this->cms->get_acceptance_rate();
			$acc_rates = $acc['total_pub']/$acc['total_sub']*100;
			$acc_rates = round($acc_rates,2);
      
			$all_download = $this->cms->get_all_download();
			$all_downloads = $all_download['total_download']/$all_download['total_papers'];
			$this->data['time_to_pub'] = $avg;
			$this->data['acceptance_rate'] = $acc_rates;
			$this->data['all_downloads'] = $all_downloads;


			// $this->data['time_to_pub'] = $avg;
			// $this->data['acceptance_rate'] = $acc_rates;
      /*tambahan 22 august 2018 END*/
		}
		/*vincent 20-jan-2020 start*/
		if(in_array(5, $role)){
			$user_id = $this->session->userdata('user_id');
			$status = "active"; //jika active tulis active, jika semua maka kosongkan saja
			$this->load->library('pagination');
			$this->data['title'] = 'Submission';
			$this->data['sts'] = $status;
			$this->data['issue'] = $this->cms->get_all_issue();
			# config paging submission
			$this->data['perpage'] = 10;
			$config = array(
                'base_url'		    => base_url().'dashboard/index',
				'per_page'		 	=> $this->data['perpage'],
				'num_links'			=> 2,			
				'full_tag_open'	 	=> '<div class="pull-right"><ul class="pagination pagination-sm">',
				'full_tag_close' 	=> '</ul></div>',
				'cur_tag_open'	 	=> '<li class="active"><a href="#">',
				'cur_tag_close' 	=> '</a></li>',
				'num_tag_open'		=> '<li>',
				'num_tag_close'		=> '</li>',
				'prev_tag_open' 	=> '<li class="prev">',
				'prev_tag_close' 	=> '</li>',
				'next_tag_open' 	=> '<li class="next">',
				'next_tag_close' 	=> '</li>',
				'prev_link'			=> '<i class="fa fa-chevron-left"></i>',
				'next_link'			=> '<i class="fa fa-chevron-right"></i>',
				'first_tag_open'	=> '<li>',
				'first_tag_close'	=> '</li>',
				'first_link'		=> '&laquo; First',
				'last_link'			=> 'Last &raquo; ',
				'last_tag_open'		=> '<li>',
				'last_tag_close'	=> '</li>',			
				'use_page_numbers' 	=> TRUE,
				'reuse_query_string' => TRUE,		
			);		
			$keyword = isset($_GET['q']) ? $_GET['q'] : null;
			$this->data['keyword'] = $keyword;
			$this->pagination->initialize($config);
			$this->data['total'] = $this->cms->count_all_submission_author_keyword($user_id, $status, $keyword);
			$config['base_url'] = base_url().'dashboard/';
			$config['total_rows'] = $this->data['total'];

            $offset = $this->uri->segment(3)? (($this->uri->segment(3)-1) * $config['per_page']) : 0;
			$this->data['offset'] = $offset;
			$this->data['submission'] = $this->cms->get_all_submission_author_paging($user_id, $status, $config['per_page'], $offset, $keyword);
			$this->data['paging'] = $this->pagination->create_links();
		}
		/*vincent 20-jan-2020 END*/
		$this->load->view('template', $this->data);
	}

	/*
	 * @ general crud controller
	 * @ crudname [param]
	 */
	public function create($param, $id=''){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		switch($param){
			case "announcement":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Create Announcement';
        $this->data['issue'] = $this->cms->get_all_issue();
				$this->data['page'] = 'page/form_announcement';
			} break;
			case "section":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Create New Section';
				$this->data['editors'] = $this->cms->get_available_editor();
				$this->data['page'] = 'page/form_section';			
			} break;
			case "edition":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Create New Edition';
				$this->data['page'] = 'page/form_edition';			
			} break;
			case "issue":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Create Issue';
				$this->data['page'] = 'page/form_issue';			
			} break;
			case "people":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Add People';
				$this->data['countries'] = $this->cms->get_countries();
				$this->data['page'] = 'page/form_people';			
			} break;
			case "user":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Register New User';
				$this->data['section'] = $this->cms->get_all_section();
				$this->data['page'] = 'page/register';			
			} break;

			# submission module transaction 
			case "submission":{
				$uid = $this->session->userdata('user_id');
				$enable = $this->lib_view->check_profile($uid);
				if($enable == false)
					redirect('dashboard/edit/profile/'.md5($uid));

				$this->data['title'] = 'Submit Article';
				$this->data['section'] = $this->cms->get_all_section();				
				$this->data['editions'] = $this->db->query("select * from editions where status='Active'")->result_array();
				$this->data['page'] = 'page/form_submission';			
			} break;
			
			# editorial
			case "editorial":{
				$this->data['title'] = 'Submit Article';
				$this->data['issue'] = $this->cms->get_all_issue();
				$this->data['section'] = $this->cms->get_all_section();				
				$this->data['page'] = 'page/form_editorial';			
			} break;
			case "author":{
				if ($id !== ''){
					$this->data['title'] = 'Article Authors';
					$this->data['action'] = 'create';
					$this->data['countries'] = $this->cms->get_countries();
					$this->data['authors'] = $this->cms->get_author_submission($id);
					#$this->data['existing_author'] = $this->cms->get_existing_authors($id);
					$this->data['page'] = 'page/form_submission';
				}else{
					$this->session->set_flashdata('warning','You can not skip to this state before fill the article data!');
					redirect('dashboard/create/submission');
				}				
			} break;
			case "suplement":{
				if ($id !== ''){
					$this->data['sub'] = $this->cms->current_submission($id);
					$this->data['title'] = 'Upload Suplement File';
					$this->data['suplement'] = $this->cms->get_submission_file($id, $this->data['sub'][0]['round']);
					$this->data['page'] = 'page/form_submission';
				}else{
					$this->session->set_flashdata('warning','You can not skip to this state before fill the article data!');
					redirect('dashboard/create/submission');
				}				
			} break;
			case "reviewer":{
				if ($id !== ''){
					$this->data['title'] = 'Suggest Reviewer';
					$this->data['action'] = 'create';
					$this->data['reviewer'] = $this->cms->get_reviewers($id);
					$this->data['authors'] = $this->cms->get_author_submission($id);
					#$this->data['existing_reviewer'] = $this->cms->get_existing_reviewers($id);
					$this->data['sub'] = $this->cms->current_submission($id);
					$this->data['page'] = 'page/form_submission';
				}else{
					$this->session->set_flashdata('warning','You can not skip to this state before fill the article data!');
					redirect('dashboard/create/submission');
				}				
			} break;
			case "agreement":{
				if ($id !== ''){
					$this->data['sub'] = $this->cms->current_submission($id);
					$this->data['doc'] = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 1);
                	$this->data['pdf'] = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 2);
					$this->data['suplement'] = $this->cms->get_submission_file($id, $this->data['sub'][0]['round']);
					$this->data['title'] = 'Journal Agreement';
					$this->data['authors'] = $this->cms->get_author_submission($id);
					$this->data['reviewer'] = $this->cms->get_reviewers($id);
					$this->data['funders'] = $this->cms->get_submission_funder($id);
					$this->data['page'] = 'page/form_submission';
				}else{
					$this->session->set_flashdata('warning','You can not skip to this state before fill the article data!');
					redirect('dashboard/create/submission');
				}				
			} break;
			# end submission transaction module 
			case "page":{
				$this->allow_access(array(1,2));
				$this->data['title'] = 'Create Page';
				$this->data['page'] = 'page/form_page';
			} break;
			default:{
				$this->session->set_flashdata('info','Wrong request page!');
				redirect('dashboard');
			} break;
		}
		$this->load->view('template', $this->data);
	}
	
	public function edit($param, $id='', $id2 = ''){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		switch($param){
			case "announcement":{
				$this->data['title'] = 'Edit Announcement';
				$this->data['ann'] = $this->cms->current_announcement($id);
        $this->data['issue'] = $this->cms->get_all_issue();
				$this->data['page'] = 'page/form_announcement';
			} break;
			case "section":{
				$this->data['title'] = 'Edit Section';
				$this->data['item'] = $this->cms->current_section($id);
				$this->data['editors'] = $this->cms->get_available_editor($id);
				$this->data['section_editor'] = $this->cms->get_section_editor($id);
				$this->data['page'] = 'page/form_section';
			} break;
			case "edition":{
				$this->data['title'] = 'Edit Edition';
				$this->data['item'] = $this->db->query("select * from editions where id=$id")->result_array();
				$this->data['page'] = 'page/form_edition';
			} break;
			case "issue":{
				$this->data['title'] = 'Edit Issue';
				$this->data['item'] = $this->cms->current_issue($id);
				$this->data['page'] = 'page/form_issue';
			} break;
			case "password":{
				$this->data['title'] = 'Change Password';				
				$this->data['page'] = 'page/change_password';
			} break;
			case "page":{
				$this->data['title'] = 'Edit Page';
				$this->data['item'] = $this->cms->current_page($id);
				$this->data['page'] = 'page/form_page';
			} break;
			case "people":{
				$this->data['title'] = 'Edit People';
				$this->data['item'] = $this->cms->current_people($id);
				$this->data['countries'] = $this->cms->get_countries();
				$this->data['page'] = 'page/form_people';
			} break;
			case "profile":{
				$this->data['countries'] = $this->cms->get_countries();
				$this->data['section'] = $this->cms->get_all_section();
				$this->data['title'] = 'Profile User';
				$this->data['page'] = 'page/profile';
				if(in_array(1, $this->session->userdata('role')) || in_array(2, $this->session->userdata('role'))){
					if($id == "")
						$id = md5($this->session->userdata('user_id'));
				}else{
					if($id == "" || $id !== md5($this->session->userdata('user_id')))
						redirect('dashboard/profile/'.md5($this->session->userdata('user_id')));
				}
				$this->data['user'] = $this->cms->get_user($id);
			} break;
			case "submission":{
				$this->data['title'] = 'Submit a revision';
				$this->data['issue'] = $this->cms->get_all_issue();
				$this->data['section'] = $this->cms->get_all_section();
				$this->data['editions'] = $this->db->query("select * from editions where status='Active'")->result_array();
				$this->data['sub'] = $this->cms->current_submission($id);
				$this->data['page'] = 'page/form_submission';
			} break;
			case "detail":{
				if($id !== ""){
					$this->data['title'] = 'Detail Article';
					$this->data['sub'] = $this->cms->current_submission($id);
					$this->data['cover'] = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 5);
					$this->data['funders'] = $this->cms->get_submission_funder($id);
					$this->data['page'] = 'page/form_submission';
				}else{
					$this->session->set_flashdata('warning','You can not skip to this state before fill the article data!');
					redirect('dashboard/create/submission');
				}	
			} break;
			case "reviewer":{
				$this->data['title'] = 'Edit Reviewer';
				$this->data['action'] = 'edit';
				$this->data['sub'] = $this->cms->current_submission($id);
				$this->data['reviewer'] = $this->cms->get_reviewers($id);
				$this->data['cr'] = $this->cms->get_current_reviewer($id2);
				$this->data['page'] = 'page/form_submission';
			} break;
			case "author":{
				$this->data['title'] = 'Edit Author';
				$this->data['action'] = 'edit';
				$this->data['sub'] = $this->cms->current_submission($id);
				$this->data['authors'] = $this->cms->get_author_submission($id);
				$this->data['countries'] = $this->cms->get_countries();
				$this->data['ca'] = $this->cms->get_current_author($id2);
				$this->data['page'] = 'page/form_submission';
			} break;
			default:{
				$this->session->set_flashdata('info','Wrong request page!');
				redirect('dashboard');
			} break;
		}
		$this->load->view('template', $this->data);
	}
	
	public function insert($param){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		switch($param){
			case "announcement": $this->lib_cms->insert_announcement(); break;
			case "section": $this->lib_cms->insert_section(); break;
			case "edition": $this->lib_cms->insert_edition(); break;
			case "section_editor": $this->lib_cms->insert_section_editor(); break;
			case "issue": $this->lib_cms->insert_issue(); break;
			case "page": $this->lib_cms->insert_page(); break;
			case "people": $this->lib_cms->insert_people(); break;
			case "user": $this->lib_cms->insert_user(); break;
			case "submission": $this->lib_cms->insert_submission(); break;
			case "suplement": $this->lib_cms->insert_suplement(); break;
			case "author": $this->lib_cms->insert_author(); break;
			case "send_response_letter": $this->lib_cms->send_response_letter(); break;
			case "selected_author": $this->lib_cms->insert_selected_author(); break;
			case "selected_reviewer": $this->lib_cms->insert_selected_reviewer(); break;
			case "reviewer": $this->lib_cms->insert_reviewer(); break;
			case "upload_review": $this->lib_cms->upload_review(); break;
			case "review": $this->lib_cms->insert_review(); break;
			case "funder": $this->lib_cms->insert_funder(); break;
			case "agreement": $this->lib_cms->insert_agreement(); break;
			case "journal": $this->lib_cms->save_journal(); break;
			case "publish": $this->lib_cms->publish_submission(); break;
			case "publish_journal": $this->lib_cms->publish_journal(); break;
			case "migrate": $this->lib_cms->migrate_journal(); break;
			default:{
				$this->session->set_flashdata('info','Wrong request page!');
				redirect('dashboard');
			} break;
		}
	}
	
	public function update($param){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		switch($param){  
			case "announcement": $this->lib_cms->update_announcement(); break;
			case "info": $this->lib_cms->update_info(); break;
			case "section":$this->lib_cms->update_section(); break;
			case "edition":$this->lib_cms->update_edition(); break;
			case "submission":$this->lib_cms->update_submission(); break;
			case "submission_withdraw":$this->lib_cms->withdraw(); break;
			case "submission_erratum":$this->lib_cms->erratum(); break; //Ruki16feb2019
			case "screening":$this->lib_cms->submission_screening(); break;
			case "revise_agreement":$this->lib_cms->revise_agreement(); break; //this function will increase submission.round
			case "inline_editing":$this->lib_cms->inline_editing_process(); break;
			case "submission_detail":$this->lib_cms->update_submission('detail'); break;
			case "reviewer":$this->lib_cms->update_reviewer(); break;
			case "author":$this->lib_cms->update_author(); break;
			case "coauthor":$this->lib_cms->set_coauthor(); break;
			case "review_status":$this->lib_cms->update_review_status(); break;
			case "reviewer_status":$this->lib_cms->update_reviewer_status(); break;
			case "status_submission":$this->lib_cms->save_decision(); break;
			case "editor_decision":$this->lib_cms->save_editor_decision(); break;
			case "issue":$this->lib_cms->update_issue(); break;
			case "issue_reviewers":$this->lib_cms->update_issue_reviewers(); break; //ruki25jan2019
			case "issue_status":$this->lib_cms->update_issue_status(); break;			
			case "password":$this->lib_cms->change_password(); break;
			case "reset_password":$this->lib_cms->reset_password(); break;
			case "profile":$this->lib_cms->update_user(); break;
			case "user_status":$this->lib_cms->change_user_status(); break;
			case "user_privilage":$this->lib_cms->change_privilage(); break;
			case "page":$this->lib_cms->update_page(); break;
			case "sort_author":$this->lib_cms->sort_author(); break;
			case "avatar": $this->lib_cms->change_avatar(); break;
			case "people": $this->lib_cms->update_people(); break;
			default:{
				$this->session->set_flashdata('info','Wrong request page!');
				redirect('dashboard');
			} break;
		}
	}
	
	public function detail($param, $id){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		switch($param){
			case "submission": {
			    
				if(!$this->cms->canAuthorAccessSub($this->session->user_id,$id)){ //kalo bukan authornya, gabisa akses
				   $this->session->set_flashdata('info','Wrong URL'); redirect('dashboard');
				}
				
				# check user who open the submission, if role an editor then update status
				$this->data['sub'] = $this->cms->current_submission($id);				
				$this->data['suplement'] = $this->cms->get_submission_file($id, $this->data['sub'][0]['round']);
				$this->data['title'] = isset($this->data['sub'][0]['sub_title']) ? $this->data['sub'][0]['sub_title']:'Detail Submission';
				$this->data['existing_reviewer'] = $this->cms->get_existing_reviewers($id);				

				for($x=1; $x <= $this->data['sub'][0]['round']; $x++){
					$file0 = $this->cms->get_manuscript_file_type($id, $x, 0);
					$file1 = $this->cms->get_manuscript_file_type($id, $x, 1);
					$file2 = $this->cms->get_manuscript_file_type($id, $x, 2);
					$file3 = $this->cms->get_manuscript_file_type($id, $x, 3);
					$file4 = $this->cms->get_manuscript_file_type($id, $x, 4);
					$file5 = $this->cms->get_manuscript_file_type($id, $x, 5);
					
					$this->data['preview'][$x] = $file0;
					$this->data['images'][$x] = $file3;
					$this->data['cover'][$x] = $file5;
					$this->data['letter'][$x] = $file4;
					$this->data['doc'][$x] = $file1;
	                $this->data['pdf'][$x] = $file2;
	                
	                $toBeCompared = array();
                    if(isset($file0[0])){ $toBeCompared[] = $file0[0]['round']; }
                    if(isset($file1[0])){ $toBeCompared[] = $file1[0]['round']; }
                    if(isset($file2[0])){ $toBeCompared[] = $file2[0]['round']; }
                    if(isset($file3[0])){ $toBeCompared[] = $file3[0]['round']; }
                    if(isset($file4[0])){ $toBeCompared[] = $file4[0]['round']; }
                    if(isset($file5[0])){ $toBeCompared[] = $file5[0]['round']; }
                    if(!empty($toBeCompared)){
                        $this->data['maxFileRound'][$x] = max($toBeCompared);
                    }else{
                        $this->data['maxFileRound'][$x] = 0;
                    }
                    //$this->data['maxFileRound'][$x] = max($toBeCompared);
					/* $this->data['maxFileRound'][$x] = max(
						$file0[0]['round'],
						$file1[0]['round'],
						$file2[0]['round'],
						$file3[0]['round'],
						$file4[0]['round'],
						$file5[0]['round']
					); */
	            }

	            $this->data['last_screening'] = $this->cms->get_last_screening($id);
	            $this->data['section'] = $this->cms->get_all_section();
				$this->data['issue'] = $this->cms->get_all_issue();
				$this->data['review_result'] = $this->cms->get_review_submission($id, $this->data['sub'][0]['round']);
				$this->data['page'] = 'page/detail_submission';
			} break;

			case "journal": {
				$this->data['sub'] = $this->cms->get_current_journal($id);
				$this->data['title'] = isset($this->data['sub'][0]['sub_title']) ? $this->data['sub'][0]['sub_title']:'Journal Detail';
				$this->data['page'] = 'page/journal_detail';
			} break;

			default:{
				$this->session->set_flashdata('info','Wrong request page!');
				redirect('dashboard');
			} break;
		}
		$this->load->view('template', $this->data);	
	}

	/**
	 * review result preview from author
	 * ajax request
	 **/
	public function review_result(){
		if (IS_AJAX){
			$id = $this->input->post('sub_id');
			$round = $this->input->post('round');
			$data = array();
			for ($a=1; $a<=$round; $a++){
				$data[$a] = $this->cms->get_review_submission($id, $a);
			}
			// echo json_encode($data); die;
			$point = array("originality","technical","methodology","readability","practicability","organization","importance");
			$val = array("-", "poor","fair","average","above average","excellent");
			if(!empty($data[1])){
				$html = '<div class="box-group" id="accordion">';
				for ($b=1; $b<=$round; $b++){
					if(!empty($data[$b])){ 
						$no=0; 
						$html .= '
						<div class="panel" style="margin:0px;border-top:solid 1px #DDD">
						    <div class="box-header with-border" style="background-color:#EEE">
						      <h5 class="box-title" style="font-weight:normal;font-size:14px">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$b.'" aria-expanded="'.($b == $round ? 'true':'false').'" class="'.($b == $round ? 'collapsed':'').'">
						          Reviewer Comment '.($b > 1 ? '(R'.($b-1).')':'').'
						        </a>
						      </h5>
						    </div>
						    <div id="collapse'.$b.'" class="panel-collapse collapse '.($b == $round ? 'in':'').'" aria-expanded="'.($b == $round ? 'true':'false').'" style="">
						    	<div class="box-body">';
						foreach($data[$b] as $rs){ $no++;
							$identity = in_array(5, $this->session->userdata('role')) || in_array(6, $this->session->userdata('role')) ? '': ': '.$rs['reviewer_email'].'<br/><small style="font-style:italic" class="text-warning"> &nbsp; <i class="fa fa-warning"></i> Hidden for author(s)</small>';							
							$html .= 
									'<table class="" width="100%">
										<tr><td valign="top">Reviewer</td><td> '.$identity.'<span class="btn btn-default btn-lg pull-right">'.$no.'</span></td></tr>							
										<tr><td>Date Review</td><td>: '.date('d M Y - H:i', strtotime($rs['date_review'])).'</td></tr>
										<tr><td valign="top">Introduction</td><td>: '.nl2br(strip_tags($rs['introduction_comment'])).'</td></tr>
										<tr><td valign="top">Methodology</td><td>: '.nl2br(strip_tags($rs['methodology_comment'])).'</td></tr>
										<tr><td valign="top">Results and Discussion</td><td>: '.nl2br(strip_tags($rs['result_comment'])).'</td></tr>
										<tr><td valign="top">References</td><td>: '.nl2br(strip_tags($rs['references_comment'])).'</td></tr>
										<tr><td valign="top">Other</td><td>: '.nl2br(strip_tags($rs['other_comment'])).'<br><br>'.nl2br(strip_tags($rs['additional_comment'])).'</td></tr>
										<tr><td colspan="2">
											<table class="table table-bordered table-striped">';

										for($a=0; $a<count($point); $a++){
											$html .= '<tr><td width="100">'.ucwords($point[$a]).'</td><td>'.(isset($rs[$point[$a]]) ? $rs[$point[$a]]."<i> (".$val[$rs[$point[$a]]].")</i>":'').'</td></tr>';
										}
										$html .= '</table>
										</td></tr>
										<tr><td valign="top">Attachment</td><td>: ';
										if($rs['review_url'] != ""){
											$html .= '<a href="'.site_url().$rs['review_url'].'">Review Attachment</a>';
										}else{ $html .= "-"; }
										$html .= '</td></tr>
										<tr><td>Result</td><td>: '.review_result($rs['review_result']).'</td></tr>
									</table><hr/>';							
						}
						$html .= '</div></div></div>';
					}
				}
				$html .= '</div>';
			}else{ $html = '<div class="callout callout-info"><i class="fa fa-info-circle"></i> There are no reviews yet for this manuscript!</div>'; }
			echo $html;
		}
	}

	public function delete($param, $id="", $id2=""){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		switch($param){
			case "announcement": $this->lib_cms->delete_announcement(); break;
			case "section": $this->lib_cms->delete_section(); break;
			case "edition": $this->lib_cms->delete_edition($id); break;
			case "section_editor": $this->lib_cms->delete_section_editor($id, $id2); break;
			case "submission": $this->lib_cms->delete_submission($id, $id2); break;
			case "funder": $this->lib_cms->delete_funder(); break;
			case "suplement": $this->lib_cms->delete_suplement_file($id, $id2); break;
			case "author": $this->lib_cms->delete_author($id, $id2); break;
			case "author_migrate": $this->lib_cms->delete_author($id, $id2, true); break;
      // case "submission_reviewer": echo $id; echo $id2; die(); break;
			case "reviewer": $this->lib_cms->delete_reviewer($id, $id2); break;
			case "issue": $this->lib_cms->delete_issue(); break;
			case "reviewers_list_file": $this->lib_cms->delete_reviewers_list_file($param, $id); break;
			case "user": $this->lib_cms->delete_user(); break;
			case "people":{
			    $this->db->delete('people', array('pid' => $id));
			    $this->session->set_flashdata('info','Success');
			    redirect('dashboard/people');
			} break;
			default:{
				$this->session->set_flashdata('info','Wrong request page!');
				redirect('dashboard');
			} break;
		}
	}

	# draft message sent
	public function messages($screening_id){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$data['msg'] = $this->cms->get_message_screening($screening_id);
		$this->load->view('template/page/message_screening', $data);
	}

	# cover letter string
	public function cover_letter($sub_id, $round){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$data['sub'] = $this->cms->current_submission($sub_id);
		$data['cover'] = $this->cms->get_manuscript_file_type($sub_id, $round, 5);
		$this->load->view('template/page/cover_letter', $data);
	}

	# page list data
	# ============================================================
	public function profile($id = ""){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		if(in_array(1, $role) || in_array(2, $role)){
			if($id == "")
				$id = md5($this->session->userdata('user_id'));
		}else{
			if($id == "" || $id !== md5($this->session->userdata('user_id')))
				redirect('dashboard/profile/'.md5($this->session->userdata('user_id')));
		}
		
		$this->data['title'] = 'Profile User';
		$this->data['page'] = 'page/profile';
		$this->data['user'] = $this->cms->get_user($id);
		$this->data['user_role'] = $this->cms->get_role_user($id);
		$this->load->view('template', $this->data);
	}

	public function announcement(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Announcement';
		$this->data['page'] = 'page/announcement';
		$this->data['announcement'] = $this->cms->get_all_announcement();
		$this->load->view('template', $this->data);
	}
	
	public function info(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Journal Info';
		$this->data['page'] = 'page/info';
		$tmp = $this->cms->get_info();
		$this->data['info_content'] = $tmp[0]['value'];
		$this->load->view('template', $this->data);
	}
	
	public function section(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Journal Section';
		$this->data['page'] = 'page/section';
		$this->data['section'] = $this->cms->get_all_section();
		$this->load->view('template', $this->data);
	}
	public function editions(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Journal Editions';
		$this->data['page'] = 'page/editions';
		$this->data['section'] = $this->db->query("select * from editions")->result_array();
		$this->load->view('template', $this->data);
	}

	public function people(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Editorial Team';
		$this->data['page'] = 'page/editorial_team';
		$this->data['people'] = $this->cms->people();
		$this->load->view('template', $this->data);
	}

	public function issue(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Journal Issues';
		$this->data['page'] = 'page/issue';
		$this->data['issue'] = $this->cms->get_all_issue();
		$this->load->view('template', $this->data);
	}
    public function broadcastNewIssueNews($i=''){
    	$roles = $this->session->userdata('role');
    	if( !in_array(1,$roles) && !in_array(2,$roles) && !in_array(3,$roles) ){ redirect('dashboard'); }
    	
    	if($i!='' && is_numeric($i) && $i>0){
    		$issue = $this->db->query("select * from issue where issue_id = $i")->row();
    		if(isset($issue)){
    			// $namaIssue = "Vol. $issue->volume No. $issue->issue_number ($issue->year)";
    		}else{
    			$this->session->set_flashdata('error','Issue not found'); redirect('dashboard/issue');
    		}
    	}else{
    		$this->session->set_flashdata('error','Invalid URL'); redirect('dashboard/issue');
    	}
    	
    	$users = $this->db->query("select 
    		group_concat(distinct s.section_id order by s.section_id asc) section,
    		concat(u.first_name,' ',u.last_name) name,
    		u.salutation,
    		trim(u.email) mail
    		from submission s
    		join users u on u.user_id = s.user_id
    		group by u.email order by u.email")->result(); //user yg pernah mensubmit artikel
    	if(isset($users)){
    		$papers = $this->db->query("select a.issue_id, a.sub_id, a.title, a.pdf_file, a.pages, a.download, a.cite, a.date_publish, a.doi_url, b.section_id from journal a 
    			left join submission b on a.sub_id = b.sub_id
    			where a.issue_id = $i and b.sub_status = 9 order by cast(a.pages as unsigned) ASC")->result();
    		$mails = array();
    		//echo '<pre>';print_r($papers);die();
    		foreach($users as $u){
    			$this->data['u'] = $u;
    			$this->data['p'] = $papers;
    			$this->data['i'] = $issue;
    			$this->data['s'] = "Vol. $issue->volume No. $issue->issue_number ($issue->year) is published";
    			$mails[] = array(
    				'to' => $u->mail,
    				'subject' => '[IJTech] '.$this->data['s'],
    				'body' => $this->load->view('template/mailer/author/broadcastNewIssue', (object)$this->data, true),
    				'status' => 'Test',
    				'time' => date('Y-m-d H:i:s')
    			);
    		}
    		// echo '<pre>';print_r($mails);die();
    		$cnt = count($mails);
    		if($cnt>0){
    		    $this->db->insert_batch('sendmail_log', $mails);
    		    //TODO: batasi insert batch supaya ga lemot
    		    $this->session->set_flashdata('success',"OK. $cnt emails will be sent. Please be patient because fast sending may be regarded as SPAM.");
    		}
    		redirect('dashboard/issue');
    	}else{
    		$this->session->set_flashdata('error','No user to send email to.'); redirect('dashboard/issue');
    	}
    }

	public function about(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['page'] = 'page/pages';
		$this->data['static'] = $this->cms->get_all_page();
		$this->load->view('template', $this->data);
	}

	public function submission($rolename, $param = null, $status = null){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$user_id = $this->session->userdata('user_id');
		$this->load->library('pagination');
		$this->data['title'] = 'Submission';
		$this->data['page'] = 'page/submission';
		$this->data['sts'] = $status;
		$this->data['issue'] = $this->cms->get_all_issue();
		# config paging submission
		$this->data['perpage'] = 10;
		$config = array(
			'per_page'		 	=> $this->data['perpage'],
			'num_links'			=> 2,			
			'full_tag_open'	 	=> '<div class="pull-right"><ul class="pagination pagination-sm">',
			'full_tag_close' 	=> '</ul></div>',
			'cur_tag_open'	 	=> '<li class="active"><a href="#">',
			'cur_tag_close' 	=> '</a></li>',
			'num_tag_open'		=> '<li>',
			'num_tag_close'		=> '</li>',
			'prev_tag_open' 	=> '<li class="prev">',
			'prev_tag_close' 	=> '</li>',
			'next_tag_open' 	=> '<li class="next">',
			'next_tag_close' 	=> '</li>',
			'prev_link'			=> '<i class="fa fa-chevron-left"></i>',
			'next_link'			=> '<i class="fa fa-chevron-right"></i>',
			'first_tag_open'	=> '<li>',
			'first_tag_close'	=> '</li>',
			'first_link'		=> '&laquo; First',
			'last_link'			=> 'Last &raquo; ',
			'last_tag_open'		=> '<li>',
			'last_tag_close'	=> '</li>',			
			'use_page_numbers' 	=> TRUE,
			'reuse_query_string' => TRUE,		
		);		
		$keyword = isset($_GET['q']) ? $_GET['q'] : null;
		$this->data['keyword'] = $keyword;
		# base config for pagination 
		# ------------------------------------------------------
		switch ($rolename) {
			case 'secretariat':{

				if($param != ''){
					if($param == 'status'){
						# submission status
						$this->data['total'] = $keyword ? $this->cms->count_submission_status_by_keyword($keyword, $status) : $this->cms->count_submission_status($status);
						$config['base_url'] = base_url().'dashboard/submission/secretariat/'.$param.'/'.$status.'/page/';
						$config['total_rows'] = $this->data['total'];
						$offset = $this->uri->segment(7) ? (($this->uri->segment(7)-1) * $config['per_page']) : 0;
						//$offset = $this->uri->segment(7) ? (($this->uri->segment(7)-1) * 999) : 0;
						$this->data['offset'] = $offset;
						$this->data['submission'] = $this->cms->get_submission_status_paging($status, $config['per_page'], $offset, $keyword);
						//$this->data['submission'] = $this->cms->get_submission_status_paging($status, 999, $offset, $keyword);
					}else if($param == 'page'){
						# all submission
						$this->data['total'] = $this->cms->count_all_submission_secretariat_keyword($keyword);
						$config['base_url'] = base_url().'dashboard/submission/secretariat/page/';
						$config['total_rows'] = $this->data['total'];
						$offset = $this->uri->segment(5) ? (($this->uri->segment(5)-1) * $config['per_page']) : 0;
						$this->data['offset'] = $offset;
						$this->data['submission'] = $this->cms->get_all_submission_secretariat_paging($config['per_page'], $offset, $keyword);
					}else{
						redirect('dashboard');
					}
				}else{
					# all submission dashboard/submission/secretariat/page/3
					$this->data['total'] = $this->cms->count_all_submission_secretariat_keyword($keyword);
					$config['base_url'] = base_url().'dashboard/submission/secretariat/page/';
					$config['total_rows'] = $this->data['total'];
					$offset = $this->uri->segment(5) ? (($this->uri->segment(5)-1) * $config['per_page']) : 0;
					$this->data['offset'] = $offset;
					$this->data['submission'] = $this->cms->get_all_submission_secretariat_paging($config['per_page'], $offset, $keyword);
				}
			}break;

			case 'editor':{
				$section = $this->session->userdata('editor_section');
				if($param != ''){
					if($status != ''){
						$this->data['total'] = $this->cms->count_all_submission_editor_section_keyword($section, $status, $keyword);
						$config['base_url'] = base_url().'dashboard/submission/editor/'.$param.'/'.$status.'/page/';
						$config['total_rows'] = $this->data['total'];
						$offset = $this->uri->segment(7) ? (($this->uri->segment(7)-1) * $config['per_page']) : 0;
						$this->data['offset'] = $offset;
						$this->data['submission'] = $this->cms->get_all_submission_editor_section_keyword($section, $status, $config['per_page'], $offset, $keyword);
					}
				}

			} break;
			
			case 'author':{

				if($param != ''){
					if($param == 'status'){
						$this->data['total'] = $this->cms->count_all_submission_author_keyword($user_id, $status, $keyword);
						$config['base_url'] = base_url().'dashboard/submission/'.$param.'/'.$status.'/page/';
						$config['total_rows'] = $this->data['total'];
						$offset = $this->uri->segment(7) ? (($this->uri->segment(7)-1) * $config['per_page']) : 0;
						$this->data['offset'] = $offset;
						$this->data['submission'] = $this->cms->get_all_submission_author_paging($user_id, $status, $config['per_page'], $offset, $keyword);
					}else redirect('dashboard');
				}
			} break;
			
			case 'issue':{
				$this->data['submission'] = $this->cms->get_journal_issue($param);
				$this->data['total'] = count($this->data['submission']);
				$this->data['offset'] = 0;
			} break;

			default:
				redirect('dashboard');
				break;
		}

		/*
		if(in_array(5, $role)){
			$this->data['sts'] = null;
			if($param == 'status'){
				if($status !== null){
					$this->data['total'] = $this->cms->count_all_submission_by_keyword($user_id, $status, $keyword);
					$config['base_url'] = base_url().'dashboard/submission/'.$param.'/'.$status.'/page/';
					$config['total_rows'] = $this->data['total'];
					$offset = $this->uri->segment(6) ? (($this->uri->segment(6)-1) * $config['per_page']) : 0;
					$this->data['submission'] = $this->cms->get_all_submission_paging($user_id, $status, $config['per_page'], $offset, $keyword);
				}
			}
		}
		
		if(in_array(1, $role) || in_array(2, $role) || in_array(3, $role)){
			$this->data['submission'] = $this->cms->get_all_submission();			
			if($param == 'status'){
				if($status !== null){
					$this->data['total'] = $keyword ? $this->cms->count_submission_status_by_keyword($keyword, $status) : $this->cms->count_submission_status($status);
					$config['base_url'] = base_url().'dashboard/submission/'.$param.'/'.$status.'/page/';
					$config['total_rows'] = $this->data['total'];
					$offset = $this->uri->segment(6) ? (($this->uri->segment(6)-1) * $config['per_page']) : 0;
					$this->data['submission'] = $this->cms->get_submission_status_paging($status, $config['per_page'], $offset, $keyword);
				}else{
					$this->data['total'] = $this->cms->count_all_submission_by_keyword(null, $status, $keyword);
					$config['base_url'] = base_url().'dashboard/submission/page/';
					$config['total_rows'] = $this->data['total'];
					$offset = $this->uri->segment(4) ? (($this->uri->segment(4)-1) * $config['per_page']) : 0;
					$this->data['submission'] = $this->cms->get_all_submission_paging(null, $status, $config['per_page'], $offset, $keyword);	
				}
			}else{
				$this->data['total'] = $this->cms->count_all_submission_by_keyword(null, null, $keyword);
				$config['base_url'] = base_url().'dashboard/submission/page/';
				$config['total_rows'] = $this->data['total'];
				$offset = $this->uri->segment(4) ? (($this->uri->segment(4)-1) * $config['per_page']) : 0;
				$this->data['submission'] = $this->cms->get_all_submission_paging(null, null, $config['per_page'], $offset, $keyword);
			}

			if($param == 'issue'){
				if($status !== null)
					$this->data['submission'] = $this->cms->get_journal_issue($status);
			}

		}

		if(in_array(4, $role)){
			$section = $this->session->userdata('editor_section');
			if($param == 'section'){
				if(!empty($section))
					$this->data['submission'] = $this->cms->get_submission_section($section);
				else 
					$this->data['submission'] = array();
			}else{
				if($status !== null)
					$this->data['submission'] = $this->cms->get_submission_section($section, $status);
			}
		}
		*/

		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$this->load->view('template', $this->data);
	}

	public function users(){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['title'] = 'Enrolled Users';
		$this->data['page'] = 'page/users';

		$tot = $this->cms->count_all_user();
		$this->data['msg'] = 'Total : <b>'.number_format($tot).'</b>';
		$this->load->library('pagination');
		$config = array(
			'base_url'		 => base_url().'dashboard/users/page/',
			'total_rows'	 => $tot,
			'per_page'		 => 10,
			'full_tag_open'	 => '<div class="pull-right"><ul class="pagination pagination-sm">',
			'full_tag_close' => '</ul></div>',
			'cur_tag_open'	 => '<li class="active"><a href="#">',
			'cur_tag_close' => '</a></li>',
			'num_tag_open'	=> '<li>',
			'num_tag_close'	=> '</li>',
			'prev_tag_open' => '<li class="prev">',
			'prev_tag_close' => '</li>',
			'next_tag_open' => '<li class="next">',
			'next_tag_close' => '</li>',
			'prev_link'		=> '<i class="fa fa-chevron-left"></i>',
			'next_link'		=> '<i class="fa fa-chevron-right"></i>',
			'first_tag_open'	=> '<li>',
			'first_tag_close'	=> '</li>',
			'first_link'	=> '&laquo; First',
			'last_link'	=> 'Last &raquo; ',
			'last_tag_open'	=> '<li>',
			'last_tag_close'	=> '</li>',			
			'use_page_numbers' => TRUE,
      'reuse_query_string' => TRUE,
		);
		$offset = $this->uri->segment(4)? (($this->uri->segment(4)-1) * $config['per_page']) : 0;
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();		
		$this->data['users'] = $this->cms->get_all_user_paging($config['per_page'], $offset);
		$this->load->view('template', $this->data);
	}

	public function review($id, $param = ''){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$email = $this->session->userdata('email');
		$this->data['sub'] = $this->cms->current_submission($id);
		$this->data['page'] = 'page/review_list';
		$this->data['type'] = $id;
		if($id == "archive" || $id == "active"){
			$this->data['sts'] = $id;
			$this->data['submission_review'] = $this->cms->get_journal_review_user($email, $id);
		}else{ //$id =  sub_id atau "online"
		    if(!$this->cms->canGiveReview($email,$id)){ //cegah reviewer yg tidak berhak
		        redirect('dashboard');
		    }
			$this->data['page'] = 'page/review';
			
			if($this->lib_view->check_valid_reviewer($id)){ //if this logged-in user bener2 ada di daftar reviewer (ga peduli apakah sudah diinvite, sudah agree, sudah selesai, dll)
    			$this->db->query("update submission_review set date_seeFile = now() where date_seeFile is null and review_id = ?",[$param]); //catat waktu kapan reviewer ini mulai melihat review form dan file papernya
				if($this->data['sub'][0]['sub_status'] == 3){ //if submission status is "reviewAssignment"
					$this->log_submission($id, 4, 'Reviewer viewing the review form and file to be reviewed. Status changed to reviewProess');
					$this->cms->update('submission', array('sub_id', $id), array('sub_status' => 4)); //change sub_status to "reviewProcess"
				}
			}
			
			$srr = $this->db->query("select sr_id from submission_reviewer where sub_id = ? and email = ? and status = 2",[$id,$email])->row();
			if(isset($srr) && is_numeric($srr->sr_id) && $srr->sr_id>0){
			    $this->data['verification'] = '<div class="form-group"><label>Do you accept this offer to review this manuscript?</label>
								<p><a href="'.base_url('invitation/'.$id.'/'.$srr->sr_id.'/1/home').'" target="_new" class="btn btn-success">I am willing to give my review comment</a></p>
								<p><a href="'.base_url('invitation/'.$id.'/'.$srr->sr_id.'/2/home').'" target="_new" class="btn btn-error">I refuse this invitation</a></p>
							</div>';
			}

			$this->data['review'] = $this->cms->current_review($param); //data from table submission_review for this reviewing ID
			
			
			if($param == 'online' || $param == null){
				$this->data['review'] = $this->cms->get_review_item($id, $this->data['sub'][0]['round'], $email); //select * from submission_review where sub_id = '$sub_id' and round = '$round' and reviewer_email = '$email'
			}
			$this->data['pdf']    = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 2); //get filename from table submission_file
			$this->data['supplementaryFiles']    = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 3);
			$this->data['graphicalAbstract']    = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 0);
			$this->data['letter'] = $this->cms->get_manuscript_file_type($id, $this->data['sub'][0]['round'], 4);
			$this->data['title'] = isset($this->data['sub'][0]['sub_title'])? $this->data['sub'][0]['sub_title']:'Detail Submission';
		}
		$this->load->view('template', $this->data);
	}

/*
ruki2

pas invitation kita diaccept:
  nambahin suggested reviewer ke db users
  role = reviewer
  kita generate password, status = 1.
  kita kasih link yg autologin
    cek autologin jam 1, lalu jam 2 autologin dg yg lain (tanpa logout yg pertama, gmn hasilnya)
cek juga apakah suggested reviewer ini sudah terdaftar di db users. kalo ya: tetp dikasih email info login, tapi tidak dikasih password. dan dikasih single link buat akses tanpa login
*/

//per 27jan2023: lagi ada debug utk sr_id=20862
	public function invitation($sub_id, $sr_id, $status, $debug=""){
	    //kalo di tabel submission_reviewer, status: 0=blmDikirimiEmail 1=bersedia 2=waitingConfirmation 3=refused 4=removed 6=expired
	    //sedangkan di link yg dikirim ke email undangan ke reviewer: 1=willing, 2=refuse
	    //debug: liame=(dari email invitasi), rmd000=(dari email reminder invitasi)
	    if($debug!=''){
	        /*
	        $lastLoggedStatus = $this->db->query("select sub_status from submission_log_status where sub_id = ? order by sub_log_id desc limit 1",[$sub_id])->row()->sub_status;
	        $debugdata = array(
                'sub_id'=>$sub_id,
                'sub_status'=>$lastLoggedStatus,
                'log_desc'=>'sr='.$sr_id.'|.status='.$status.'|debug='.$debug,
                'date_log'=>date('Y-m-d H:i:s')
            );
	        $this->db->insert('submission_log_status',$debugdata);
	        //di tabel ini, sub_status = 0:diAuthorTertulisCompletedManuscript 1:screeningEIC 2:screeningSC 3:reviewAssignment 4:reviewProcess 5:reviewReceived 7:revisionProcess 8:accepted 9:archived(published) 10:authorDeclineToReviseBasedOnReviewerComment  11:inPress 12:lineEditing 99:withdraw
	        */
	    }
	    
		$reviewer = $this->cms->get_current_reviewer($sr_id);
    // die($reviewer[0]['email']);
		$sub = $this->cms->current_submission($sub_id);
		$is_active = $this->cms->check_review_active($sub_id); //check if submission is still active or not
		if($sr_id == 20862){ echo "sub_id=$sub_id <br>sr_id=$sr_id <br>status=$status<br>"; }
		if($is_active){
			if($sr_id == 20862){ echo "sub is active<br>"; }
			$check = $this->cms->is_review_invitation_not_responded($sub_id,$sr_id); //ruki17jan2019
			if(!$check){die('You cannot click this button more than once.<br>Or this invitation has been expired.');}
			if($sr_id == 20862){ echo "invitation was not previously reacted to.<br>"; }
			$srdata = array(
				'sub_id' => $sub_id,
				'reviewer_email' => $reviewer[0]['email'],
				'round'	=> $sub[0]['round'],
			);
			if($sub[0]['round']==1){
				$srdata['date_round_start']=date('Y-m-d H:i:s');
			}
			
			if($status == 1){ //accept
				if($sr_id == 20862){ echo "response is agree<br>"; }
				# insert submission review 
				$ins = 0;
				$check = $this->cms->check_existing_submission_review($sub_id, $sub[0]['round'], $reviewer[0]['email']);	//ruki14sep2018 change function name
				if(empty($check)){
					if($sr_id == 20862){ echo "blm ada data review<br>"; }
					$ins = $this->cms->insert('submission_review', $srdata);
					$ins = 1; 	//ruki14sep2018, make sure ins is > 0
				} else{die('You have responded to this invitation before.<br>Please check <a href="http://ijtech.eng.ui.ac.id/dashboard">your dashboard</a> to see your review assignment(s) if any.');} //ruki 7jan2019
				if($ins>0){
					if($sr_id == 20862){ echo "creating db entry to save review data<br>"; }
					$upd = $this->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status'=> 1,'date_respond'=>date('Y-m-d H:i:s'))); //update submission reviewer status
					if($upd){
						if($sr_id == 20862){ echo "created: db entry to save review data<br>"; }
						# confirm reminder and set new reminder invitation
						$this->load->model('Mdl_reminder','reminder');
						$this->reminder->cofirm_reminder($sub_id, $reviewer[0]['email'], 2);
						$set_reminder = array(
							'sub_id' => $sub_id,
							'type'	=> 3, //remind reviewer to do review.
							'date_set'	=> date('Y-m-d H:i:s'),
							'date_remind'	=> date('Y-m-d H:i:s', strtotime('+'.DAY_TO_REVIEW_MANUSCRIPT.' days')),
							'email_destination'	=> $reviewer[0]['email']
						);
						if($this->cms->insert('reminder', $set_reminder)){}else{
              die('Error<br>Please contact administrator and inform them about this error:<br>Cannot create reminder.'); //ruki1aug18
            }
            if($sr_id == 20862){ echo "created: reminder<br>"; }
						
						$check = $this->cms->check_count_reviewer_approve($sub_id); //update submission status
						if($check > 0){ //ruki14sep2018 change from 1 to 0
							$this->log_submission($sub_id, 4, 'Review Started');
							$coba = $this->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 4));
							if($sr_id == 20862){ echo "sub_status updated to 4<br>"; }
						}else{
							// die('Error<br>Please contact administrator and inform them about this error:<br>Cannot found submission status to be updated.');
							die('Error<br>Cannot update the status for the submission.');
						} //ruki1aug18
            
            //ruki2: send username & password for new reviewer
            $reviewerAccount = $this->cms->get_user_from_mail($reviewer[0]['email']); //get user by email
            $mailData=array();
            $mailData['username']=$reviewerAccount[0]['user_id']; //if user status=1, just send username and guide
            $mailData['email']=$reviewerAccount[0]['email']; //if user status=1, just send username and guide
            if($reviewerAccount[0]['status']!=1){ //if user status!=1, make it=1, create new password, create roleuser, send username, password and guide
              $mailData['newPassword'] = substr( str_shuffle( str_repeat( 'abcdefghijklmnopqrstuvwxyz0123456789', 10 ) ), 0, 7 );
              $this->cms->update('users', array('user_id', $reviewerAccount[0]['user_id']), array('status'=> 1,'password'=>md5($mailData['newPassword'])));
							$roles = $this->db->query("select role_id from roleuser where user_id = ?",[$reviewerAccount[0]['user_id']])->result();
							$ada6 = 0;
							$ada5 = 0;
							foreach($roles as $rl){
								$ada6 = $rl->role_id==6 ? 1 : $ada6;
								$ada5 = $rl->role_id==5 ? 1 : $ada5;
							}
							if($ada6==0){
								$this->cms->insert('roleuser', array('user_id'=> $reviewerAccount[0]['user_id'], 'role_id' => 6));
							}
							if($ada5==0){
								$this->cms->insert('roleuser', array('user_id'=> $reviewerAccount[0]['user_id'], 'role_id' => 5));
							}
							if($sr_id == 20862){ echo "creating an account for this reviewer<br>"; }
            }
            $sub = $this->cms->current_submission($sub_id);
						$editor = $this->cms->get_section_editor($sub[0]['section_id']);
						$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
            $mailData['journal_id'] = $journal_id;
						$mailData['editor']	= $editor;
						$mailData['journal']	= $sub;
						$mailData['reviewer']	= $this->cms->get_user_from_mail($reviewer[0]['email']);
            // $message = $this->load->view('template/mailer/reviewer/assign_new_reviewer', $mailData, TRUE);
						// $this->load->library('email'); // load email library
						// $this->email->from(MAILSYSTEM, 'IJTech');
						// $this->email->to($reviewer[0]['email']);
						// $this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
						// $this->email->subject('[IJTech] Review assignment for manuscript #'.$journal_id);
						// $this->email->message($message);
						// $this->email->send();
						
						$this->db->set(array(
							'to' => $reviewer[0]['email'],
							'subject' => '[IJTech] Review assignment for manuscript #'.$journal_id,
							'body' => $this->load->view('template/mailer/reviewer/assign_new_reviewer', $mailData, TRUE),
							'time' => date('Y-m-d H:i:s'),
							'parent' => $sub_id
						))->insert('sendmail_log');
						if($sr_id == 20862){ echo "reviewer assignment email for reviewer is queued<br>"; }
            
            $this->session->set_flashdata('message','Thank you for accepting our invitation. Please follow the email that we have just sent to you detailing the review process.'); //ruki4
            if($sr_id == 20862){ die("debug"); }
            redirect('login');
					}else{ die('Error<br>Please contact administrator and inform them about this error:<br>Cannot update submission reviewer status.'); } //ruki1aug18
				}else{ die('Error<br>Please contact administrator and inform them about this error:<br>Cannot create new submission review.'); } //ruki1aug18
				die('Request completed. Process terminated. You can now close this window.');
			}elseif($status == 2){
				if($sr_id == 20862){ echo "response = refuse<br>"; }
				//check if answer has been sent.
				
				$check = $this->cms->is_review_invitation_not_responded($sub_id,$sr_id); //ruki17jan2019
				if($check){
					if($sr_id == 20862){ echo "this response is his/her first time for this invitation<br>"; }
					$upd = $this->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status'=> 3,'date_respond'=>date('Y-m-d H:i:s') )); //update submission reviewer status
					if($upd){
						if($sr_id == 20862){ echo "invitation status updated.<br>"; }
						$this->load->model('Mdl_reminder','reminder');
						$this->reminder->update_reminder($sub_id, $reviewer[0]['email'], $status); //cancel reminder
						if($sr_id == 20862){ echo "reminder canceled.<br>"; }
						//todo: notify EiC ask to invite others
						/// ======================== START
						/* disabled per 25mei2023 karena bu eny masih terima email "reviewer refused padahal agree (paper=6450, reviewer=junwei.lim@utp.edu.my)"
						$responReviewer = $this->db->query("select count(*) c, status
							from submission_reviewer
							where sub_id = ?
							and sr_id = ?
							and date_respond is not null",[$sub_id, $sr_id])->row();
						if($responReviewer!=1){
							$this->db->set(array(
								'to' => 'ruki.hwyu@gmail.com',
								'subject' => '[IJTech] Dashboard-Invitation-Declined but not found #'.$sub_id,
								'body' => 'Begitulah',
								'time' => date('Y-m-d H:i:s')
							))->insert('sendmail_log');
						}else{
							$d1 = $this->db->query("select 
							s.sub_id,
							s.sub_title,
							s.round,
							sec.section_abv,
							e.abv,
							group_concat(concat(eic.salutation,' ',eic.first_name,' ',eic.last_name) separator ',<br>') eicNames,
							group_concat(eic.email) eicEmails,
							datediff(now(),s.date_submit) days,
							concat(sr.salutation,' ',sr.fullname) r_name,
							sr.email r_email
							from submission s
							left join section sec on s.section_id = sec.section_id
							left join editions e on e.id = s.edition
							left join section_editor se on se.section_id = s.section_id
							left join users eic on se.user_id = eic.user_id
							left join submission_reviewer sr on (sr.sr_id = ? )
							where s.sub_id = ?
							group by s.sub_id",[$sr_id,$sub_id])->row();

							$d2 = $this->db->query("select
							sum(if(status = 1,1,0)) numAgree,
							sum(if(status = 2,1,0)) numInvited,
							sum(if(status = 3,1,0)) numRefuse,
							sum(if(status = 6,1,0)) numExpired
							from submission_reviewer
							where sub_id = ?",[$sub_id])->row();

							$txt = "Dear<br>$d1->eicNames,
							<br>
							<br>Paper #$d1->section_abv-$sub_id entitled <b>$d1->sub_title</b> was initially submitted to IJTech <b>$d1->days</b> days ago.
							<br>It is now at round $d1->round of the peer review.
							<br>
							<br>However, just now, one of the invited reviewers, <b>$d1->r_name ($d1->r_email)</b>, refused to do the review.
							<br>To ensure the timeliness of the process, you may need to assign other reviewer(s) at:
							<br>
							<br>".base_url('dashboard/detail/submission/'.$sub_id)."
							<br>
							<br>FYI, currently, there are $d2->numInvited review invitations still waiting for response;
							 $d2->numAgree reviewers agree to give review;
							 $d2->numRefuse reviewers refused the invitation;
							 and $d2->numExpired review invitations are expired.
							<br><br><br>_________________<br><small>This email is generated by system.</small>";

							$this->db->set(array(
								'to' => $d1->eicEmails,
								'subject' => '[IJTech] Review invitation is refused for #'.$d1->section_abv.'-'.$sub_id,
								'body' => $txt,
								'time' => date('Y-m-d H:i:s'),
							'parent' => $sub_id, //ruki19feb23
							'k' => 'respon reviewer = '.$status  //ruki19feb23
							))->insert('sendmail_log');
						}
						*/
						/// ======================== END
						$this->session->set_flashdata('message','<b>Thank you</b> for responding to the review invitation on International Journal of Technology.');
					}else{ die("Cannot update invitation status."); }
					if($sr_id == 20862){ die("debug"); }
					redirect('login');
				}else{die('You cannot click this button again.');}
				
				// $ins = 0;
				// $check = $this->cms->check_existing_submission_review($sub_id, $sub[0]['round'], $reviewer[0]['email']);	//ruki14sep2018 change function name
				// if(empty($check)){
					// $ins = $this->cms->insert('submission_review', $srdata);
					// die('System busy. Please try again.');
          // $ins = 1; 	//ruki14sep2018, make sure ins is > 0
				// } else{die('You cannot click this button again.');} //ruki 7jan2019
				// if($ins>0){
					// $upd = $this->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status'=> 3 )); //update submission reviewer status
					// if($upd){
						// $this->load->model('Mdl_reminder','reminder');
						// $this->reminder->update_reminder($sub_id, $reviewer[0]['email'], $status);
						// $this->session->set_flashdata('message','<b>Thank you</b> for responding to the review invitation on International Journal of Technology.');
					// }
					// redirect('login');
				// }
			}else{ die('Wrong URL'); }
		}else{
			# manuscript out of review process
			// $upd = $this->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status'=> 3 ));
			// if($upd)
			if($sr_id == 20862){ die("debug"); }
			redirect('home/review/'.$sub_id);
		}
		if($sr_id == 20862){ die("debug"); }
	}




	/**
	 * inpress process manuscript 
	 * reformat acepted manuscript 
	 */
	public function process($id, $step = ''){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$this->data['task'] = 'inpress';
		$this->data['step'] = $step !== '' ? $step : 'article';
		$sub = $this->cms->get_current_journal($id);
		if(empty($sub))
			$sub = $this->cms->current_submission($id);

		
		$this->data['back'] = $this->navprocess($id, $step, 'back');
		$this->data['sub'] = $sub;
		$this->data['suplement'] = $this->cms->get_submission_file($id, $this->data['sub'][0]['round']);
		$this->data['author'] = $this->cms->get_author_submission($id);
		$this->data['title'] = isset($this->data['sub'][0]['sub_title']) ? $this->data['sub'][0]['sub_title']:'Detail Submission';
		for($x=1; $x <= $this->data['sub'][0]['round']; $x++){
			$this->data['preview'][$x] = $this->cms->get_manuscript_file_type($id, $x, 0);
			$this->data['images'][$x] = $this->cms->get_manuscript_file_type($id, $x, 3);
			$this->data['cover'][$x] = $this->cms->get_manuscript_file_type($id, $x, 5);
			$this->data['letter'][$x] = $this->cms->get_manuscript_file_type($id, $x, 4);
			$this->data['doc'][$x] = $this->cms->get_manuscript_file_type($id, $x, 1);
            $this->data['pdf'][$x] = $this->cms->get_manuscript_file_type($id, $x, 2);
        }
        $this->data['section'] = $this->cms->get_all_section();
		$this->data['issue'] = $this->cms->get_all_issue();		
		$this->data['page'] = 'page/inpress';
		$this->load->view('template', $this->data);
	}

	private function navprocess($id, $step, $condition){
		$url = site_url().'dashboard/process/'.$id.'/';
		if($condition == 'back'){
			switch($step){
				case "article": $url ='#'; break;
				case "introduction": $url .='article'; break;
				case "experimental": $url .='introduction'; break;
				case "result": $url .='experimental'; break;
				case "conclusion": $url .='result'; break;
				case "acknowledgement": $url .='conclusion'; break;
				case "references": $url .='acknowledgement'; break;
				case "file": $url .='references'; break;
				case "publish": $url .='file'; break;
			}
			return $url;
		}else{
			switch($step){
				case "article": $url ='introduction'; break;
				case "introduction": $url .='experimental'; break;
				case "experimental": $url .='result'; break;
				case "result": $url .='conclusion'; break;
				case "conclusion": $url .='acknowledgement'; break;
				case "acknowledgement": $url .='references'; break;
				case "references": $url .='file'; break;
				case "file": $url .='publish'; break;
				case "publish": $url ='#'; break;
			}
			return $url;
		}
	}

	# string returns
	private function get_author($sub_id){
		$res = array();
    	$data = $this->cms->get_author_submission($sub_id);
    	if(!empty($data)){
    		foreach($data as $a){
    			array_push($res, $a['first_name'].' '.$a['last_name']);
    		}
    	}
    	return implode (', ', $res);
	}

	# json returns 
	public function get_submission_json($sub_id){
		if (IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');
			$data = $this->cms->current_submission($sub_id);
			header("Content-type: application/json");
			echo json_encode($data);
		}
	}

	# json returns 
	public function get_submission_status_json($userid, $sts){
		if (IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');
			$data = $this->cms->get_submission_status_by_user($userid, $sts);
			if(!empty($data)){
				for ($a=0; $a < count($data); $a++){
					$data[$a]['authors'] = $this->get_author($data[$a]['sub_id']);
				}
			}
			header("Content-type: application/json");
			echo json_encode($data);
		}
	}
	
	# json returns 
	public function get_author_by_email_address_json(){	
		if(IS_AJAX){	
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');
			$email = $this->input->post('email');
			$data = $this->cms->get_role_by_email_address($email, 5);
			header("Content-type: application/json");
			echo json_encode($data);
		}
	}

	# json returns 
	public function get_reviewer_by_email_address_json(){
		if(IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');
			$email = $this->input->post('email');
			$data = $this->cms->get_role_by_email_address($email, 6);
			header("Content-type: application/json");
			echo json_encode($data);
		}
	}

	public function get_reviewer_by_keywords_json(){
		if(IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');
			$key = $this->input->post('key');
			$data = $this->cms->get_role_by_keywords($key, 6);
			header("Content-type: application/json");
			echo json_encode($data);
		}
	}
	
	public function get_reviewer_by_keywords_html(){
		if(IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) die('restricted');
			$key = $this->input->post('key');
			$sub_id = $this->input->post('sub_id');
			$data = $this->cms->get_suggested_reviewer($key);			
			$res = '<i>None</i>';
			if(!empty($data)){
				$res = '<table class="table table-bordered data-table-reviewer" style="background:#fff">';
				$res .= '<thead>
				<tr>
					<th rowspan="2" style="text-align:center;vertical-align:middle">No</th>
					<th rowspan="2" style="text-align:center;vertical-align:middle">Reviewer<br><small><i>Click to select</i></small></th>
					<th rowspan="2" style="text-align:center;vertical-align:middle">Expertise</th>
					<th colspan="5" style="text-align:center;vertical-align:middle">Statistics (from round 1 reviews)</th>
					<th rowspan="2" style="text-align:center;vertical-align:middle"></th>
				</tr>
				<tr>
					<th style="text-align:center;vertical-align:middle" title="number of review invitations & date of last invite"                          >Invitation</th>
					<th style="text-align:center;vertical-align:middle" title="number of not responded, agreed, declined invitations & date of last decline">Response</th>
					<th style="text-align:center;vertical-align:middle" title="number of pending reviews to be done"                                       >Job</th>
					<th style="text-align:center;vertical-align:middle" title="number of quickly-accepted & rejected papers"                                >Result</th>
					<th style="text-align:center;vertical-align:middle" title="average days to respond the invitation & to complete the review"             >Speed</th>
				</tr>
				</thead><tbody>';
				//numReviewed dihapus karena sudah ada numAgree dan numActiveAssignment, karena data lama ga konsisten (ada komentar tanpa invitation, ada invitation tanpa komentar round 1)
				
				///TODO: expertise include section
				///TODO: done include time
				
				$no=0; 
				foreach ($data as $r) {
					$no++;
					$fullname = $r['salutation'].' '.$r['first_name'].' '.$r['last_name'];
					$r['dateLastInvite']  = ($r['dateLastInvite']  == '' || $r['dateLastInvite']  == '00-00-0000') ? '' : '<br> '.date('j M Y',strtotime($r['dateLastInvite']));
					$r['dateLastDecline'] = ($r['dateLastDecline'] == '' || $r['dateLastDecline'] == '00-00-0000') ? '' : '<br> '.date('j M Y',strtotime($r['dateLastDecline']));
					$res .= '
					<tr bgcolor="'.($no % 2 == 0 ? '#FFFFFF':'').'">
						<td>'.$no.'</td>
						<td><a href="'.site_url().'dashboard/save_selected_reviewer/'.$sub_id.'/'.$r['user_id'].'" title="select">'.$fullname.'</a><br/><i><i class="fa fa-envelope-o"></i> '.$r['email'].'</i><br/>'.$r['affiliation'].'</td>
						<td>'.($r['expertise'] == ''? '---':$r['expertise']).'</td>
						
<td title="number of review invitations & date of last invite"                          >'.$r['numInvite'].$r['dateLastInvite'].'</td>
<td title="number of not responded, agreed, declined invitations & date of last decline">'.$r['numNoResponse'].' | '.$r['numAgree'].' | '.$r['numDecline'].$r['dateLastDecline'].'</td>
<td title="number of pending reviews"                                                   >'.$r['numActiveAssignment'].'</td>
<td title="number of quickly-accepted & rejected papers"                                >'.$r['numR1Accept'].' | '.$r['numReject'].'</td>
<td title="average days to respond the invitation & to complete the review"             >'.round($r['avgResponseSpeed'],1).' | '.round($r['avgReviewSpeed'],1).'</td>
						
						<td><a href="'.site_url().'dashboard/save_selected_reviewer/'.$sub_id.'/'.$r['user_id'].'" class="btn btn-sm btn-primary" title="select"><i class="fa fa-hand-o-left"></i></a></td>
					</tr>';
				}
				$res .= '</tbody></table>';
			}
			echo $res;
		}else{die('not found');}
	}

	public function save_selected_reviewer($sub_id, $user_id){ //ruki2
		$page = 'dashboard/detail/submission/'.$sub_id;
    	$reviewer = $this->cms->get_current_reviewer_from_db_users($user_id); //ruki3
    	if(!isset($reviewer[0])){
            $this->session->set_flashdata('error','The account of your selected reviewer has a problem. Please consult system maintainer.');
    	    redirect($page);
    	}
    	$data = array(
    		'sub_id' => $sub_id,
    		'user_id' => $this->session->userdata('user_id'),
    		'salutation'	=> $reviewer[0]['salutation'],
    		'fullname'	=> $reviewer[0]['first_name'].' '.$reviewer[0]['last_name'],
    		'email'	=> $reviewer[0]['email'],
    		'expertise'	=> $reviewer[0]['expertise'],
    		'affiliation'	=> $reviewer[0]['affiliation'],
    	);
    	$submitter = $this->db->query("select user_id from submission where sub_id = $sub_id")->row()->user_id;
    	
    	$c = $this->db->query("select count(*) c from submission_reviewer where sub_id = $sub_id and email = '".$reviewer[0]['email']."' and user_id != '$submitter' ")->row()->c; //cek apakah sudah ada di submission_reviewer dan bukan suggested by author
    	if($c>0){
    	    $this->session->set_flashdata('error','Selected reviewer has been added. Cannot add again.');
    	    redirect($page);
    	}
    	$c = $this->db->query("select count(*) c from submission_reviewer where sub_id = $sub_id and email = '".$reviewer[0]['email']."' and user_id = '$submitter' ")->row()->c; //cek apakah sudah ada di submission_reviewer DAN suggested by author
    	if($c>0){
    	    $sr_id = $this->db->query("select sr_id from submission_reviewer where sub_id = $sub_id and email = '".$reviewer[0]['email']."' and user_id = '$submitter' ")->row()->sr_id;
    	    $this->lib_cms->update_reviewer_status($sub_id,$sr_id,2);
    	    //$this->session->set_flashdata('success','Invitation email has been sent.');
    	    //redirect($page);
    	}
    	$act = $this->cms->insert('submission_reviewer', $data);
    	if ($act){
    		$this->log('Add existing reviewer with email : '.$reviewer[0]['email'].' to submission id : '.$sub_id, 'submission_reviewer', $sub_id);
    		$this->session->set_flashdata('success','Succeessfully add reviewer from existing data');
    	}
    	redirect($page);
	}

	public function get_user_privilage($uid){
		if(IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');	
			$roles = array(1 => "administrator", "secretariat","editor","section editor","author/reviewer");
			$data = $this->cms->get_user_privilage($uid);		
			$html = '<h4>Please Choose privilage.</h4><hr/>';		
			$html .= '<input type="hidden" name="user_id" value="'.$uid.'">';
			for($a=1; $a<=5; $a++){
				$ck = in_array($a, $data) ? 'checked = checked':'';
				$html .= '<label><input class="icheck" type="radio" name="role" value="'.$a.'" '.$ck.'> '.$roles[$a]."</label><br/>";
			}
			echo $html;
		}

	}

	# untuk keperluan migrasi data
	# ===================================================
	public function migrate($id = '', $step = '', $aid=''){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');
		$this->allow_access(array(1,2));
		$sub = array();
		$this->data['title'] = 'Migrate Journal';
		$this->data['task'] = 'migrate';
		$this->data['step'] = $step !== '' ? $step : 'article';
		$this->data['section'] = $this->cms->get_all_section();
		$this->data['issue'] = $this->cms->get_all_issue();
		if($id != ''){
			$sub = $this->cms->get_current_journal($id);
			if(empty($sub))
				$sub = $this->cms->current_submission($id);

			$this->data['suplement'] = $this->cms->get_submission_file($id, $sub[0]['round']);
			$this->data['authors'] = $this->cms->get_author_submission($id);
			$this->data['title'] = isset($sub[0]['sub_title']) ? $sub[0]['sub_title']:'Detail Submission';
			for($x=1; $x <= $sub[0]['round']; $x++){
				$this->data['preview'][$x] = $this->cms->get_manuscript_file_type($id, $x, 0);
				$this->data['images'][$x] = $this->cms->get_manuscript_file_type($id, $x, 3);
				$this->data['cover'][$x] = $this->cms->get_manuscript_file_type($id, $x, 5);
				$this->data['letter'][$x] = $this->cms->get_manuscript_file_type($id, $x, 4);
				$this->data['doc'][$x] = $this->cms->get_manuscript_file_type($id, $x, 1);
	            $this->data['pdf'][$x] = $this->cms->get_manuscript_file_type($id, $x, 2);
	        }
		}
		if($aid != '')
			$this->data['ca'] = $this->cms->get_current_author($aid);

		$this->data['sub'] = $sub;
		$this->data['countries'] = $this->cms->get_countries();
		$this->data['page'] = 'page/inpress';
		
		$this->load->view('template', $this->data);		
	}

	# search paging
	public function search($param){
		switch($param){
			case "users":{
				$keyword = isset($_GET['search']) ? $_GET['search'] : '';
				$filter = isset($_GET['filter']) ? $_GET['filter'] : 'first_name';
				$this->data['keyword'] = $keyword;
				$this->data['filter'] = ucwords(str_replace('_',' ', $filter));
				$this->data['title'] = "Enrolled User";
				$this->data['page'] = "page/users";
				$tot = $this->cms->count_search_user($filter, $keyword);
				$this->data['msg'] = 'Search Result : <b>'.$tot.'</b>';
				$this->load->library('pagination');
				$config = array(
					'base_url'		 => base_url().'dashboard/search/users/page/',
					'total_rows'	 => $tot,
					'per_page'		 => 100,
					'full_tag_open'	 => '<div class="pull-right"><ul class="pagination pagination-sm">',
					'full_tag_close' => '</ul></div>',
					'cur_tag_open'	 => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					'num_tag_open'	=> '<li>',
					'num_tag_close'	=> '</li>',
					'prev_tag_open' => '<li class="prev">',
					'prev_tag_close' => '</li>',
					'next_tag_open' => '<li class="next">',
					'next_tag_close' => '</li>',
					'prev_link'		=> '<i class="fa fa-chevron-left"></i>',
					'next_link'		=> '<i class="fa fa-chevron-right"></i>',
					'first_link'	=> '',
					'last_link'	=> '',
					'use_page_numbers' => TRUE,
          'reuse_query_string' => TRUE,
				);
				$offset = $this->uri->segment(5)? (($this->uri->segment(5)-1) * $config['per_page']) : 0;
				$this->pagination->initialize($config);
				$this->data['paging'] = $this->pagination->create_links();		
				$this->data['users'] = $this->cms->get_search_user($filter, $keyword, $config['per_page'], $offset);
				$this->load->view('template', $this->data);
			} break;
		}
	}

	# crossref
	# =================================
	public function generate($param){
		switch($param){
			case "crossref":{

				$this->data['page'] = 'page/crossref';
				$this->data['issue'] = $this->cms->get_all_issue();

			} break;
     		case "doaj":{
				$this->data['page'] = 'page/doaj';
				$this->data['issue'] = $this->cms->get_all_issue();

			} break;
			default: redirect('dashboard');
		}
		
		$this->load->view('template', $this->data);
	}

	public function json_manuscript($sub_id){
		if (IS_AJAX){
			$sub = $this->cms->current_submission($sub_id);
			echo json_encode($sub);
		}
	}

	# BACKUP DATABASE
	public function backup($act = null){
		if ($act !== null){
			$file = date('Y-m-d_His').'_backup.gz';
			$this->load->dbutil();
			$prefs = array(
		        'tables'        => array(),   					// Array of tables to backup.
		        'ignore'        => array('log_activities'),     // List of tables to omit from the backup
		        'format'        => 'gzip',                      // gzip, zip, txt
		        'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
		        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
		        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
		        'newline'       => "\n"                         // Newline character used in backup file
			);
			$backup = $this->dbutil->backup($prefs);
			$this->load->helper('file');
			write_file('/assets/journal.zip', $backup);
			$this->load->helper('download');
			force_download($file, $backup);
		}else{
			$this->data['page'] = 'page/backup';
			$this->load->view('template', $this->data);
		}
	}

	# REMINDER SCHEDULER
	public function reminder(){
		$user_roles = $this->session->userdata('role');
		if(empty($user_roles)) redirect('login');
		$this->load->model('Mdl_reminder','reminder');
		$this->data['title'] = "Queue Email Reminder";
		$type = isset($_GET['type']) ? $_GET['type'] : 1;
		$this->data['type'] = $type;
		$this->data['reminder'] = $this->reminder->get_reminder($type);
		$this->data['page'] = 'page/reminder';		
		$this->load->view('template', $this->data);		
	}

	public function cek($sub_id, $mail = false){
		print_r($this->cms->get_corresponding_author($sub_id, $mail));
	}

/*date modified = 19-9-2018, vincent */

	public function login_as_user($user_id){
		$user_roles = $this->session->userdata('role'); if(empty($user_roles)) redirect('login');
		//die('a');
#simpan session user id sebelumnya
		$data = $this->session->userdata('user_id');
		$this->session->user_id_old = $data;
#ambil seluruh data session user yang dipilih;

		$this->load->model('Mdl_login','model_login');
		$user = $this->model_login->get_userdata_new(urldecode($user_id));
		//echo '<pre>';print_r($user);die();
		$sessionDataNew = array(
			'user_id'	=> $user[0]['user_id'],
			'section'	=> $user[0]['section_id'],
			'email'		=> $user[0]['email'],
			'avatar'	=> $user[0]['profile_image'],
			'fname'		=> $user[0]['first_name'],
			'name'		=> $user[0]['first_name'].' '.$user[0]['last_name'],
			'role'		=> $this->model_login->get_role_user($user[0]['user_id']),
			'status'	=> $this->model_login->get_rolename_user($user[0]['user_id']),
			'editor_section' => $this->model_login->get_section_editor($user[0]['user_id']),
			'last_login'=> $user[0]['last_login']
			);

		$this->session->set_userdata($sessionDataNew);	
#memberi penanda bahwa adalah admin
		$this->session->login_as = 1;
		redirect('dashboard');
	}

	public function logout_as_user(){
#membawa kembali seluruh data admin
		$data = $this->session->user_id_old;
		$this->load->model('Mdl_login','model_login');
		$user = $this->model_login->get_userdata_new($data);
		$sessionDataNew = array(
			'user_id'	=> $user[0]['user_id'],
			'section'	=> $user[0]['section_id'],
			'email'		=> $user[0]['email'],
			'avatar'	=> $user[0]['profile_image'],
			'fname'		=> $user[0]['first_name'],
			'name'		=> $user[0]['first_name'].' '.$user[0]['last_name'],
			'role'		=> $this->model_login->get_role_user($user[0]['user_id']),
			'status'	=> $this->model_login->get_rolename_user($user[0]['user_id']),
			'editor_section' => $this->model_login->get_section_editor($user[0]['user_id']),
			'last_login'=> $user[0]['last_login']
			);
		$this->session->set_userdata($sessionDataNew);
		$this->session->login_as = 0;
		$this->session->user_id_old = "";
		redirect('dashboard');
	}
	
#certificate
	public function certificate($sub_id,$review_id){
		$role = $this->session->userdata('role');
		if(empty($role)) redirect('login');	
		
		$user = $this->cms->get_current_reviewer_from_db_users($this->session->userdata('user_id'));
		$cd = $this->cms->get_certificate($sub_id, $review_id);

		$fullname =  $user[0]['salutation']." ".$user[0]['first_name']." ".$user[0]['last_name'];
		
		$this->load->library('fpdf_master');
		//SetMargins(float left, float top [, float right])
		$this->fpdf->SetMargins(0,0);
		$this->fpdf->AddPage('L','A4');
		
		$timeReview = strtotime($cd['date_review']);
		$timeLine1 = strtotime('2022-02-01'); //start dekan Prof. Heri.
		$timeLine2 = strtotime('2023-09-20'); //start dekan Prof. Heri., pak yudan prof
		if($timeReview >= $timeLine2){
		    $this->fpdf->Image(base_url().'assets/img/cert2023.png',0,0,300); 	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
		}elseif($timeReview >= $timeLine1){
		    $this->fpdf->Image(base_url().'assets/img/cert2022.png',0,0,300); 	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
		}else{
		    $this->fpdf->Image(base_url().'assets/img/cert.png',0,0,300); 	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
		}
		$this->fpdf->SetXY(0,90);
		$this->fpdf->SetFont('Times','',17);
		$this->fpdf->Cell(0,9,'This certificate is given to',0,2,'C'); //Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
		$this->fpdf->SetFont('Times','B',25);
		$this->fpdf->Cell(0,9,$fullname,0,2,'C');
		$this->fpdf->SetFont('Times','',17);
		$this->fpdf->SetXY(15,110);
		$this->fpdf->MultiCell(270, 7, 'for the contribution in reviewing a submission entitled "'.trim(strip_tags($cd['sub_title'])).'" which was completed at '.date('d F Y', strtotime($cd['date_review'])).'.', 0, 'C');

		// $this->fpdf->Cell(0,10,'for reviewing a submission entitled "'.$cd['sub_title'].'" which is completed at '.date('d F Y', strtotime($cd['date_review'])).'.',0,2,'C');
		$this->fpdf->Cell(0,20,'Depok, '.date('d F Y', strtotime($cd['date_review'])),0,2,'C');
		
		$this->fpdf->SetXY(0,43);
		$this->fpdf->SetFont('Arial','I',8);
		$this->fpdf->Cell(0,5,'Certificate ID: '.$cd['sub_id'].'-'.$cd['review_id'].'                    ',0,0,'R');
		
		echo $this->fpdf->Output('IJTech-reviewer-certificate.pdf','D');// D download, I display
		
		// die('ini sertf');
		// $this->data['page']='page/certificate';
		// $this->load->view('template/page/certificate', $this->data);
	}
	
	public function adminOnly_removeDuplicateExpertiseForAllUsers($uid=""){
		$this->load->model('Mdl_cms','cms');
		if($uid!=''){
		    $this->cms->adminOnly_removeDuplicateExpertiseForAllUsers("user_id='$uid'");
		}else{
		    $this->cms->adminOnly_removeDuplicateExpertiseForAllUsers();
		}
		
	}
	
	public function broadcastAPCNotice(){
		$user_roles = $this->session->userdata('role');
		if(empty($user_roles)) redirect('login');
		$u = $this->db->query("select s.sub_id,s.sub_title, concat(sc.section_abv,'-',s.sub_id) submission_id, concat(u.salutation,' ',u.first_name,' ',u.last_name) author, u.email
			from submission s
			join users u on u.user_id = s.user_id
			left join section sc on sc.section_id = s.section_id
			where s.sub_status in (1,2,3,4,5,7,8,11,12)")->result();
		$data = array();
		$mails = array();
		foreach($u as $s){
			$thehash = md5($s->sub_id.$s->email);
			$i = $this->db->query("select * from is_agree_apc where thehash='$thehash'")->row();
			if(!isset($i)){
				array_push($data,array(
					'sub_id' => $s->sub_id,
					'thehash' => $thehash
				));
				$subj = "[IJTech] Article Processing Charge (APC) Confirmation for Manuscript #$s->submission_id";
				array_push($mails,array(
					'to' => $s->email,
					'subject' => $subj,
					'body' => $this->load->view('template/mailer/author/broadcastAPCNotice', $s, true),
					'time' => date('Y-m-d H:i:s'),
					'parent' => $s->sub_id,
					'k' => md5($s->email.date('Y-m-d H:i:s').$subj)
				));
			}
		}
		if(!empty($data)){
			$this->db->insert_batch('is_agree_apc', $data);
			$this->db->insert_batch('sendmail_log', $mails);			
		}
		$cnt = count($data);
		$this->session->set_flashdata('success',"OK. $cnt emails will be sent. Please be patient because fast sending may be regarded as SPAM.");
		redirect('dashboard');
	}
	public function isAgreeAPC($thehash='',$response=''){
		if($thehash==''||$response==''){
			die('Sorry, the link is invalid.');
			$this->session->set_flashdata('error','Sorry, the link is invalid.');
			redirect('home');
		}else{
			$i = $this->db->query("select i.*, concat(u.salutation,' ',u.first_name,' ',u.last_name) author, u.email, s.sub_title, concat(sc.section_abv,'-',s.sub_id) submission_id
				from is_agree_apc i
				join submission s on s.sub_id = i.sub_id
				left join section sc on sc.section_id = s.section_id
				join users u on u.user_id = s.user_id
				where i.thehash='$thehash' and i.response='' ")->row();
			if(isset($i)){
				$subj = "Re: [IJTech] Article Processing Charge (APC) Confirmation for Manuscript #$i->submission_id";
				if($response==1){
					$this->db->set(array(
						'to' => $i->email,
						'subject' => $subj,
						'body' => $this->load->view('template/mailer/author/thankForAgreeingAPC', $i, true),
						'time' => date('Y-m-d H:i:s'),
						'parent' => $i->sub_id,
						'k' => md5($i->email.date('Y-m-d H:i:s').$subj)
					))->insert('sendmail_log');
				}elseif($response==2){
					$this->db->set(array(
						'to' => $i->email,
						'subject' => $subj,
						'body' => $this->load->view('template/mailer/author/notAgreeingAPC', $i, true),
						'time' => date('Y-m-d H:i:s'),
						'parent' => $i->sub_id,
						'k' => md5($i->email.date('Y-m-d H:i:s').$subj)
					))->insert('sendmail_log');
					$this->cms->withdraw_manuscript($i->sub_id, 'Disagree with APC policy');
				}else{
					die('Sorry, the link is invalid.');
					$this->session->set_flashdata('error','Sorry, the link is invalid.');
					redirect('home');
				}
				$data = array(
					'response' => $response,
					'response_time' => date('Y-m-d H:i:s')
				);
				$this->db->where('thehash', $thehash);
				$this->db->update('is_agree_apc', $data);
				
				die('Thank you. Your response has been recorded.');
				$this->session->set_flashdata('success','Thank you. Your response has been recorded.');
			}else{
				die('Sorry, the link is already used or expired.');
				$this->session->set_flashdata('error','Sorry, the link is already used or expired.'); //you have responded to this question, or your URL is invalid
			}
			redirect('home');
		}
	}
	public function mailrelay($tes=0){ // called by cron at belajardna.online. this one is replacing cron_sendmail (scheduled task)
	    /* if($tes==0){
	        die('system under maintenance');
	    } */
	    //die();
	    //echo "start<br>";
	    $this->db->trans_begin(); //5mar2022
		//$e = $this->db->query("select * from sendmail_log where (status='' or status='failed') and time <= now() limit ".MAX_BULK_SENDMAIL)->result(); //22aug2023: di server dsti, kolom time defaultnya 0000-00-00 00:00:00, dan query ini always return 0
		$e = $this->db->query("select * from sendmail_log where (status='' or status='failed') limit ".MAX_BULK_SENDMAIL)->result(); 
		if(!isset($e)){die('No pending emails.');}
		foreach($e as $m){
			$this->db->set('status','processing')
				->where('id',$m->id)
				->update('sendmail_log');
			//echo "setting $m->to as 'processing'<br>";
		}
		$this->load->library('email'); // load email library
		foreach($e as $m){
		    $this->db->set('status','sending...')->where('id',$m->id)->update('sendmail_log');
			$this->email->from(MAILSYSTEM, 'IJTech');
			//$this->email->to('ruki.hwyu@gmail.com');
			$this->email->to($m->to);
			//$this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
			if(is_null($m->bcc)){
			    $this->email->bcc(BCC_MAILSYSTEM_MULTI);
			}elseif($m->bcc!='no'){ //ada BCC nya tapi bukan 'no', alias alamat email(s)
			    $this->email->bcc($m->bcc);
			}
			$this->email->subject($m->subject);
			$this->email->message($m->body);
			if($m->attachment!='' && !is_null($m->attachment)){
				foreach(json_decode($m->attachment) as $file){ //TODO: exclude malformed json
					$this->ci->email->attach($file); //TODO: check if file exist
				}
			}
			//echo "sending to $m->to ";
			if($this->email->send()){
				$this->db->set('time_sent', date('Y-m-d H:i:s'))
					->set('status','sent')
					->where('id',$m->id)
					->update('sendmail_log');
				//echo ": ok<br>";
			}else{
			    //echo ": fail<br>";
				$this->db->set('time_sent', date('Y-m-d H:i:s'))
					->set('status','failed')
					->where('id',$m->id)
					->update('sendmail_log'); //tidak usah diapa2in biar next cron akan dicoba lagi
				/*
				$this->email->from(MAILSYSTEM, 'IJTech');
				$this->email->to('ijtech@ruki.web.id');
				$this->email->subject('Email gagal dikirim');
				$this->email->message('Dear Ruki Harwahyu, this sendmail_log item is failed to be sent: '.$m->id);
				$this->email->send();
				*/
			}
		}
		
		//5mar2022:
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }
		//echo "done<br>";
	}
	public function cron_sendmail(){
	    //this function is replaced by mailrelay()
	    //die();
	    //this function is replaced by mailrelay()
		$e = $this->db->query("select * from sendmail_log where status='' and time <= now() limit ".MAX_BULK_SENDMAIL)->result();
		if(!isset($e)){die('No pending emails.');}
		foreach($e as $m){
			$this->db->set('status','processing')
				->where('id',$m->id)
				->update('sendmail_log');
		}
		$this->load->library('email'); // load email library
		foreach($e as $m){
		    $this->db->set('status','sending...')->where('id',$m->id)->update('sendmail_log');
			$this->email->from(MAILSYSTEM, 'IJTech');
			$this->email->to($m->to);
			//$this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
			$this->email->bcc(BCC_MAILSYSTEM_MULTI);
			$this->email->subject($m->subject);
			$this->email->message($m->body);
			if($m->attachment!='' && !is_null($m->attachment)){
				foreach(json_decode($m->attachment) as $file){ //TODO: exclude malformed json
					$this->ci->email->attach($file); //TODO: check if file exist
				}
			}
			if($this->email->send()){
				$this->db->set('time_sent', date('Y-m-d H:i:s'))
					->set('status','sent')
					->where('id',$m->id)
					->update('sendmail_log');
			}else{
				$this->db->set('time_sent', date('Y-m-d H:i:s'))
					->set('status','failed')
					->where('id',$m->id)
					->update('sendmail_log'); //tidak usah diapa2in biar next cron akan dicoba lagi
				/*
				$this->email->from(MAILSYSTEM, 'IJTech');
				$this->email->to('ijtech@ruki.web.id');
				$this->email->subject('Email gagal dikirim');
				$this->email->message('Dear Ruki Harwahyu, this sendmail_log item is failed to be sent: '.$m->id);
				$this->email->send();
				*/
			}
		}
	}
    public function cancelOldReviewJob($duration=60,$notifyEiC=0){ //batalkan reviewer yg udh bersedia tapi blm ngerjain sejak 60 hari lalu
        $re = $this->db->query("
            select
            s.sub_id, s.sub_status, srr.email, srr.date_invite, srr.date_respond, srr.fullname, srr.salutation, s.sub_title, sec.section_abv, srr.sr_id, group_concat(u.email) se_email
            from submission s
            left join section sec on s.section_id = sec.section_id
            left join submission_reviewer srr on srr.sub_id = s.sub_id
            left join submission_review sr on (sr.sub_id = s.sub_id and sr.reviewer_email = srr.email)
            left join section_editor se on se.section_id = s.section_id
            left join users u on u.user_id = se.user_id
            where
            (s.sub_status = 3 or s.sub_status = 4)
            and srr.status = 1
            and sr.date_review is null
            and srr.date_invite < DATE_SUB(Now(), INTERVAL $duration DAY)
            group by srr.sr_id
        ")->result();
        
        $mails = array();
        $srr = array();
        foreach($re as $u){
        	$this->data['title'] = $u->sub_title;
        	$this->data['email'] = $u->email;
        	$this->data['sub_id'] = $u->sub_id;
        	$this->data['sec'] = $u->section_abv;
        	$this->data['name'] = $u->salutation.' '.$u->fullname;
        	$this->data['date_invite'] = $u->date_invite;
        	$this->data['duration'] = $duration;
        	$mails[] = array(
        		'to' => $u->email,
        		'subject' => "Re: [IJTech] Review assignment for manuscript #$u->section_abv-$u->sub_id",
        		'body' => $this->load->view('template/mailer/reviewer/reviewJobExpired', (object)$this->data, true),
        		'time' => date('Y-m-d H:i:s')
        	); // notify reviewer
        	if($notifyEiC){
            	$mails[] = array(
            		'to' => $u->se_email,
            		'subject' => "Re: [IJTech] - New Submission needs Initial Screening by EiC: #$u->section_abv-$u->sub_id",
            		'body' => $this->load->view('template/mailer/editor/peerReviewStatusUpdate', (object)$this->data, true),
            		'time' => date('Y-m-d H:i:s')
            	); //notify EIC
        	}
        	$srr[] = array(
        	    'sr_id' => $u->sr_id,
        	    'status' => 4
        	);
        }
        $cnt = count($mails);
        if($cnt>0){
            //echo '<pre>';print_r($mails);echo '</pre>';
            //echo '<pre>';print_r($srr);echo '</pre>';
        	$this->db->insert_batch('sendmail_log', $mails);
        	$this->db->update_batch('submission_reviewer', $srr, 'sr_id');
        	echo "OK. $cnt emails will be sent. Please be patient because fast sending may be regarded as SPAM.";
        }
    }
    
    public function cancelOldReviewInvitation($duration=60,$notifyEiC=0){ //batalkan reviewer diinvite tapi blm merespon sejak 60 hari lalu
        $re = $this->db->query("
            select
            s.sub_id, s.sub_status, srr.email, srr.date_invite, srr.date_respond, srr.fullname, srr.salutation, s.sub_title, sec.section_abv, srr.sr_id, group_concat(u.email) se_email
            from submission s
            left join section sec on s.section_id = sec.section_id
            left join submission_reviewer srr on srr.sub_id = s.sub_id
            left join section_editor se on se.section_id = s.section_id
            left join users u on u.user_id = se.user_id
            where
            (s.sub_status = 3 or s.sub_status = 4)
            and srr.status = 2
            and srr.date_invite < DATE_SUB(Now(), INTERVAL $duration DAY)
            group by srr.sr_id
        ")->result();
        
        $mails = array();
        $srr = array();
        foreach($re as $u){
        	$this->data['title'] = $u->sub_title;
        	$this->data['email'] = $u->email;
        	$this->data['sub_id'] = $u->sub_id;
        	$this->data['sec'] = $u->section_abv;
        	$this->data['name'] = $u->salutation.' '.$u->fullname;
        	$this->data['date_invite'] = $u->date_invite;
        	$this->data['duration'] = $duration;
        	$mails[] = array(
        		'to' => $u->email,
        		'subject' => "Re: [IJTech] Reviewer Invitation",
        		'body' => $this->load->view('template/mailer/reviewer/reviewInvitationExpired', (object)$this->data, true),
        		'time' => date('Y-m-d H:i:s')
        	); // notify reviewer
        	if($notifyEiC){
                $mails[] = array(
            		'to' => $u->se_email,
            		'subject' => "Re: [IJTech] - New Submission needs Initial Screening by EiC: #$u->section_abv-$u->sub_id",
            		'body' => $this->load->view('template/mailer/editor/peerReviewStatusUpdate', (object)$this->data, true),
            		'time' => date('Y-m-d H:i:s')
            	); //notify EIC
        	}
        	$srr[] = array(
        	    'sr_id' => $u->sr_id,
        	    'status' => 4
        	);
        }
        $cnt = count($mails);
        if($cnt>0){
            //echo '<pre>';print_r($mails);echo '</pre>';
            //echo '<pre>';print_r($srr);echo '</pre>';
        	$this->db->insert_batch('sendmail_log', $mails);
        	$this->db->update_batch('submission_reviewer', $srr, 'sr_id');
        	echo "OK. $cnt emails will be sent. Please be patient because fast sending may be regarded as SPAM.";
        }
    }
    

	public function getfile($a = array()){
		// http://ijtech.eng.ui.ac.id/assets/front/img/logo_lama.png
		
		$filename="./assets/front/img/logo_lama.png"; //<-- specify the image  file
		if(file_exists($filename)){ 
			$mime = mime_content_type($filename); //<-- detect file type
			header('Content-Length: '.filesize($filename)); //<-- sends filesize header
			header("Content-Type: $mime"); //<-- send mime-type header
			header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
			readfile($filename); //<--reads and outputs the file onto the output buffer
			die(); //<--cleanup
			exit; //and exit
		}
		die('404');
		
		echo '<pre>';
		print_r($this->input->get('p'));
		die();
		if(is_array($a)){
			die('yes');
		}else{
			die('no');
		}
		die(implode('-',$a));
	}
}
