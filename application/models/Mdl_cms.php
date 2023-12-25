<?php
/**
 * @ author : Sabbana
 * @ corp : Pajon/sstud-io.net
 * @ date : 21-09-2016
 */

class Mdl_cms extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	# log_activities
	public function log($user, $event, $table, $item){
		$data = array(
			'user_id' => $user,
			'event'	=> $event,
			'table_relation'	=> $table,
			'item_id'	=> $item,
			'ip_address'	=> $_SERVER['REMOTE_ADDR'],
			'device'	=> $_SERVER['HTTP_USER_AGENT']
		);
		return $this->db->insert('log_activities', $data);
	}

	public function log_submission($sub_id, $status, $desc){
		$data = array(
			'sub_id'	=> $sub_id,
			'sub_status'	=> $status,
			'log_desc'	=> $desc
		);
		return $this->db->insert('submission_log_status', $data);
	}

	# get country
	public function get_countries(){
		$sql = "select * from countries order by country_name ASC";
		return $this->db->query($sql)->result_array();
	}
	
	# general crud
	public function insert($table, $data){
		$this->db->set($data);
		return $this->db->insert($table);
		// return $this->db->insert($table, $data);
	}
	
	public function update($table, $param=array(), $data){
		if(empty($param))
			return $this->db->update($table, $data);
		else{
			$this->db->where($param[0], $param[1]);
			return $this->db->update($table, $data);			
		}
	}

	public function update_review($sub_id, $email_reviewer, $data){
		$this->db->where('sub_id', $sub_id);
		$this->db->where('reviewer_email', $email_reviewer);
		return $this->db->update('submission_review', $data);
	}

	public function get_review_item($sub_id, $round, $email){
		$sql = "select * from submission_review where sub_id = '$sub_id' and round = '$round' and reviewer_email = '$email'";
		return $this->db->query($sql)->result_array();
	}

	public function check_count_review($sub_id, $round = 1){
		$sql = "select * from submission_review where sub_id = '$sub_id' and review_result is NOT NULL and round = '$round'";
		return $this->db->query($sql)->num_rows();
	}
	
	public function check_existing_submission_review($sub_id, $round, $email){ //ruki14sep2018 change function name
		$sql = "select * from submission_review where sub_id = '$sub_id' and round = '$round' and reviewer_email = '$email'";
		return $this->db->query($sql)->num_rows();
	}
	
	public function is_review_invitation_not_responded($sub_id, $sr_id){ //ruki17jan2019
		$sql = "select * from submission_reviewer where sub_id = '$sub_id' and sr_id = '$sr_id' and status = 2";
		return $this->db->query($sql)->num_rows();
	}

	public function check_review_active($sub_id){
		$sql = "select sub_status from submission where sub_id = '$sub_id'";
		$result = $this->db->query($sql)->result_array();
		$res = false;
		if(!empty($result)){
			if(in_array($result[0]['sub_status'], array(3,4,5)))
				$res = true;
		}
		return $res;
	}

	public function delete($table, $param=array()){
		$this->db->where($param[0], $param[1]);
		return $this->db->delete($table);
	}
	
	# static pages
	public function get_all_page(){
		$sql = "select * from page order by page_title ASC";
		return $this->db->query($sql)->result_array();
	}
	public function current_page($id){
		$sql = "select * from page where page_id = '$id'";
		return $this->db->query($sql)->result_array();
	}


	# announcement
	public function get_all_announcement(){
		$sql = "select * from announcement order by date_input DESC";
		return $this->db->query($sql)->result_array();
	}
	public function current_announcement($id){
		$sql = "select * from announcement where ann_id = '$id'";
		return $this->db->query($sql)->result_array();	
	}

	# journal info
	public function get_info(){
		$sql = "select * from misc where param = 'info' limit 1";
		return $this->db->query($sql)->result_array();
	}
	
	# journal section
	public function get_all_section(){
		$sql = "select * from section order by sort ASC";
		return $this->db->query($sql)->result_array();
	}
	public function current_section($id){
		$sql = "select * from section where section_id = '$id'";
		return $this->db->query($sql)->result_array();
	}
	public function get_section_editor($sec_id){
		$sql = "select a.*, b.salutation, b.first_name, b.last_name, b.email, b.phone, b.fax, b.affiliation from section_editor a
				right join users b on a.user_id = b.user_id
				where a.section_id = '$sec_id'";
		return $this->db->query($sql)->result_array();
	}
	public function get_available_editor($sec_id = ''){
		$sql = "select a.*,  b. first_name, b.last_name, b.affiliation from roleuser a left join users b on a.user_id = b.user_id
				where a.role_id = '4' and a.user_id not in (select user_id from section_editor where section_id = '$sec_id')";
		return $this->db->query($sql)->result_array();
	}

	# issue 
	public function get_all_issue(){
		$sql = "select * from issue ORDER BY year desc, date_publish DESC";
		return $this->db->query($sql)->result_array();
	}
	
	public function current_issue($id){
		$sql = "select * from issue where issue_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function update_issue_status($id){
		$this->db->query('update issue set status = 0');
		$sql = "update issue set status = 1 where issue_id = '$id'";
		return $this->db->query($sql);
	}
	
	public function count_submission_by_edition($id){
		$c = $this->db->query(" select sub_id from submission where edition = $id and sub_status in (1,2,3,4,5,7,8,9,11,12) " )->result();
		return count($c);
	}

	# user models
	# ======================================================
	# this function will be expired by uploading new version
	public function get_author_from_user($uid, $sub_id){
		$sql = "select * from submission_author where email = (select email from users where user_id = '$uid') and sub_id = '$sub_id'";
		return $this->db->query($sql)->result_array();
	}

	public function get_author_not_user($uid, $sub_id, $for_email = false){
		$sql = "select * from submission_author where email not in (select email from users where user_id = '$uid') and sub_id = '$sub_id'";
		if ($for_email)
			return $this->db->query($sql)->result_array();	
		else{
			$emails = arary();
			$data = $this->db->query($sql)->result_array();
			if(!empty($data)){
				foreach ($data as $e) {
					array_push($emails, $e['email']);
				}
			}
			return $emails;
		}
	}
	# this function will be expired by uploding new version

	public function get_corresponding_author($sub_id, $for_email = false){
		$sql = "select * from submission_author where sub_id = '$sub_id' and corresponding = 1";
		$data = $this->db->query($sql)->result_array();
		if(empty($data)){
			$sql = "select * from submission_author where sub_id = '$sub_id'";
			$res = $this->db->query($sql)->result_array();
			if(count($res) > 1)
				$data[0] = $res[0];
			else $data = $res;
		}
		if($for_email){
			$res = array();
			array_push($res, $data[0]['email']);
			return $res;
		}else return $data;
	}
	
	public function get_other_author($sub_id, $for_email = false){
		$sql = "select * from submission_author where sub_id = '$sub_id' and corresponding = 0";
		$data = $this->db->query($sql)->result_array();
		$check_ca = $this->get_corresponding_author($sub_id);
		// return $check_ca;
		if($for_email){
			$res = array();
			if(!empty($data)){
				foreach ($data as $e) {
					if(!empty($check_ca)){
						if($check_ca[0]['first_name'] !== $e['first_name'])
							array_push($res, $e['email']);
					}else{
						array_push($res, $e['email']);
					}
				}
			}
			return $res;
		}else{
			$res = array();
			if(!empty($check_ca)){
				foreach ($data as $author) {
					if($check_ca[0]['first_name'] !== $author['first_name'])
						array_push($res, $author);
				}
			}
			return $res;
		}
	}

	public function count_user($role = null){
		$sql = "select * from users";
		if($role !== null)
			$sql = "select * from roleuser where role_id = '$role'";
		return $this->db->query($sql)->num_rows();
	}

	public function get_user($uid=""){
		$id = $this->session->userdata('user_id');
		if($uid != "")
			$id = $uid;

		$sql =     "select a.*, b.section_id, b.section_title from users a left join section b on a.section_id = b.section_id where a.user_id = '$id'";
		if(strlen($id) == 32){
			$sql = "select a.*, b.section_id, b.section_title from users a left join section b on a.section_id = b.section_id where (md5(a.user_id) = '$id' or a.user_id = '$id')";
		}
		return $this->db->query($sql)->result_array();
	}
	
	public function get_all_users(){
		$sql = "select * from users
				order by date_create DESC";
		return $this->db->query($sql)->result_array();
	}

	public function get_all_user_paging($num = 25, $offset = 0){
		$this->db->select('*');		
		$this->db->order_by("date_create", "DESC"); 
		return $this->db->get('users', $num, $offset)->result_array();
	}

	public function count_all_user(){
		$this->db->select('*');
		return $this->db->get('users')->num_rows();
	}
	
	public function count_search_user($filter, $keyword){
		$this->db->select('*');
		//$this->db->like($filter, $keyword);
		$this->db->like('first_name', $keyword);
		$this->db->or_like('last_name', $keyword);
		$this->db->or_like('email', $keyword);
		$this->db->or_like('user_id', $keyword);
		return $this->db->get('users')->num_rows();
	}
	
	public function get_search_user($filter, $keyword, $num = 25, $offset = 0){		
		$this->db->select('*');
		//$this->db->like($filter, $keyword);
		$this->db->like('first_name', $keyword);
		$this->db->or_like('last_name', $keyword);
		$this->db->or_like('email', $keyword);
		$this->db->or_like('user_id', $keyword);
		$res = $this->db->get('users', $num, $offset)->result_array();
		return $res;
	}

	public function get_role_user($uid){
		$sql = "select * from roleuser a left join role b on a.role_id = b.role_id where a.user_id = '$uid'";
		return $this->db->query($sql)->result_array();
	}

	public function get_all_user_active(){
		$sql = "select a.*, b.role_name from users a 
				left join role b on a.role_id = b.role_id				
				where a.role_id != 1 and a.status = 1 order by date_create DESC";
		return $this->db->query($sql)->result_array();		
	}

	public function check_user_email($email){
		$sql = "select * from users where email = '$email'";
		return $this->db->query($sql)->num_rows();
	}
	
	public function get_user_from_mail($email){
		$sql = "select * from users where email = '$email'";
		return $this->db->query($sql)->result_array();
	}

	public function default_author($sub_id, $id){
		$data = $this->db->query("select * from users where user_id = '$id'")->result_array();
		$sql = "insert into submission_author (sub_id, salutation, first_name, last_name, email, affiliation, short_biography, country, corresponding) 
				values ('".$sub_id."','".$data[0]['salutation']."','".$this->db->escape_str($data[0]['first_name'])."','".$this->db->escape_str($data[0]['last_name'])."','".$data[0]['email']."','- ".$this->db->escape_str($data[0]['affiliation']).'<br/>- '.$this->db->escape_str($data[0]['affiliation2'])."','".$this->db->escape_str($data[0]['short_biography'])."','".$this->db->escape_str($data[0]['country'])."','1')";
		return $this->db->query($sql);
	}

	public function set_coauthor($sub_id, $sa_id){
		$this->db->query("update submission_author set corresponding = 0 where sub_id = '$sub_id'");
		return $this->db->query("update submission_author set corresponding = 1 where sa_id = '$sa_id'");
	}
	# submission
	public function check_submission_active($sub_id){
		$sql = "select sub_status from submission where sub_id = '$sub_id'";
		$result = $this->db->query($sql)->result_array();
		$res = false;
		if(!empty($result)){
			if($result[0]['sub_status'] < 8 && $result[0]['sub_status'] > 0)
				$res = true;
		}
		return $res;
	}
	
	public function check_submission_active_revise($sub_id){
		$sql = "select sub_status from submission where sub_id = '$sub_id'";
		$result = $this->db->query($sql)->result_array();
		$res = false;
		if(!empty($result)){
			if(in_array($result[0]['sub_status'], array(0, 7))){
				$res = true;
			}
		}
		return $res;
	}

	public function is_send_back($sub_id){
		$sql = "select * from submission_review where sub_id = '$sub_id'";
		$count = $this->db->query($sql)->num_rows();
		$res = 'Send back to author';
		if($count > 0)
			$res = 'Revise';
		return $res;
	}

	public function count_submission_status($status = null){
		$sql = "select sub_id from submission where sub_status > 0";
		if($status !== null)
			$sql = "select sub_id from submission where sub_status = '$status'";
			if($status == "completed")
				$sql = "select sub_id from submission where sub_status in (8, 9, 10, 99)";
		return $this->db->query($sql)->num_rows();
	}
	
	public function count_submission_status_by_section($section, $status = null){
		if(!empty($section)){
			$sql = "select sub_id from submission where section_id in (".implode(',', $section).") and sub_status > 0";
			if($status !== null)
				$sql = "select sub_id from submission where section_id in (".implode(',', $section).") and sub_status = '$status'";
				if($status == "completed")
					$sql = "select sub_id from submission where section_id in (".implode(',', $section).") and sub_status in (8, 9, 10, 99)";
			return $this->db->query($sql)->num_rows();
		}else return 0;
	}

	public function count_submission_status_by_user($user_id, $status = null){
		$sql = "select sub_id from submission";
		if($status !== null)
			$sql = "select sub_id from submission where sub_status = '$status' and user_id = '$user_id'";
		return $this->db->query($sql)->num_rows();
	}

	public function get_submission_status_by_user($user_id, $status = null){
		$sql = "select * from submission where sub_status = '$status' and user_id = '$user_id'";
		if ($status == 3)
			$sql = "select * from submission where sub_status in (3,4,5,6) and user_id = '$user_id'";
		return $this->db->query($sql)->result_array();
	}
  
  public function get_submission_by_sub_id_and_user_id($sub_id, $user_id){ // tambahan Ruki 10 Sep 2018
    $sql = "select * from submission where sub_id = '$sub_id' and user_id = '$user_id'";
    return $this->db->query($sql)->result_array();
  }

  public function get_submission_by_sub_id_and_reviewer_email($sub_id, $email){ // tambahan Ruki 10 Sep 2018
    $sql = "select * from submission_reviewer where sub_id = '$sub_id' and email = '$email' and status = 1";
    return $this->db->query($sql)->result_array();
  }

	public function get_submission_section($array_section, $status = null){
		if(empty($array_section))
			return array();

		$sql = "select a.sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv from submission a 
				left join section b on a.section_id = b.section_id where a.section_id in (".implode(',', $array_section).") and a.sub_status != 0
				order by a.date_input DESC";
		if ($status !== null){			
			$sql = "select a.sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv from submission a 
				left join section b on a.section_id = b.section_id where a.section_id in (".implode(',', $array_section).") and a.sub_status = '$status'
				order by a.date_input DESC";
			if($status == 'completed'){
				$sql = "select a.sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv from submission a 
					left join section b on a.section_id = b.section_id where a.section_id in (".implode(',', $array_section).") and a.sub_status in (8,9,10)
					order by a.date_input DESC";
			}
		}
		return $this->db->query($sql)->result_array();		
	}

	public function get_all_submission($user_id = '', $status = ''){
		$sql = "select a.sub_id, a.round, a.sub_title, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish from
			 	submission a left join section b on a.section_id = b.section_id where a.sub_status != 0 order by a.date_input DESC";
		if ($user_id !== ''){
			$filter = "a.sub_status in (8, 9, 10, 11, 12, 99)";
			if($status == 'active')
				$filter = "a.sub_status < 8";
			
			$sql = "select a.sub_id, a.round, a.sub_title, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish from 
					submission a left join section b on a.section_id = b.section_id where a.user_id = '$user_id' and ".$filter." 
					order by a.date_input DESC";
			
		}
		return $this->db->query($sql)->result_array();
	}

	public function get_submission_status($sts){
		$sql = "select a.sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish 
				from submission a 
				left join section b on a.section_id = b.section_id where a.sub_status = '$sts'
				order by a.date_input DESC";
		if($sts == 'completed'){
			$sql = "select a.sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish 
				 from submission a 
				left join section b on a.section_id = b.section_id where a.sub_status in (8, 9, 10, 99)
				order by a.date_input DESC";
		}
		return $this->db->query($sql)->result_array();
	}

	# submission paging query and search
	# =====================================================
	
	/**
	 * submission list by status paging and search keyword
	 */
	public function get_submission_status_paging($sts, $num=10, $offset=0, $key=null){
	    $t='';$t2='';
	    if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$t = "a.sub_id = ".$param[1];
			}else{
				$t = "(a.sub_title like '%".$key."%' or c.first_name like '%".$key."%' or c.first_name like '%".$key."%')"; //because a & c is used for search, both table should be with JOIN not LEFT JOIN
			}
		}
		if ($sts == 'completed'){
			$t2 = "a.sub_status in (8,9,10,99)";
		}else{
			$t2 = "a.sub_status = ".$sts;
		}
		$t3 = $t==''? '' : ' and ';
		return $this->db->query("select 
			distinct(a.sub_id) as sub_id,
			a.sub_title,
			a.round,
			a.user_id,
			a.section_id,
			a.sub_status,
			a.date_submit,
			b.section_title,
			b.section_abv,
			e.abv,
			a.read_ethics,
			a.not_publish
			from submission a
			left join section b on a.section_id = b.section_id
			left join editions e on e.id = edition
			join submission_author c on a.sub_id = c.sub_id
			where ".$t." ".$t3." ".$t2." 
			order by a.date_submit desc limit $num offset $offset ")->result_array();
			
	    /*
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, e.abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('editions e', 'e.id = edition', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id');
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				// $this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				// $this->db->group_end();
			}
		}

		if ($sts == 'completed')
			$this->db->where_in('a.sub_status', array(8,9,10,99));
		else $this->db->where('a.sub_status', $sts);

		$this->db->group_by('a.sub_id');
		$this->db->order_by("a.date_submit", "DESC"); 
		return $this->db->get('submission a', $num, $offset)->result_array();
		*/
	}
	
	/**
	 * submission total records by status paging and search keyword 
	 */
	public function count_submission_status_by_keyword($key, $sts){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, e.abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('editions e', 'e.id = edition', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id'); //2sep2023 remove LEFT

		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		
		if ($sts == 'completed')
			$this->db->where_in('a.sub_status', array(8,9,10,99));
		else $this->db->where('a.sub_status', $sts);

		$this->db->group_by('a.sub_id');
		return $this->db->get('submission a')->num_rows();		
	}

	/**
	 * submission list by user paging and search keyword
	 */	
	public function get_all_submission_secretariat_paging($num=10, $offset=0, $key=null){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, e.abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('editions e', 'e.id = edition', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id'); //2sep2023 remove LEFT
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		$this->db->where('a.sub_status > ', 0);

		$this->db->group_by('a.sub_id');
		$this->db->order_by("a.date_submit", "DESC"); 
		return $this->db->get('submission a', $num, $offset)->result_array();
	}

	/**
	 * submission list by user paging and search keyword
	 */	
	public function count_all_submission_secretariat_keyword($key=null){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id'); //2sep2023 remove LEFT
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		$this->db->where('a.sub_status > ', 0);		
		$this->db->group_by('a.sub_id');
		return $this->db->get('submission a')->num_rows();
	}


	/**
	 * submission list by user paging and search keyword
	 */	
	public function get_all_submission_author_paging($user_id, $status, $num=10, $offset=0, $key=null){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, e.abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('editions e', 'e.id = edition', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id'); //2sep2023 remove LEFT
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		if($status == 'active'){
			$this->db->where('a.sub_status <= ', 8);
		}

		if($status == 'archive'){
			$this->db->where('a.sub_status > ', 8);
		}

		$this->db->where('a.user_id', $user_id);

		$this->db->group_by('a.sub_id');
		$this->db->order_by("a.date_submit", "DESC"); 
		return $this->db->get('submission a', $num, $offset)->result_array();
	}

	/**
	 * submission list by author paging and search keyword
	 */	
	public function count_all_submission_author_keyword($user_id, $status, $key=null){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id'); //2sep2023 remove LEFT
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		if($status == 'active'){
			$this->db->where('a.sub_status < ', 8);
		}

		if($status == 'archive'){
			$this->db->where('a.sub_status > ', 8);
		}
		$this->db->where('a.user_id', $user_id);		
		$this->db->group_by('a.sub_id');
		return $this->db->get('submission a')->num_rows();
	}


	/**
	 * submission list by section editor paging and search keyword
	 */	
	public function get_all_submission_editor_section_keyword($array_section, $status, $num=10, $offset=0, $key=null){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, e.abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('editions e', 'e.id = edition', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id'); //2sep2023 remove LEFT
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		if(!empty($array_section)){
			$this->db->where_in('a.section_id', $array_section);
		}
		if($status == 'completed'){			
			$this->db->where_in('a.sub_status', array(8,9,10,99));
		}else $this->db->where('a.sub_status', $status);

		$this->db->where('a.sub_status > ', 0);
		if($this->session->userdata('user_id')!='ruki.h@ui.ac.id'){
		    $this->db->where(' length(a.sub_title) > 10 ');
		}
		$this->db->group_by('a.sub_id');
		//$this->db->order_by("a.date_submit", "DESC"); 
		$this->db->order_by("a.round desc, a.date_submit asc"); 
		return $this->db->get('submission a', $num, $offset)->result_array();		
	}

	/**
	 * submission list by author paging and search keyword
	 */	
	public function count_all_submission_editor_section_keyword($array_section, $status, $key=null){
		$this->db->select('distinct(a.sub_id) as sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish');
		$this->db->join('section b', 'a.section_id = b.section_id', 'left');
		$this->db->join('submission_author c', 'a.sub_id = c.sub_id');  //2sep2023 remove LEFT
		
		if($key != null){
			if (strpos($key, 'id:') !== FALSE){
				$param = explode(':', $key);
				$this->db->where('a.sub_id', $param[1]);
			}else{
				$this->db->group_start();
					$this->db->or_group_start();
						$this->db->like('a.sub_title', $key);
						$this->db->or_like('c.first_name', $key);
						$this->db->or_like('c.last_name', $key);
					$this->db->group_end();
				$this->db->group_end();
			}
		}
		if(!empty($array_section)){
			$this->db->where_in('a.section_id', $array_section);
		}
		if($status == 'completed'){
			$this->db->where_in('a.sub_status', array(8,9,10,99));
		}else $this->db->where('a.sub_status', $status);

		$this->db->where('a.sub_status > ', 0);
		$this->db->group_by('a.sub_id');
		return $this->db->get('submission a')->num_rows();
	}

	
	# ========================================================

	public function get_submission_status_limit($sts, $limit){
		$order = 'a.date_submit';
		if($sts == 8)
			$order = 'x.date_accept';

		$sql = "select a.sub_id, a.sub_title, a.round, a.user_id, a.section_id, a.sub_status, a.date_submit, b.section_title, b.section_abv, a.read_ethics, a.not_publish, x.date_accept from submission a 
				left join journal x on a.sub_id = x.sub_id 
				left join section b on a.section_id = b.section_id 
				where a.sub_status = '$sts'
				order by ".$order." DESC limit 0, $limit";		
		return $this->db->query($sql)->result_array();
	}

    /**
     * Check if an author can access the submission
     *
     * @param string $uid user ID
     * @param int $sid submission ID
     *
     * @return bool TRUE if can access, FALSE otherwise.
     *
     * @access public
     * @author Ruki
     * @since 2020-11-14
     */
	public function canAuthorAccessSub($uid, $sid){
	    $c = $this->db->query("select count(*) c from users u 
			join roleuser r on r.user_id = u.user_id
			where u.user_id = '$uid'
			and r.role_id < 5
			and u.status = 1
            ")->row()->c;
        if($c>0){ return true; } //admin, sekre, editor, or EIC
        $c = $this->db->query("select count(*) c from users u 
			join roleuser r on r.user_id = u.user_id
			join submission s on s.user_id = u.user_id
			where u.user_id = '$uid'
			and s.sub_id = $sid
			and r.role_id = 5
			and u.status = 1
			")->row()->c;
		if($c!=1){ return false; }
		return true;
	}

	public function current_submission($sid){
		$sql = "select a.*, b.section_id, b.section_abv, b.section_title from submission a 
				left join section b on a.section_id = b.section_id where a.sub_id = '$sid'";
		return $this->db->query($sql)->result_array();		
	}

	public function count_submission_issue($issue_id){
		$sql = "select * from journal where issue_id = '$issue_id'";
		return $this->db->query($sql)->num_rows();
	}

	public function get_journal_issue($issue_id){
		$sql = "select e.abv, a.*, b.*, c.section_id, c.section_abv, c.section_title, b.round from journal a 
				left join submission b on a.sub_id = b.sub_id 
                left join editions e on e.id = b.edition
				left outer join section c on c.section_id = b.section_id
				where a.issue_id = '$issue_id'";
		return $this->db->query($sql)->result_array();
	}

	public function withdraw_manuscript($sub_id, $reason){
		$mails = array();
		$sub = $this->db->query("select s.sub_title, concat(sec.section_abv,'-',s.sub_id) id, concat(u.salutation,' ',u.first_name,' ',u.last_name) author, u.email
			from submission s 
			join section sec on sec.section_id = s.section_id 
			join users u on u.user_id = s.user_id
			where s.sub_id = $sub_id")->row();
		$subj = "[IJTech] Manuscript #$sub->id is withdrawn";
		array_push($mails,array(
			'to' => $sub->email,
			'subject' => $subj,
			'body' => $this->load->view('template/mailer/author/withdrawn', $sub, true),
			'time' => date('Y-m-d H:i:s'),
			'parent' => $sub_id,
			'k' => md5($sub->email.date('Y-m-d H:i:s').$subj)
		));
		
		$revwr = $this->db->query("select concat(srr.salutation,' ',srr.fullname) name, srr.email, srr.status, s.sub_title, concat(sec.section_abv,'-',s.sub_id) id
			from submission_reviewer srr
			join submission s on s.sub_id = srr.sub_id
			join section sec on sec.section_id = s.section_id 
			left join submission_review sr on (sr.reviewer_email = srr.email and sr.sub_id = srr.sub_id)
			where srr.sub_id = $sub_id
			and ((srr.status = 1 and sr.date_review is null) or srr.status = 2)
			group by srr.email
			")->result(); //get all submission_reviewer (aggree but not yet reviewing OR have not confirmed), along with submission title and ID
		foreach($revwr as $r){
			$subj = "[IJTech] Review request cancelled because manuscript #$r->id is withdrawn";
			array_push($mails,array(
				'to' => $r->email,
				'subject' => $subj,
				'body' => $this->load->view('template/mailer/reviewer/invitation_cancelled', $r, true),
				'time' => date('Y-m-d H:i:s'),
				'parent' => $sub_id,
				'k' => md5($r->email.date('Y-m-d H:i:s').$subj)
			));
		}
		$this->db->insert_batch('sendmail_log', $mails); //send email of cancelation
		$this->db->query("update submission_reviewer set status = 4 where sub_id = '$sub_id'"); //cancel review assignment
		
		$this->db->query("update reminder set date_cancel = NOW() where sub_id = $sub_id and date_remind >= CURRENT_DATE"); //cancel all remaining reminder (for author to revise the manuscript, for reviewer to respond the invitation, for reviewer to conduct review)
		
		return $this->db->where('sub_id', $sub_id)->update('submission', array('sub_status' => 99, 'date_withdraw' => date('Y-m-d H:i:s'), 'withdraw_reason' => $reason)); //withdraw submission
	}

	public function get_submit_date_history($sub_id){
		// $sql = "select * from submission_log_status where sub_id = '$sub_id' and sub_status = 1 order by date_log ASC";
		$sql = "select * from submission_log_status where sub_id = '$sub_id' and (sub_status = 1 or sub_status = 2) order by date_log ASC"; // #tukerUrutanScreening ??? 
		return $this->db->query($sql)->result_array();
	}
	# author models
	# ===================================================
	public function get_author_submission($sid){
		$sql = "select * from submission_author where sub_id = '$sid' order by sort ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_coauthor_submission($sid){
		$sql = "select * from submission_author where sub_id = '$sid' and corresponding = 1  order by sort ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_email_author_from_sub_id($sub){
		$sql = "select * from submission_author where sub_id = '$sub' order by sa_id ASC";
		$data = $this->db->query($sql)->result_array();
		$res = '';
		if(!empty($data))
			$res = $data[0]['email'];
		return $res;
	}

	public function count_author_submission($sid){
		$sql = "select * from submission_author where sub_id = '$sid'";
		return $this->db->query($sql)->num_rows();
	}

	public function get_role_by_email_address($email, $role){
		$sql = "select * from roleuser a left join users b on a.user_id = b.user_id where b.email = '$email' and role_id = '$role'";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_role_by_keywords($key, $role){
		$sql = "select * from roleuser a left join users b on a.user_id = b.user_id where 
				((b.email like '%$key%' or 
				b.first_name like '%$key%' or 
				b.expertise like '%$key%' or 
				b.last_name like '%$key%') and b.section_id != 0 )
				and (role_id = '$role') order by b.first_name ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_suggested_reviewer($key){ //ruki2
		$key = str_replace('Prof.',' ',$key);
		$key = str_replace('Dr.',' ',$key);
		$key = preg_replace('/\s+/', ' ',trim($key)); //hapus spasi yg dobel2
		
		//pisah key berdasarkan spasi
		$words = explode(' ',$key);
		$t_ = array();
		foreach($words as $w){
			$t = "(
				u.email LIKE '%$w%' 
				or u.first_name LIKE '%$w%' 
				or u.last_name like '%$w%' 
				or u.affiliation like '%$w%' 
				or u.expertise like '%$w%'
				)";
			array_push($t_,$t);
		}
		$txt = implode(' or ',$t_);
    $sql = "SELECT distinct(u.email),
        u.user_id,
        u.salutation,
        u.first_name,
        u.last_name,
        u.expertise,
        u.affiliation
        FROM users u join roleuser r on u.user_id=r.user_id
        WHERE r.role_id=6 
				and (u.salutation LIKE '%prof%' or u.salutation LIKE '%dr%' or u.first_name LIKE '%drs.%' or u.first_name LIKE '%dr.%' or u.first_name LIKE '%prof.%' )
				and ( $txt )
				limit 50
				";
		$rv = $this->db->query($sql)->result_array();
		$i = 0;
		foreach($rv as $r){
			$rv[$i]['numInvite'] = $this->db->query("
				select count(*) c
				from submission_reviewer srr
				where (srr.status = 2 or srr.status = 1 or srr.status = 3)
				and srr.email = '".$r['email']."'
				")->row()->c;
			$tmp = $this->db->query("
				select DATE_FORMAT(srr.date_invite,'%d-%m-%Y') c
				from submission_reviewer srr
				where (srr.status = 2 or srr.status = 1 or srr.status = 3)
				and srr.email = '".$r['email']."'
				order by srr.date_invite desc
				limit 1
				")->row();
			$rv[$i]['dateLastInvite'] = '';
			if(isset($tmp)){
				$rv[$i]['dateLastInvite'] = $tmp->c;
			}
			$rv[$i]['numNoResponse'] = $this->db->query("
				select count(*) c
				from submission_reviewer srr
				where srr.status = 2
				and srr.email = '".$r['email']."'
				")->row()->c;
			$rv[$i]['numAgree'] = $this->db->query("
				select count(*) c
				from submission_reviewer srr
				where srr.status = 1
				and srr.email = '".$r['email']."'
				")->row()->c;
			$rv[$i]['numDecline'] = $this->db->query("
				select count(*) c
				from submission_reviewer srr
				where srr.status = 3
				and srr.email = '".$r['email']."'
				")->row()->c;
			$rv[$i]['numReviewed'] = $this->db->query("
				select count(*) c
				from submission_review sr
				where sr.review_result IS NOT NULL
				and sr.reviewer_email = '".$r['email']."'
				and sr.round = 1
				")->row()->c;
			$rv[$i]['numReject'] = $this->db->query("
				select count(*) c
				from submission_review sr
				where sr.review_result = 3
				and sr.reviewer_email = '".$r['email']."'
				and sr.round = 1
				")->row()->c;
			$rv[$i]['numR1Accept'] = $this->db->query("
				select count(*) c
				from submission_review sr
				where sr.review_result = 1
				and sr.reviewer_email = '".$r['email']."'
				and sr.round = 1
				")->row()->c;
			$rv[$i]['avgReviewSpeed'] = $this->db->query("
				select
				avg(abs(TIMESTAMPDIFF(DAY, sr.date_review, srr.date_respond))) c
				from submission_review sr
				join submission_reviewer srr on (srr.email = sr.reviewer_email and srr.sub_id = sr.sub_id)
				where 
				srr.status = 1
				and sr.date_review is not null
				and sr.reviewer_email = '".$r['email']."'
				and sr.round = 1
				")->row()->c;
			$rv[$i]['avgResponseSpeed'] = $this->db->query("
				select
				avg(TIMESTAMPDIFF(DAY, srr.date_invite, srr.date_respond)) c
				from submission_reviewer srr
				where 
				(srr.status = 1 or srr.status = 3)
				and srr.email = '".$r['email']."'
				")->row()->c;
			$rv[$i]['numActiveAssignment'] = $this->db->query("
				select (
				(select count(*) c
				from submission_reviewer srr
				where srr.status = 1
				and srr.email = '".$r['email']."')
				-
				(select count(*) c
				from submission_review sr
				where sr.review_result is not null
				and sr.reviewer_email = '".$r['email']."'
				and sr.round = 1)
				) c
				")->row()->c; //pake cara ini, kerjaan yg tanpa invitation & kerjaan yg dimuulai di round > 1 tidak terhitung (diinvite, agree, tapi langsung kerja @round > 1 VS kerja @ round 1 tanpa invitation)
			$rv[$i]['numActiveAssignment'] = $this->db->query("
				SELECT count(*) c FROM submission_review WHERE reviewer_email = '".$r['email']."' and review_result is null
				")->row()->c; //ini lebih bener
			$tmp = $this->db->query("
				select DATE_FORMAT(srr.date_respond,'%d-%m-%Y') c
				from submission_reviewer srr
				where srr.status = 3
				and srr.email = '".$r['email']."'
				order by srr.date_invite desc
				limit 1
				")->row();
			$rv[$i]['dateLastDecline'] = '';
			if(isset($tmp)){
				$rv[$i]['dateLastDecline'] = $tmp->c;
			}
				
			$i++;
		}
		//echo '<pre>';print_r($rv);echo '</pre>';die();
		return $rv;
	}

	public function get_author_affiliation($sub_id){
		$sql = "select a.affiliation, a.affiliation2, b.first_name, b.last_name from users a left join submission_author b on a.email = b.email
				where b.email in (select email from submission_author where sub_id = '$sub_id')";
		return $this->db->query($sql)->result_array();		
	}

	# reviewer models
	# ====================================================
	public function get_submission_reviewer_active($sid){
		$sql = "select * from submission_reviewer where sub_id = '$sid' and status = 1 order by date_input ASC";
		return $this->db->query($sql)->result_array();	
	}

	public function get_submission_reviewer($sid){
		$sql = "select * from submission_reviewer where sub_id = '$sid' order by date_input ASC";
		return $this->db->query($sql)->result_array();	
	}

	public function get_reviewer_by_email_address($sub_id, $email){
		$sql = "select * from submission_reviewer where sub_id != '$sub_id' and email = '$email' group by email";
		return $this->db->query($sql)->result_array();
	}

	public function get_user_reviewer($review_id){
		$sql = "select * from users where email = (select reviewer_email from submission_review where review_id = '$review_id')";
		return $this->db->query($sql)->result_array();
	}	

	public function get_submission_file($sid, $round = 1){
		$sql = "select * from submission_file where sub_id = '$sid' and round = '$round' order by date_input ASC";
		return $this->db->query($sql)->result_array();	
	}

/*
date modified 08-09-2018
fungsi baru untuk download file submission
*/	
//	public function get_file_submission($sf_id){ //hanya untuk controller download dan fungsi ini berbeda dengan get_submission_file
//		$sql = "select * from submission_file where sf_id = '$sf_id'";
//		return $this->db->query($sql)->row_array();
//	}
  
	public function get_current_author($sa){
		$sql = "select * from submission_author where sa_id = '$sa'";
		return $this->db->query($sql)->result_array();
	}

	public function get_existing_authors($sid){
		$sql = "select * from submission_author where sub_id != '$sid' group by email";
		return $this->db->query($sql)->result_array();
	}

	public function get_existing_reviewers($sid){
		$sql = "select * from submission_reviewer where sub_id != '$sid' group by email";
		return $this->db->query($sql)->result_array();
	}

	public function get_reviewers($sid, $email = null){
		$sql = "select * from submission_reviewer where sub_id = '$sid' order by date_input ASC";
		if($email !== null)
			$sql = "select * from submission_reviewer where sub_id = '$sid' and email='$email' order by date_input ASC";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_reviewers_from_ids($ids = array()){
		$sql = "select * from submission_reviewer where sr_id in (".implode(',', $ids).") order by date_input ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_reviewers_active($sid){
		$sql = "select * from submission_reviewer where sub_id = '$sid' and status = 1 order by date_input ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_current_reviewer($sr_id){
		$sql = "select * from submission_reviewer where sr_id = '$sr_id'"; 
		return $this->db->query($sql)->result_array();
	}

	public function get_current_reviewer_from_db_users($user_id){ //ruki3
		$sql = "select * from users where user_id = '$user_id'";
		return $this->db->query($sql)->result_array();
	}

  
	public function update_reviewer_status($sub_id, $email, $status){
		$sql = "update submission_reviewer set status = '$status' where sub_id = '$sub_id' and email = '$email'";
		return $this->db->query($sql);
	}
  
	public function remove_candidate_reviewer($sub_id, $email){ //ruki
		$sql = "delete from submission_reviewer where sub_id = '$sub_id' and email = '$email'";
		return $this->db->query($sql);
	}

	# model file submission
	public function current_suplement_file($id){
		$sql = "select * from submission_file where sf_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	# funder model upsert
	# check if funder exists by name, than skip inserting funder goto insert submission funder
	# check if funder not exists by name, than inserting funder and insert submission funder
	public function upsert_funder($data){
		$fund = $this->db->query("select * from funder where funder_name = '".$data['funder_name']."'")->result_array();
		if(count($fund) > 0){
			# insert submission funder
			$datasub = array(
				'sub_id'	=> $data['sub_id'],
				'funder_id'	=> $fund[0]['funder_id'],
				'funder_desc'	=> $data['funder_desc'],
				'award_number' => $data['award_number']
			);
			return $this->db->insert('submission_funder', $datasub);
		}else{
			$datafunder = array(
				'funder_name' => $data['funder_name']				
			);
			$this->db->insert('funder', $datafunder);
			$id = $this->db->insert_id();
			$datasub = array(
				'sub_id' => $data['sub_id'],
				'funder_id' => $id,
				'funder_desc' => $data['funder_desc'],
				'award_number' => $data['award_number']
			);
			return $this->db->insert('submission_funder', $datasub);
		}
	}

	public function get_submission_funder($sub_id){
		$sql = "select a.*, b.funder_name from submission_funder a left join funder b on a.funder_id = b.funder_id where a.sub_id = '$sub_id' order by date_input DESC";
		return $this->db->query($sql)->result_array();
	}

	public function get_manuscript_file($sid){
		$sql = "select * from submission_file where type = 1 and sub_id = '$sid'";
		return $this->db->query($sql)->result_array();
	}

	public function get_manuscript_file_type($sid, $round, $type){		
		$sql = "select * from submission_file where type = '$type' and sub_id = '$sid' and round = '$round'";
		if ($round == 9)
			$sql = "select * from submission_file where type = '$type' and sub_id = '$sid' order by sf_id DESC";
		return $this->db->query($sql)->result_array();
	}

	public function clear_submission_funder($sub_id){
		$sql = "delete from submission_funder where sub_id = '$sub_id'";
		return $this->db->query($sql);
	}

	public function clear_submission($sub_id){
		$this->db->query("delete from submission_log_status where sub_id = '$sub_id'");
		$this->db->query("delete from submission_funder where sub_id = '$sub_id'");
		$this->db->query("delete from submission_author where sub_id = '$sub_id'");
		$this->db->query("delete from submission_file where sub_id = '$sub_id'");
		$this->db->query("delete from submission_reviewer where sub_id = '$sub_id'");
		$this->db->query("delete from submission_review where sub_id = '$sub_id'");
		$this->db->query("delete from journal where sub_id = '$sub_id'");
		return true;
	}

	# reviewer 
	public function get_journal_review_user($email, $status = ''){
	    //$tmp = ""; //1: agree, 2: invited (TODO: kalo diklik akan menampilkan pertanyaan agree/disagree) TODO: dari email, klo diklik agree/disagree, larinya jangan ke halaman login
	    $sql = "select a.sub_id
            ,a.user_id
            ,a.sub_title
            ,a.section_id
            ,e.abv edition
            ,a.article_type
            ,a.round
            ,a.sub_status
            ,a.not_publish
            ,a.read_ethics
            ,a.agree_proofread
            ,a.date_input
            ,a.date_submit
            ,a.date_update
            ,a.date_publish
            ,a.date_withdraw
            ,a.withdraw_reason
            ,c.review_id
            ,c.date_round_start
            ,c.review_result
            ,b.section_title
            ,b.section_abv
            ,srr.date_invite
            from submission a
            join section b on a.section_id = b.section_id 
            join submission_reviewer srr on a.sub_id = srr.sub_id
            left join submission_review c on (a.sub_id = c.sub_id and c.reviewer_email = srr.email and c.round = a.round)
            left join editions e on e.id = a.edition
            where 
            (srr.status = 1
            and c.reviewer_email = '$email' 
            and a.sub_status in (3,4,5) 
            and date_review IS NULL)
            or
            (srr.status = 2 and
            srr.email = '$email'
            and a.sub_status in (3,4,5))
            group by a.sub_id, review_id
            order by c.date_round_start DESC"; //20sep2023 left join c diedit ON nya, biar yg round sblmnya udh agree tapi blm kerja ga bisa kasih komen di round berikutny
	    if($status == 'archive'){ 
            //$tmp = "NOT";
            $sql = "select a.*, c.*, b.section_title, b.section_abv, e.abv edition
		        from submission a
		        join section b on a.section_id = b.section_id 
				join submission_review c on a.sub_id = c.sub_id 
				join submission_reviewer srr on (a.sub_id = srr.sub_id and c.reviewer_email = srr.email)
				left join editions e on e.id = a.edition
				where c.reviewer_email = '$email' 
				and (srr.status = 1 or srr.status = 4)
                and date_review IS NOT NULL 
				group by a.sub_id, review_id
				order by c.date_round_start DESC";
                //and (date_review IS NOT NULL OR a.sub_status IN (8,9,10,99) ) "; --> tadinya mau ky gini tapi klo ky gini, reviewer jd bisa ngisi form review dan bisa cetak sertifikat
	    }
	    
		//$sql = ""; //2021-04-01 15:20
				// order by a.date_submit DESC"; //tadinya ada and a.sub_status not in (99), tapi ga adil karena reviewer udh kerja, jadi sub_status=99 tetep ditampilkan
		return $this->db->query($sql)->result_array();
	}
	public function canGiveReview($email, $sub_id){
	    $c = $this->db->query("
	        select count(*) c
	        from submission_reviewer
	        where sub_id = $sub_id
	        and email = '$email'
	        and status <= 2
	    ")->row()->c;
	    if($c>=1){
	        return true;
	    }
	    return false;
	}

	public function check_count_reviewer_approve($sub_id){
		$sql = "select * from submission_reviewer where sub_id = '$sub_id' and status = 1";
		return $this->db->query($sql)->num_rows();
	}

	public function check_count_reviewer_assign($sub_id){
		$sql = "select * from submission_reviewer where sub_id = '$sub_id' and status = 2";
		return $this->db->query($sql)->num_rows();
	}

	public function current_review($review_id){
		$sql = "select * from submission_review where review_id = '$review_id'";
		return $this->db->query($sql)->result_array();
	}

	public function get_review_submission($sub_id, $round = null){
		$sql = "select * from submission_review where sub_id = '$sub_id' and review_result is NOT NULL";
		if($round !== null)
			$sql = "select * from submission_review where (sub_id = '$sub_id' and round = '$round') and review_result is NOT NULL";
		return $this->db->query($sql)->result_array();
	}

	public function get_log_submission_status($sub_id){
		$sql = "select * from submission_log_status where sub_id = '$sub_id' order by date_log ASC";
		return $this->db->query($sql)->result_array();
	}

	# submission screening
	public function get_all_screening_result($sub_id){
		$sql = "select * from submission_screening where sub_id = '$sub_id' and type = 0 order by screening_id ASC";
		return $this->db->query($sql)->result_array();
	}

	public function is_pass_screening_by_eic($sub_id){
		$c = $this->db->query("select count(*) c
			from submission_screening ss
			join users u on u.user_id = ss.user_id
			join roleuser r on r.user_id = u.user_id
			where ss.status = 1
			and ss.sub_id = ?
			and r.role_id = 4",[$sub_id])->row()->c; //status=1 artinya pass, role_id=4 artinya EiC
		if($c>0){ return true; }
		return false;
		/*
		$sql = "select * from submission_screening where sub_id = '$sub_id' and type = 0 order by screening_id DESC limit 0,1";
		$data = $this->db->query($sql)->result_array();
		$res = false;
		if(!empty($data)){
			if($data[0]['eic'] == 1)
				$res = true;
		}
		return $res;
		*/
	}
	
	public function get_current_screening($id){
		$sql = "select * from submission_screening where screening_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function get_message_screening($id){
		$sql = "select * from submission_screening where screening_id = '$id'";
		$data = $this->db->query($sql)->result_array();
		$sub_id = $data[0]['sub_id'];
		$round = $data[0]['round'];		
		
		$res = array(
			'sender' => $this->get_user($data[0]['user_id']),
			'submission' => $this->current_submission($sub_id),
			'screening' => $data,
			'author'	=> $this->get_author_submission($sub_id),
			'review_result' => $this->get_review_submission($sub_id, $round),
		);
		return $res;
	}

	public function get_submission_screening($sub_id, $round = ''){
		$sql = "select * from submission_screening where sub_id = '$sub_id'";
		if($round !== '')
			$sql = "select * from submission_screening where sub_id = '$sub_id' and round = '$round'";
		return $this->db->query($sql)->result_array();
	}
	
	public function get_last_screening($sub_id){
		$sql = "select * from submission_screening where sub_id = '$sub_id' and type = 0 order by screening_id DESC limit 0,1";
		return $this->db->query($sql)->result_array();
	}

	# checking view conditions
	# ==============================================
	public function check_enable_screening($sub_id){
		$sql = "select * from submission_screening where sub_id = '$sub_id' order by date_input DESC limit 0, 1";
		$data = $this->db->query($sql)->result_array();		
		$res = true;
		if(!empty($data)){
			if($data[0]['type'] == 1)
				$res = false;
			// else{
			// 	// if($data[0]['author_respond'] == 0)
			// 	$res = false;
			// }
		}
		return $res;
	}

	public function check_enable_confirm_revise($sub_id){
		$sql = "select * from submission_screening where sub_id = '$sub_id' order by date_input DESC limit 0, 1";
		$data = $this->db->query($sql)->result_array();		
		$res = false;
		if(!empty($data)){
			if($data[0]['author_respond'] == 0 && $data[0]['status'] == 2) //status=2 artinya decisionnya disuruh revise
				$res = true;
		}
		return $res;
	}

	public function revise_agreement($sub_id){
		$last = $this->db->query("select * from submission_screening where sub_id = '$sub_id' order by screening_id DESC limit 0, 1")->result_array();
		$id = $last[0]['screening_id'];		
		$this->db->query("update submission_screening set author_respond = '1' where screening_id = '$id'");
		if ($last[0]['type'] == 1){	 //0=screening, 1=decision on a review round
			$act = "update submission set round = ".($last[0]['round']+1)." where sub_id = '$sub_id'"; //increase round is only done here (no other in whole IJTech code)
			return $this->db->query($act);
		}else
			return false;
	}

	public function check_screening($sub_id){
		$sql = "select * from submission_screening where sub_id = '$sub_id' and type = 1";
		return $this->db->query($sql)->num_rows();		
	}

	public function check_show_suggest_reviewer($sub_id){
		$sql = "select * from submission_screening where sub_id = '$sub_id' and status not in (2,3)";
		return $this->db->query($sql)->num_rows();
	}

	# journal model
	public function get_current_journal($sub_id){
		$sql = "select *, i.date_publish as issue_publish from journal a 
				left join issue i on a.issue_id = i.issue_id 
				left join submission b on a.sub_id = b.sub_id 
				left outer join section c on b.section_id = c.section_id
				where a.sub_id = '$sub_id'";
		return $this->db->query($sql)->result_array();
	}
	public function check_journal_exists($sub_id){
		$sql = "select * from journal where sub_id = '$sub_id'";
		return $this->db->query($sql)->num_rows();
	}

	public function get_date_log($sub_id, $status){
		$sql = "select date_log from submission_log_status where sub_id = '$sub_id' and sub_status = '$status' order by date_log ASC";
		$data = $this->db->query($sql)->result_array();
		if(!empty($data))
			return $data[0]['date_log'];
		return '';
	}

	public function people(){
		$sql = "select * from people order by status ASC";
		return $this->db->query($sql)->result_array();
	}

	public function current_people($pid){
		$sql = "select * from people where pid = '$pid'";
		return $this->db->query($sql)->result_array();
	}

	/* migrate model */
	public function migrate_journal($data){
		$sub = array(
			'section_id' => $data['section_id'],
			'sub_title' => $data['title'],
			'abstract'	=> $data['abstract'],
			'keywords'	=> $data['keywords'],
			'sub_status'	=> 11,
			'date_input'	=> date('Y-m-d H:i:s'),
			'date_update'	=> date('Y-m-d H:i:s'),
			'date_submit'	=> date('Y-m-d H:i:s'),
			'user_id'	=> $this->session->userdata('user_id')
		);		
		$this->db->insert('submission', $sub);
		$sub_id = $this->db->insert_id();
		$_data = array(
			'sub_id' => $sub_id,
			'issue_id' => $data['issue_id'],
			'title'	=> $data['title'],
			'keywords'	=> $data['keywords'],
			'abstract'	=> $data['abstract'],
			'date_accept'	=> $sub['date_submit'],
			'date_submit'	=> $sub['date_submit']
		);
		$act = $this->db->insert('journal', $_data);
		if($act)
			return $sub_id;
	}

	# model update @ 29 April 2017
	# =======================================================================
	public function get_user_privilage($uid){
		$sql = "select role_id from roleuser where user_id = '$uid'";
		$role = array();
		$data = $this->db->query($sql)->result_array();
		if(!empty($data)){
			foreach($data as $p){
				array_push($role, $p['role_id']);
			}
		}
		return $role;
	}

	public function change_privilage($uid, $priv){
		$_clear = $this->db->query("delete from roleuser where user_id = '$uid'");
		if($priv == 5){
			$this->db->insert('roleuser', array('user_id' => $uid, 'role_id' => 5, 'date_create' => date('Y-m-d H:i:s')));
			$this->db->insert('roleuser', array('user_id' => $uid, 'role_id' => 6, 'date_create' => date('Y-m-d H:i:s')));
		}else
			$this->db->insert('roleuser', array('user_id' => $uid, 'role_id' => $priv, 'date_create' => date('Y-m-d H:i:s')));

		return true;
	}
  
	# model update @ 22 August 2018
	# =======================================================================  
	public function get_acceptance_rate(){
		$sql = "select subm.total_sub,pub.total_pub from (select count(*) as total_sub from submission) as subm cross join (select count(*) as total_pub from journal) as pub";
		return $this->db->query($sql)->row_array();
	}

	public function get_time_to_pub(){
		$sql = "SELECT sub_id,DATEDIFF(date_publish,date_submit) as waktu from submission where date(date_publish)>0000-00-00 and date(date_submit)>0000-00-00";
		return $this->db->query($sql)->result_array();
	}
  
	public function get_all_download(){
		$sql = "SELECT count(*) as total_papers,sum(download) as total_download from journal";
		return $this->db->query($sql)->row_array();
	}
	
#certificate
	public function get_certificate($sub_id, $review_id){
		$sql = "SELECT a.*, b.sub_title FROM submission_review a LEFT OUTER JOIN submission b ON a.sub_id = b.sub_id WHERE a.sub_id = $sub_id AND a.review_id = $review_id";
		return $this->db->query($sql)->row_array();
	}
	
############### manajemen data reviewer
/*
		//user dengan role reviewer yg minimal doktor, yg memilih sectionnya = 1
select s.section_title, u.email, u.email2, u.first_name, u.last_name, u.affiliation, u.affiliation2, u.suggested_affiliation, u.country, u.expertise, u.suggested_expertise
from users u
join section s on s.section_id = u.section_id
join roleuser r on r.user_id = u.user_id
where s.section_id = 1
and (u.salutation LIKE "%prof%" or u.salutation LIKE "%dr%")
and r.role_id = 6
	//apakah paper yg dia review udah kepublish?
	//apakah dia juga author? apakah papernya sudah kepublish?	
	//gimana kinerja reviewing nya?
	
	//// update section user --> ternyata semua user sudah punya section	
select u.user_id from //baris ini bisa diganti jd "update"
users as u
inner join (
select user_id, section_id
from submission as s
where s.sub_status > 0
) as A on u.user_id = A.user_id
where u.section_id = 0

	/// contoh update count juga --> buat itung kinerja reviewer
Update
Competition as C
inner join (
select CompetitionId, count(*) as NumberOfTeams
from PicksPoints as p
where UserCompetitionID is not NULL
group by CompetitionID
) as A on C.CompetitionID = A.CompetitionID
set C.NumberOfTeams = A.NumberOfTeams

	/// hubungkan tiap user di submission_author dengan user di tabel users
Update submission_author as sa
inner join (
select u.user_id, u.email from users u
where u.email!=""
limit 0,1000 //sliding window
) as A on A.email = sa.email
set sa.user_id = A.user_id
where sa.user_id=0 and sa.email!=""
	/// tambahkan keyword dari author of published papers ke tabel users
update users as u
inner join (
select s.sub_id, s.user_id, j.keywords from submission s
join journal j on j.sub_id = s.sub_id
where j.keywords!=""
) as X on u.user_id = X.user_id
set u.expertise = concat(u.expertise, ', ', replace(X.keywords,';',','));
	/// masukkan nama section di expertise
update users as u
inner join (
select section_title, section_id from section
) as s on s.section_id = u.section_id
set u.expertise = concat(lcase(s.section_title), ', ', u.expertise);
	/// cleanup similar expertise via PHP: http://ijtech.eng.ui.ac.id/dashboard/adminOnly_removeDuplicateExpertiseForAllUsers
	
*/

	public function adminOnly_removeDuplicateExpertiseForAllUsers($where=""){ //clean up: remove duplicate, lowercase, trim, trim comma
		if($where!=""){$where = " and ".$where;}
		$sql = "select u.user_id, u.expertise, u.suggested_expertise from users u where (u.expertise!='' or u.suggested_expertise!='') ".$where;
		$tmp = 'yg berubah:<br>';
		foreach ( $this->db->query($sql)->result() as $u ){
			$ar0 = explode(',',trim(trim(strtolower($u->expertise),',')));
			$ar1 = explode(',',trim(trim(strtolower($u->suggested_expertise),',')));
			$ar = array_merge($ar0,$ar1);
			$ar2 = array_filter(array_unique(array_map('trim', $ar)));
// echo '<pre>';
// print_r($ar2);
// die();
			if($ar !== $ar2){
				$this->db->where('user_id',$u->user_id)->update('users',array('suggested_expertise'=>implode(', ',$ar2)));
				$tmp .= $this->db->affected_rows().'<br>';
			}
		}
		die($tmp);
	}

}