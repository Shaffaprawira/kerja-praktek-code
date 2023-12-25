<?php

class Mdl_migrate extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	

	public function set_roles($user_id, $roles=array()){
		$res = false;
		if(!empty($roles)){
			for($a=0; $a<count($roles); $a++){
				$sql = "select * from roleuser where user_id = '$user_id' and role_id = '".$roles[$a]."'";
				$_exists = $this->db->query($sql)->num_rows();
				if($_exists == 0)
					$this->db->insert('roleuser', array('user_id' => $user_id, 'role_id' => $roles[$a], 'date_create' => date('Y-m-d H:i:s')));
			}
			$res = true;
		}
		return $res;
	}

	public function check_roles($user_id){
		$sql = "select * from roleuser where user_id = '$user_id'";
		return $this->db->query($sql)->num_rows();
	}

	public function migrate_user($offset= 0, $limit = 0){
		$sql = "select * from user_x order by date_create DESC limit $offset, $limit";
		$data = $this->db->query($sql)->result_array();
		if(!empty($data)){
			$no=0;
			foreach ($data as $u) {
				$no++;
				$_cek = "select * from users where email = '".$u['email']."' or user_id = '".$u['user_id']."'";
				$check = $this->db->query($_cek)->num_rows();
				if($check > 0){					
					$this->set_roles($u['user_id'], array(5,6));					
					echo $no.". User registered ".$u['email']."<br/>";
				}else{
					$_reg = "insert into users select * from user_x where email = '".$u['email']."'";
					$ex = $this->db->query($_reg);
					if($ex){					
						$this->set_roles($u['user_id'], array(5,6));						
						echo $no.". New user migrate : ".$u['email']." | ".$u['first_name'].' '.$u['last_name']."<br/>";
					}
				}
			}
		}
	}

	
	
}


