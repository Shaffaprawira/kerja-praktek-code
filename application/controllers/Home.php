<?php

/**
 * Journal engineering FTUI	
 * @ author	: Sabbana
 * @ corp	: Pajon Tech/sstud-io.net
 * @ Date Created	: 17 Sept 2016
 */

class Home extends CI_Controller{

	var $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->model('Mdl_front','front');
		$this->load->model('Mdl_cms','cms'); //ruki31jan2019
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

	public function index(){
		$session = $this->session->userdata('ci');
		$issue_id = $session['issue_id'];
		$this->data['title'] = 'International Journal of Technology';
		$this->data['page'] = 'page/home';
		$tot = $this->front->count_journal_issue($issue_id);
		$this->load->library('pagination');
		$config = array(
			'base_url'		 => base_url().'article/page/',
			'total_rows'	 => $tot,
			'per_page'		 => 10,
			'full_tag_open'	 => '<ul class="pagination pagination-sm text-center">',
			'full_tag_close' => '</ul>',
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
		);
		$offset = $this->uri->segment(3)? (($this->uri->segment(3)-1) * $config['per_page']) : 0;
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$this->data['journal'] = $this->front->get_all_journal_issue($issue_id, $config['per_page'], $offset);
		$this->data['mostDownloadedArticles'] = $this->front->get_mostDownloadedArticles();
		$this->data['news'] = $this->front->latest_news();		
		$this->load->view('template_front', $this->data);
	}
	
	public function mostdownloadedpapers(){
		$this->data['title'] = 'International Journal of Technology';
		$this->data['page'] = 'page/static';
		
	    $papers = $this->front->get_mostDownloadedArticles();
	    $t = '<h1>Top 20 most downloaded papers</h1><p>&nbsp;</p><ol>';
	    if(!empty($papers)){foreach($papers as $s){
	      $t .= '<li><b><a href="'.site_url().'article/view/'.$s['sub_id'].'">'.$s['title'].'</a></b>
					<div style="font-size:small;color:#999;padding-left:20px"><small>'.$this->lib_view->author_submission($s['sub_id']).'</small>
					<br><span title="published date"><i class="fa fa-calendar"></i> '.date('d M Y', strtotime($s['date_publish'])).'</span> &nbsp;  &nbsp;  &nbsp; <span title="number of downloads"><i class="fa fa-download"></i> '.$s['download'].'</span></div></li>
	      ';  
	    }}
	    $this->data['content'] = array('0' => array('page_title'=>'Top-10 Most Downloaded Papers','page_content'=>$t.'</ol>'));
	    $this->load->view('template_front', $this->data);
	}
	
	public function get_info(){ //ruki31jan2019
		$tmp = $this->cms->get_info();
		
		$acc_rates = 0;
		$acc = $this->cms->get_acceptance_rate();
		$acc_rates = $acc['total_pub']/$acc['total_sub']*100;
		$acc_rates = round($acc_rates,2);
		
		$publish = $this->cms->get_time_to_pub();
		$days = 0;
		foreach ($publish as $row) {
			$days += $row['waktu'];
		}
		$total_pub = count($publish);
		$avg = $days/$total_pub;
		
		$persentase_diterima = number_format(100 * $acc['total_pub'] / ($acc['total_sub'] + 2297),2); //2297 adalah total paper di web lama yg rejected.
		die($tmp[0]['value'].'<hr>Acceptance rate: <b>'.$persentase_diterima.'</b> %<br>Average time to publish: <b>'.number_format($avg).'</b> days.');
	}
	
	public function register(){
		$this->data['section'] = $this->cms->get_all_section();
		$this->data['page'] = 'page/register';
		$this->data['title'] = 'Register';
		$this->load->view('template_front', $this->data);
	}

	public function about($id, $param = null){
		$this->data['param'] = $param ? $param:'about';
		$this->data['page'] = 'page/static';
		$this->data['content'] = $this->front->static_page($id);
		$this->load->view('template_front', $this->data);
	}

