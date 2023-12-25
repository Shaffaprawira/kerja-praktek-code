<?php

/**
 * Journal engineering FTUI	
 * @author	: Vincent & Ruki
 * @Date Created	: 7 Agustus 2018
 * @Date Updated	: 9 Agustus 2018
 */

if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Xml_generator_doaj extends CI_Controller {

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

		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?>"."<records></records>");

    $xml->addAttribute("xsi:noNamespaceSchemaLocation", "http://www.doaj.org/schemas/doajArticles.xsd", "http://www.w3.org/2001/XMLSchema-instance");

		if(!empty($journal)){
			foreach ($journal as $item) {
				$record = $xml->addChild('record');
				$record->addChild('publisher','Universitas Indonesia');
				$record->addChild('journalTitle','International Journal of Technology');

				$_page = $item['pages'] ? explode('-', $item['pages']): array(0,0);
				
				$e = $record->addChild('issn', P_ISSN);
				$e = $record->addChild('eissn',E_ISSN);
				$pdate = $record->addChild('publicationDate',date('Y-m-d', strtotime($is[0]['date_publish'])));

				$vol = $record->addChild('volume',$is[0]['volume']);
				$_issue = $record->addChild('issue', $is[0]['issue_number']);
				$spage = $record->addChild('startPage',(int)$_page[0]);
				$epage = $record->addChild('endPage',(int)$_page[1]);
				$doi_data = $record->addChild('doi', $this->_doiID.'.v'.$is[0]['volume'].'i'.$is[0]['issue_number'].'.'.$item['sub_id']);	  
				$pub_r_id = $record->addChild('publisherRecordId',$item['sub_id']);
				$title = $record->addChild('title',htmlspecialchars(strip_tags($item['title'])));
				$title->addAttribute('language','eng');

				// get authors 
				$authors = $record->addChild('authors');
				$_author = $this->cms->get_author_submission($item['sub_id']);
        
        $affiliations = array();
        $counter = 0;
				foreach ($_author as $a){
					$author = $authors->addChild('author');
					$name = $author->addChild('name',$a['first_name'].' '.$a['last_name']);
          if(!empty($a['email'])){
            $email = $author->addChild('email',$a['email']);
          }
          $affiliations[$counter] = $a['affiliation'];
          $author->addChild('affiliationId',$counter);
          $counter++;
				}
        
        $affiliationsList = $record->addChild('affiliationsList');
        $counter = 0;
        foreach ($affiliations as $aff){
          $affiliationName = $affiliationsList->addChild('affiliationName',trim(htmlspecialchars($aff)));
          $affiliationName->addAttribute('affiliationId',$counter);
          $counter++;
        }

				$abstract = $record->addChild('abstract',htmlspecialchars(strip_tags($item['abstract'])));
				$abstract->addAttribute('language','eng');
				$furl = $record->addChild('fullTextUrl', site_url().'article/view/'.$item['sub_id']);
				$furl->addAttribute('format','html');
				//get keywords
        if(!empty($item['keywords'])){
          $keywords = $record->addChild('keywords');
          $key = explode(";",$item['keywords']);
          foreach($key as $b){
            $keyword = $keywords->addChild('keyword',htmlspecialchars(trim($b)));
          }
        }
			}
		}
		header('Content-Disposition: attachment; filename="doaj.xml"');
		Header('Content-type: text/xml');
		echo $xml->asXML();	
	}	
}
