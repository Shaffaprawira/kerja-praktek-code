<?php

/**
 * Journal engineering FTUI	
 * @author	: Sabbana
 * @corp	: sStud-io.net
 * @Date Created	: 28 April 2017
 */

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Xml_generator extends CI_Controller {

	protected $_doiID;

    public function __construct() {
        parent::__construct();
        $this->load->model('Mdl_cms','cms');
        $this->_doiID = '10.14716/ijtech';
    }

    public function index() {
    	echo "Class protected!";
	}

	public function issue($issue_id){
		
		$is = $this->cms->current_issue($issue_id);
		$journal = $this->cms->get_journal_issue($issue_id);

		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?>"."<doi_batch></doi_batch>");
		// add namespace doi
		$xml->addAttribute('xmlns', 'http://www.crossref.org/schema/4.3.0');
		$xml->addAttribute('xmlns:xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$xml->addAttribute('version', '4.3.0');
		$xml->addAttribute('xmlns:xsi:schemaLocation', 'http://www.crossref.org/schema/4.3.0 http://www.crossref.org/schema/deposit/crossref4.3.0.xsd');

		$head = $xml->addChild('head');
		$head->addChild('doi_batch_id', 'IJTech_'.time());
		$head->addChild('timestamp', time());
		$depositor = $head->addChild('depositor');
			$depositor->addChild('name','IJTech Secretariat');
			$depositor->addChild('email_address','ijtech@eng.ui.ac.id');
		$head->addChild('registrant','Universitas Indonesia');

		$body = $xml->addChild('body');
		if(!empty($journal)){
			foreach ($journal as $item) {
				$_page = $item['pages'] ? explode('-', $item['pages']): array(0,0);
				$journal_id = ($item['round'] > 1 ? 'R'.($item['round']-1).'-':'').$item['section_abv'].'-'.$item['sub_id'];
				$item_url = site_url().'article/view/'.$item['sub_id'];
				
				$journal = $body->addChild('journal');
				$metadata = $journal->addChild('journal_metadata');
				$metadata->addChild('full_title','International Journal of Technology');
				$metadata->addChild('abbrev_title','IJTech');
				$e = $metadata->addChild('issn',E_ISSN);
				$e->addAttribute('media_type','electronic');
				$e = $metadata->addChild('issn', P_ISSN);
				$e->addAttribute('media_type','print');
				$issue = $journal->addChild('journal_issue');
				$pdate = $issue->addChild('publication_date');
				$pdate->addAttribute('media_type','online');
				$pdate->addChild('month', date('m', strtotime($is[0]['date_publish'])));
				$pdate->addChild('day', date('d', strtotime($is[0]['date_publish'])));
				$pdate->addChild('year', date('Y', strtotime($is[0]['date_publish'])));

				$vol = $issue->addChild('journal_volume');
				$vol->addChild('volume', $is[0]['volume']);
				$_issue = $issue->addChild('issue', $is[0]['issue_number']);

				$doi_data = $issue->addChild('doi_data');
				$doi_data->addChild('doi', $this->_doiID.'.v'.$is[0]['volume'].'i'.$is[0]['issue_number']);
				// $doi_data->addChild('resource', site_url().'issue/'.$is[0]['issue_number']);
				$doi_data->addChild('resource', site_url().'issue/'.$issue_id);

				$article = $journal->addChild('journal_article');
				$article->addAttribute('publication_type','full_text');
				$titles = $article->addChild('titles');
				$title = $titles->addChild('title', strip_tags($item['title']));

				// get authors 
				$author = $this->cms->get_author_submission($item['sub_id']);
				$cont = $article->addChild('contributors');
				$no=0;
				foreach ($author as $a) {
					$no++;
					$pn = $cont->addChild('person_name');
					$pn->addAttribute('contributor_role','author');
					$pn->addAttribute('sequence', $no == 1 ? 'first':'additional');
					//$fName = trim($a['first_name']) == '' ? 
					$pn->addChild('given_name', empty($a['first_name']) ? trim($a['last_name']) : trim($a['first_name']));
					$pn->addChild('surname', empty($a['last_name']) ? trim($a['first_name']) : trim($a['last_name']));
				}
				$articel_date = $article->addChild('publication_date');
				$articel_date->addAttribute('media_type','online');
				$articel_date->addChild('month', date('m', strtotime($is[0]['date_publish'])));
				$articel_date->addChild('day', date('d', strtotime($is[0]['date_publish'])));
				$articel_date->addChild('year', date('Y', strtotime($is[0]['date_publish'])));
				$pages = $article->addChild('pages');				
				$pages->addChild('first_page',(int)$_page[0]);
				$pages->addChild('other_pages',(int)$_page[1]);
				$articel_doi = $article->addChild('doi_data');
				$articel_doi->addChild('doi', $this->_doiID.'.v'.$is[0]['volume'].'i'.$is[0]['issue_number'].'.'.$item['sub_id']);
				$articel_doi->addChild('resource', $item_url);				
			}
		}
		header('Content-Disposition: attachment; filename="crossref.xml"');
		Header('Content-type: text/xml');
		echo $xml->asXML();
		
	}

	public function issueXXX($issue_id){
		
		$is = $this->cms->current_issue($issue_id);
		$journal = $this->cms->get_journal_issue($issue_id);

		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?>"."<doi_batch></doi_batch>");
		// add namespace doi
		$xml->addAttribute('xmlns', 'http://www.crossref.org/schema/4.3.0');
		$xml->addAttribute('xmlns:xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$xml->addAttribute('version', '4.3.0');
		$xml->addAttribute('xmlns:xsi:schemaLocation', 'http://www.crossref.org/schema/4.3.0 http://www.crossref.org/schema/deposit/crossref4.3.0.xsd');

		$head = $xml->addChild('head');
		$head->addChild('doi_batch_id', 'IJTech_'.time());
		$head->addChild('timestamp', time());
		$depositor = $head->addChild('depositor');
			$depositor->addChild('name','IJTech Secretariat');
			$depositor->addChild('email_address','ijtech@eng.ui.ac.id');
		$head->addChild('registrant','Universitas Indonesia');

		$body = $xml->addChild('body');
		if(!empty($journal)){
			foreach ($journal as $item) {
				$_page = $item['pages'] ? explode('-', $item['pages']): array(0,0);
				$journal_id = ($item['round'] > 1 ? 'R'.($item['round']-1).'-':'').$item['section_abv'].'-'.$item['sub_id'];
				$item_url = site_url().'article/view/'.$item['sub_id'];

				$journal = $body->addChild('journal');
				$metadata = $journal->addChild('journal_metadata');
				$metadata->addChild('full_title','International Journal of Technology');
				$metadata->addChild('abbrev_title','IJTech');
				$e = $metadata->addChild('issn',E_ISSN);
				$e->addAttribute('media_type','electronic');
				$e = $metadata->addChild('issn', P_ISSN);
				$e->addAttribute('media_type','print');
				$issue = $journal->addChild('journal_issue');
				$pdate = $issue->addChild('publication_date');
				$pdate->addAttribute('media_type','online');
				$pdate->addChild('month', date('m', strtotime($is[0]['date_publish'])));
				$pdate->addChild('day', date('d', strtotime($is[0]['date_publish'])));
				$pdate->addChild('year', date('Y', strtotime($is[0]['date_publish'])));

				$vol = $issue->addChild('journal_volume');
				$vol->addChild('volume', $is[0]['volume']);
				$_issue = $issue->addChild('issue', $is[0]['issue_number']);

				$doi_data = $issue->addChild('doi_data');
				$doi_data->addChild('doi','10.14716/ijtech.v8i3');
				$doi_data->addChild('resource', site_url().'issue/'.$is[0]['issue_id']);

				$article = $journal->addChild('journal_article');
				$article->addAttribute('publication_type','full_text');
				$titles = $article->addChild('titles');
				$title = $titles->addChild('title', strip_tags($item['title']));

				// get authors 
				$author = $this->cms->get_author_submission($item['sub_id']);
				$cont = $article->addChild('contributors');
				$no=0;
				foreach ($author as $a) {
					$no++;
					$pn = $cont->addChild('person_name');
					$pn->addAttribute('contributor_role','author');
					$pn->addAttribute('sequence', $no == 1 ? 'first':'additional');
					$pn->addChild('given_name', trim($a['first_name']));
					$pn->addChild('surname', empty($a['last_name']) ? trim($a['first_name']) : trim($a['last_name']));
				}
				$articel_date = $article->addChild('publication_date');
				$articel_date->addAttribute('media_type','online');
				$articel_date->addChild('month', date('m', strtotime($is[0]['date_publish'])));
				$articel_date->addChild('day', date('d', strtotime($is[0]['date_publish'])));
				$articel_date->addChild('year', date('Y', strtotime($is[0]['date_publish'])));
				$pages = $article->addChild('pages');				
				$pages->addChild('first_page',(int)$_page[0]);
				$pages->addChild('other_pages',(int)$_page[1]);
				$articel_doi = $article->addChild('doi_data');
				$articel_doi->addChild('doi','10.14716/ijtech.v8i3.'.strtolower($journal_id));
				$articel_doi->addChild('resource', $item_url);				
			}
		}
		header('Content-Disposition: attachment; filename="crossref.xml"');
		Header('Content-type: text/xml');
		echo $xml->asXML();
		
	}

	

}