	public function announcement($param = null, $id = null){
		$this->load->library('pagination');
		$this->data['param'] = 'Announcement';		
		$tot = $this->front->count_announcement();
		$config = array(
			'base_url'		 => base_url().'announcement/page/',
			'total_rows'	 => $tot,
			'per_page'		 => 10,
			'full_tag_open'	 => '<ul class="pagination pagination-sm text-center">',
			'full_tag_close' => '</ul>',
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
		);
		$offset = $this->uri->segment(3)? (($this->uri->segment(3)-1) * $config['per_page']) : 0;
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$this->data['announcement'] = $this->front->get_announcement($config['per_page'], $offset);

		if($param == "view"){			
			$this->data['detail'] = 'detail';
			$this->data['announcement'] = $this->front->current_announcement($id);
		}
		$this->data['page'] = 'page/announcement';
		$this->load->view('template_front', $this->data);
	}

	# review message for review feedback
	public function review($sub_id){
		$data['sub'] = $this->cms->current_submission($sub_id);
		if(!empty($data['sub']))
			$this->load->view('template/front/page/review_message', $data);
		else
			redirect('home');
	}

	public function archives(){
		$this->data['title'] = 'Archives';
		$this->data['page'] = 'page/archives';
		$this->data['issue'] = $this->front->get_issue();
		$this->load->view('template_front', $this->data);
	}
	
	public function people(){
		$this->data['title'] = 'Editorial Team';
		$this->data['page'] = 'page/people';
		$this->data['people1'] = $this->front->get_people(1);
		$this->data['people2'] = $this->front->get_people(2);
		$this->data['people3'] = $this->front->get_people(3);
		$this->load->view('template_front', $this->data);
	}

	public function issue($id=''){
		$this->data['page'] = 'page/issue';
		if($id !== ''){
			$this->data['title'] = 'Journal Issue';
			$this->data['issue'] = $this->front->get_issue($id);
			$this->data['submission'] = $this->front->get_submission_by_issue($id);
		}else{
			$id = $this->session->userdata('ci')['issue_id']; //userdata('ci')['issue_id'] harus diset ke latest issue yg published (atau yg kolom status nya ==1 di tabel issue)
			$this->data['title'] = 'Current Issue';
			$this->data['issue'] = $this->front->get_issue();
			$this->data['submission'] = $this->front->get_submission_by_issue($id);
		}
		if(count($this->data['issue']) > 0)
			$this->load->view('template_front', $this->data);
		else redirect('_404');
	}

	# date update: 16-11-2018 - function reviewer
	public function reviewer($id=''){
		$this->data['page'] = 'page/issue_reviewer';
		$this->data['issue'] = $this->front->get_issue($id);		
		$this->data['issue_reviewer'] = $this->front->get_reviewer_issue($id);
		if(count($id>0))
			$this->load->view('template_front',$this->data);
		else redirect('_404');
	}

	public function article($param, $id = ""){
		$this->data['page']	= 'page/article';
		$this->data['param'] = $param;
		if ($param == 'sortby'){			
			$this->data['title'] = 'Article by '. $id;
			$this->data['articles'] = $this->front->get_article($id);
		}else if($param = 'view'){
			$this->data['articles'] = $this->front->current_journal($id);
			$this->data['authors'] = $this->lib_view->author_submission($id);
		}
		if(count($this->data['articles']) > 0){
			# meta
			if($param == 'view'){
				$this->data['title'] = $this->data['articles'][0]['title'];
				$this->data['supplement'] = $this->cms->get_manuscript_file_type($id, $this->data['articles'][0]['round'], 3);
				$this->data['meta']['description'] = strip_tags($this->data['articles'][0]['abstract']);
				$this->data['meta']['keywords'] = strip_tags($this->data['articles'][0]['keywords']);
                $this->data['meta']['authors'] = $this->data['authors'];
				$this->data['meta']['title'] = strip_tags($this->data['articles'][0]['title']);
				# open graph for facebook			
				$images = $this->cms->get_manuscript_file_type($id, $this->data['articles'][0]['round'], 0);				
				if(!empty($images)){
					$image = str_replace('./', '', $images[0]['file_url']);
					$this->data['ogfb']['og:image'] = site_url().$image;
					$this->data['ogtw']['twitter:image'] = site_url().$image;
				}
				$this->data['ogfb']['og:url'] = current_url();
				$this->data['ogfb']['og:type'] = 'article';
				$this->data['ogfb']['og:title'] = (string)$this->data['articles'][0]['title'];
				$this->data['ogfb']['og:description'] = substr($this->data['meta']['description'], 0, 250);
				$this->data['ogfb']['og:site_name'] = 'IJTech - International Journal of Technology';
				# open graph for twitter
				$this->data['ogtw']['twitter:card'] = 'detail_article';
				$this->data['ogtw']['twitter:site'] = '@ijtech';
				$this->data['ogtw']['twitter:creator'] = '@ijtech';
				$this->data['ogtw']['twitter:title'] = (string)$this->data['articles'][0]['title'];
				$this->data['ogtw']['twitter:description'] = substr($this->data['meta']['description'], 0, 250);
			}
			$this->load->view('template_front', $this->data);
		}else redirect('_404');
	}
	
