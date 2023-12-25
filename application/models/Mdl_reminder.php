<?php

/**
 * Model reminder 
 * Date Created : 2 Maret 2017
 * By : sStud-io.net
 * 
 columns in reminder table:
	reminder_id: int(11) Auto Increment
	sub_id: int(11) NULL
	email_destination: varchar(50) NULL
	date_set: datetime NULL: tgl kapan reminder ini dibuat
	date_remind: date NULL: tgl kapan reminder berikutnya dikirim (akan terupdate saat sudah terlaksana dg tgl berikutnya)
	date_cancel: datetime NULL
	date_confirm: datetime NULL
	confirm: tinyint(1) NULL [0]: ada 0, 1, dan 2.. saya blm tau maksudnya
	type: tinyint(4): 1: for author to revise manuscript, 2: for reviewer to respond invitation. 3: for reviewer to finish review
	attempt: int(11) [0]: jml reminder yg sudah terkirim (excluding first original email)
 **/

class Mdl_reminder extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	

	public function insert($data){ //dummy
		return $this->db->insert('test', $data);
	}

	public function get_reminder($type){ //get reminders of the type that has not been confirmed, not cancelled, and next date to send reminder is today or later
		// 2: for reviewer to respond invitation. 3: for reviewer to finish review
		//$sql = "select a.*, b.sub_title, b.sub_status from reminder a left join submission b on a.sub_id = b.sub_id where a.type = '$type' and a.confirm = 0 and a.date_cancel is null and a.date_remind >= CURRENT_DATE order by a.date_remind DESC";
		$sql = "select a.*, b.sub_title, b.sub_status from reminder a left join submission b on a.sub_id = b.sub_id where a.type = '$type' and a.confirm = 0 and a.date_cancel is null and a.date_remind >= CURRENT_DATE and a.date_confirm is null order by a.date_remind DESC";
		if ($type == 1) //for author to revise manuscript
			//$sql = "select a.*, b.sub_title, b.sub_status from reminder a left join submission b on a.sub_id = b.sub_id where a.type = '$type' and a.confirm = 0 and a.date_remind >= CURRENT_DATE and sub_status in (0,7) order by a.date_remind DESC";
			//$sql = "select a.*, b.sub_title, b.sub_status from reminder a left join submission b on a.sub_id = b.sub_id where (a.type = '$type' and a.confirm = 0 and a.date_cancel is null and a.date_remind >= CURRENT_DATE) and sub_status in (0,7) order by a.date_remind DESC";
			$sql = "select a.*, b.sub_title, b.sub_status from reminder a left join submission b on a.sub_id = b.sub_id where (a.type = '$type' and a.confirm = 0 and a.date_cancel is null and a.date_remind >= CURRENT_DATE and a.date_confirm is null) and sub_status in (0,7) order by a.date_remind DESC";
		return $this->db->query($sql)->result_array();
	}
	
	public function current_reminder($id){	//get a reminder by id (actually singular or null, but stored in array :D )
		$sql = "select * from reminder where reminder_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function get_author($sub_id, $email){ //get an author's first & last name, salutation, email, afiliation, short bio, scopus id, country, and whether corresponding or not in this paper (actually singular or null, but stored in array :D )
		$sql = "select * from submission_author where sub_id = '$sub_id' and email = '$email' order by sa_id ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_reviewer($sub_id, $email){ //get a reviewer's data
		$sql = "select * from submission_reviewer where sub_id = '$sub_id' and email = '$email' order by sr_id ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_submission($sid){ //get data of a submission and its section (from table submission and section)
		$sql = "select a.*, b.section_id, b.section_abv, b.section_title from submission a 
				left join section b on a.section_id = b.section_id where a.sub_id = '$sid'";
		return $this->db->query($sql)->result_array();
	}

	public function cofirm_reminder($sub_id, $email, $type){ //fill the confirm and date_confirm fields in reminder table (done when author or reviewer has take an action corresponding to a reminder)
		$date = date('Y-m-d H:i:s');
		$sql = "update reminder set confirm = 1, date_confirm = '$date' where sub_id = '$sub_id' and email_destination = '$email' and type='$type'";
		return $this->db->query($sql);
	}

	public function update_reminder($sub_id, $email_destination, $status){ //set date_cancel and the status (can be 0, 1, or 2, blm tau bedanya apa.. dan kenapa yg diset malah date_cancel instead of date_confirm ya?)
		$sql = "update reminder set date_cancel = CURRENT_DATE, confirm = '$status' where sub_id = '$sub_id' and email_destination = '$email_destination'";
		return $this->db->query($sql);
	}
	
}


