<?php

/**
 * Journal engineering FTUI	
 * @ author	: Sabbana
 * @ corp	: Pajon Tech/sstud-io.net
 * @ Date Created	: 17 Sept 2016
 */

class Mdl_front extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function static_page($id){
		$sql = "select * from page where page_id = '$id'";
		return $this->db->query($sql)->result_array();		
	}

	public function get_issue($id = null){		
		// $sql = "select * from issue order by date_input DESC"; //issue yg artikel2nya blm dipublish akan keliatan
		$sql = "select issue.* from issue join journal on issue.issue_id = journal.issue_id where journal.date_publish IS NOT NULL group by issue_id order by date_input DESC";
		if($id != null)
			$sql = "select * from issue where issue_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function current_issue(){
		$sql = "select * from issue where status = 1";
		return $this->db->query($sql)->result_array();
	}

	public function get_article($param){ //TODO: pagination
		$sql = "select a.*, b.sub_title, b.user_id from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9 ORDER BY b.user_id ASC limit 10";
		if ($param == 'issue')
			$sql = "select a.*, b.sub_title, b.user_id from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9 ORDER BY a.issue_id ASC";
		else if($param == 'title')
			$sql = "select a.*, b.sub_title, b.user_id from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9 ORDER BY a.title ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_journal($param){
		$sql = "select a.* from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9 ORDER BY user_id ASC";
		if ($param == 'issue')
			$sql = "select a.* from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9 ORDER BY b.issue_id DESC";
		else if($param == 'title')
			$sql = "select a.* from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9 ORDER BY a.title ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_announcement($num = 10, $offset = 0){
		$this->db->select('*');
		$this->db->join('users b','a.user_id = b.user_id','left');
		$this->db->where('a.expire_date','0000-00-00 00:00:00');
		$this->db->or_where('a.expire_date <= ','CURRENT_DATE()');
		$this->db->order_by("a.date_input", "DESC"); 
		$query = $this->db->get('announcement a', $num, $offset)->result_array();
		return $query;
	}

	public function count_announcement(){
		$this->db->select('*');
		$this->db->join('users b','a.user_id = b.user_id','left');
		$this->db->where('a.expire_date','0000-00-00 00:00:00');
		$this->db->or_where('a.expire_date <= ','CURRENT_DATE()');
		$this->db->order_by("a.ann_id", "DESC"); 
		$query = $this->db->get('announcement a')->num_rows();
		return $query;
	}

	public function current_announcement($id){
		$sql = "select * from announcement where ann_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function latest_news(){
		$sql = "select * from announcement order by date_input DESC limit 0,3";
		return $this->db->query($sql)->result_array();	
	}
	# submission
	public function get_all_submission(){
		$sql = "select * from submission a 
				left join section b on a.section_id = b.section_id where sub_status = 9
				order by a.date_input DESC";
		return $this->db->query($sql)->result_array();
	}
	public function count_journal($issue=null){
		if($issue !== null){
			$this->db->select('a.*, b.*, a.date_publish as publish_date');
			$this->db->join('submission b','a.sub_id = b.sub_id','left');
			$this->db->where('b.sub_status',9);			
			$this->db->where('a.issue_id', $issue);			
		}else{
			$this->db->select('a.*, b.*, a.date_publish as publish_date');
			$this->db->join('submission b','a.sub_id = b.sub_id','left');
			$this->db->where('b.sub_status',9);						
		}

		$query = $this->db->get('journal a')->num_rows();
		return $query;
	}

	public function count_journal_issue($issue_id){
		$this->db->select('a.*, b.*, a.date_publish as publish_date');
		$this->db->join('submission b','a.sub_id = b.sub_id','left');
		$this->db->where('b.sub_status',9);
		$this->db->where('a.issue_id', $issue_id);
		$query = $this->db->get('journal a')->num_rows();
		return $query;
	}

	public function get_all_journal($num = 10, $offset = 0){
		$this->db->select('a.*, b.*, a.date_publish as publish_date');
		$this->db->join('submission b','a.sub_id = b.sub_id','left');
		$this->db->where('b.sub_status',9);
		$this->db->order_by("a.issue_id", "DESC"); 
		$this->db->order_by("cast(a.pages as unsigned)", "ASC"); 
		$query = $this->db->get('journal a', $num, $offset)->result_array();
		return $query;
	}

	public function get_all_journal_issue($issue_id, $num = 10, $offset = 0){
		$this->db->select('a.*, b.*, a.date_publish as publish_date');
		$this->db->join('submission b','a.sub_id = b.sub_id','left');
		$this->db->where('b.sub_status',9);
		$this->db->where('a.issue_id', $issue_id);
		$this->db->order_by("cast(a.pages as unsigned)", "ASC");
		$query = $this->db->get('journal a', $num, $offset)->result_array();
		return $query;
	}
	public function get_mostDownloadedArticles(){
		$query = $this->db->query("select journal_id, sub_id, issue_id, title, pdf_file, download, date_publish from journal order by download desc limit 20")->result_array();
		return $query;
	}
	
	public function get_submission_by_issue($issue_id){
		$sql = "select a.* from journal a 
				left join submission b on a.sub_id = b.sub_id
				left join issue x on a.issue_id = x.issue_id
				left outer join section c on b.section_id = c.section_id 
				where a.issue_id = '$issue_id' and b.sub_status = 9 order by cast(a.pages as unsigned) ASC";
		return $this->db->query($sql)->result_array();		
	}

	public function current_submission($sid){
		$sql = "select a.*, b.section_id, b.section_abv, b.section_title from submission a 
				left join section b on a.section_id = b.section_id where a.sub_id = '$sid'";
		return $this->db->query($sql)->result_array();		
	}
	
	public function current_journal($sid){
		$sql = "select z.*, c.*, b.*, z.date_publish as publish_date, a.round from journal z
				left join submission a on z.sub_id = a.sub_id
				left outer join section b on a.section_id = b.section_id 
				left join issue c on z.issue_id = c.issue_id where a.sub_id = '$sid'";
		return $this->db->query($sql)->result_array();
	}

	public function get_author_submission($sid){
		$sql = "select * from submission_author where sub_id = '$sid' order by date_input ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_submission_reviewer($sid){
		$sql = "select * from submission_reviewer where sub_id = '$sid' order by date_input ASC";
		return $this->db->query($sql)->result_array();	
	}

	public function get_submission_file($sid){
		$sql = "select * from submission_file where sub_id = '$sid' order by date_input ASC";
		return $this->db->query($sql)->result_array();	
	}

	public function get_authors($sid){
		$sql = "select * from submission_author where sub_id = '$sid' order by date_input ASC";
		return $this->db->query($sql)->result_array();
	}

	public function get_reviewers($sid){
		$sql = "select * from submission_reviewer where sub_id = '$sid' order by date_input ASC";
		return $this->db->query($sql)->result_array();
	}

	public function current_suplement_file($id){
		$sql = "select * from submission_file where sf_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function get_preview_image($sid){
		$sql = "select * from submission_file where type = 0 and sub_id = '$sid' order by sf_id desc";
		return $this->db->query($sql)->result_array();
	}

	public function count_download($id){		
		$data = $this->current_journal($id);
		$tot = $data[0]['download']+1;
		$sql = "update journal set download = '$tot' where sub_id = '$id'";
		return $this->db->query($sql);
	}

	public function get_people($status){
		$sql = "select * from people where status = '$status' order by fullname asc";
		return $this->db->query($sql)->result_array();	
	}

	public function current_people($id){
		$sql = "select * from people where pid = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function search($by, $q='', $num = 10, $offset = 0){
		$this->db->select('a.title, a.keywords, a.doi_url, a.pages, a.journal_id, b.sub_id, a.date_publish');
		$this->db->join('submission b','a.sub_id = b.sub_id','left');
		$this->db->join('issue c','a.issue_id = c.issue_id','left');

		if($by == "all" || $by == "title")
			$this->db->like('a.title', $q);

		if($by == "keywords")
			$this->db->like('a.keywords', $q);

		if($by == "issue"){
			$this->db->or_group_start();
				$this->db->where('c.volume', $q);
				$this->db->or_where('c.issue_number', $q);
				$this->db->or_where('c.year', $q);
			$this->db->group_end();
		}

		if($by == "author"){
			$this->db->join('submission_author d','b.sub_id = d.sub_id','right');
			$this->db->group_start();
        $qs = explode(" ",$q);
        foreach($qs as $qss){
          $this->db->or_where('d.first_name',$qss);
          $this->db->or_where('d.last_name', $qss);
        }
				// $this->db->or_group_start();
				// 	$this->db->or_like('d.first_name', $q);
				// 	$this->db->or_like('d.last_name', $q);
				// $this->db->group_end();
			$this->db->group_end();
		}
		$this->db->where('b.sub_status',9);
		$this->db->order_by("a.date_publish", "DESC"); 
		$query = $this->db->get('journal a', $num, $offset)->result_array();
		return $query;		
	}

	public function count_search($by, $q=''){
		$this->db->select('a.title, a.keywords, a.doi_url, a.pages, a.journal_id, b.sub_id, a.date_publish');
		$this->db->join('submission b','a.sub_id = b.sub_id','left');
		$this->db->join('issue c','a.issue_id = c.issue_id','left');

		if($by == "all" || $by == "title")
			$this->db->like('a.title', $q);

		if($by == "keywords")
			$this->db->like('a.keywords', $q);

		if($by == "issue"){
			$this->db->or_group_start();
				$this->db->where('c.volume', $q);
				$this->db->or_where('c.issue_number', $q);
				$this->db->or_where('c.year', $q);
			$this->db->group_end();
		}

		if($by == "author"){
			$this->db->join('submission_author d','b.sub_id = d.sub_id','right');
      
			$this->db->group_start();
        $qs = explode(" ",$q);
        foreach($qs as $qss){
          $this->db->or_where('d.first_name',$qss);
          $this->db->or_where('d.last_name', $qss);
        }
				// $this->db->or_group_start();
					// $this->db->or_like('d.first_name', $q);
					// $this->db->or_like('d.last_name', $q);
				// $this->db->group_end();
			$this->db->group_end();
		}
		$this->db->where('b.sub_status',9);
		$this->db->order_by("a.date_publish", "DESC"); 
		$query = $this->db->get('journal a')->num_rows();
		// $query = $this->db->from('journal a')->get_compiled_select();
    // die($query);
		return $query;
	}