	public function get_bibtex($sub_id){
		$name = "ijtech-$sub_id.bib"; 
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Expires: 0');
		// next - do a query
		$r = $this->db->query("SELECT 
			j.title,
			j.pages,
			year(j.date_publish) as year,
			date_format(j.date_publish,'%b') as month,
			j.doi_url as DOI,
			i.volume,
			i.issue_number as number,
			group_concat(concat(sa.first_name,' ',sa.last_name)) as author
			from journal j 
			join submission_author sa on sa.sub_id = j.sub_id
			join issue i on i.issue_id = j.issue_id
			where j.sub_id = $sub_id
			group by j.sub_id
			")->row();
		// use echo for testing purposes only
		// cause echo considered as a content of your file
		echo "@article{ijtech-$sub_id,
				title={" . $r->title . "},
				author={" . $r->author . "},
				volume={" . $r->volume . "},
				number={" . $r->number . "},
				year={" . $r->year . "},
				month={" . $r->month . "},
				pages={" . $r->pages . "},
				DOI={" . $r->DOI . "},
				journal={International Journal of Technology},
				ISSN={2087-2100}}";
		$fp = fopen($name, 'a');
		// $text = ""; //test (it doesn't appears on archive and I don't know why, so I used the echo above and worked, but this is what should be on archive, or isn't?)
		// fwrite($fp, $text);
		fclose($fp);   // don't forget to close file for saving newly added data
		readfile($name);   // readfile takes a filename, not a handler.
		unlink($name); // tanpa ini, file akan kesimpen di root of public dir
		die();    // end your script cause in other case all other data will be outputted too
	}
	public function get_ris($sub_id){
		$name = "ijtech-$sub_id.ris"; 
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Expires: 0');
		// next - do a query
		$r = $this->db->query("SELECT 
			j.sub_id,
			j.title,
			j.pages,
			year(j.date_publish) as year,
			date_format(j.date_publish,'%m') as month,
			date_format(j.date_publish,'%d') as day,
			j.doi_url as DOI,
			i.volume,
			i.issue_number as number,
			group_concat(concat(sa.first_name,' ',sa.last_name)) as author
			from journal j 
			join submission_author sa on sa.sub_id = j.sub_id
			join issue i on i.issue_id = j.issue_id
			where j.sub_id = $sub_id
			group by j.sub_id
			")->row();
		// use echo for testing purposes only
		// cause echo considered as a content of your file
		echo "TY  - JOUR
T1  - $r->title
AU  - $r->author
JO  - International Journal of Technology
VL  - $r->volume
IS  - $r->number
SP  - 291
EP  - 319
PY  - $r->year
DA  - $r->year/$r->month/$r->day
SN  - 2087-2100
DO  - $r->DOI
UR  - https://ijtech.eng.ui.ac.id/article/view/$r->sub_id
			";
		$fp = fopen($name, 'a');
		// $text = ""; //test (it doesn't appears on archive and I don't know why, so I used the echo above and worked, but this is what should be on archive, or isn't?)
		// fwrite($fp, $text);
		fclose($fp);   // don't forget to close file for saving newly added data
		readfile($name);   // readfile takes a filename, not a handler.
		unlink($name); // tanpa ini, file akan kesimpen di root of public dir
		die();    // end your script cause in other case all other data will be outputted too
	}

	public function download($id){ //Ruki16feb2019
		$this->load->helper('download');
		$tmp = explode('erratum',$id);
		if(count($tmp)==2){ //download erratum
			$id=$tmp[1];
			$data = $this->front->current_journal($id);
			force_download($data[0]['erratum_file'], NULL);
		}else{ //download paper
			$data = $this->front->current_journal($id);
			$act = $this->front->count_download($id);
			if($act){
				$path = $data[0]['pdf_file'];
				$tmp = $this->db->query("select
				    sec.section_abv,j.sub_id,j.title
                    from journal j
                    join submission s on s.sub_id = j.sub_id
                    join section sec on sec.section_id = s.section_id 
                    where j.sub_id = ?
				",[$id])->row();
				
				$filename = preg_replace("/[^A-Za-z0-9 ]/", '', $tmp->title); //sisakan alphanumeric dan spasi saja
				$filename = substr($filename,0,50); //sisakan 50 karakter pertama saja
				$filename = str_replace(" ","-",$filename); //replace spasi dengan dash
				
				$filename = "IJTech_".$tmp->section_abv."-".$id."_".$filename.".pdf";
				header('Content-type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				//force_download($path, NULL);
				readfile($path);
			}
		}
	}
	
	public function article_sortby($by=""){
		$this->data['page']	= 'page/article';
		$this->data['param'] = 'sortby';
		$this->data['title'] = 'Article by '. $by;
		$this->load->library('pagination');
		$tot = $this->db->query("select count(*) c from journal a left join submission b on a.sub_id = b.sub_id where b.sub_status = 9")->row()->c;
		$config = array(
			'base_url'			=> base_url().'home/article_sortby/title/',
			'total_rows'		=> $tot,
			'per_page'		 	=> 20,
			'num_links'			=> 3,			
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
		$offset = $this->uri->segment(4)? (($this->uri->segment(4)-1) * $config['per_page']) : 0;
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();
		$limit = $config['per_page'];
		$sql = "select 
			j.sub_id
			,j.title sub_title
			,j.date_publish
			,j.doi_url
			,j.pages
			from journal j
			left join submission s on s.sub_id = j.sub_id and s.sub_status = 9";
		if($by == 'title'){ $sql .= " order by j.title ASC "; }
		$sql .= " limit $limit offset $offset";
		$this->data['articles'] = $this->db->query($sql)->result_array();
		// echo '<pre>';print_r($this->data['articles']);die();
		$this->load->view('template_front', $this->data);
	}

	public function search(){
		$this->load->library('pagination');
		$this->data['title'] = 'Search Result';
		$this->data['page'] = 'page/search';
        if(!isset($_GET['by']) && !isset($_GET['q'])){ redirect('home'); }
		$tot = $this->front->count_search($_GET['by'], $_GET['q']);
		$config = array(
			'base_url'			=> base_url().'search/page/',
			'total_rows'		=> $tot,
			'per_page'		 	=> 5,
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
		$offset = $this->uri->segment(3)? (($this->uri->segment(3)-1) * $config['per_page']) : 0;
		$this->pagination->initialize($config);
		$this->data['paging'] = $this->pagination->create_links();		
		$this->data['result'] = $this->front->search($_GET['by'], $_GET['q'], $config['per_page'], $offset);
		$this->load->view('template_front', $this->data);
	}

	public function current_people($id){
		header('Content-type:application/json');
		$data = $this->front->current_people($id);
		echo json_encode($data);
	}

	private function log_submission($sub_id, $status, $desc){
		return $this->cms->log_submission($sub_id, $status, $desc);
	}

	# for inline editing confirmation
	public function confirmation($sub_id, $type=1){
		$sub = $this->front->current_submission($sub_id);
		if(!empty($sub)){
			$journal_id = ($sub[0]['round'] > 1 ? 'R'.($sub[0]['round']-1).'-':'').$sub[0]['section_abv'].'-'.$sub[0]['sub_id'];

			if($sub[0]['sub_status'] == 8){
				$author = $this->cms->get_corresponding_author($sub_id);
				$other_author = $this->cms->get_other_author($sub_id, true);
				
				if($type == 1) $mailer = 'ijtech_inline_editing';
				else $mailer = 'other_inline_editing';

				$result = array('journal_id' => $journal_id, 'journal'	=> $sub, 'author'	=> $author);
				// $message = $this->load->view('template/mailer/author/'.$mailer, $result, TRUE);
				// $this->load->library('email'); // load email library
				// $this->email->from(MAILSYSTEM, 'IJTech');
				// $this->email->to($author[0]['email']);

				// if(NOTIF_ALL_AUTHOR){
					// if(!empty($other_author))
						// $this->email->cc(implode(',', $other_author));
				// }

				// $this->email->bcc(BCC_MAILSYSTEM_MULTI, 3);
				// $this->email->subject('[IJTech] Inline-editing confirmation for manuscript '.$journal_id);
				// $this->email->message($message);
				
				$tujuan = $author[0]['email'];
				if(NOTIF_ALL_AUTHOR){
					if(!empty($other_author))
						$tujuan .= ','.implode(',', $other_author);
				}
				
				$this->db->set(array(
					'to' => $tujuan,
					'subject' => '[IJTech] Inline-editing confirmation for manuscript #'.$journal_id,
					'body' => $this->load->view('template/mailer/author/'.$mailer, $result, TRUE),
					'time' => date('Y-m-d H:i:s'),
					'parent' => $r['sub_id']
				))->insert('sendmail_log');
				
				// if($this->email->send()){					
					$this->cms->update('submission', array('sub_id', $sub_id), array('sub_status' => 12));
					$this->log_submission($sub_id, 12, 'inline editing');
					$sub[0]['sub_status'] = 12;
					$this->load->view('template/front/page/inline_editing_message', array('sub' => $sub));
				// }else{
					// $this->load->view('template/front/page/inline_editing_message', array('sub' => $sub));					
				// }
			}else{
				$this->load->view('template/front/page/inline_editing_message', array('sub' => $sub));
			}
		}else{
			redirect('home');
		} 
	}
	public function forthcoming($param = null){
	    $q = $this->db->query("select j.title
            ,group_concat(concat(a.first_name,' ',a.last_name) separator ', ') author
            from submission s
            left join journal j on j.sub_id = s.sub_id
            left join submission_author a on a.sub_id = s.sub_id
            where s.sub_status = 11
            and s.section_id != 2
            group by s.sub_id")->result();
	    $p = "";
	    foreach($q as $a){
	        $p .= '<li>'.$a->title.'<i>'.$a->author.'</i></li>';
	    }
	    if($p==""){
	        $p="No articles to be displayed here.";
	    }else{
	        $p='<ol>'.$p.'</ol>';
	    }
	    $t = '<h3 class="heading">Forthcoming Articles</h3><br>'.$p;
	    $this->data['param'] = $param ? $param:'about';
		$this->data['page'] = 'page/static';
		$this->data['content'][0] = array('page_title'=>'','page_content'=>$t);
		$this->load->view('template_front', $this->data);
	}
	public function inpress($param = null){
	    $q = $this->db->query("select j.title
            ,concat('Vol. ',i.volume,' No. ',i.issue_number,', ',i.year) terbitan
            ,concat('https://doi.org/10.14716/ijtech.v',i.volume,'i',i.issue_number,'.',s.sub_id) doi
            ,group_concat(concat(a.first_name,' ',a.last_name) separator ', ') author
            from submission s
            join journal j on j.sub_id = s.sub_id
            join issue i on i.issue_id = j.issue_id
            left join submission_author a on a.sub_id = s.sub_id
            where s.sub_status = 11
            and s.section_id != 2
            -- and j.introduction is not null
            group by s.sub_id")->result();
	    $p = "";
	    foreach($q as $a){
	        $p .= '<li>'.$a->title.'<i>'.$a->author.'</i><br>'.$a->terbitan.'<br>DOI: '.$a->doi.'</li>';
	    }
	    if($p==""){
	        $p="No articles to be displayed here.";
	    }else{
	        $p='<ol>'.$p.'</ol>';
	    }
	    $t = '<h3 class="heading">Inpress/Early Access</h3><br>'.$p;
	    $this->data['param'] = $param ? $param:'about';
		$this->data['page'] = 'page/static';
		$this->data['content'][0] = array('page_title'=>'','page_content'=>$t);
		$this->load->view('template_front', $this->data);
	}
	
}
