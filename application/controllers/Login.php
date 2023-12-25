<?php

/**
 * Journal engineering FTUI	
 * @author	: Sabbana
 * @corp	: sStud-io.net
 * @Date Created	: 20 Sept 2016
 */

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mdl_front','front');
        $this->load->model('mdl_login');
        $issue = $this->front->current_issue();
		if(!empty($issue)){
			$data = array(
				'issue_id' => $issue[0]['issue_id'],
				'issue'	=> 'Vol '.$issue[0]['volume'].', No '.$issue[0]['issue_number'].' ('.$issue[0]['year'].')',
				'cover'	=> base_url().$issue[0]['cover_image']
				);
			$this->session->unset_userdata('ci');
			$this->session->set_userdata('ci', $data);
		}
    }

  public function index() {
    $this->data['page'] = 'page/login';
		$this->load->view('template_front', $this->data);
	}
	
	private function clean($str){
		return str_replace(array('"',"'"),'', $str);
	}
	
	public function auth(){
		$user = $this->clean($this->input->post('username'));
		$pass = $this->clean($this->input->post('password'));
		$user = $this->mdl_login->auth($user, $pass);		
		if(!empty($user)){
			#create session
			$this->mdl_login->update($user[0]['user_id'], array('last_login'=> date('Y-m-d H:i:s')));
			$sessionData = array(
				'user_id'	=> $user[0]['user_id'],
				'section'	=> $user[0]['section_id'],
				'email'		=> $user[0]['email'],
				'avatar'	=> $user[0]['profile_image'],
				'fname'		=> $user[0]['first_name'],
				'name'		=> $user[0]['first_name'].' '.$user[0]['last_name'],
				'role'		=> $this->mdl_login->get_role_user($user[0]['user_id']),
				'status'	=> $this->mdl_login->get_rolename_user($user[0]['user_id']),
				'editor_section' => $this->mdl_login->get_section_editor($user[0]['user_id']),
				'last_login'=> $user[0]['last_login']
			);			
			$this->session->set_userdata($sessionData);
			redirect('dashboard');
		}else{
			$msg = '<div class="alert alert-warning alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-warning"></i> Warning!</h4>Invalid Username or password!</div>';
			$this->session->set_flashdata('invalid',$msg);
			redirect('login');
		}
	}
	
	public function reset(){
		$this->data['page'] = 'page/login';
		$this->load->view('template_front', $this->data);
	}
	
	
	public function check_user(){
		$key = $this->input->post('key');
		if($key==''){die();}
		$value = $this->input->post('value');
		$res = $this->mdl_login->check_user($key, $value);
		echo $res;
	}
	
	private function prevent_email($str){
		$res = $str;
		if(strpos($str, '@') !== FALSE){
			$_str = explode('@', $str);
			$res = $_str[0];
		}
		return $res;
	}

	public function proc_register(){
		$salutation = $this->security->xss_clean($this->input->post('salutation'));
		$userid = $this->security->xss_clean($this->input->post('username'));
		$section = $this->security->xss_clean($this->input->post('section_id'));
		$password = $this->security->xss_clean($this->input->post('password'));
		$role = array(5,6);
		$fname = $this->security->xss_clean($this->input->post('first_name'));
		$lname = $this->security->xss_clean($this->input->post('last_name'));
		$affiliation = $this->security->xss_clean($this->input->post('affiliation'));
		$scopus = $this->security->xss_clean($this->input->post('scopus'));
		$email = $this->security->xss_clean($this->input->post('email_gue'));		
		$data = array(
			// 'user_id'	=> $this->prevent_email($userid),
			'user_id'	=> $email,
			'section_id' => $section,
			'salutation' => $salutation,
			'status'	=> 1,
			'password'	=> md5($password),
			'first_name'=> $fname,
			'last_name'	=> $lname,
			'email'		=> $email,
			'affiliation' => $affiliation,
			'scopus_id' => $scopus,
			'date_create' => date('Y-m-d H:i:s'),
			'date_update' => date('Y-m-d H:i:s'),
			'register_browser' => $_SERVER['HTTP_USER_AGENT']
		);
		
		if($fname=='Osamah' && $lname=='Ibrahim'){
		    $msg = '<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-warning"></i>Sorry you cannot register</h4>Please contact ijtech@eng.ui.ac.id about this problem.</div>';
		    $this->session->set_flashdata('invalid',$msg);
			redirect('login');
		}
		
		if($this->input->post('email') == "" && $fname !== ""){
			$act = $this->mdl_login->create_user($data);
			if($act=='account exist'){
				$msg = '<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-warning"></i> Warning!</h4>Email is already used. Please register with different email, or try to reset your password.</div>';
				$this->session->set_flashdata('invalid',$msg);
				redirect('login');
			}
			if($act=='account activated'){
				$this->load->model('mdl_cms','cms');
				for($a=0; $a<count($role); $a++){
					$this->cms->insert('roleuser', array('user_id' => $data['user_id'], 'role_id' => $role[$a]));
				}
				$result = array(				
					'from'		=> 'register',
					'user_id'	=> $data['user_id'],
					'password'	=> $password,
					'email'		=> $email,
					'name'		=> $salutation.' '.$fname.' '.$lname,
					'status'	=> $this->mdl_login->get_rolename_user($userid)
				);
				// $message = $this->load->view('template/mailer/author/account_created', $result, TRUE);
				// $this->load->library('email'); // load email library
				// $this->email->from(MAILSYSTEM, 'IJTech');
				// $this->email->to($data['email']);
				// $this->email->bcc(BCC_MAILSYSTEM); 
				// $this->email->subject('[IJTech] Account Created in IJTech Online System');
				// $this->email->message($message);
				
				$this->db->set(array(
					'to' => $data['email'],
					'subject' => '[IJTech] Account Created in IJTech Online System',
					'body' => $this->load->view('template/mailer/author/account_created', $result, TRUE),
					'time' => date('Y-m-d H:i:s'),
					'parent' => $r['sub_id']
				))->insert('sendmail_log');

				// if($this->email->send()){
					$msg = '<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-check"></i> Account Created!</h4>Your account information is sent to your email. You can now login.</div>';
				// }else{
					// $msg = '<div class="alert alert-success alert-dismissable">
						// <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						// <h4><i class="icon fa fa-check"></i> Account Created!</h4>You can now login.</div>';
				// }
				$this->session->set_flashdata('invalid',$msg);
				redirect('login');
			}
			if($act=='account created'){
				$this->load->model('mdl_cms','cms');
				for($a=0; $a<count($role); $a++){
					$this->cms->insert('roleuser', array('user_id' => $data['user_id'], 'role_id' => $role[$a]));
				}
				$result = array(				
					'from'		=> 'register',
					'user_id'	=> $data['user_id'],
					'password'	=> $password,
					'email'		=> $email,
					'name'		=> $salutation.' '.$fname.' '.$lname,
					'status'	=> $this->mdl_login->get_rolename_user($userid)
				);
				// $message = $this->load->view('template/mailer/author/account_created', $result, TRUE);
				// $this->load->library('email'); // load email library
				// $this->email->from(MAILSYSTEM, 'IJTech');
				// $this->email->to($data['email']);
				// $this->email->bcc(BCC_MAILSYSTEM); 
				// $this->email->subject('[IJTech] Account Created in IJTech Online System');
				// $this->email->message($message);

				$this->db->set(array(
					'to' => $data['email'],
					'subject' => '[IJTech] Account Created in IJTech Online System',
					'body' => $this->load->view('template/mailer/author/account_created', $result, TRUE),
					'time' => date('Y-m-d H:i:s'),
					'parent' => $r['sub_id']
				))->insert('sendmail_log');
				
				// if($this->email->send()){
					$msg = '<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-check"></i> Account Created!</h4>Your account information is sent to your email. You can now login.</div>';
				// }else{
					// $msg = '<div class="alert alert-success alert-dismissable">
						// <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						// <h4><i class="icon fa fa-check"></i> Account Created!</h4>You can now login.</div>';
				// }
			}else{
				$this->session->set_flashdata('warning','<b>Error</b> Trouble while registering new user. Please contact administrator.');
				$msg = '<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-warning"></i> Registration Error!</h4>Sorry currently we have some troubles in registering new account. Please contact our <a href="'.base_url('about/2/journal-contact').'">administrator</a>.</div>';
			}
			$this->session->set_flashdata('invalid',$msg);
		}
		redirect('login');
	}
	
	
	/**
	 * reset password 
	 * @email
	 */

	public function reset_password(){
		$emailpost = $this->input->post('email');
        $emailget = $this->input->get('email');
        if(isset($emailpost) && $emailpost!=''){ $email = $emailpost; }
        elseif(isset($emailget)&& $emailget!=''){ $email = $emailget; } //ruki2
        
		# get data member
		if ($email){
			$data = $this->mdl_login->check_user_data('email', $email);
			if(!empty($data)){
			    if($data[0]['status']!=1){ //akun inactive
                    $msg = '<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    <h4><i class="icon fa fa-warning"></i> Account is inactive</h4>Please contact us to activate this account.</div>';
				    $this->session->set_flashdata('invalid',$msg);
			        redirect('reset');
			    }
				$bcc = array(
					'email' => 'sabbana.log@gmail.com',
					'name'	=> 'Sabbana Azmi'
				);
				$this->load->helper('misc');
				$result = array(
					'password'	=> generatePassword(8, 4),
					'user_id'	=> $data[0]['user_id'],
					'name'		=> $data[0]['first_name'].' '.$data[0]['last_name'],				
				);
				# update password
				$act = $this->mdl_login->update($data[0]['user_id'], array('password' => md5($result['password'])));
				if($act){
					// $message = $this->load->view('template/mailer/author/reset_password', $result, TRUE);
					// $this->load->library('email'); // load email library
					// $this->email->from(MAILSYSTEM, 'IJTech');
					// $this->email->to($email);
					// $this->email->bcc(BCC_MAILSYSTEM); 
					// $this->email->subject('[IJTech] IJTech Online System Password Request ');
					// $this->email->message($message);
					
					$this->db->set(array(
						'to' => $email,
						'subject' => '[IJTech] Password Request',
						'body' => $this->load->view('template/mailer/author/reset_password', $result, TRUE),
						'time' => date('Y-m-d H:i:s'),
						'parent' => $r['sub_id']
					))->insert('sendmail_log');
					// if($this->email->send()){
						$msg = '<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    <h4><i class="icon fa fa-check-circle"></i> Success!</h4>We just sent you a new password to your email address. Please check your inbox and/or spambox.</div>';
						$this->session->set_flashdata('invalid', $msg);
					// }else{
						// #print_r($this->email->send()); die();
						// $msg = '<div class="alert alert-warning alert-dismissable">
							// <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    // <h4><i class="icon fa fa-warning"></i> Invalid!</h4>Trouble sending new password to email address.</div>';
						// $this->session->set_flashdata('invalid', $msg);
					// }
				}
			}else{
				$msg = '<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                    <h4><i class="icon fa fa-warning"></i> Invalid!</h4>Invalid email address.</div>';
				$this->session->set_flashdata('invalid',$msg);
			}
		}
		redirect('reset');
	}

	public function activation($token){
		$act = $this->mdl_login->account_activation($token);
		if($act){
			$msg = '<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>Your account has been activated. Please user your account to log in into dashboard FTUI.</div>';
			$this->session->set_flashdata('invalid',$msg);
		}else{
			$msg = '<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Warning!</h4>Problem was detected while activating your account, please contact administrator.</div>';
			$this->session->set_flashdata('invalid',$msg);
		}
		redirect('login');
	}
	
    public function signout(){
		$this->session->sess_destroy();
        redirect('home');
    }

}