// fungsi mendata reviewer pada issue
// date update : 16-11-2018
	public function get_reviewer_issue($issue_id){
		$sql = "SELECT c.* from users c left outer join  (select distinct (a.reviewer_email) from submission_review a inner join journal b on a.sub_id = b.sub_id where b.issue_id = $issue_id and a.review_result != 0 and a.canListAck = 1) d on c.email = d.reviewer_email where c.email = d.reviewer_email or c.email2 = d.reviewer_email";
		return $this->db->query($sql)->result_array();
	}
  
  // public function count_search_all($by, $q=''){ //ruki
  //   $this->db->select('a.title, a.keywords, a.doi_url, a.pages, a.journal_id, b.sub_id, a.date_publish');
  //   
  //   $query = $this->db->get()->num_rows();
  //   
  //   "SELECT * FROM `journal` WHERE (`title` LIKE '%ruki%' OR `keywords` LIKE '%ruki%' OR `abstract` LIKE '%ruki%' OR `introduction` LIKE '%ruki%' OR `experimental_method` LIKE '%ruki%' OR `result` LIKE '%ruki%' OR `conclusion` LIKE '%ruki%' OR `acknowledgement` LIKE '%ruki%' OR `references` LIKE '%ruki%')"
  //   join submission_author 
  //   
  //   
  //   return $query
	// }

}