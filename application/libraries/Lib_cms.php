<?php

/**
 * @package    Journal FTUI/libraries - 2016
 * @author     Sabbana
 * @copyright  sstud-io.net
 * @version    1.0
 */

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lib_cms {

    private $ci;

    function __construct() {
        $this->ci =&get_instance();
    }
	 
	/**
	 * @ this section announcement CRUD Modules
	 * @ methods:
	 * 		- insert
	 * 		- update
	 * 		- delete
	 */

	private function log($event, $table, $key)
	{
		return $this->ci->cms->log($this->ci->session->userdata('user_id'), $event, $table, $key);
	}
	private function log_submission($sub_id, $status, $desc){
		return $this->ci->cms->log_submission($sub_id, $status, $desc);
	}
    # create announcement
    # =============================
    public function insert_announcement(){
    	$exp = $this->ci->input->post('expire_date').' 00:00:00';
    	$date_input = $this->ci->input->post('date_input').' 00:00:00';
    	$data = array(
    		'user_id' 	=> $this->ci->session->userdata('user_id'),
    		'ann_title'	=> $this->ci->security->xss_clean($this->ci->input->post('ann_title')),
     		'ann_description'	=> $this->ci->input->post('ann_description'),
     		'issue_id'	    => $this->ci->input->post('issue_id'), //ruki
    		'expire_date'		=> $exp,
    		'date_input'		=> $date_input != "" ? $date_input : date('Y-m-d H:i:s'),
    		'date_update'		=> $date_input != "" ? $date_input : date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->insert('announcement', $data);
    	if($act){
    		$this->log('Create journal announcement', 'announcement','');
    		$this->ci->session->set_flashdata('success','New Announcement has been created.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/announcement');
    }
    # update announcement
    # =======================================
	public function update_announcement(){
		$id = $this->ci->input->post('ann_id');
    	$exp = $this->ci->input->post('expire_date').' 00:00:00';
    	$date_input = $this->ci->input->post('date_input').' 00:00:00';
    	$data = array(
    		'ann_title'	=> $this->ci->security->xss_clean($this->ci->input->post('ann_title')),
    		'ann_description'	=> $this->ci->input->post('ann_description'),
        'issue_id'     	=> $this->ci->input->post('issue_id'), //ruki
    		'expire_date'		=> $exp,
    		'date_input'		=> $date_input != "" ? $date_input : date('Y-m-d H:i:s'),
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->update('announcement', array('ann_id', $id), $data);
    	if($act){
    		$this->log('Update journal announcement', 'announcement', $id);
    		$this->ci->session->set_flashdata('success','The Announcement has been updated.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/announcement');
    }
		
    # update info
    # =======================================
	public function update_info(){
    	$act = $this->ci->cms->update('misc', array('param', 'info'), array('value'=>$this->ci->input->post('info_content')));
    	if($act){
    		$this->ci->session->set_flashdata('success','Journal info has been updated.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while updating journal info.');
    	redirect('dashboard/info');
    }

    # delete announcement
    # =======================================
	public function delete_announcement(){
		$id = $this->ci->input->post('ann_id');
		$act = $this->ci->cms->delete('announcement', array('ann_id', $id));
		if($act){
			$this->log('Delete journal announcement', 'announcement', $id);
			$this->ci->session->set_flashdata('success','Announcement has been deleted.');
		}else $this->ci->session->set_flashdata('error','Trouble deleting announcement.');
		redirect('dashboard/announcement');
	}


	/**
	 * @ page modules
	 * @ methods:
	 * 		- insert
	 * 		- update
	 * 		- delete
	 */
    # create page
    # =============================
    public function insert_page(){
    	$data = array(
    		'user_id' 	=> $this->ci->session->userdata('user_id'),
    		'page_title'	=> $this->ci->security->xss_clean($this->ci->input->post('page_title')),
     		'page_content'	=> $this->ci->input->post('page_content'),
    		'date_input'		=> date('Y-m-d H:i:s'),
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->insert('page', $data);
    	if($act){
    		$this->log('Create new page', 'page','');
    		$this->ci->session->set_flashdata('success','New Page has been created.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/about');
    }

    # update page
    # =======================================
	public function update_page(){
		$id = $this->ci->input->post('page_id');
    	$data = array(
    		'page_title'	=> $this->ci->security->xss_clean($this->ci->input->post('page_title')),
    		'page_content'	=> $this->ci->input->post('page_content'),
    		'date_update'	=> date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->update('page', array('page_id', $id), $data);
    	if($act){
    		$this->log('Update page', 'page', $id);
    		$this->ci->session->set_flashdata('success','The Page has been updated.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/about');
    }

    # delete page
    # =======================================
	public function delete_page(){
		$id = $this->ci->input->post('page_id');
		$act = $this->ci->cms->delete('page', array('page_id', $id));
		if($act){
			$this->log('Delete page', 'page', $id);
			$this->ci->session->set_flashdata('success','Page has been deleted.');			
		}else $this->ci->session->set_flashdata('error','Trouble deleting page.');
		redirect('dashboard/about');
	}

	/**
	 * @ this section is Journal section CRUD Modules
	 * @ methods:
	 * 		- insert
	 * 		- update
	 * 		- delete
	 */

    # create journal section
    # =============================
    public function insert_section(){
    	$data = array(
    		'user_id' 	=> $this->ci->session->userdata('user_id'),
    		'section_title'	=> $this->ci->security->xss_clean($this->ci->input->post('section_title')),
     		'section_abv'	=> $this->ci->input->post('section_abv'),
    		'review_form'		=> $this->ci->input->post('review_form'),
    		'peer_review'		=> $this->ci->input->post('peer_review') ? $this->ci->input->post('peer_review') : 0,
    		'abstract_required'		=> $this->ci->input->post('abstract_required') ? $this->ci->input->post('abstract_required') : 0,
    		'submission_restriction'		=> $this->ci->input->post('submission_restriction') ? $this->ci->input->post('submission_restriction'):0,
    		'title_restriction'		=> $this->ci->input->post('title_restriction') ? $this->ci->input->post('title_restriction') : 0,
    		'author_restriction'		=> $this->ci->input->post('author_restriction') ? $this->ci->input->post('author_restriction') : 0,
    		'date_input'		=> date('Y-m-d H:i:s'),
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->insert('section', $data);
    	if($act){
    		$this->log('Create journal section', 'section','');
    		$this->ci->session->set_flashdata('success','New Section has been created.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/section');
    }
    public function insert_edition(){
    	$data = array(
    		'title'	=> $this->ci->security->xss_clean($this->ci->input->post('title')),
    		'abv'	=> $this->ci->security->xss_clean($this->ci->input->post('abv')),
     		'status'	=> $this->ci->input->post('status'),
    	);
    	$act = $this->ci->cms->insert('editions', $data);
    	if($act){
    		$this->log('Create edition', 'edition','');
    		$this->ci->session->set_flashdata('success','New edition has been created.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/editions');
    }

    public function insert_section_editor(){    	
    	$id = $this->ci->input->post('section_id');
    	$data = array(
    		'section_id' => $id,
    		'user_id'	=> $this->ci->input->post('editor')
    	);
    	$act = $this->ci->cms->insert('section_editor', $data);
    	if($act){
    		$this->log('Create new section editor', 'section_editor','');
    		$this->ci->session->set_flashdata('success','Section editor has been added.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/edit/section/'.$id);
    }

    # update journal section
    # =============================
    public function update_section(){
    	$id = $this->ci->input->post('section_id');
    	$data = array(
    		'section_title'	=> $this->ci->security->xss_clean($this->ci->input->post('section_title')),
     		'section_abv'	=> $this->ci->input->post('section_abv'),
    		'review_form'		=> $this->ci->input->post('review_form'),
    		'peer_review'		=> $this->ci->input->post('peer_review') ? $this->ci->input->post('peer_review') : 0,
    		'abstract_required'		=> $this->ci->input->post('abstract_required') ? $this->ci->input->post('abstract_required') : 0,
    		'submission_restriction'		=> $this->ci->input->post('submission_restriction') ? $this->ci->input->post('submission_restriction'):0,
    		'title_restriction'		=> $this->ci->input->post('title_restriction') ? $this->ci->input->post('title_restriction') : 0,
    		'author_restriction'		=> $this->ci->input->post('author_restriction') ? $this->ci->input->post('author_restriction') : 0,    		
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->update('section', array('section_id', $id), $data);
    	if($act){
    		$this->log('Update journal section', 'section', $id);
    		$this->ci->session->set_flashdata('success','The Section has been updated.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/section');
    }
		
		public function update_edition(){
    	$id = $this->ci->input->post('id');
    	$data = array(
    		'title'	=> $this->ci->security->xss_clean($this->ci->input->post('title')),
    		'abv'	=> $this->ci->security->xss_clean($this->ci->input->post('abv')),
     		'status'	=> $this->ci->input->post('status'),
    	);
    	$act = $this->ci->cms->update('editions', array('id', $id), $data);
    	if($act){
    		$this->log('Update journal edition', 'edition', $id);
    		$this->ci->session->set_flashdata('success','The edition has been updated.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/editions');
		}

	# delete section
    # =======================================
	public function delete_section(){
		$id = $this->ci->input->post('section_id');
		$act = $this->ci->cms->delete('section', array('section_id', $id));
		if($act){
			$this->log('Delete journal section', 'section', $id);
			$this->ci->session->set_flashdata('success','Journal Section has been deleted.');
		}else $this->ci->session->set_flashdata('error','Trouble deleting Journal Section.');
		redirect('dashboard/section');
	}

	public function delete_edition($id){
		//$id = $this->ci->input->post('id');
		$any = $this->ci->cms->count_submission_by_edition("$id");
		if($any>0){
			$this->ci->session->set_flashdata('error','Some submissions exist under this edition, therefore this edition cannot be deleted.');
			redirect('dashboard/editions');
		}
		$act = $this->ci->cms->delete('editions', array('id', $id));
		if($act){
			$this->ci->session->set_flashdata('success','Delete success.');
		}else $this->ci->session->set_flashdata('error','Delete failed.');
		redirect('dashboard/editions');
	}

	public function delete_section_editor($sid, $uid){
		$act = $this->ci->cms->delete('section_editor', array('user_id', $uid));
		if($act){
			$this->log('Delete section editor', 'section_editor', $sid);
			$this->ci->session->set_flashdata('success','Section editor has been deleted.');
		}else $this->ci->session->set_flashdata('error','Trouble deleting Section editor.');
		redirect('dashboard/edit/section/'.$sid);
	}
	
	/**
	 * @ user module
	 * @ update
	 */

	public function insert_user(){
		$this->ci->load->library('form_validation');
		$this->ci->form_validation->set_rules('user_id','Username','required|trim|alpha_numeric');
		$this->ci->form_validation->set_rules('password','Password','required|trim|alpha_numeric|min_length[6]');
		$this->ci->form_validation->set_rules('repassword','Confirm Password','required|matches[password]');
		if($this->ci->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->ci->session->set_flashdata('warning', $msg);
			redirect('dashboard/create/user');
		}else{
			$pass = $this->ci->security->xss_clean($this->ci->input->post('password'));
			$data = array(
				'user_id'	=> $this->ci->security->xss_clean($this->ci->input->post('user_id')),
				'section_id' => $this->ci->security->xss_clean($this->ci->input->post('section_id')),
				'password'	=> md5($pass),
				'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
				'first_name'	=> $this->ci->security->xss_clean($this->ci->input->post('first_name')),
				'last_name'		=> $this->ci->security->xss_clean($this->ci->input->post('last_name')),
				'expertise'		=> $this->ci->security->xss_clean($this->ci->input->post('expertise')),				
				'email'		=> $this->ci->security->xss_clean($this->ci->input->post('email')),
				'phone'		=> $this->ci->security->xss_clean($this->ci->input->post('phone')),
				'fax'		=> $this->ci->security->xss_clean($this->ci->input->post('fax')),
				'status'	=> 1,
				'postal_address' => $this->ci->input->post('postal_address'),
				'date_create'	=> date('Y-m-d H:i:s'),
				'date_update'	=> date('Y-m-d H:i:s'),
			);
			$role = $this->ci->input->post('role_id');			
			$act = $this->ci->cms->insert('users', $data);
			if($act){
				# set section editor
				if (in_array(4, $role))
					$this->ci->cms->insert('section_editor', array('user_id' => $data['user_id'], 'section_id' => $data['section_id']));

				$this->log('Create new user', 'users', $data['user_id']);
				for($a=0; $a<count($role); $a++){
					$this->log('Create user as '.$role[$a], 'roleuser', $data['user_id']);
					$this->ci->cms->insert('roleuser', array('user_id' => $data['user_id'], 'role_id' => $role[$a]));
				}
				$this->ci->load->model('mdl_login');
				$result = array(					
					'user_id'	=> $data['user_id'],
					'email'		=> $data['email'],
					'name'		=> $data['first_name'].' '.$data['last_name'],
					'status'	=> $this->ci->mdl_login->get_rolename_user($data['user_id'])
				);
				$message = $this->ci->load->view('template/mailer/author/account_created', $result, TRUE);
				$this->ci->load->library('email'); // load email library
				$this->ci->email->from(MAILSYSTEM, 'IJTech');
				$this->ci->email->to($data['email']);
				$this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
				$this->ci->email->subject('Account Created');
				$this->ci->email->message($message);
				if($this->ci->email->send()){
					$this->log('Sending email to '.$data['email'].' - Registration process', 'users', $data['user_id']);
					$this->ci->session->set_flashdata('success','Registration process successfully');
				}else{
					$this->ci->session->set_flashdata('warning','<b>Warning!</b> We could not send user account to email. Please check the email is valid.');
				}				
			}else
				$this->ci->session->set_flashdata('error','Trouble while register new user!');
			redirect('dashboard/create/user');
		}
	}
	
	/**
	 * @ issue modules
	 * @ methods:
	 * 		- insert
	 * 		- update
	 * 		- delete
	 */
	 
	public function update_issue_reviewers(){
		$id = $this->ci->input->post('issue_id');
		$data['reviewers_list_file'] = "";
		if($_FILES['reviewers_list_file']['tmp_name'] !== ""){ //ruki25jan2019
			$config['upload_path'] = './assets/reviewers_list_file/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '2048'; # Max size 2 MB
			$config['overwrite'] = true;
			$fileName = $id.'.pdf';
			$config['file_name'] = $fileName;
			$path = 'assets/reviewers_list_file/';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload('reviewers_list_file')){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('error','Error when attempting to upload reviewers list.<br/>'.$msg);
			}else{
				$data['reviewers_list_file'] = $path.$fileName;
				$act = $this->ci->cms->update('issue', array('issue_id', $id), $data);
				if($act){
					$this->log('Update journal issue - meta data', 'issue', $id);
					$this->ci->session->set_flashdata('success','File has been uploaded.');
				}else{ $this->ci->session->set_flashdata('error','Trouble uploading.'); }
			}
		}
		redirect('dashboard/edit/issue/'.$id,'refresh');
	}
	
	public function delete_reviewers_list_file($param, $id){
		if(unlink('assets/reviewers_list_file/'.$id.'.pdf')){
			$this->ci->session->set_flashdata('success','File has been deleted.');
			$data['reviewers_list_file'] = '';
			$act = $this->ci->cms->update('issue', array('issue_id', $id), $data);
		}else{
			$this->ci->session->set_flashdata('error','Error deleting file.');
		}
		redirect('dashboard/edit/issue/'.$id,'refresh');
		// die(site_url().'assets/reviewers_list_file/'.$id.'.pdf');
	}
	 
	# create issue
	# =============================
	public function insert_issue(){
		$date = $this->ci->input->post('date_publish').' '.date('H:i:s');
		$data = array(
			'user_id' 	=> $this->ci->session->userdata('user_id'),
			'volume'	=> (int)$this->ci->input->post('volume'),
			'issue_number'	=> (int)$this->ci->input->post('issue_number'),
			'year'		=> (int)$this->ci->input->post('year'),
			'special_issue'		=> $this->ci->input->post('special') ? $this->ci->input->post('special') : 0,
			'date_publish'		=> $date != "" ? $date : date('Y-m-d H:i:s'),
			'date_input'		=> date('Y-m-d H:i:s'),
			'date_update'		=> date('Y-m-d H:i:s'),
		);

		$issue = $data['volume'].'-'.$data['issue_number'].'-'.$data['year'];
		
		if($_FILES['userfile']['tmp_name'] !== ""){
			$config['upload_path'] = './uploads/cover/';
			$config['allowed_types'] = 'jpg|jpef|png|gif';
			$config['max_size'] = '2048'; # Max size 2 MB
			$config['overwrite'] = true;
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$fileName = $issue.'.'.$ext;
			$config['file_name'] = $fileName;
			$path = 'uploads/cover/';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('error','Trouble saving cover image.<br/>'.$msg);
			}else{
				$data['cover_image'] = $path.$fileName;
			}
		}
					
		$this->ci->cms->update('issue', array(), array('status'=>0));
		$act = $this->ci->cms->insert('issue', $data);
		if($act){
			$this->log('Create journal issue', 'issue','');
			$this->ci->session->set_flashdata('success','Journal Issue has been created.');
		}else{
			$this->ci->session->set_flashdata('error','Trouble saving Issue.');
		}
		redirect('dashboard/issue');
	}

	# update issue
	# =======================================
	public function update_issue(){
		$id = $this->ci->input->post('issue_id');
		$date = $this->ci->input->post('date_publish').' '.date('H:i:s');
    	$data = array(
    		'volume'	=> (int)$this->ci->input->post('volume'),
    		'issue_number'	=> (int)$this->ci->input->post('issue_number'),
     		'year'	=> (int)$this->ci->input->post('year'),
     		'special_issue'		=> $this->ci->input->post('special') ? $this->ci->input->post('special') : 0,    		
     		'date_publish'	=> $date != "" ? $date : date('Y-m-d H:i:s'),
    		'date_update'	=> date('Y-m-d H:i:s'),
    	);
    	$issue = $data['volume'].'-'.$data['issue_number'].'-'.$data['year'];
    	if($_FILES['userfile']['tmp_name'] !== ""){
				$config['upload_path'] = './uploads/cover/';
				$config['allowed_types'] = 'jpg|jpef|png|gif';
				$config['max_size'] = '2048'; # Max size 2 MB
				$config['overwrite'] = true;
				$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $issue.'.'.$ext;
				$path = 'uploads/cover/';
				$this->ci->load->library('upload', $config);
				if(!$this->ci->upload->do_upload('userfile')){
					$msg = $this->ci->upload->display_errors();
					$this->ci->session->set_flashdata('error','Trouble updating cover image.<br/>'.$msg);
				}else{
					$data['cover_image'] = $path.$fileName;
				}
			}
						
			$act = $this->ci->cms->update('issue', array('issue_id', $id), $data);
			if($act){
				$this->log('Update journal issue - meta data', 'issue', $id);
				$this->ci->session->set_flashdata('success','Journal Issue has been updated.');
			}else{ $this->ci->session->set_flashdata('error','Trouble updating Issue.'); }
    	redirect('dashboard/issue');
    }

	# update status issue
	public function update_issue_status(){
    	$id = $this->ci->input->post('issue_id');
		$act = $this->ci->cms->update_issue_status($id);
		if($act){
			$this->log('Update current issue', 'issue', $id);
			$this->ci->session->set_flashdata('success','Journal Issue has been updated.');
		}else $this->ci->session->set_flashdata('error','Trouble updating issue.');
		redirect('dashboard/issue');
    }

    # delete issue
    # =======================================
	public function delete_issue(){
		$id = $this->ci->input->post('issue_id');
		$act = $this->ci->cms->delete('issue', array('issue_id', $id));
		if($act){
			//PR: delete cover file and reviewers file
			$this->log('Delete journal issue', 'issue', $id);
			$this->ci->session->set_flashdata('success','Journal Issue has been deleted.');
		}else $this->ci->session->set_flashdata('error','Trouble deleting issue.');
		redirect('dashboard/issue');
	}

	# change avatar
	# ====================================
	public function change_avatar(){
		$id = md5($this->ci->session->userdata('user_id'));
		if($_FILES){
			$config['upload_path'] = './uploads/profile/';
			$config['allowed_types'] = 'jpg|jpef|png';
			$config['max_size'] = '10240'; # Max size 10 MB
			$config['overwrite'] = true;
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$fileName = $id.'.'.$ext;
			$config['file_name'] = $fileName;

			$path = 'uploads/profile/';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('error','Trouble updating user avatar.<br/>'.$msg);
			}else{
				$data['avatar'] = $path.$fileName;
				$act = $this->ci->cms->update('users', array('MD5(user_id)', $id), array('profile_image'=>$path.$fileName));
				if($act){
					$this->log('Update photo profile', 'users', $id);
					$this->ci->session->set_userdata('avatar', $path.$fileName);
					$this->ci->session->set_flashdata('success','Profile image has been updated.');
				}else $this->ci->session->set_flashdata('error','Trouble updating profile image.');
			}
		}
		redirect('dashboard/profile/'.$id);
	}

	# change password 
	# ============================
	public function change_password(){
		$id = $this->ci->input->post('user_id');
		$pass = $this->ci->security->xss_clean($this->ci->input->post('user_password'));
		$repass = $this->ci->security->xss_clean($this->ci->input->post('user_repassword'));
		if($pass !== $repass){
			$msg = 'Confirm password should be match with password';
			$this->ci->session->set_flashdata('error', $msg);
		}else{
			$data = array('password' => md5($pass));
			$change = $this->ci->cms->update('users', array('user_id', $id), $data);
			if($change){
				$this->log('Change password', 'users', $id);
				$this->ci->session->set_flashdata('success','Your password has been updated.');
			}
			else
				$this->ci->session->set_flashdata('error','Trouble while updating your password!');
		}
		redirect('dashboard/edit/password');
	}
	
	# change status
	# ============================
	public function change_user_status(){
		$id = $this->ci->security->xss_clean($this->ci->input->post('user_id'));
		$sts = $this->ci->security->xss_clean($this->ci->input->post('status'));
		if($sts == 0) $status = 1; else $status = 0;
		$data = array('status' => $status);
		$change = $this->ci->cms->update('users', array('user_id', $id), $data);
		if($change){
			$this->log('Change user status', 'users', $id);
			$this->ci->session->set_flashdata('success','User status has been updated.');
		}
		else
			$this->ci->session->set_flashdata('alert','Trouble while updating user status!');
		redirect('dashboard/users');
	}
	
	public function reset_password(){
		$id = $this->ci->security->xss_clean($this->ci->input->post('user_id'));		
		$change = $this->ci->cms->update('users', array('user_id', $id), array('password'=>md5('123456')));
		if($change){
			$this->log('Reset password user', 'users', $id);
			$this->ci->session->set_flashdata('success','User password has been updated.');
		}
		else
			$this->ci->session->set_flashdata('alert','Trouble while updating user password!');
		redirect('dashboard/users');
	}
	
	# delete users
	public function delete_user(){
		$id = $this->ci->input->post('user_id');
		$act = $this->ci->cms->delete('users', array('user_id', $id));
		if($act){
			$this->log('Delete user', 'users', $id);
			$this->ci->cms->delete('roleuser', array('user_id', $id));
			$this->ci->session->set_flashdata('success','User has been deleted.');	
		} 
		else $this->ci->session->set_flashdata('error','Trouble deleting user.');
		redirect('dashboard/users');
	}

	public function set_role_user(){
		$id = $this->ci->input->post('user_id');
		$role = $this->ci->input->post('role_id');
		$act = $this->ci->cms->update('users', array('user_id', $id), array('role_id' => $role));
		if($act){
			$this->log('Set role user ', 'users','');
			$this->ci->session->set_flashdata('success','User role has been updated.');
		}else $this->ci->session->set_flashdata('error','Trouble updating user role.');
		redirect('dashboard/users');
	}

	public function update_user(){
		$id = $this->ci->input->post('user_id');
    	$data = array(
    		'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
    		'first_name'	=> $this->ci->security->xss_clean($this->ci->input->post('first_name')),
    		'last_name'	=> $this->ci->security->xss_clean($this->ci->input->post('last_name')),
    		'section_id'	=> $this->ci->security->xss_clean($this->ci->input->post('section_id')),
    		'phone'	=> $this->ci->security->xss_clean($this->ci->input->post('phone')),
    		'fax'	=> $this->ci->security->xss_clean($this->ci->input->post('fax')),
    		'email'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
    		'email2'	=> $this->ci->security->xss_clean($this->ci->input->post('email2')),
     		'postal_address'	=> $this->ci->security->xss_clean($this->ci->input->post('postal_address')),
     		'scopus_id'	=> $this->ci->security->xss_clean($this->ci->input->post('scopus_id')),
     		'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
     		'affiliation2'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation2')),
     		'expertise'	=> $this->ci->security->xss_clean($this->ci->input->post('expertise')),
    		'country'	=> $this->ci->input->post('country'),
    		'short_biography'	=> $this->ci->input->post('short_biography'),
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);
    	$act = $this->ci->cms->update('users', array('user_id', $id), $data);
    	if($act){
    		$this->ci->session->unset_userdata('section');
    		$this->ci->session->set_userdata('section', $data['section_id']);    		
    		$this->ci->session->set_flashdata('success','The User Profile has been updated.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/profile/'.$id);
	}

	/**
	 * @ this section submission CRUD Modules
	 * @ methods:
	 * 		- insert
	 * 		- update
	 * 		- delete
	 */

    # create announcement
    # =============================
    public function insert_submission(){
    	$data = array(
    		'user_id'	=> $this->ci->session->userdata('user_id'),
    		'edition' 	=> $this->ci->input->post('edition'),
    		'section_id' 	=> $this->ci->input->post('section_id'),
    		'article_type' 	=> $this->ci->input->post('article_type'),
    		'sub_title'	=> $this->ci->security->xss_clean($this->ci->input->post('sub_title')),
     		'abstract'	=> $this->ci->input->post('abstract'),
     		'keywords'	=> $this->ci->security->xss_clean($this->ci->input->post('keywords')),
     		'sub_references'	=> $this->ci->input->post('sub_references'),
    		'date_input'		=> date('Y-m-d H:i:s'),
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);
    	
    	$this->ci->db->insert('submission', $data);
    	$sub_id = $this->ci->db->insert_id();
    	if($sub_id !== Null){
    		# default author
    		$this->log_submission($sub_id, 0, 'Start submission');
    		$this->log('Create new submission', 'submission', $sub_id);
    		$this->ci->cms->default_author($sub_id, $this->ci->session->userdata('user_id'));
    		$this->ci->session->set_flashdata('success','New article has been created.');
    	}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/create/author/'.$sub_id);
    }

	public function update_submission($param = null){
		$action = $this->ci->input->post('submit');
		$id = $this->ci->input->post('sub_id');
		$round = $this->ci->input->post('round');
		if ($param !== null){
			$is_funder = $this->ci->input->post('is_funder');
			$cover = strip_tags($this->ci->input->post('cover_letter'));
			$data = array(
				'cover_letter'	=> $this->ci->security->xss_clean($cover),
				'not_publish'	=> $this->ci->input->post('publish') != null ? $this->ci->input->post('publish') : 0,
				'read_ethics'	=> $this->ci->input->post('read') != null ? $this->ci->input->post('read') : 0,
				'agree_proofread'	=> $this->ci->input->post('agree_proofread') != null ? $this->ci->input->post('agree_proofread') : 0,
			);
			if ($is_funder == 0)
				$this->ci->cms->clear_submission_funder($id);

			# if attach file
			if($_FILES['userfile']['tmp_name'] !== ""){
				$config['upload_path'] = './uploads/cover/';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = '10240'; # Max size 10 MB
				$config['overwrite'] = true;
				
				$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
				$fileName = "attach_cover_".$id.'.'.$ext;
				$config['file_name'] = $fileName;

				$path = 'uploads/cover/';
				$this->ci->load->library('upload', $config);
				if(!$this->ci->upload->do_upload()){
					$msg = $this->ci->upload->display_errors();
					$this->ci->session->set_flashdata('error','Trouble attach file.<br/>'.$msg);
				}else{
					$datafile = array(
			    		'sub_id' => $id,
			    		'type'	 => 5,
			    		'round'	=> $round,
			    		'file_url'	=> $path.$fileName
			    	);					
					$this->ci->cms->insert('submission_file', $datafile);
				}
			}
			
			# update
			$act = $this->ci->cms->update('submission', array('sub_id', $id), $data);
			if($act){
				$this->log('Update submission detail', 'submission', $id);
	    		$this->ci->session->set_flashdata('success','Article detail data has been updated.');
			}
	    	else $this->ci->session->set_flashdata('error','Trouble while updating data.');
			if($action == "Save")
				redirect('dashboard/edit/detail/'.$id);
			else
				redirect('dashboard/create/suplement/'.$id);
		}else{
			$data = array( 
	    		'edition' 	=> $this->ci->input->post('edition'),
	    		'section_id' 	=> $this->ci->input->post('section_id'),
'article_type' 	=> $this->ci->input->post('article_type'),
	    		'sub_title'	=> $this->ci->security->xss_clean($this->ci->input->post('sub_title')),
	     		'abstract'	=> $this->ci->input->post('abstract'),
	     		'keywords'	=> $this->ci->security->xss_clean($this->ci->input->post('keywords')),
	     		'sub_references'	=> $this->ci->input->post('sub_references'),
	    		'date_update'		=> date('Y-m-d H:i:s'),
	    	);
	    	$act = $this->ci->cms->update('submission', array('sub_id', $id), $data);
	    	if($act){
	    		$this->log('Update submission meta data', 'submission', $id);
	    		$this->ci->session->set_flashdata('success','Article meta data has been updated.');
	    	}
	    	else $this->ci->session->set_flashdata('error','Trouble while updating data.');
			if($action == "Save")
				redirect('dashboard/edit/submission/'.$id);
			else
				redirect('dashboard/create/author/'.$id);	
		}
    }

    public function withdraw(){    	
    	$page = $this->ci->security->xss_clean($this->ci->input->post('page'));
    	$sub_id = $this->ci->security->xss_clean($this->ci->input->post('sub_id'));
    	$reason = $this->ci->security->xss_clean($this->ci->input->post('reason'));
    	$update = $this->ci->cms->withdraw_manuscript($sub_id, $reason);
    	if ($update){
    		$this->log('Withdraw submission '.$sub_id, 'submission', $sub_id);
    		$this->log_submission($sub_id, 99, 'Withdraw submission ');
    		$this->ci->session->set_flashdata('success','All process related on this manuscript has been stoped!');
    	}
    	redirect($page);
    }
		
    public function erratum(){ //Ruki16feb2019
    	$page = $this->ci->security->xss_clean($this->ci->input->post('page'));
    	$id = $this->ci->security->xss_clean($this->ci->input->post('sub_id'));
			$data['erratum_file'] = "";
			$data['erratum_type'] = "";
			// $data['erratum_desc'] = "";
			if($this->ci->input->post('clear')){
				$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
				if ($act){
					$this->log('Remove erratum', $sub_id);
					$this->ci->session->set_flashdata('success','Erratum succeessfully removed.');
				}
				redirect($page);
			}
			
			$data['erratum_type'] = $this->ci->security->xss_clean($this->ci->input->post('type'));
			// $data['erratum_desc'] = $this->ci->security->xss_clean($this->ci->input->post('description'));
			$path = 'uploads/submission/manuscript/'.$id.'/';
			if($_FILES['userfile']['tmp_name'] !== ""){
				$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);			
				$fileName = $data['erratum_type'].'.'.$ext;
				$config['file_name'] = $fileName;
				$config['overwrite'] = true;
				$config['upload_path'] = $path;
				$config['max_size'] = '10240'; # Max size 10 MB
				$config['allowed_types'] = 'pdf';
				
				$this->ci->load->library('upload', $config);
				if(!$this->ci->upload->do_upload()){
					$msg = $this->ci->upload->display_errors();
					$this->ci->session->set_flashdata('invalid','Trouble uploading file.<br/>'.$msg);
				}else{
					$data['erratum_file'] = $path.$fileName;
				}
			}
			$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
    	if ($act){
    		$this->log('Add/Update erratum', $sub_id);
    		$this->ci->session->set_flashdata('success','Erratum succeessfully added/updated.');
    	}
    	redirect($page);
    }

    public function insert_selected_author(){
    	$page = $this->ci->input->post('page');
    	$user_id = $this->ci->input->post('user_id');
    	$sub_id = $this->ci->input->post('sub_id');
    	$author = $this->ci->cms->get_user($user_id);
    	$tot = $this->ci->cms->count_author_submission($sub_id);
    	$data = array(
    		'sub_id' => $sub_id,
    		'salutation' => $author[0]['salutation'],
    		'first_name'	=> $author[0]['first_name'],
    		'last_name'	=> $author[0]['last_name'],
    		'email'	=> $author[0]['email'],
    		'affiliation'	=> '- '.$author[0]['affiliation'].($author[0]['affiliation2'] !== '' && $author[0]['affiliation2'] !== NULL  ? '<br/>- '.$author[0]['affiliation2']:''),
    		'short_biography'	=> $author[0]['short_biography'],
    		'country'	=> $author[0]['country'],    		
    		'sort'	=> $tot + 1,
    	);    	
    	$act = $this->ci->cms->insert('submission_author', $data);
    	if ($act){
    		$this->log('Add existing author with email : '.$author[0]['email'].' to submission id : '.$sub_id, 'submission_author', $sub_id);
    		$this->ci->session->set_flashdata('success','Succeessfully add author from existing data');
    	}
    	redirect($page);
    }

    public function set_coauthor(){
    	$page = $this->ci->input->post('page');
    	$sa_id = $this->ci->input->post('sa_id');
    	$sub_id = $this->ci->input->post('sub_id');
    	$act = $this->ci->cms->set_coauthor($sub_id, $sa_id);
    	if ($act)
    		$this->ci->session->set_flashdata('success','Succeessfully set author as corresponding author');    	
    	redirect($page);	
    }

	public function insert_selected_reviewer(){
    	$page = $this->ci->input->post('page');
    	$sr_id = $this->ci->input->post('sr_id');
    	$sub_id = $this->ci->input->post('sub_id');
    	$reviewer = $this->ci->cms->get_user($sr_id);
    	$data = array(
    		'sub_id' => $sub_id,
    		'user_id' => $this->ci->session->userdata('user_id'),
    		'salutation'	=> $reviewer[0]['salutation'],
    		'fullname'	=> $reviewer[0]['first_name'].' '.$reviewer[0]['last_name'],
    		'email'	=> $reviewer[0]['email'],
    		'expertise'	=> $reviewer[0]['expertise'],
    		'affiliation'	=> $reviewer[0]['affiliation'],
    	);    	
    	$act = $this->ci->cms->insert('submission_reviewer', $data);
    	if ($act){
    		$this->log('Add existing reviewer with email : '.$reviewer[0]['email'].' to submission id : '.$sub_id, 'submission_reviewer', $sub_id);
    		$this->ci->session->set_flashdata('success','Succeessfully add reviewer from existing data');
    	}
    	redirect($page);
    }

    public function delete_submission(){
    	$page = $this->ci->input->post('page');
    	$id = $this->ci->input->post('sub_id');
    	$clear = $this->ci->cms->clear_submission($id);
    	if($clear){
	    	$act = $this->ci->cms->delete('submission', array('sub_id', $id));
			if($act){
				$this->log('Delete submission', 'submission', $id);
				$this->ci->session->set_flashdata('success','Submission succeessfully deleted.');
			}
		}
    	else $this->ci->session->set_flashdata('error','Trouble while deleting data.');
    	redirect($page);
    }

    public function insert_suplement(){
    	$id = $this->ci->input->post('sub_id');
    	$type = $this->ci->input->post('type');
    	$round = $this->ci->input->post('round');
    	$data = array(
    		'sub_id' => $id,
    		'type'	 => $type,
    		'round'	=> $round,
    		'file_description'	=> $this->ci->input->post('file_description'),
    	);
		if($_FILES['userfile']['tmp_name'] !== ""){

			$path = 'uploads/submission/manuscript/';
			$cpath = './'.$path.$id;
			if(!is_dir($cpath))
				mkdir($cpath, 0777);

			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);			
			$fileName = $this->ci->lib_view->gen_manuscript_name($id).'.'.$ext;
			$config['file_name'] = $fileName;
			$config['overwrite'] = true;
			$config['upload_path'] = $cpath;
			$config['max_size'] = '10240'; # Max size 10 MB
			$config['allowed_types'] = 'doc|docx|DOC|DOCX';

			if ($type == 0){ //graphical abstract
				$path = 'uploads/submission/attachment/';
				$cpath = './'.$path.$id;
				if(!is_dir($cpath))
					mkdir($cpath, 0777);
				
				$config['upload_path'] = $cpath;
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = '2048'; # Max size 2 MB
			}
			if ($type == 3){ //supp
				$path = 'uploads/submission/attachment/';
				$cpath = './'.$path.$id;
				if(!is_dir($cpath))
					mkdir($cpath, 0777);
				
				$config['upload_path'] = $cpath;
				$config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docx|pdf';
				$config['max_size'] = '2048'; # Max size 2 MB
			}

			if ($type == 2)
				$config['allowed_types'] = 'pdf|PDF';
			
			if ($type == 4){
				$config['allowed_types'] = 'pdf|PDF';
				$fileName = "Response_letter_".$fileName;
				$config['file_name'] = $fileName;
			}

			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('invalid','Trouble uploading file.<br/>'.$msg);
			}else{
				$data['file_url'] = $cpath.'/'.$fileName;
				$act = $this->ci->cms->insert('submission_file', $data);
				if($act){
					$this->log('Upload file submission : '.$fileName, 'submission_file', $id);
					$this->ci->session->set_flashdata('success','File succeessfully uploaded.');
				}
		    	else $this->ci->session->set_flashdata('error','Trouble while uploading file.');
			}
		}
		redirect('dashboard/create/suplement/'.$id);
	}

	public function delete_suplement_file($id, $id2){
		if($this->ci->input->post('sub_id') !== "")
			$id = $this->ci->input->post('sub_id');
		
		if($this->ci->input->post('sf_id') !== "")
			$id2 = $this->ci->input->post('sf_id');

		$page = $this->ci->input->post('page');

		$url = $this->ci->cms->current_suplement_file($id2);
		if (file_exists('./'.$url[0]['file_url']))
			unlink('./'.$url[0]['file_url']);

		$act = $this->ci->cms->delete('submission_file', array('sf_id', $id2));
		if($act){
			$this->log('Delete submission file','submission_file', $id2);
			$this->ci->session->set_flashdata('success','File succeessfully deleted.');
		}
    	else $this->ci->session->set_flashdata('error','Trouble while deleting file.');
    	if($page !== "")
    		redirect($page);
    	else	
    		redirect('dashboard/create/suplement/'.$id);
	}

	# remove funder 
	public function delete_funder(){
		$page = $this->ci->input->post('page');
		$id = $this->ci->input->post('sfunder_id');
		$act = $this->ci->cms->delete('submission_funder', array('sfunder_id', $id));
		if($act)
			$this->ci->session->set_flashdata('success','Funder has been deleted.');
		else $this->ci->session->set_flashdata('danger','Trouble removing data.');
		redirect($page);
	}


	# insert athor submission/article
	public function insert_author(){
		$id = $this->ci->input->post('sub_id');
		$tot = $this->ci->cms->count_author_submission($id);
		$data = array(
			'sub_id'	=> $id,
			'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
			'first_name'	=> $this->ci->security->xss_clean($this->ci->input->post('first_name')),
			'last_name'	=> $this->ci->security->xss_clean($this->ci->input->post('last_name')),
			'email'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
			'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
			'short_biography'	=> $this->ci->security->xss_clean($this->ci->input->post('short_biography')),
			'country'	=> $this->ci->input->post('country'),
			'sort'	=> $tot+1
		);
		$act = $this->ci->cms->insert('submission_author', $data);
		if($act){
			$this->log('Add author into submission with id : '.$id, 'submission_author', $id);
			$this->ci->session->set_flashdata('success','Author has been added to this article.');
		}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
		redirect('dashboard/create/author/'.$id);			
	}

	# delete author
	public function delete_author($id, $id2, $migrate = false){
		$act = $this->ci->cms->delete('submission_author', array('sa_id', $id2));
		if($act){
			$this->log('Delete submission athor','submission_author', $id2);
			$this->ci->session->set_flashdata('success','Author succeessfully deleted.');
		}
    	else $this->ci->session->set_flashdata('error','Trouble while deleting author.');
    	if($migrate)
    		redirect('dashboard/migrate/'.$id.'/authors');
    	else
    		redirect('dashboard/create/author/'.$id);
	}

	# insert reviewer submission/article
	public function insert_reviewer(){
		$page = $this->ci->input->post('page');
		$id = $this->ci->input->post('sub_id');
    
    //cek apakah email ini udah ada di tabel submission_reviewer
    $existingreviewer = $this->ci->db->where('sub_id',$id)->where('email',$this->ci->security->xss_clean($this->ci->input->post('email')))->get('submission_reviewer')->result_array();
    if(count($existingreviewer)>0){ //pake count_all_results gimana?
      $this->ci->session->set_flashdata('warning','Reviewer with this email address is already added.');
      redirect('dashboard/create/reviewer/'.$id);
    }
    
    //cek apakah di tabel user udah ada email ini atau belum
    $reviewer = $this->ci->cms->get_user_from_mail( $this->ci->security->xss_clean($this->ci->input->post('email')) );
    if($reviewer){
      if($reviewer[0]['suggested_expertise'] != ""){ $suggested_expertise	= $reviewer[0]['suggested_expertise'].', '.$this->ci->security->xss_clean($this->ci->input->post('expertise')); }
      else{ $suggested_expertise = $this->ci->security->xss_clean($this->ci->input->post('expertise')); }
      
      if($reviewer[0]['suggested_affiliation'] != ""){ $suggested_affiliation	= $reviewer[0]['suggested_affiliation'].'; '.$this->ci->security->xss_clean($this->ci->input->post('affiliation')); }
      else{ $suggested_affiliation = $this->ci->security->xss_clean($this->ci->input->post('affiliation')); }
      
      if($reviewer[0]['status']==1){$status=1;}else{$status=$reviewer[0]['status']-1;}
      
      $data2 = array(
        'suggested_expertise'	=> $suggested_expertise,
        'suggested_affiliation'	=> $suggested_affiliation,
        'status' => $status,
        'date_update'	=> date('Y-m-d H:i:s'),
      );
      $act2 = $this->ci->cms->update('users', array('email',$reviewer[0]['email']), $data2); //ruki2
      
      // cara agak njelimet (ada cara yg gampang?) buat nambahin koma. //ruki2
      $expertise = $reviewer[0]['expertise'];
      $this->ci->security->xss_clean($this->ci->input->post('expertise'));
      if($expertise!=""){
        if($reviewer[0]['suggested_expertise'] != ""){
          $expertise = $expertise .', '.$reviewer[0]['suggested_expertise'];
        }
        if($this->ci->security->xss_clean($this->ci->input->post('expertise')) != ""){
          $expertise = $expertise .', '.$this->ci->security->xss_clean($this->ci->input->post('expertise'));
        }
      }else{
        if($reviewer[0]['suggested_expertise'] != ""){
          $expertise = $reviewer[0]['suggested_expertise'];
        }
        if($this->ci->security->xss_clean($this->ci->input->post('expertise')) != ""){
          if($expertise != ""){
            $expertise = $expertise .', '.$this->ci->security->xss_clean($this->ci->input->post('expertise'));
          }else{
            $expertise = $this->ci->security->xss_clean($this->ci->input->post('expertise'));
          }
        }
      }
      
      $affiliation = $reviewer[0]['affiliation'];
      $this->ci->security->xss_clean($this->ci->input->post('affiliation'));
      if($affiliation!=""){
        if($reviewer[0]['suggested_affiliation'] != ""){
          $affiliation = $affiliation .'; '.$reviewer[0]['suggested_affiliation'];
        }
        if($this->ci->security->xss_clean($this->ci->input->post('affiliation')) != ""){
          $affiliation = $affiliation .'; '.$this->ci->security->xss_clean($this->ci->input->post('affiliation'));
        }
      }else{
        if($reviewer[0]['suggested_affiliation'] != ""){
          $affiliation = $reviewer[0]['suggested_affiliation'];
        }
        if($this->ci->security->xss_clean($this->ci->input->post('affiliation')) != ""){
          if($affiliation != ""){
            $affiliation = $affiliation .'; '.$this->ci->security->xss_clean($this->ci->input->post('affiliation'));
          }else{
            $affiliation = $this->ci->security->xss_clean($this->ci->input->post('affiliation'));
          }
        }
      }
      
      $data = array(
        'sub_id'	=> $id,
        'user_id'	=> $this->ci->security->xss_clean($this->ci->session->userdata('user_id')),
        'salutation'	=> $reviewer[0]['salutation'],
        'fullname'	=> $reviewer[0]['first_name'].' '.$reviewer[0]['last_name'], //ruki2
        'email'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
        'expertise'	=> $expertise,
        'affiliation'	=> $affiliation,
      );
      $act = $this->ci->cms->insert('submission_reviewer', $data);
    }else{
      $data3 = array(
        'user_id'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
        'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
        'first_name'	=> $this->ci->security->xss_clean($this->ci->input->post('first_name')),
        'last_name'		=> $this->ci->security->xss_clean($this->ci->input->post('last_name')),				
        'email'		=> $this->ci->security->xss_clean($this->ci->input->post('email')),
        'expertise'	=> $this->ci->security->xss_clean($this->ci->input->post('expertise')),
        'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
        'status'	=> -1,
        'date_create'	=> date('Y-m-d H:i:s'),
        'date_update'	=> date('Y-m-d H:i:s'),
      );
      $act3 = $this->ci->cms->insert('users', $data3); //ruki2
      
      $data = array(
        'sub_id'	=> $id,
        'user_id'	=> $this->ci->security->xss_clean($this->ci->session->userdata('user_id')),
        'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
        'fullname'	=> $this->ci->security->xss_clean($this->ci->input->post('first_name')).' '.$this->ci->security->xss_clean($this->ci->input->post('last_name')), //ruki2
        'email'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
        'expertise'	=> $this->ci->security->xss_clean($this->ci->input->post('expertise')),
        'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
      );
      $act = $this->ci->cms->insert('submission_reviewer', $data);
    }

		if($act){
			$this->log('Add suggested reviewer into submission with id : '.$id, 'submission_reviewer', $id);
		}
    if($act2){
      // $this->log('Merge reviewer into users list','users',??);
			$this->ci->session->set_flashdata('success','Reviewer is merged with existing reviewer data.');
    }elseif($act3){
      // $this->log('Add reviewer into users list');
			$this->ci->session->set_flashdata('success','Reviewer has been added.');
    }else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    if(isset($page))
      redirect($page);
    else
      redirect('dashboard/create/reviewer/'.$id);
	}

	public function delete_reviewer($id, $id2){
		$r = $this->ci->db->select('email')->where('sr_id',$id2)->get('submission_reviewer')->result_array(); //ruki2
    $act = $this->ci->cms->delete('submission_reviewer', array('sr_id', $id2));
		if($act){
			$this->log('Delete submission reviewer','submission_reviewer', $id2);
			$this->ci->session->set_flashdata('success','Reviewer succeessfully deleted.');
      
      //ruki2: kolom status di tabel users: 1=bisa dipake buat login. 0=ga bisa. -1=gabisa login dan disuggest di 1 submission. -9=gabisa login dan disuggest di 9 submission
      $revwr = $this->ci->cms->get_user_from_mail($r[0]['email']);
      if($revwr[0]['status']==0 || $revwr[0]['status']==-1){
        $this->ci->cms->delete('users', array('email', $r[0]['email']));
      }elseif($revwr[0]['status']<0){
        $data = array('status' => $revwr[0]['status']+1);
        $this->ci->cms->update('users', array('email', $r[0]['email']), $data);
      }
      
		}else{
      $this->ci->session->set_flashdata('error','Trouble while deleting reviewer.');
    }
    redirect('dashboard/create/reviewer/'.$id);
	}
	
	public function insert_agreement(){
		$sub_id = $this->ci->input->post('sub_id');
		$author = $this->ci->cms->get_corresponding_author($sub_id);
		$sub = $this->ci->cms->current_submission($sub_id);
		
		//$this->ci->load->library('email'); # load email library

		$pass_eic = $this->ci->cms->is_pass_screening_by_eic($sub_id);
		$CI =& get_instance();
		$jmlReviewerDone = $CI->db->query("select count(*) c
			from submission_review
			where review_result is not null
			and sub_id = ?",[$sub_id])->row()->c; //2021jul25: membedakan submission baru, revisi pada tahap screening, revisi pada tahap review
		if (count($author) > 0){
			$data = array(
				'date_submit' => date('Y-m-d H:i:s'),
				'sub_status' => $jmlReviewerDone > 0 ? 2 : ($pass_eic ? 2 : 1), //bukan ke 4 melainkan 2 krn harus ada action by sekre utk membuat keputusan (apakah lanjut round berikutnya atau tidak)
			);
			$act = $this->ci->cms->update('submission', array('sub_id', $sub_id), $data);
			if($act){				
				# confirm reminder
				if(true){
					$this->ci->load->model('Mdl_reminder','reminder');
					$this->ci->reminder->cofirm_reminder($sub_id, $author[0]['email'], 1);
				}
				
				if($jmlReviewerDone>0){ //submission ini sudah memiliki komentar review --> yg disubmit adalah revisi atas komentar reviewer
					$this->log_submission($sub_id, 4,'Revision submitted. Now waiting for next review round to be started.');
				}else{ //yg disubmit adalah paper baru atau paper yg disuruh revisi pada tahap screening
					if($pass_eic){
						$this->log_submission($sub_id, 2,'Submit manuscript'); //put back at screening by sekre
					}else{
						$this->log_submission($sub_id, 1,'Submit manuscript'); //put back at screening by eic
					}
					//2021jun28: cari tau siapa yg memberikan keputusan screening terakhir yg menyatakan revise(2) atau reject(3), apakah sekre atau eic
					// $isLastScreenDecisionBySekre = $this->db->query("select count(*) c from roleuser where user_id = (
					// 	select user_id
					// 	from submission_screening
					// 	where sub_id = ?
					// 	and status > 1
					// 	order by screening_id desc
					// 	limit 1
					// 	)
					// 	and role_id < 3",[$sub_id])->row()->c; //bila c=0 berarti eic. bila c=1 berarti sekre
					// if($isLastScreenDecisionBySekre==1){ //dari sekre, maka kembalikan statusnya ke screening by sekre
					// 	$this->log_submission($sub_id, 2,'Submit manuscript'); //put back at screening by sekre
					// }else{
					// 	$this->log_submission($sub_id, 1,'Submit manuscript'); //put back at screening by eic
					// }					
				}

				$this->log('Submit journal','submission', $sub_id);
				# send mail to all related author
				$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
				$msg_author = array();
				foreach ($author as $a) {
					$data = array(
						'journal_id' => $journal_id,
						'journal'	=> $sub,
						'author'	=> $a
					);
					$email = $a['email'];
					if($email){
						$this->ci->db->set(array(
							'to' => $email,
							'subject' => '[IJTech] Manuscript Submission Notification for #'.$journal_id,
							'body' => $this->ci->load->view('template/mailer/author/submission_confirmation', $data, TRUE),
							'time' => date('Y-m-d H:i:s')
						))->insert('sendmail_log');
						//TODO:
						//Manuscript #xxx successfully submitted
						//Revision for #xxx successfully submitted
						//Resubmission for #xxx successfully conducted
						$this->log('Email for corresponding author queued: '.$email, 'submission_author', $a['sa_id']);
						array_push($msg_author, $a['salutation'].' '.$a['first_name'].' '.$a['last_name']);
					}
				}

				# send to editors
				if ($pass_eic && $sub[0]['round'] == 1){
					# insert submission_screening					
					$pass = array('sub_id' => $sub_id, 'user_id' => $this->ci->session->userdata('user_id'), 'round' => 1, 'status'	=> 1, 'section_id'	=> 0);
					$this->ci->db->insert('submission_screening', $pass);
				}else{
					$authors = $this->ci->cms->get_author_submission($sub_id);
					$authors_string = '';
					foreach($authors as $a){
						$authors_string = $a['salutation'].' '.$a['first_name'].' '.$a['last_name'].' ('.$a['email'].'), ';
					}
					$authors_string = trim($authors_string);
					$authors_string = trim($authors_string,',');
					$editor = $this->ci->cms->get_section_editor($sub[0]['section_id']);
					foreach ($editor as $e) {
						$data = array(
							'journal_id' => $journal_id,
							'journal_section' => $sub[0]['section_title'],
							'manuscript_title' => $sub[0]['sub_title'], //ruki4march2019
							'authors_string' => $authors_string,
							'manuscript_abstract' => $sub[0]['abstract'],
							'editor' => $e
						);
						if($jmlReviewerDone > 0){
							$this->ci->db->set(array(
								'to' => 'ijtech@eng.ui.ac.id', //tadinya $e['email'] alias ke semua eic
								'subject' => '[IJTech] Revision for #'.$journal_id.' is submitted',
								'body' => 'Dear editor in charge,<br><br>Author for manuscript #'.$journal_id.' has submitted a revision.<br>Please go to <a href="'.base_url('dashboard/detail/submission/'.$sub_id).'">'.base_url('dashboard/detail/submission/'.$sub_id).'</a> to check it, then please give a decision or start the next review round if necessary.<br><br>Thank you',
								'time' => date('Y-m-d H:i:s')
							))->insert('sendmail_log'); //2021jul26
						}else{
						    $cntAgreeToRevise = $this->ci->db->query("select count(*) c from submission_log_status where sub_status = 7 and sub_id = ?",[$sub[0]['sub_id']])->row()->c;
						    if($cntAgreeToRevise > 0){
                                $jdl = '[IJTech] Resubmission of #'.$journal_id.' needs initial Screening';
						    }else{
						        $jdl = '[IJTech] New Submission needs Initial Screening by EiC: #'.$journal_id;
						    }
                            $this->ci->db->set(array(
								'to' => $e['email'],
								'subject' => $jdl,
								'body' => $this->ci->load->view('template/mailer/editor/new_submission', $data, TRUE),
								'time' => date('Y-m-d H:i:s')
							))->insert('sendmail_log');							
						}
						$this->log('Email for EiC queued: '.$email, 'submission_author', $a['sa_id']);
					}
				}

				if(!empty($msg_author)){
					$this->ci->session->set_flashdata('success','Article submitted.<br/>Notification email have been sent to corresponding authors and Editors in charge for your chosen section.'); //.<br/>'.implode(', ', $msg_author));				//ruki2
				}else{
					$this->ci->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 0)); 
					$this->ci->session->set_flashdata('warning','Trouble sending submission. Please check your internet connection.');
				}
			}
	    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');

	    	redirect('dashboard/create/agreement/'.$sub_id);
		}else{
			$this->ci->session->set_flashdata('warning','Please add the author at least one.');
	    	redirect('dashboard/create/author/'.$sub_id);
		}
	}

	public function save_decision(){
		$id = $this->ci->input->post('sub_id');
		$status = $this->ci->input->post('sub_status');
		$other = $this->ci->input->post('other');
		$reason = array();
		for ($a=0; $a < 5; $a++){
			$name = 'r'.$a;
			if ($this->ci->input->post($name))
				array_push($reason, $this->ci->input->post($name));
		}
		if($other !== "")
			array_push($reason, "<br/><i>".$other."</i>");
		$data = array(
			'sub_status' => $status,
			'similarity_rate'	=> $this->ci->input->post('similarity_rate'),
		);
		if($status == 10)
			$data['reason_back'] = !empty($reason) ? implode(',', $reason):'';

		# set reminder to author revision
		$author = $this->ci->cms->get_corresponding_author($id);
		if($status == 7){
			$set_reminder = array(
				'sub_id' => $id,
				'type'	=> 1,
				'date_set'	=> date('Y-m-d H:i:s'),				
				'date_remind'	=> date('Y-m-d H:i:s', strtotime('+'.DAY_REVISE_SCREENING.' days')),
				'email_destination'	=> $author[0]['email'],
			);
			$data['round'] = 2;
		}

		$act = $this->ci->cms->update('submission', array('sub_id', $id), $data);
		if($act){
			$this->ci->cms->insert('reminder', $set_reminder);
			$this->log_submission($sub_id, $status,'');
			$this->ci->session->set_flashdata('success','Decision for this submission has been saved.');
		}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/detail/submission/'.$id);
	}

	public function update_reviewer(){
		$id = $this->ci->input->post('sr_id');
		$sub_id = $this->ci->input->post('sub_id');
		$data = array(
			'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
			'fullname'	=> $this->ci->security->xss_clean($this->ci->input->post('fullname')),
			'email'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
			'expertise'	=> $this->ci->security->xss_clean($this->ci->input->post('expertise')),
			'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
		);
		$act = $this->ci->cms->update('submission_reviewer', array('sr_id', $id), $data);
		if($act){
			$this->log('Update reviewer','submission_reviewer', $id);
			$this->ci->session->set_flashdata('success','Reviewer has been updated.');
		}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/create/reviewer/'.$sub_id);
	} 

	public function update_author(){
		$id = $this->ci->input->post('sa_id');
		$sub_id = $this->ci->input->post('sub_id');
		$data = array(
			'salutation'	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
			'first_name'	=> $this->ci->security->xss_clean($this->ci->input->post('first_name')),
			'last_name'	=> $this->ci->security->xss_clean($this->ci->input->post('last_name')),
			'email'	=> $this->ci->security->xss_clean($this->ci->input->post('email')),
			'scopus_id'	=> $this->ci->security->xss_clean($this->ci->input->post('scopus_id')),
			'country'	=> $this->ci->security->xss_clean($this->ci->input->post('country')),
			'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
			'short_biography'	=> $this->ci->security->xss_clean($this->ci->input->post('short_biography')),
		);
		$act = $this->ci->cms->update('submission_author', array('sa_id', $id), $data);
		if($act){
			$this->log('Update author','submission_author', $id);
			$this->ci->session->set_flashdata('success','Author has been updated.');
		}
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect('dashboard/create/author/'.$sub_id);
	} 

	public function update_reviewer_status($sub_id=0,$sr_id=0,$status=0){ // ruki -- status: 0: baru ditambahkan sbg candidate reviewer; 1: agree to do review; 2: invited and waiting confirmation; 3: invited and decline; 4: removed (di database ga ada status = 4)
		$sub_id = $sub_id != 0 ? $sub_id : $this->ci->input->post('sub_id');
		$sr_id = $sr_id != 0 ? $sr_id : $this->ci->input->post('sr_id');
		$status = $status != 0 ? $status : $this->ci->input->post('status');
		$sub = $this->ci->cms->current_submission($sub_id);
		$editor = $this->ci->cms->get_section_editor($sub[0]['section_id']);
		$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
		$tmp = $this->ci->cms->get_current_reviewer($sr_id);
		$email = $tmp[0]['email'];
        //die($email); //ruki3
		if($status == 2){ //status is changed to 2. artinya kita baru aja invite (statusnya berubah menjadi waiting confirmation)
			$data = array(
				'journal' => $sub,
				'journal_id'=> $journal_id,
				'editor'	=> $editor,
				'reviewer'	=> $this->ci->cms->get_current_reviewer($sr_id),
				'accepted'	=> site_url().'invitation/'.$sub_id.'/'.$sr_id.'/1/liame',
				'refused'	=> site_url().'invitation/'.$sub_id.'/'.$sr_id.'/2/liame',
			);
			$reviewerAccount = $this->ci->cms->get_user_from_mail($email); //I want to check if reviewer's account is active or not (dont have password yet)
			//echo '<pre>';print_r($reviewerAccount);die();
			if($reviewerAccount[0]['status']!=1){ //if this reviewer's account is inactive
			    //TODO: ?
			}
			$message = $this->ci->load->view('template/mailer/reviewer/reviewer_invitation', $data, TRUE);
			// $this->ci->load->library('email'); # load email library
			// $this->ci->email->from(MAILSYSTEM, 'IJTech');
			// $this->ci->email->to($email);
			// $this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
			// $this->ci->email->subject('[IJTech] Reviewer Invitation');
			// $this->ci->email->message($message);
			// if($this->ci->email->send()){
			
			$this->ci->db->set(array(
				'to' => $email,
				'subject' => '[IJTech] Reviewer Invitation',
				'body' => $message,
				'time' => date('Y-m-d H:i:s')
			))->insert('sendmail_log');
			
			if(true){
				# set reminder invitation				
				$set_reminder = array(
					'sub_id' => $sub_id,
					'type'	=> 2,
					'date_set'	=> date('Y-m-d H:i:s'),
					'date_remind'	=> date('Y-m-d H:i:s', strtotime('+'.DAY_TO_ACCEPT_REVIEW.' days')),
					'email_destination'	=> $email
				);
				$this->ci->cms->insert('reminder', $set_reminder);	

				if($status==2){
					$this->ci->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status' => $status , 'date_invite'=> date('Y-m-d H:i:s')));
				}else{ //status==1(agree) or 2(decline)
					$this->ci->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status' => $status , 'date_respond'=>date('Y-m-d H:i:s')));
				}
				$check = $this->ci->cms->check_count_reviewer_assign($sub_id);
				if($check > 1){
					$this->log('Sending email to reviewer to : '.$email,'submission_reviewer', '', $data['reviewer'][0]['sr_id']);
					$this->log_submission($sub_id, 3 ,'');
					if($sub[0]['sub_status'] < 3){
					    $update = $this->ci->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 3));
					}
					//if($update)
						$this->ci->session->set_flashdata('success','Invitation email has been sent. Article status is now "Review Assignment"'); //ruki2
					//else // --> bisa masuk ke sini bila update gagal karena sub_status nya sudah = 3
						//$this->ci->session->set_flashdata('warning','Trouble sending invitation email.'); //ruki2
				}else
					$this->ci->session->set_flashdata('success','Invitation email has been sent.'); //ruki2
			}else{ $this->ci->session->set_flashdata('error','Mail server busy. Please try again later.');} //ruki2
    		
		}elseif($status == 4){ //ruki
      $act = $this->ci->cms->delete('submission_reviewer', array('sr_id', $sr_id)); //ruki2
      if($act){
        $this->ci->session->set_flashdata('success','Candidate reviewer has been removed.');
      }else $this->ci->session->set_flashdata('error','Trouble deleting candidate reviewer.');
    }else{
			$this->ci->cms->update('submission_reviewer', array('sr_id', $sr_id), array('status' => $status));
			$this->ci->session->set_flashdata('success','Reviewer declined the invitation.'); //ruki2
		}
    redirect('dashboard/detail/submission/'.$sub_id);
	}

	# funders
	public function insert_funder(){
		$page = $this->ci->input->post('page');
		$data = array(
			'sub_id'	=> $this->ci->input->post('sub_id'),
			'funder_name' => $this->ci->security->xss_clean($this->ci->input->post('funder_name')),
			'funder_desc' => $this->ci->security->xss_clean($this->ci->input->post('funder_desc')),
			'award_number' => $this->ci->security->xss_clean($this->ci->input->post('award_number'))
		);
		$act = $this->ci->cms->upsert_funder($data);
		if($act)
			$this->ci->session->set_flashdata('success','Submissio funder has been added.');
    	else $this->ci->session->set_flashdata('error','Trouble while saving data.');
    	redirect($page);
	}

	public function sort_author(){
		$page = $this->ci->input->post('page');
		$id = $this->ci->input->post('id');
		$sort = $this->ci->input->post('sort');
		$act = $this->ci->cms->update('submission_author', array('sa_id', $id), array('sort' => $sort));
		if ($act)
			return true;
		else
			return false;
	}
	
	/**
	 * module review process
	 */
	public function insert_review(){
		$review_id = $this->ci->input->post('review_id');
		$sub_id = $this->ci->input->post('sub_id');
		$page = $this->ci->input->post('page');
		$email = $this->ci->session->userdata('email');
		$point = array('Originality','Technical','Methodology','Readability','Practicability','Organization','Importance');
		$data = array(
			'sub_id' => $sub_id,
			'reviewer_email' => $this->ci->input->post('reviewer_email'),
			'review_type'	=> 0,
			'introduction_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('introduction_c')),
			'methodology_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('methodology_c')),
			'result_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('result_c')),
			'discussion_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('discussion_c')),
			'references_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('references_c')),
			'other_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('other_c')),
			'additional_comment'	=> $this->ci->security->xss_clean($this->ci->input->post('additional_c')),
			'date_review'	=> date('Y-m-d H:i:s'),
            'canInviteAgain' => $this->ci->security->xss_clean($this->ci->input->post('canInviteAgain')), //Ruki6sep2020
            'canListAck' => $this->ci->security->xss_clean($this->ci->input->post('canListAck')), //Ruki6sep2020
			'review_result' => $this->ci->input->post('review_result') //Ruki30jul2019
		);
		$point_ = "";
		$style_ = "style='color:#999'";
		$v_ = ["Poor","Fair","Average","Above","Average","Excellent"];
		for($a=0; $a<count($point); $a++){
			$data[strtolower($point[$a])] =  $this->ci->input->post(strtolower($point[$a]));
			$point_ .= "<li>".$point[$a].": <i ".$style_.">".$v_[$this->ci->input->post(strtolower($point[$a]))]."</i></li>";
		}
		switch($this->ci->input->post('review_result')){
		    case "1":
		        $decision_ = "Accept";break;
		    case "2":
		        $decision_ = "Revise";break;
		    case "3":
		        $decision_ = "Reject";
		}
		$comments_ = "
        <ol> <li>Comment for Introduction section: <i ".$style_.">".$this->ci->security->xss_clean($this->ci->input->post('introduction_c'))."</i>
        </li><li>Comment for Methodology section: <i ".$style_.">".$this->ci->security->xss_clean($this->ci->input->post('methodology_c'))."</i>
        </li><li>Comment for Results and Discussion section: <i ".$style_.">".$this->ci->security->xss_clean($this->ci->input->post('result_c'))."</i>
        </li><li>Comment for Bibliography/References section: <i ".$style_.">".$this->ci->security->xss_clean($this->ci->input->post('references_c'))."</i>
        </li><li>Comment for other section (if any): <i ".$style_.">".$this->ci->security->xss_clean($this->ci->input->post('other_c'))."</i>
        </li>".$point_."
        <li>Other Comment (if any): <i ".$style_.">".$this->ci->security->xss_clean($this->ci->input->post('additional_c'))."</i>
        </li><li>Suggested Decision: <i ".$style_.">".$decision_."</i>
        </li></ol>";

		if($_FILES['userfile']['tmp_name'] !== ""){
			$config['upload_path'] = './uploads/review/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '10240'; # Max size 10 MB
			$config['overwrite'] = true;
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$fileName = "reviewer_attachment_".$review_id.'.'.$ext;
			$config['file_name'] = $fileName;

			$path = 'uploads/review/';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('error','Trouble attach file.<br/>'.$msg);
				$this->ci->session->set_flashdata('message','Upload Failed, please select PDF file.');
				redirect($page);
			}else{
				$data['review_url'] = $path.$fileName;
			}
		}
		$upd = $this->ci->cms->update('submission_review', array('review_id', $review_id), $data);
		if($upd){
			# send mail feedback
			$sub = $this->ci->cms->current_submission($sub_id);
			$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
			$editor = $this->ci->cms->get_section_editor($sub[0]['section_id']);
			$data = array(
				'journal' => $sub,
				'journal_id'=> $journal_id,
				'editor'	=> $editor,
				'reviewer'	=> $this->ci->cms->get_user_reviewer($review_id),
				'comments' => $comments_
			);
			/*
			$message = $this->ci->load->view('template/mailer/reviewer/after_reviewing', $data, TRUE);
			$this->ci->load->library('email'); # load email library
			$this->ci->email->from(MAILSYSTEM, 'IJTech');
			$this->ci->email->to($data['reviewer'][0]['email']);
			$this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
			$this->ci->email->subject('[IJTech] Thank you for your review on manuscript #'.$journal_id);
			$this->ci->email->message($message);
			$msg = "Thank you for reviewing manuscript.";
			if(!$this->ci->email->send()){
				$msg = "Trouble sending mail notification.";
			}
			*/
			$msg = "Thank you for reviewing manuscript."; //ga tau ini kepake apa nggak
			$this->ci->db->set(array( //ruki 2021-07-25: supaya semua tercatat di sendmail_log
				'to' => $data['reviewer'][0]['email'],
				'subject' => '[IJTech] Thank you for your review on manuscript #'.$journal_id,
				'body' => $this->ci->load->view('template/mailer/reviewer/after_reviewing', $data, TRUE),
				'time' => date('Y-m-d H:i:s')
			))->insert('sendmail_log');
			
			# confirm reminder
			$this->ci->load->model('Mdl_reminder','reminder');
			$this->ci->reminder->cofirm_reminder($sub_id, $data['reviewer'][0]['email'], 3); //turn off reminder kah?

            if($sub[0]['sub_status']==4){ //ruki 25jan2021: agar kalo udh "accepted" tidak balik ke "review received" lagi
			    $this->ci->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 5)); //set status artikel menjadi "review received"
			    $this->log_submission($sub_id, 5, 'Reviewer done reviewing');
            }else{
                $this->log_submission($sub_id, $sub[0]['sub_status'], 'Reviewer done reviewing');
            }
			
			// $check = $this->ci->cms->check_count_review($sub_id, $round); //ambil jumlah reviewer yg udah kerja utk paper ini
			// if($check > 0){ //kalo ada reviewer yg udah ngerjain
			// 	$data = array('sub_status' => 5); //set status artikel menjadi "review received"
			// 	$set = $this->ci->cms->update('submission', array('sub_id', $sub_id), $data);
			// 	if($set) $this->log_submission($sub_id, 5, '');
			// }
			$this->ci->session->set_flashdata('success','Done. Thank you for your contribution.');
		}else{
			$this->ci->session->set_flashdata('error','Trouble saving review data.');
		}
		
		//update status
		
		//redirect(str_replace('/online','', $page));
		redirect('dashboard/review/'.$sub_id.'/'.$review_id);  //Ruki30jul2019
	}

	public function update_review_status(){ //TODO: function ini dipanggil di controller, tapi controller tsb ga dipanggil oleh view. apa bisa didelete?
		$review_id = $this->ci->input->post('review_id');
		$sub_id = $this->ci->input->post('sub_id');
		$round = $this->ci->input->post('round');
		$result = $this->ci->input->post('review_result');
		$upd = $this->ci->cms->update('submission_review', array('review_id', $review_id), array('review_result'=>$result));
		if($upd){
			# send mail feedback
			$sub = $this->ci->cms->current_submission($sub_id);
			$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
			$editor = $this->ci->cms->get_section_editor($sub[0]['section_id']);
			$data = array(
				'journal' => $sub,
				'journal_id'=> $journal_id,
				'editor'	=> $editor,
				'reviewer'	=> $this->ci->cms->get_user_reviewer($review_id),
			);
			$message = $this->ci->load->view('template/mailer/reviewer/after_reviewing', $data, TRUE);
			/*
			$this->ci->load->library('email'); # load email library
			$this->ci->email->from(MAILSYSTEM, 'IJTech');
			$this->ci->email->to($data['reviewer'][0]['email']);
			$this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
			$this->ci->email->subject('[IJTech] Thank you for your review on manuscript #'.$journal_id);
			$this->ci->email->message($message);
			$msg = "Thank you for reviewing manuscript.";
			if(!$this->ci->email->send())
				$msg = "Trouble sending mail notification.";
			*/
			$msg = "Thank you for reviewing manuscript."; //ini ga tau kepake apa ngga
			$this->ci->db->set(array( //ruki 2021-07-25: supaya semua tercatat di sendmail_log
				'to' => $data['reviewer'][0]['email'],
				'subject' => '[IJTech] Thank you for reviewing manuscript #'.$journal_id,
				'body' => $this->ci->load->view('template/mailer/reviewer/after_reviewing', $data, TRUE),
				'time' => date('Y-m-d H:i:s')
			))->insert('sendmail_log');

			# confirm reminder
			$this->ci->load->model('Mdl_reminder','reminder');
			$this->ci->reminder->cofirm_reminder($sub_id, $data['reviewer'][0]['email'], 3);

			$check = $this->ci->cms->check_count_review($sub_id, $round);
			$this->log_submission($sub_id, 100, 'jml review yg udh kerja = '.$check); //tambahan utk debug
			if($check > 0){
				$data = array('sub_status' => 5);
				$set = $this->ci->cms->update('submission', array('sub_id', $sub_id), $data);
				if($set) $this->log_submission($sub_id, 5, '');
				else $this->ci->session->set_flashdata('warning','Trouble updating submission status.');
			}else{			
				$this->ci->session->set_flashdata('success','The review has been saved.<br/>'.$msg);	//ruki24aug2018
			}
		}else
			$this->ci->session->set_flashdata('error','Trouble Saving journal review.');

		redirect('dashboard/review/'.$sub_id.'/'.$review_id);
	}

	
	public function submission_screening(){
/*
yg disubmit oleh eic utk mengakhiri screeningnya:
- sub_id
- round
- author
- page
- status (1: accept, 2:revise, 3:reject)
- c_section
- section_id
- notes_for_secretariat
- reasons (r1,r2...)
- other
- revise_days

yg disubmit oleh sekret utk mengakhiri screeningnya:
- semua field eic kecuali notes_for_secretariat
- screening_id
- from_eic
- similarity_rate
- userfile
*/

        
        
		$page = $this->ci->input->post('page');
		$data['sub_id'] = $this->ci->security->xss_clean($this->ci->input->post('sub_id'));
		if ($this->ci->input->post('section_id')>0){
		    $data['section_id'] = $this->ci->security->xss_clean($this->ci->input->post('section_id'));
		    echo $data['section_id']."<br>";
		    // Ruki 1nov2022: 
            $oldSecId = $this->ci->db->query("select section_id from submission where sub_id = ?",$data['sub_id'])->row()->section_id;
            if($oldSecId != $data['section_id']){ //pindah section
                //kalo change section, berarti statusnya balik ke screening by EIC lagi (sub_statu=1)
                $this->ci->db->where('sub_id',$data['sub_id'])->update('submission',['section_id'=>$data['section_id']]);
                $this->ci->db->insert('submission_log_status',['sub_id'=>$data['sub_id'],'sub_status'=>1,'log_desc'=>'Screening by EiC done, but move section','date_log'=>date('Y-m-d H:i:s')]);
                //TODO: notify EIC baru
                //$this->ci->cms->update('submission', array('sub_id', $data['sub_id']), array('section_id' => $data['section_id']));
                redirect($page); // done
            }
			// $this->ci->cms->update('submission', array('sub_id', $data['sub_id']), array('section_id' => $data['section_id']));
		}
		// die('Change not saved. Server under high load. Please try again later.<br>');
		// if (null == $this->ci->input->post('status')) // Ruki 20nov2018: hanya change section, tidak bikin decision
		// 	redirect($page); // done
		
		$author = $this->ci->input->post('author');
		
		$data = array(
			'sub_id'	=> $this->ci->security->xss_clean($this->ci->input->post('sub_id')),
			'user_id'	=> $this->ci->session->userdata('user_id'), //pelaku (EiC or Sekre)
			'round'	=> $this->ci->security->xss_clean($this->ci->input->post('round')),
			'status'	=> $this->ci->security->xss_clean($this->ci->input->post('status')), //keputusan dari screening, bukan sub_status
		);
		if ($this->ci->input->post('similarity_rate')) //hanya bila pelakunya secretariat
			$data['similarity_rate'] = $this->ci->security->xss_clean($this->ci->input->post('similarity_rate'));
		if ($this->ci->input->post('notes_for_secretariat')) //hanya bila pelakunya eic
			$data['notes_from_eic'] = $this->ci->security->xss_clean($this->ci->input->post('notes_for_secretariat'));
		
		if ($data['status']==3) //10jun2021 ruki: kalo keputusannya reject, maka baik eic maupun sekre bisa mengirimkan notifikasi
			$data['type'] = 1; // 15des2021 ini bener gak ya?
		
		$revise_days = $this->ci->input->post('revise_days') ? $this->ci->security->xss_clean($this->ci->input->post('revise_days')) : DAY_REVISE_SCREENING;

		//rejection reasons checked from the provided checklist
		$reason = array();
		
		/* ENTAH KENAPA INI GAGAL:
		for ($a=0; $a < 6; $a++){
			$name = 'r'.$a;
			if ($this->ci->input->post($name)) array_push($reason, $this->ci->input->post($name));
		}
		*/
        if ($this->ci->input->post('r1')) array_push($reason, $this->ci->input->post('r1'));
        if ($this->ci->input->post('r2')) array_push($reason, $this->ci->input->post('r2'));
        if ($this->ci->input->post('r3')) array_push($reason, $this->ci->input->post('r3'));
        if ($this->ci->input->post('r4')) array_push($reason, $this->ci->input->post('r4'));
        if ($this->ci->input->post('r5')) array_push($reason, $this->ci->input->post('r5'));
        if ($this->ci->input->post('r6')) array_push($reason, $this->ci->input->post('r6'));
        if ($this->ci->input->post('r7')) array_push($reason, $this->ci->input->post('r7'));
        if ($this->ci->input->post('r8')) array_push($reason, $this->ci->input->post('r8'));
        if ($this->ci->input->post('r9')) array_push($reason, $this->ci->input->post('r9'));
		
		//other rejection reason that are typed manually
		$other = $this->ci->security->xss_clean($this->ci->input->post('other'));
		if($other !== "")
			array_push($reason, "<i>".$other."</i>");
		$data['reason_back'] = !empty($reason) ? implode(';', $reason): '';
		
		$from_eic = $this->ci->input->post('from_eic'); //ini udh terlanjur salah penamaan. bila from_eic = 1, artinya pelakunya adalah secretariat
		$screening_id = $this->ci->input->post('screening_id'); //screening_id sebelumnya (oleh eic). hanya terisi bila pelakunya secretariat

		if($from_eic != 1){ //oleh EiC (ini udh terlanjur salah penamaan alias kebalik)
			$this->log_submission($data['sub_id'], 2, 'Screening by EiC done');
		}
		$act = $this->ci->cms->insert('submission_screening', $data);
		if($act){
			$sts_mail = "Was Accepted";
			$sts = 2;
			$mail = ""; # if accepted no need to send mail

			if($data['status'] == 2){
				$sts_mail = "Need to be revised";
				$sts = 7;
				$subject = "Revise";
				$mail = "initial_revise";
			}
			if($data['status'] == 3){
				$sts_mail = "Was Rejected";
				$sts = 10;
				$subject = "Reject";
				$mail = "initial_reject";
			}
			if($from_eic){ $upd = $this->ci->cms->update('submission', array('sub_id', $data['sub_id']), array('sub_status' => $sts == 2 ? 3 : $sts));
			}else{ $upd = $this->ci->cms->update('submission', array('sub_id', $data['sub_id']), array('sub_status' => $sts)); }

			//update status history
			if($sts == 10){ //reject
				$this->log_submission($data['sub_id'], 10, 'Rejected at initial screening');
			}
			
			//update log_activities
			//$email = $this->ci->session->userdata('email');
			$this->log('Sending email to corresponding author about editor decision manuscript round "'.$data['round'].'", email : '.$email, 'submission_author', $data['author'][0]['email']);						
			
			//create reminder
			if($sts == 7){ //revise
				$set_reminder = array(
					'sub_id' => $data['sub_id'],
					'type'	=> 1,
					'date_set'	=> date('Y-m-d H:i:s'),
					'date_remind'	=> date('Y-m-d H:i:s', strtotime('+'.ceil($revise_days/2).' days')),
					'email_destination'	=> $email
				);
				$this->ci->cms->insert('reminder', $set_reminder);
			}
			
			# upload file hasil similarity check
			/*
			$path = 'uploads/submission/screening/';
			$filename = $data['sub_id'];
			if($_FILES['userfile']['tmp_name'] !== ""){
				$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);			
				$fileName = $filename.'.'.$ext;
				$config['file_name'] = $fileName;
				$config['overwrite'] = true;
				$config['upload_path'] = $path;
				$config['max_size'] = '10240'; # Max size 10 MB
				$config['allowed_types'] = 'pdf';
				
				$this->ci->load->library('upload', $config);
				if(!$this->ci->upload->do_upload()){
				    $msg = $this->ci->upload->display_errors();
				 	$this->ci->session->set_flashdata('invalid','Trouble uploading file.<br/>'.$msg);
				}else{
				     // $data['attach'] = './'.$path.$fileName;   
				    $this->ci->db->set([
				        'sub_id'=>$data['sub_id'],
				        'file_url'=>'./'.$path.$fileName,
				        'type'=>10,
				        'round'=>$data['round'],
				        'file_descriptioon'=>'similarity check result',
				        'date_input'=>date('Y-m-d H:i:s')
				    ])->insert('submission_file');
				}
			}
			*/

			# send mail
			if($mail !== ""){
				$sub =  $this->ci->cms->current_submission($data['sub_id']);
				$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
				$data['status'] = $sts_mail;
				$data['journal_id'] = $journal_id;
				$data['notes'] = $data['reason_back'];
				$data['journal'] = $sub;
				$data['revise_days'] = $revise_days;
				$data['author'] = $this->ci->cms->get_corresponding_author($data['sub_id']);
				$other_author = $this->ci->cms->get_other_author($data['sub_id'], true);
				
				$email = $data['author'][0]['email'];
				$message = $this->ci->load->view('template/mailer/author/'.$mail, $data, TRUE);
				
				$this->ci->db->set(array(
					'to' => $email,
					'subject' => '[IJTech] Result of initial screening for manuscript #'.$journal_id.': '.$subject,
					'body' => $message,
					'time' => date('Y-m-d H:i:s'),
					'parent' => $sub[0]['sub_id']
				))->insert('sendmail_log');
				
				// $this->ci->load->library('email'); # load email library
				// $this->ci->email->from(MAILSYSTEM, 'IJTech');
				// $this->ci->email->to($email);
        // 
				// if(NOTIF_ALL_AUTHOR){
				// 	if(!empty($other_author))
				// 		$this->ci->email->cc(implode(',', $other_author));
				// }
				// // if(isset($data['attach']))
				// // 	$this->ci->email->attach($data['attach']);
				// 
				// $this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
				// $this->ci->email->subject('[IJTech] '.$subject.' initial screening manuscript #'.$journal_id);
				// $this->ci->email->message($message);
				// $this->ci->email->send();
				
				$this->ci->session->set_flashdata('info','Sending email to corresponding author.');
			}else{
				# if accepted 
				$this->ci->session->set_flashdata('success','Succeessfull saving data.');
			}
		}
		redirect($page);
	}

	public function save_editor_decision(){
		$isNotifyAuthor = $this->ci->input->post('isNotifyAuthor'); //ruki 27nov2018
		$isNotifyInvolvedReviewers = $this->ci->input->post('isNotifyInvolvedReviewers'); //ruki 27nov2018
		$page = $this->ci->input->post('page');
		
		$sub_id = $this->ci->security->xss_clean($this->ci->input->post('sub_id'));
		$CI =& get_instance();
		$sub_status = $CI->db->query("select sub_status x from submission where sub_id = ? ",[$sub_id])->row()->x;
		if(in_array($sub_status,[9,10,99])){ //archived(published), arcived(rejected), withdraw
			$this->session->set_flashdata('error','Forbidden because paper is already published, arcived, or withdrawn.');
			redirect($page);
		}
		
		$author = $this->ci->input->post('author');
		$other = $this->ci->security->xss_clean($this->ci->input->post('other'));
		$data = array(
			'sub_id'	=> $sub_id,
			'user_id'	=> $this->ci->session->userdata('user_id'),
			'round'	=> $this->ci->security->xss_clean($this->ci->input->post('round')),
			'status'	=> $this->ci->security->xss_clean($this->ci->input->post('status')),
			'type'	=> 1,
			'reason_back'	=> $other,
		);
		$revise_days = $this->ci->input->post('revise_days') ? $this->ci->input->post('revise_days') : DAY_REVISE_SCREENING;		

		$thedecision = 'Rejected';
		if($data['status'] == 2){
			$thedecision = 'Accepted with revision';
		}else if($data['status']	== 1){
			$thedecision = 'Accepted';
		}
		$rolesPelaku = $this->ci->db->query("select role_id from roleuser where user_id = ?",[$this->ci->session->userdata('user_id')])->result_array();
		$rolesPelaku = array_column($rolesPelaku,'role_id');
		if( (in_array(3,$rolesPelaku)||in_array(4,$rolesPelaku))){ //EiC / editor
			$this->ci->db->set(array(
				'to' => 'ijtech@eng.ui.ac.id',
				'subject' => "[IJTech] EiC has concluded peer review for #".$data['sub_id'],
				'body' => "EiC with username <b>".$data['user_id']."</b> has concluded peer review round ".$data['round']." for paper ID ".$data['sub_id'].".<br>The decision is <b>$thedecision</b>.<br>Note (if any): ".$data['reason_back']."<br>Duration for revision (in days, if any): ".$revise_days."<br><br>Please go to <a href='".base_url("dashboard/detail/submission/".$data['sub_id'])."'>".base_url("dashboard/detail/submission/".$data['sub_id'])."</a> to make a decision to be sent to author.",
				'time' => date('Y-m-d H:i:s'),
				'parent' => $data['sub_id']
			))->insert('sendmail_log');
			$this->ci->session->set_flashdata('success','Your decision is notified to Secretariat. Notification to author is centralized from secretariat only.');
			redirect($page);
		}elseif( (in_array(1,$rolesPelaku)||in_array(2,$rolesPelaku))){ //secretariat / admin
		    
		}else{ //author/reviewer
			$this->ci->session->set_flashdata('error','Not allowed.');
			redirect('dashboard');
		}
		
		$act = $this->ci->cms->insert('submission_screening', $data);
		if($act){
			if($data['status'] == 2){
				$sts_mail = 'Need to be Revised';
				$sts = 7;				
				$this->log_submission($data['sub_id'], 7, 'Revision required');
				$data['round'] = $data['round'];
				$mail = 'decision_revise';
			}
			else if($data['status']	== 1){
				$sts_mail = 'Accepted';
				$sts = 8;
				$this->log_submission($data['sub_id'], 8, 'Accepted'); //ruki 2021-01-20? ini udh ada di sini, tapi paper 3537 yg sudah accepted tetep submission_log_status nya yg terakhir adalah 5, bukan 8?
				$mail = 'decision_accept';
			}
			
			else{
				$sts_mail = 'Rejected';
				$sts = 10;	
				$mail = 'decision_reject';
				$this->log_submission($data['sub_id'], 10, 'Rejected');
			} 
			
			$data['review_result'] = $this->ci->cms->get_review_submission($data['sub_id'], $data['round']);
			$upd = $this->ci->cms->update('submission', array('sub_id', $data['sub_id']), array('sub_status' => $sts, 'round' => $data['round']));
			if($upd){
				$sub = $this->ci->cms->current_submission($data['sub_id']);
				$editor = $this->ci->cms->get_section_editor($sub[0]['section_id']);
				$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
				# send mail to author
				$data['status'] = $sts_mail;
				$data['notes'] = $data['reason_back'];
				$data['journal'] = $sub;
				$data['revise_days'] = $revise_days;
				$data['editor'] = $editor;
				$data['journal_id'] = $journal_id;

				$data['author'] = $this->ci->cms->get_corresponding_author($data['sub_id']);
				$other_author = $this->ci->cms->get_other_author($data['sub_id'], true);
				$email = $data['author'][0]['email'];
				
				// $this->ci->load->library('email'); # load email library
				// $this->ci->email->clear();
				// $this->ci->email->from(MAILSYSTEM, 'IJTech');
				// $this->ci->email->to($email);
				
				if(NOTIF_ALL_AUTHOR){
					if(!empty($other_author))
						// $this->ci->email->cc(implode(',',$other_author));
						$email .= ",".implode(',',$other_author);
				}

				// $this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
				// $this->ci->email->subject('[IJTech] Editor Decision');
				$message = $this->ci->load->view('template/mailer/author/'.$mail, $data, TRUE);
				// $this->ci->email->message($message);
				
				if($isNotifyAuthor){
					
					$this->ci->db->set(array( //ruki 2021-07-25: supaya semua tercatat di sendmail_log
						'to' => $email,
						'subject' => '[IJTech] Decision for manuscript #'.$journal_id.': '.$sts_mail,
						'body' => $message,
						'time' => date('Y-m-d H:i:s'),
						'parent' => $sub[0]['sub_id']
					))->insert('sendmail_log');
					
					// if($this->ci->email->send()){
						if($sts == 10)
							$this->log_submission($sub[0]['sub_id'], 10, 'Rejected manuscript');
						$this->log('Sending email to corresponding author about editor decision manuscript round "'.$data['round'].'", email : '.$email, 'submission_author', $data['author'][0]['email']);
						$this->ci->session->set_flashdata('success','Sending email to corresponding author successfully');
					// }
				}
        
				# save reminder queue
				if($sts == 7){
					$set_reminder = array(
						'sub_id' => $data['sub_id'],
						'type'	=> 1,
						'date_set'	=> date('Y-m-d H:i:s'),
						'date_remind'	=> date('Y-m-d H:i:s', strtotime('+'.ceil($revise_days/2).' days')),
						'email_destination'	=> $email
					);
					$this->ci->cms->insert('reminder', $set_reminder);
				}
			
        //ruki: send email buat involved reviewers START
		if($isNotifyInvolvedReviewers){
         if($thedecision	== 'Accepted' || $thedecision	== 'Rejected'){ //if this is final decision (accpet or reject)
          //$reviewer = $this->ci->cms->get_submission_reviewer_active($data['sub_id']);
          $reviewer = $CI->db->query("select * from submission_reviewer s
            join submission_review sr on sr.reviewer_email = s.email and sr.sub_id = s.sub_id and sr.review_result is not null and sr.date_review is not null
            where s.sub_id = ?",[$data['sub_id']]); //22sep2023
          foreach($reviewer as $rev){
            $data2 = array(
              'round' => $this->ci->security->xss_clean($this->ci->input->post('round')),
              'journal' => $sub,
              'journal_id'=> $journal_id,
              'editor'	=> $editor,
              'editor_note' => isset($data['notes']) ? $data['notes'] : '',
              'decision'	=> $thedecision,
              'reviewer'	=> $rev
            );

            $data2['author'] = $this->ci->cms->get_corresponding_author($data['sub_id']);
            $data2['review_result'] = $data['review_result'];
            
        	$data = array(
        		'to' 	=> $rev['email'],
        		'subject' => '[IJTech] Final decision on the manuscript that you have reviewed #'.$journal_id,
         		'body'	=> $this->ci->load->view('template/mailer/reviewer/after_final_decision', $data2, TRUE),
         		'time'	=> date('Y-m-d H:i:s')
        	);
        	$act = $this->ci->cms->insert('sendmail_log', $data);
            
            // $this->ci->email->clear();
            // $this->ci->email->to($rev['email']);
            // $this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
            // $this->ci->email->subject('[IJTech] Final decision on the manuscript that you have reviewed #'.$journal_id);
            // $message = $this->ci->load->view('template/mailer/reviewer/after_final_decision', $data2, TRUE);
            // echo '==================<br>';
            // echo '==================<br>';
            // echo $message;
            // $this->ci->email->message($message);
            // if($this->ci->email->send()){
              // $this->log('Sending email to involved reviewers about editor decision manuscript round "'.$data['round'].'", email : '.$rev['email'], 'submission_author', $data['author'][0]['email']);
            // }
            
          }
         }
        }
        //ruki: send email buat involved reviewers END
      }
		}
		redirect($page);
	}

	public function revise_agreement(){
		$page = $this->ci->input->post('page');
		$sub_id = $this->ci->input->post('sub_id');
		$round = $this->ci->input->post('round');
		$action = $this->ci->input->post('action');
		$url = site_url().'dashboard/edit/submission/'.$sub_id;
		$upd = $this->ci->cms->revise_agreement($sub_id); //this function will increase submission.round
		if($action == "No"){
			$url = $page;
			$act = $this->ci->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 10)); //jadi skrg round nya sudah +1 dan sub_status=10 ya
			$user_id = 'system/cron';
			if(isset($this->session)){
				$user_id = $this->session->user_id;
			}
			if($act)
				$this->log_submission($sub_id, 10, 'Author decline to revise ('.$user_id.')');
			$this->ci->session->set_flashdata('info','Submission has been withdrawn and archived'); //sblm 10apr2021: 'Submitted manuscript has been store to completed manuscript.');
		}else{
			$this->log_submission($sub_id, 7, 'Author agree to revise the manuscript');
			$this->ci->session->set_flashdata('info','Now you can submit a revision'); //sblm 10apr2021: 'Submitted manuscript is ready to be revised.'); //sebelumnya author sudah menerima email reminder utk merevisi dalam beberapa hari

		}
		redirect($url);
	}

	public function send_response_letter(){
		
		$sub_id = $this->ci->input->post('sub_id');
		$author = $this->ci->input->post('author');
		$round = $this->ci->input->post('round');
		$page = $this->ci->input->post('page');
		$ids = $this->ci->input->post('sr_id');
		
		//echo "<pre>"; print_r($ids); 

		$sub = $this->ci->cms->current_submission($sub_id);
		$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
		$editor = $this->ci->cms->get_section_editor($sub[0]['section_id']);
		$file = $this->ci->cms->get_manuscript_file_type($sub_id, $round, 2);
		$letter = $this->ci->cms->get_manuscript_file_type($sub_id, $round, 4);
		// $is_send = true;
		
		$reviewer = $this->ci->cms->get_submission_reviewer_active($sub_id);
		if(!empty($ids))
			$reviewer = $this->ci->cms->get_reviewers_from_ids($ids);
			
		//print_r($reviewer);
		//die();
				
		foreach($reviewer as $rev){
			$CI =& get_instance();
			$check = $CI->db->query("select canInviteAgain from submission_review where reviewer_email = '".$rev['email']."' and sub_id = $sub_id order by round desc limit 1 ")->row();
			if($check->canInviteAgain!=1){ continue; } //bila reviewer tidak bersedia, jangan kirimi email
			
		  $check = $CI->db->query("select count(*) c from submission_review where reviewer_email = '".$rev['email']."' and sub_id = $sub_id and round = ". ($round-1) ." and date_review is not null ")->row();
			if($check->c < 1){ continue; } //bila round sblmnya blm memberikan review, jangan dikirimi juga
			
			# send email			
			$set_reminder = array(
				'sub_id' => $sub_id,
				'type'	=> 3, //remind reviewer to conduct review
				'date_set'	=> date('Y-m-d H:i:s'),
				'date_remind'	=> date('Y-m-d H:i:s', strtotime('+'.DAY_TO_REVIEW_MANUSCRIPT.' days')),
				'email_destination'	=> $rev['email']
			);
			$this->ci->cms->insert('reminder', $set_reminder);

			$data = array(
				'journal' => $sub,
				'journal_id'=> $journal_id,
				'editor'	=> $editor,
				'reviewer'	=> $rev,					
			);

			$message = $this->ci->load->view('template/mailer/reviewer/invitation_revise', $data, TRUE);
			$this->ci->load->library('email'); // load email library
			$this->ci->email->clear(TRUE);
			$this->ci->email->from(MAILSYSTEM, 'IJTech');
			$this->ci->email->to($rev['email']);
			$this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3); 
			$this->ci->email->subject('[IJTech] Revised Manuscript and Response Letter #'.$journal_id);
			$this->ci->email->message($message);
			
			$attachments = array();
			if(file_exists($file[0]['file_url'])){
				$this->ci->email->attach('./'.$file[0]['file_url']);
				$attachments[] = './'.$file[0]['file_url'];
			}
			if(file_exists($letter[0]['file_url'])){
				$this->ci->email->attach('./'.$letter[0]['file_url']);
				$attachments[] = './'.$letter[0]['file_url'];
			}
			
			$this->ci->email->send(); //23apr2021: kembali ke cara awal
			
			//ruki 2021-07-25 agar tercatat di sendmail_log
			$this->ci->db->set(array(
				'to' => $rev['email'],
				'subject' => '[IJTech] Revised Manuscript and Response Letter #'.$journal_id, //TODO: tambahkan link utk refuse, minta extend, dan link ke review form nya, karena bisa saja reviewer ini sibuk
				'body' => $message,
				'time' => date('Y-m-d H:i:s'),
				'status' => 'sent'
			))->insert('sendmail_log');	
			
			// if($this->ci->email->send()){
				$this->ci->cms->insert('submission_review', array('sub_id' => $sub_id, 'reviewer_email' => $rev['email'], 'round' => $round, 'date_round_start' => date('Y-m-d H:i:s') ));
			// }else $is_send = false;
			
			/* 23apr2021: dibatalkan karena ternyata ga bisa gunakan sendmail_log dg attachment. butuh testing dulu dg lebih detail
			if(count($attachments)>0){
				$attachments = json_encode($attachments);
			}else{
				$attachments = null;
			}
			$this->ci->db->set(array(
				'to' => $rev['email'],
				'subject' => '[IJTech] Revised Manuscript and Response Letter #'.$journal_id, //TODO: tambahkan link utk refuse, minta extend, dan link ke review form nya, karena bisa saja reviewer ini sibuk
				'body' => $message,
				'time' => date('Y-m-d H:i:s'),
				'parent' => $sub_id,
				'attachment' => $attachments
			))->insert('sendmail_log');	
			*/
		}
		
		// if($is_send){
			$set = $this->ci->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 4));
			if($set){
				$this->log_submission($sub_id, 4, 'Response letter sent to reviewers');
				$this->ci->session->set_flashdata('success','Response letter has been sent to reviewers');
			}else{
				$this->ci->session->set_flashdata('error','Failed sending response letter, Please try again!');
			}
		// }
		redirect($page);
	}

	public function publish_submission(){
		$sub_id = $this->ci->input->post('sub_id');
		$page = site_url().'dashboard/process/'.$sub_id;
		$data = array(
			'date_publish'	=> date('Y-m-d H:i:s'),
			'sub_status'	=> 11,
		);
		$act = $this->ci->cms->update('submission', array('sub_id', $sub_id), $data);
		if($act){
			$this->log('Inpress process manuscript', 'submission', $sub_id);
			$this->log_submission($sub_id, 11, 'In Press Process');
			$this->ci->session->set_flashdata('success','Manuscript has been moved publishing process.');			
		}else
			$this->ci->session->set_flashdata('error','Failed publishing manuscript!. Please check internet connection.');

		redirect($page);
	}

	public function publish_journal(){
		$sub_id = $this->ci->input->post('sub_id');
		$page = $this->ci->input->post('page');
		$data = array(
			'date_publish' => date('Y-m-d H:i:s'),
			'doi_url'	=> $this->ci->security->xss_clean($this->ci->input->post('doi_url'))
		);
		$act = $this->ci->cms->update('journal', array('sub_id', $sub_id), array('date_publish' => $data));
		if($act){
			$this->log('Publish Journal', 'journal', $sub_id);
			$this->log_submission($sub_id, 9, 'Publish Manuscript');
			$this->ci->session->set_flashdata('success','Succeessfully publish journal.');
		}else
			$this->ci->session->set_flashdata('error','Failed publishing journal!. Please check internet connection.');

		redirect($page);
	}


	/**
	 * save journal base on section
	 *
	 */
	private function data_step($step, $migrate = false){
		switch($step){
			case "article" : {
				$sub_id = $this->ci->security->xss_clean($this->ci->input->post('sub_id'));
				$issue_id = $this->ci->security->xss_clean($this->ci->input->post('issue_id'));
				$is = $this->ci->cms->current_issue($issue_id);
				$doi_url = 'https://doi.org/10.14716/ijtech.v'.$is[0]['volume'].'i'.$is[0]['issue_number'].'.'.$sub_id;
				$data = array(					
					'sub_id'	=> $sub_id,
					'issue_id'	=> $issue_id,
					'title'	=> $this->ci->security->xss_clean($this->ci->input->post('title')),
					'keywords'	=> $this->ci->security->xss_clean($this->ci->input->post('keywords')),
					'abstract'	=> $this->ci->input->post('abstract'),
					'doi_url'	=> $doi_url
				);
				if($migrate)
					$data['section_id'] = $this->ci->security->xss_clean($this->ci->input->post('section_id'));

			} break;
			case "introduction" : {
				$data = array(
					'introduction'	=> $this->ci->input->post('introduction')
				);
			} break;
			case "experimental" : {
				$data = array(
					'experimental_method'	=> $this->ci->input->post('experimental_method')
				);
			} break;
			case "result" : {
				$data = array(
					'result'	=> $this->ci->input->post('result')
				);
			} break;
			case "conclusion" : {
				$data = array(
					'conclusion'	=> $this->ci->input->post('conclusion')
				);
			} break;
			case "acknowledgement" : {
				$data = array(
					'acknowledgement'	=> $this->ci->input->post('acknowledgement')
				);
			} break;
			case "references" : {
				$data = array(
					'references'	=> $this->ci->input->post('references')
				);
			} break;
			case "authors" : {
				$data = array(
					'sa_id' => $this->ci->input->post('sa_id'),
					'sub_id' => $this->ci->input->post('sub_id'),
					'salutation' => $this->ci->input->post('salutation'),
					'first_name' => $this->ci->security->xss_clean($this->ci->input->post('first_name')),
					'last_name' => $this->ci->security->xss_clean($this->ci->input->post('last_name')),
					'email' => $this->ci->security->xss_clean($this->ci->input->post('email')),
					'affiliation' => $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
					'country' => $this->ci->security->xss_clean($this->ci->input->post('country')),
				);
			} break;			
			case "suplement" : {
				$data = array(
					'sub_id' => $this->ci->input->post('sub_id'),
					'type' => $this->ci->input->post('type'),
				);
			} break;

			case "file" : {
				$data = array(
					'pages'	=> $this->ci->input->post('pages'),
					'cite'	=> $this->ci->input->post('cite')
				);
			} break;

			case "publish" : {
				$date_submit = $this->ci->input->post('date_submit').' 00:00:00';
				$date_accept = $this->ci->input->post('date_accept').' 00:00:00';
				$date_publish = $this->ci->input->post('date_publish').' 00:00:00';
				$data = array(
					'sub_id'	=> $this->ci->security->xss_clean($this->ci->input->post('sub_id')),
					'doi_url'	=> $this->ci->security->xss_clean($this->ci->input->post('doi_url')),
					'date_publish'	=> date('Y-m-d H:i:s')
				);
				if($migrate){
					$data['date_submit'] = $date_submit;
					$data['date_accept'] = $date_accept;
					$data['date_publish'] = $date_publish;
				}
			} break;
		}
		return $data;
	}

	public function save_journal(){
		$id = $this->ci->input->post('sub_id');
		$section_id = $this->ci->input->post('section_id');
		$step = $this->ci->input->post('step');
		$page = $this->ci->input->post('page');
		$submit = $this->ci->input->post('submit');
		$next = $this->navprocess($id, $step, 'next');

		# set atribut		
		$data = $this->data_step($step);
		if($step == 'article'){
			if ($this->ci->cms->check_journal_exists($id) > 0)
				$upd = $this->ci->cms->update('journal', array('sub_id', $id), $data);
				if($upd){
					unset($data['issue_id']);
					$data['sub_title'] = $data['title'];
					unset($data['title'], $data['doi_url']);					
					$act = $this->ci->cms->update('submission', array('sub_id', $id), $data);
				}
			else{
				$data['date_revise'] = $this->ci->cms->get_date_log($id, 7);
				$data['date_submit'] = $this->ci->cms->get_date_log($id, 1);
				$data['date_accept'] = $this->ci->cms->get_date_log($id, 8);
				$act = $this->ci->cms->insert('journal', $data);
			}
		}else{
			if($step == 'file'){
				# upload file final manuscript
				$path = 'uploads/submission/manuscript/'.$id.'/';
				$filename = $this->ci->input->post('filename');
				if($_FILES['userfile']['tmp_name'] !== ""){
					$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);			
					$fileName = $filename.'.'.$ext;
					$config['file_name'] = $fileName;
					$config['overwrite'] = true;
					$config['upload_path'] = $path;
					$config['max_size'] = '10240'; # Max size 10 MB
					$config['allowed_types'] = 'pdf';
					
					$this->ci->load->library('upload', $config);
					if(!$this->ci->upload->do_upload()){
						$msg = $this->ci->upload->display_errors();
						$this->ci->session->set_flashdata('invalid','Trouble uploading file.<br/>'.$msg);
					}else{
						$data['pdf_file'] = $path.$fileName;
						$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
					}
				}else
					$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
				
			}else if($step == 'publish'){
				$this->ci->cms->update('submission', array('sub_id', $id), array('sub_status' => 9));
				$this->log_submission($id, 9, 'Finish inpress process');
				$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);

				# SEND MAIL TO AUTHOR
				$cj = $this->ci->cms->get_current_journal($id);
				$issue_label = "Volume ".$cj[0]['volume']." Issue ".$cj[0]['issue_number'].", ".date('M Y', strtotime($cj[0]['issue_publish']));
				$maildata = array(
					'author'	=> $this->ci->cms->get_corresponding_author($id),
					'journal'	=> $this->ci->cms->current_submission($id),
					'issue_url'	=> site_url().'issue/'.$cj[0]['issue_id'],
					'issue_label'	=> $issue_label,
				);
			
				// $email = $maildata['author'][0]['email'];
				// $message = $this->ci->load->view('template/mailer/author/published', $maildata, TRUE);
				
				//2021-10-6 15:50
				$authors = $this->ci->db->query("select concat(salutation,' ',first_name,' ',last_name) name, email
					from submission_author
					where sub_id=?
					order by `sort` asc, sa_id asc",[$id])->result_array();
				$email = implode(',',array_column($authors,'email'));
				$maildata['names']  = array_column($authors,'name');
				$message = $this->ci->load->view('template/mailer/author/published_new', $maildata, TRUE);
				
				/*
				$this->ci->load->library('email'); # load email library
				$this->ci->email->from(MAILSYSTEM, 'IJTech');
				$this->ci->email->to($email);
				$this->ci->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
				$this->ci->email->subject('Journal Publishing : '.$issue_label);
				$this->ci->email->message($message);
				$this->ci->email->send();
				*/
				$this->ci->db->set(array(
					'to' => $email,
					'subject' => '[IJTech] Your manuscript is published at '.$issue_label,
					'body' => $message,
					'time' => date('Y-m-d H:i:s')
				))->insert('sendmail_log');
				
			}else{
				$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
			}
		}
		if($act)
			$this->ci->session->set_flashdata('success','Succeessfully saving data.');
		else $this->ci->session->set_flashdata('danger','Trouble saving data.');
		if($submit == 'Save' || $submit == 'Publish')
			redirect($page);
		else redirect($next);
	}
	
	/**
	 * untuk keperluan migrasi data
	 * process mirip kaya ketika aku melamarmu ke walimu.
	 */
	public function migrate_journal(){
		$id = $this->ci->input->post('sub_id');
		$step = $this->ci->input->post('step');
		$page = $this->ci->input->post('page');
		$submit = $this->ci->input->post('submit');
		
		if($id != null)
			$next = $this->navprocess($id, $step, 'next', true);
		
		$data = $this->data_step($step, true);
		
		if($step == 'article'){
			if ($this->ci->cms->check_journal_exists($id) > 0){
				unset($data['section_id'], $data['doi_url']);
				$upd = $this->ci->cms->update('journal', array('sub_id', $id), $data);
				if($upd){
					unset($data['issue_id']);
					$data['sub_title'] = $data['title'];
					unset($data['title']);					
					$act = $this->ci->cms->update('submission', array('sub_id', $id), $data);
				}
			}
			else{				
				$id = $this->ci->cms->migrate_journal($data);
				$next = $this->navprocess($id, $step, 'next', true);
			}
		}else if($step == 'authors'){
			// Upsert Uuthors
			if($data['sa_id'] !== ''){
				$sa_id = $data['sa_id'];
				unset($data['sa_id']);
				$act = $this->ci->cms->update('submission_author', array('sa_id', $sa_id), $data);
			}else $act = $this->ci->cms->insert('submission_author', $data);

		}else if($step == "publish"){
			// update submission & journal status
			$sub_id = $data['sub_id'];
			unset($data['sub_id']);			
			$this->ci->cms->update('submission', array('sub_id', $sub_id), array('sub_status'=> 9, 'date_publish' => $data['date_publish'], 'date_submit' => $data['date_submit']));
			$this->ci->cms->update('journal', array('sub_id', $sub_id), $data);
			
			
                # SEND MAIL TO AUTHOR
				$cj = $this->ci->cms->get_current_journal($sub_id);
				$issue_label = "Volume ".$cj[0]['volume']." Issue ".$cj[0]['issue_number'].", ".date('M Y', strtotime($cj[0]['issue_publish']));
				$maildata = array(
					'author'	=> $this->ci->cms->get_corresponding_author($sub_id),
					'journal'	=> $this->ci->cms->current_submission($sub_id),
					'issue_url'	=> site_url().'issue/'.$cj[0]['issue_id'],
					'issue_label'	=> $issue_label,
				);
			
				$email = $maildata['author'][0]['email'];
				$message = $this->ci->load->view('template/mailer/author/published', $maildata, TRUE);
				$this->ci->db->set(array(
					'to' => $email,
					'subject' => '[IJTech] Your manuscript is published at '.$issue_label,
					'body' => $message,
					'status' => 'sent',
					'time' => date('Y-m-d H:i:s')
				))->insert('sendmail_log');
			
			

		}else if($step == "suplement"){

			$path = 'uploads/submission/attachment/'.$data['sub_id'].'/';
			if(!file_exists($path))
				mkdir($path);
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$fileName = $this->ci->lib_view->gen_manuscript_name($data['sub_id']).'.'.$ext;
			$config['file_name'] = $fileName;
			$config['overwrite'] = false;
			$config['upload_path'] = $path;
			$config['max_size'] = '10240'; # Max size 10 MB
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('invalid','Trouble uploading file.<br/>'.$msg);
			}else{
				$data['file_url'] = $path.$fileName;
				$act = $this->ci->cms->insert('submission_file', $data);				
			}

		}else if($step == "file"){
			# upload file final manuscript
			$path = 'uploads/submission/manuscript/'.$id.'/';
			if(!file_exists($path))
				mkdir($path);
			
			$filename = $this->ci->input->post('filename');
			if($_FILES['userfile']['tmp_name'] !== ""){
				$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);			
				$fileName = $filename.'.'.$ext;
				$config['file_name'] = $fileName;
				$config['overwrite'] = true;
				$config['upload_path'] = $path;
				$config['max_size'] = '10240'; # Max size 10 MB
				$config['allowed_types'] = 'pdf';
				
				$this->ci->load->library('upload', $config);
				if(!$this->ci->upload->do_upload()){
					$msg = $this->ci->upload->display_errors();
					$this->ci->session->set_flashdata('invalid','Trouble uploading file.<br/>'.$msg);				
				}else{
					$data['pdf_file'] = $path.$fileName;					
					$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
				}
			}else $act = $this->ci->cms->update('journal', array('sub_id', $id), $data); 
		}else{
			$act = $this->ci->cms->update('journal', array('sub_id', $id), $data);
		}

		if($act)
			$this->ci->session->set_flashdata('success','Succeessfully saving data.');
		else $this->ci->session->set_flashdata('danger','Trouble saving data.');
		if($submit == 'Save' || $submit == 'Publish'){
			if($step == "authors"){
				$page = explode('authors', $page);
				redirect($page[0].'authors');
			}
			if($submit == "Publish")
				$page = site_url()."dashboard/submission/status/completed";

			redirect($page);
		}
		else redirect($next);
	}

	private function navprocess($id, $step, $condition, $migrate = false){
		$url = site_url().'dashboard/process/'.$id.'/';
		if($migrate){
			$url = site_url().'dashboard/migrate/'.$id.'/';	
			if($condition == 'next'){
				switch($step){
					case "article": $url .='introduction'; break;
					case "introduction": $url .='experimental'; break;
					case "experimental": $url .='result'; break;
					case "result": $url .='conclusion'; break;
					case "conclusion": $url .='acknowledgement'; break;
					case "acknowledgement": $url .='references'; break;
					case "references": $url .='authors'; break;
					case "authors": $url .='suplement'; break;
					case "suplement": $url .='file'; break;
					case "file": $url .='publish'; break;
					case "publish": $url ='#'; break;
				}
				return $url;
			}
		}else{
			if($condition == 'next'){
				switch($step){
					case "article": $url .='introduction'; break;
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
	}

	/**
	 * module people
	 */
	public function insert_people(){
    	$data = array(
    		'salutation' 	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
    		'fullname' 	=> $this->ci->security->xss_clean($this->ci->input->post('fullname')),
    		'email'		=> $this->ci->security->xss_clean($this->ci->input->post('email')),
    		'url'		=> $this->ci->security->xss_clean($this->ci->input->post('email')),
    		'google_scholar'	=> $this->ci->security->xss_clean($this->ci->input->post('gscholar')),
    		'research_gate'		=> $this->ci->security->xss_clean($this->ci->input->post('rgate')),
    		'scopus'		=> $this->ci->security->xss_clean($this->ci->input->post('scopus')),
    		'status'	=> $this->ci->security->xss_clean($this->ci->input->post('status')),
    		'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
     		'country'	=> $this->ci->input->post('country'),
    		'date_input'		=> date('Y-m-d H:i:s'),
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);

    	if($_FILES['userfile']['tmp_name'] !== ""){
			$config['upload_path'] = './uploads/team/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = '2048'; # Max size 2 MB
			$config['overwrite'] = true;
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$fileName = mt_rand(0000,9999).'.'.$ext;
			$config['file_name'] = $fileName;

			$path = 'uploads/team/';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('error','Trouble saving photo image.<br/>'.$msg);
			}else{
				$data['photo'] = $path.$fileName;
			}
		}
		$act = $this->ci->cms->insert('people', $data);
		if($act)
			$this->ci->session->set_flashdata('success','New People has been created.');
		else $this->ci->session->set_flashdata('error','Trouble saving data.');
    	redirect('dashboard/people');
    }

	public function update_people(){
		$id = $this->ci->input->post('pid');
    	$data = array(
    		'salutation' 	=> $this->ci->security->xss_clean($this->ci->input->post('salutation')),
    		'fullname' 	=> $this->ci->security->xss_clean($this->ci->input->post('fullname')),
    		'email'		=> $this->ci->security->xss_clean($this->ci->input->post('email')),
    		'url'		=> $this->ci->security->xss_clean($this->ci->input->post('email')),
    		'google_scholar'	=> $this->ci->security->xss_clean($this->ci->input->post('gscholar')),
    		'research_gate'		=> $this->ci->security->xss_clean($this->ci->input->post('rgate')),
    		'scopus'		=> $this->ci->security->xss_clean($this->ci->input->post('scopus')),
    		'status'	=> $this->ci->security->xss_clean($this->ci->input->post('status')),
    		'affiliation'	=> $this->ci->security->xss_clean($this->ci->input->post('affiliation')),
     		'country'	=> $this->ci->input->post('country'),    		
    		'date_update'		=> date('Y-m-d H:i:s'),
    	);

    	if($_FILES['userfile']['tmp_name'] !== ""){
			$config['upload_path'] = './uploads/team/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = '2048'; # Max size 2 MB
			$config['overwrite'] = true;
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$fileName = mt_rand(0000,9999).'.'.$ext;
			$config['file_name'] = $fileName;

			$path = 'uploads/team/';
			$this->ci->load->library('upload', $config);
			if(!$this->ci->upload->do_upload()){
				$msg = $this->ci->upload->display_errors();
				$this->ci->session->set_flashdata('error','Trouble saving photo image.<br/>'.$msg);
			}else{
				$data['photo'] = $path.$fileName;
			}
		}
		$act = $this->ci->cms->update('people', array('pid', $id), $data);
		if($act)
			$this->ci->session->set_flashdata('success','People has been updated.');
		else $this->ci->session->set_flashdata('error','Trouble saving data.');
    	redirect('dashboard/people');
    }

    # update feature 29 April 2017
    # ========================================
    public function change_privilage(){
    	$page = $this->ci->input->post('page');
    	$user_id = $this->ci->input->post('user_id');
    	$role = $this->ci->input->post('role');
    	$act = $this->ci->cms->change_privilage($user_id, $role);
    	if($act)
			$this->ci->session->set_flashdata('success','User privilage has been updated.');
		else $this->ci->session->set_flashdata('error','Trouble saving data.');
    	redirect($page);
    }

}
