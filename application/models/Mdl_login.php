<?php
/**
 * @ author : Sabbana
 * @ corp : Pajon/sstud-io.net
 * @ date : 21-09-2016
 */
class Mdl_login extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function auth($user, $pass){
		$pass = md5($pass);
		$sql = "select * from users 
				where (user_id = '$user' or email = '$user') and password = '$pass' and status = 1";		
		return $this->db->query($sql)->result_array();
	}
	
	public function get_role_user($user_id){
		$sql = "select * from roleuser where user_id = '$user_id'";
		$data = $this->db->query($sql)->result_array();
		$res = array();
		if(!empty($data))
			foreach ($data as $a){
				array_push($res, $a['role_id']);
			}
		return $res;
	}

	public function get_rolename_user($user_id){
		$sql = "select a.*, b.role_name from roleuser a left join role b on a.role_id = b.role_id where a.user_id = '$user_id'";
		$data = $this->db->query($sql)->result_array();
		$res = array();
		if(!empty($data))
			foreach ($data as $a){
				array_push($res, $a['role_name']);
			}
		return $res;
	}

	public function get_section_editor($user_id){
		$sql = "select * from section_editor where user_id = '$user_id'";
		$data = $this->db->query($sql)->result_array();
		$res = array();
		if(!empty($data))
			foreach ($data as $a){
				array_push($res, $a['section_id']);
			}
		return $res;
	}

	public function create_user($data){
		$r = $this->db->query("select * from users where email='".$data['email']."'")->row();
		if(isset($r)){
			if($r->status==-1){ //user ini sudah pernah disuggest oleh author lain utk mjd reviewer, tapi blm pernah diinvite.
				if($data['section_id']==0){unset($data['section_id']);}
				$this->db->update('users', $data, "user_id = '".$data['email']."'");
				return 'account activated';
			}else{ //user ini udh pernah create account..
				return 'account exist';
			}
		}
		$this->db->insert('users', $data);
		return 'account created';
	}
	
	public function check_user($key, $value){
		$sql = "select * from users where $key = '$value' and status != -1 ";
		return $this->db->query($sql)->num_rows();
	}
	
	public function check_user_data($key, $value){
		$sql = "select * from users where $key = '$value'";
		return $this->db->query($sql)->result_array();
	}
	
	public function account_activation($token){
		$sql = "update users set status = 1 where password = '$token'";
		return $this->db->query($sql);
	}
	
	public function update($id, $data){
		$this->db->where('user_id', $id);
		return $this->db->update('users', $data);
	}
  
/*date modified = 19-9-2018, vincent */
	
	public function get_userdata_new($user_id){
		$sql = "select * from users where user_id = '$user_id'";
		return $this->db->query($sql)->result_array();	
	}
	
}


