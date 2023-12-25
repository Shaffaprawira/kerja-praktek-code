<?php

/**
 * Journal engineering FTUI	
 * @ author	: Sabbana
 * @ corp	: sstud-io.net
 * @ Date Created	: 2 Maret 2017
 * @ Date Revised	: 22 Maret 2021
 * @ Date by : Ruki Harwahyu
 * @ lynx -dump site_url().'reminder/[method]';
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Reminder extends CI_Controller{

	var $data = array();

	public function __construct(){
		parent::__construct();	
		$this->load->model('Mdl_reminder', 'reminder');
		$this->load->model('Mdl_cms', 'cms');
	}

	public function index(){
		var_dump("This URL will execute by cronjob!");
	}
	
	public function manacoba(){
        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';
        
        $response = false;
        $mail = new PHPMailer();
        
        $mail->isSMTP();
        $mail->Host     = 'salamander.ui.ac.id'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->Port     = 25;
        $mail->SMTPAuth = true;
        $mail->Username = 'teknik.komputer@ui.ac.id'; // user email
        $mail->Password = 'DIHAPUS'; // password email
        $mail->SMTPSecure = '';
        
        
        
        $mail->setFrom('blaster@ijtech.eng.ui.ac.id', ''); // user email
        $mail->addReplyTo('ijtech@eng.ui.ac.id', ''); //user email

        // Add a recipient
        $mail->addAddress('ruki.hwyu@gmail.com'); //email tujuan pengiriman email

        // Email subject
        $mail->Subject = 'SMTP Codeigniter'; //subject email

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>SMTP Codeigniterr</h1>
            <p>Laporan email SMTP Codeigniter.</p>"; // isi email
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }

	    
	    die();
	    
	    
	    
	    
	    
	    
	    
    	$config['protocol'] = 'smtp';
    	$config['mailtype'] = 'html';
    	$config['charset'] = 'utf-8';
    	$config['wordwrap'] = TRUE;
    	$config['newline'] = "\r\n";
    	
    	$config['smtp_crypto'] = 'ssl';
    	$config['smtp_host'] = 'salamander.ui.ac.id';
    	$config['smtp_port'] = '25';
    	$config['smtp_user'] = 'ruki.h@ui.ac.id'; //akun SSO, usernamenya saja
    	$config['smtp_pass'] = ''; //password SSO
    	
        $this->load->library('email');    	
    	$this->email->initialize($config);

        $this->email->from('blaster@ijtech.eng.ui.ac.id', 'IJTech Bot (No Reply)');
        $this->email->to('ruki.hwyu@gmail.com');
        $this->email->cc('ruki.h@ui.ac.id');
        $this->email->bcc('ruki@ruki.web.id');
        $this->email->subject('ssl sala ruki at');
        $this->email->message('sala ruki');
        $this->email->send();
	}
	
	public function author($case){
		switch ($case){
			case "revision":{ # reminder to revise manuscript
				$data = $this->reminder->get_reminder(1);
				if(!empty($data)){
					foreach ($data as $r) {
						# check submission still active
						if ($this->check_manuscript_active_revise($r['sub_id'])){

							if($r['attempt'] > MAX_REMIND_TIMES){
								# update reminder date_cancel
								$act = $this->cms->update('reminder', array('sr_id', $r['reminder_id']), array('date_cancel' => date('Y-m-d H:i:s'),'date_remind'=>null));
								# update submisison status (with draw)
								if($act)
									$this->cms->update('submission', array('sub_id', $r['sub_id']), array('status' => 10));

							}else{		
								$days = DAY_REVISE_SCREENING;
								$is_valid = $this->check_date($r['date_remind']);
								if($is_valid){
									$author = $this->reminder->get_author($r['sub_id'], $r['email_destination']);
									$sub = $this->reminder->get_submission($r['sub_id']);
									$editor = $this->cms->get_section_editor($sub[0]['section_id']);
									$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
									$mail_data = array(
										'journal_id' => $journal_id,
										'journal'	=> $sub,
										'author'	=> $author,
										'editor'	=> $editor,
										'time'		=> date('d M Y', strtotime("+".$days." days"))
									);
									// $email = $r['email_destination'];
									// $this->load->library('email'); # load email library
									// $this->email->clear();
									// $this->email->from(MAILSYSTEM, 'IJTech');
									// $this->email->to($email);
									// $this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
									// $this->email->subject('[IJTech] Revision reminder for manuscript #'.$journal_id);
									// $message = $this->load->view('template/mailer/author/revision_reminder', $mail_data, TRUE);
									// $this->email->message($message);
									$this->db->set(array(
										'to' => $r['email_destination'],
										'subject' => '[IJTech] Revision reminder for manuscript #'.$journal_id,
										'body' => $this->load->view('template/mailer/reviewer/revision_reminder', $mail_data, TRUE),
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
									// if($this->email->send()){
										$_attempt = $r['attempt']+1;
										$this->cms->update('reminder', array('reminder_id', $r['reminder_id']), array('attempt' => $_attempt, 'date_remind' => date('Y-m-d', strtotime('+'.$days.' days'))));
										echo "Sending author revise reminder ".$r['email_destination']."...<br/>";
									// }
								}
							}
						}else{
							echo "Manuscript : ".$r['sub_id']." inactive. <br/>";
						}
					}
				}else
					echo "Queue is empty...";
				
			} break;

			default: return false; break;
		}
	}

	public function reviewer($case){
		switch ($case){
			case "invitation": { # reminder invitation				
				$data = $this->reminder->get_reminder(2);
				$days = DAY_4_REVR_2_RESPOND_INVTN;
				if(!empty($data)){
					foreach ($data as $r) {
						if ($this->check_manuscript_active($r['sub_id'])){ //check submission still active
							if($r['attempt'] >= MAX_REMIND_TIMES){ //sudah diingatkan 3x
								if(date('Y-m-d') == $r['date_remind']){ //sekarang adalah tanggal utk mengirimkan reminder ke 4
									$this->cms->update('reminder', array('reminder_id', $r['reminder_id']), array('date_cancel' => date('Y-m-d H:i:s'),'date_remind'=>null)); //hentikan reminder
									$this->cms->update_reviewer_status($r['sub_id'], $r['email_destination'], 6); //status reviewer berubah menjadi invitation inexpired //check apakah ini reflected di dasboard
									
									//prepare email to notify that the invitation has been expired:
									$reviewer = $this->reminder->get_reviewer($r['sub_id'], $r['email_destination']);
									$sub = $this->reminder->get_submission($r['sub_id']);
									$editor = $this->cms->get_section_editor($sub[0]['section_id']);
									$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
									$mail_data = array(
										'journal_id' => $journal_id,
										'name' => $reviewer[0]['salutation'].' '.$reviewer[0]['fullname'],
										'date_invite' => $r['date_set'],
										'title'=> $sub[0]['sub_title']
									);
									$this->db->set(array(
										'to' => $r['email_destination'],
										'subject' => "Re: [IJTech] Invitation reminder for manuscript #".$journal_id,
										'body' => $this->load->view('template/mailer/reviewer/reviewInvitationExpired', $mail_data, true),
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
									
									$this->db->set(array( //notify secretariat & EiC
										'to' => implode(',',array_column($editor,'email')).",ijtech@eng.ui.ac.id",
										'subject' => "[IJTech] Reviewer for paper #".$journal_id." reminded 3x but no response",
										'body' => "Dear EiC and Secretariat,<br><br>Reviewer <b>".$reviewer[0]['salutation']." ".$reviewer[0]['fullname']."</b> (".$r['email_destination'].") is not responding invitation even after being reminded 3 times.
    									So the invitation is automatically cancelled (this reviewer has been notified for this cancelation).
										<br>You can invite other reviewer here: <a href='".base_url('/dashboard/detail/submission/')."/".$r['sub_id']."' target='_blank'>".base_url('/dashboard/detail/submission/').$r['sub_id']."</a>.<br><br>___________<br>This email is generated and sent automatically.",
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
								}
							}else{
								if($this->check_date($r['date_remind'])){ //if date_remind == today
									$reviewer = $this->reminder->get_reviewer($r['sub_id'], $r['email_destination']);
									$sub = $this->reminder->get_submission($r['sub_id']);
									$editor = $this->cms->get_section_editor($sub[0]['section_id']);
									$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
									$mail_data = array(
										'journal_id' => $journal_id,
										'journal'	=> $sub,
										'reviewer'	=> $reviewer,
										'editor'	=> $editor,
										'time'		=> date('d M Y', strtotime("+".DAY_TO_ACCEPT_REVIEW." days")), //tambah tiga hari
										'accepted'	=> site_url().'invitation/'.$reviewer[0]['sub_id'].'/'.$reviewer[0]['sr_id'].'/1/rmd227',
										'refused'	=> site_url().'invitation/'.$reviewer[0]['sub_id'].'/'.$reviewer[0]['sr_id'].'/2/rmd228',
									);
									// $email = $r['email_destination'];
									// $this->load->library('email'); # load email library
									// $this->email->clear();
									// $this->email->from(MAILSYSTEM, 'IJTech');
									// $this->email->to($email);
									// $this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
									// $this->email->subject('[IJTech] Invitation reminder for manuscript #'.$journal_id);
									// $message = $this->load->view('template/mailer/reviewer/invitation_reminder', $mail_data, TRUE);
									// $this->email->message($message);
									$this->db->set(array(
										'to' => $r['email_destination'],
										'subject' => '[IJTech] Invitation reminder for manuscript #'.$journal_id,
										'body' => $this->load->view('template/mailer/reviewer/invitation_reminder', $mail_data, TRUE),
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
									// if($this->email->send()){
										$_attempt = $r['attempt']+1;
										$this->cms->update('reminder', array('reminder_id', $r['reminder_id']), array('attempt' => $_attempt, 'date_remind' => date('Y-m-d', strtotime('+'.$days.' days'))));
										echo "Sending reviewer invitation reminder to ".$r['email_destination']." ...<br/>";
									// }
								}
							}
						}else
							echo "Manuscript ".$r['sub_id']." inactive.<br/>";
					}
				}else
					echo "Queue is empty...";
			} break;

			case "reviewing":{ # reminder for review manuscript
				$data = $this->reminder->get_reminder(3);
				$days = DAY_4_REVR_2_GIVE_REVW;
				if(!empty($data)){
					foreach ($data as $r) {
						$days_review = 14;
						if ($this->check_manuscript_active($r['sub_id'])){ //check submission still active
							if($r['attempt'] >= MAX_REMIND_TIMES){
								if(date('Y-m-d') == $r['date_remind']){
									$this->cms->update('reminder', array('reminder_id', $r['reminder_id']), array('date_cancel' => date('Y-m-d H:i:s'),'date_remind'=>null)); //hentikan reminder
									$this->cms->update_reviewer_status($r['sub_id'], $r['email_destination'], 7); //status reviewer berubah menjadi task expired  //check apakah ini reflected di dasboard
									
									//prepare email to notify that the reviewing job has been expired:
									$reviewer = $this->reminder->get_reviewer($r['sub_id'], $r['email_destination']);
									$sub = $this->reminder->get_submission($r['sub_id']);
									$editor = $this->cms->get_section_editor($sub[0]['section_id']);
									$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
									$mail_data = array(
										'journal_id' => $journal_id,
										'name' => $reviewer[0]['salutation'].' '.$reviewer[0]['fullname'],
										'date_invite' => $r['date_set'],
										'title'=> $sub[0]['sub_title']
									);
									$this->db->set(array(
										'to' => $r['email_destination'],
										'subject' => "Re: [IJTech] Review reminder for manuscript #".$journal_id,
										'body' => $this->load->view('template/mailer/reviewer/reviewJobExpired', $mail_data, true),
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
									
									$this->db->set(array( //notify secretariat & EiC
										'to' => implode(',',array_column($editor,'email')).",ijtech@eng.ui.ac.id",
										'subject' => "[IJTech] Reviewer for paper #".$journal_id." not giving review after reminded 3x",
										'body' => "Dear EiC and Secretariat,<br><br>Reviewer <b>".$reviewer[0]['salutation']." ".$reviewer[0]['fullname']."</b> (".$r['email_destination'].") was agree to give review.
									    However, he/she have not submited a review even after being reminded 3 times. 
									    So this reviewing assignment is automatically cancelled (this reviewer has been notified for this cancelation).
										<br>You can invite other reviewer here: <a href='".base_url('/dashboard/detail/submission/')."/".$r['sub_id']."' target='_blank'>".base_url('/dashboard/detail/submission/').$r['sub_id']."</a>.<br><br>___________<br>This email is generated and sent automatically.",
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
								}
							}else{

								$_date = strtotime ("+".$days_review." days", strtotime($r['date_set']));
								$due = date('d M Y', $_date);
								$is_valid = $this->check_date($r['date_remind']);
								if($is_valid){
									$reviewer = $this->reminder->get_reviewer($r['sub_id'], $r['email_destination']);
									$sub = $this->reminder->get_submission($r['sub_id']);
									$editor = $this->cms->get_section_editor($sub[0]['section_id']);
									$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
									$mail_data = array(
										'journal_id' => $journal_id,
										'journal'	=> $sub,
										'reviewer'	=> $reviewer,
										'editor'	=> $editor,
										'time'		=> $due
									);
									// $email = $r['email_destination'];
									// $this->load->library('email'); # load email library
									// $this->email->clear();
									// $this->email->from(MAILSYSTEM, 'IJTech');
									// $this->email->to($email);
									// $this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
									// $this->email->subject('[IJTech] Review reminder for manuscript #'.$journal_id);
									// $message = $this->load->view('template/mailer/reviewer/review_reminder', $mail_data, TRUE);
									// $this->email->message($message);
									$this->db->set(array(
										'to' => $r['email_destination'],
										'subject' => '[IJTech] Review reminder for manuscript #'.$journal_id,
										'body' => $this->load->view('template/mailer/reviewer/review_reminder', $mail_data, TRUE),
										'time' => date('Y-m-d H:i:s'),
										'parent' => $r['sub_id']
									))->insert('sendmail_log');
									// if($this->email->send()){
										$_attempt = $r['attempt']+1;
										$this->cms->update('reminder', array('reminder_id', $r['reminder_id']), array('attempt' => $_attempt, 'date_remind' => date('Y-m-d', strtotime('+'.$days.' days'))));
										echo "Sending review job reminder to ".$r['email_destination']."...<br/>";
									// }
								}
							}
						}else echo "Manuscript inactive...";
					}
				}else
					echo "Queue is empty...";

			} break;

			default: return false; break;

		}
	}

	# check date reminder
	public function check_date($date_reminder){
		if(date('Y-m-d') == $date_reminder)
			return true;
		return false;
	}

	# check submission still active 
	private function check_manuscript_active($sub_id){
		return $this->cms->check_submission_active($sub_id);
	}
	
	# check submission still active 
	private function check_manuscript_active_revise($sub_id){
		return $this->cms->check_submission_active_revise($sub_id);
	}

	public function get_reminder($id){ // 1: for author to revise manuscript, 2: for reviewer to respond invitation. 3: for reviewer to finish review

		if(IS_AJAX){
			$role = $this->session->userdata('role');
			if(empty($role)) redirect('login');			
			$data = $this->reminder->current_reminder($id);
			header("Content-type: application/json");
			echo json_encode($data);
		}
	}

	/**
	 * send reminder by secretariat via dashboard
	 */
	public function sendaction(){
		$rem_id = $this->security->xss_clean($this->input->post('reminder_id'));
		$sub_id = $this->security->xss_clean($this->input->post('sub_id'));
		$action = $this->security->xss_clean($this->input->post('action'));
		$email_destination = $this->security->xss_clean($this->input->post('email_destination'));
		$type = $_POST['type'];

		if($action == 'send'){

			$rem = $this->reminder->current_reminder($rem_id);
			$sub = $this->reminder->get_submission($sub_id);
			$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];
			$subjet = '[IJTech] Revision reminder for manuscript #'.$journal_id;
			$email_type = 'author/revision_reminder';

			$author = $this->reminder->get_author($sub_id, $email_destination);
			$days = DAY_REVISE_SCREENING;
			$mail_data = array(
				'journal_id' => $journal_id,
				'journal'	=> $sub,
				'author'	=> $author,
				'time'		=> date('d M Y - H:i', strtotime("+".$days." days"))
			);	
			
			if ($type == 2){
				$reviewer = $this->reminder->get_reviewer($sub_id, $email_destination);
				$subjet = '[IJTech] Reviewer Invitation reminder'; //.$journal_id;
				$email_type = 'reviewer/invitation_reminder';
				$days = DAY_TO_ACCEPT_REVIEW;
				$mail_data = array(
					'journal_id' => $journal_id,
					'journal'	=> $sub,
					'reviewer'	=> $reviewer,
					'time'		=> date('d M Y - H:i', strtotime("+".$days." days")),
					'accepted'	=> site_url().'invitation/'.$reviewer[0]['sub_id'].'/'.$reviewer[0]['sr_id'].'/1/rmd419',
					'refused'	=> site_url().'invitation/'.$reviewer[0]['sub_id'].'/'.$reviewer[0]['sr_id'].'/2/rmd419',
				);
			}
			if ($type == 3){
				$days = 3;
				$days_review = 14;
				$_date = strtotime ("+".$days_review." days", strtotime($rem[0]['date_set']));
				$due = date('d M Y - H:i', $_date);
				$reviewer = $this->reminder->get_reviewer($sub_id, $email_destination);
				$subjet = '[IJTech] Review reminder'; //.$journal_id;
				$email_type = 'reviewer/review_reminder';
				$mail_data = array(
					'journal_id' => $journal_id,
					'journal'	=> $sub,
					'reviewer'	=> $reviewer,
					'time'		=> $due
				);
			}
			
			$email = $email_destination;
			$this->load->library('email'); # load email library
			$this->email->from(MAILSYSTEM, 'IJTech');
			$this->email->to($email);
			$this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
			$this->email->subject($subjet);
			$message = $this->load->view('template/mailer/'.$email_type, $mail_data, TRUE);
			$this->email->message($message);
			if($this->email->send()){
				$_attempt = $rem[0]['attempt']+1;
				$this->cms->update('reminder', array('reminder_id', $rem_id), array('attempt' => $_attempt, 'date_remind' => date('Y-m-d', strtotime('+'.$days.' days')))); // ini ngapain ya?
				if($_attempt < 3){
					$this->session->set_flashdata('success', "Sending email reminder to ".$r['email_destination']." successfully.");
				}else{ //kalo udah direminder 3x
					//stop reminder ini
					$act = $this->cms->update('reminder', array('reminder_id', $rem_id), array('date_cancel' => date('Y-m-d H:i:s'), 'confirm' => 2));
					$this->session->set_flashdata('success', "Sent! This is the 3rd reminder. No more reminder will be sent.");
					//TODO: jadwalkan pengiriman email "anda sudah diremind 3x tapi no action. now you dont need to review it anymore"
				}
			}
		}else{ //if action STOP
			$act = $this->cms->update('reminder', array('reminder_id', $rem_id), array('date_cancel' => date('Y-m-d H:i:s'), 'confirm' => 2));
			if($act)
				$this->session->set_flashdata('warning','Schedule reminder for <b>'.$email_destination.'</b> has been stoped.');
		}
		redirect('dashboard/reminder?type='.$type);
	}

	
}