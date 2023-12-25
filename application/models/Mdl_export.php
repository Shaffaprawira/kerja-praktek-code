<?php

class Mdl_export extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function submission($status = "", $year = "", $section = ""){
		$filter = "where sub_status > 0";
		if($status !== "")
			$filter = "where sub_status = ".$status;
		if($year !== "")
			$filter .= " and date_submit like '".$year."%'";
		if($section !== "")
			$filter .= " and a.section_id = ".$section;
		$sql = "select * from submission a left join section b on a.section_id = b.section_id ".$filter." order by date_submit DESC, sub_status ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_sections(){
		$sql = "select * from section order by section_title ASC";
		return $this->db->query($sql)->result_array();
	}

	public function reviewer($status = "", $year = ""){
		$filter = " where email != ''";
		if($status !== "" && $year !== "")
			$filter = " where status = ".$status." and date_input like '".$year."%' and email != ''";
		if($status !== "" && $year == "")
			$filter = " where status = ".$status." and email != ''";
		if($year !== "" && $status == "")
			$filter = " where date_input like '".$year."%' and email != ''";
		$sql = "select distinct(email) as email, fullname, salutation, expertise, affiliation from submission_reviewer".$filter." group by email order by date_input ASC";
		
		return $this->db->query($sql)->result_array();
	}
}


