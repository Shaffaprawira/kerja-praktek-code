<?php

require_once('tcpdf.php');

class SIApdf extends TCPDF { 

	public function sia_set_properties($data){
		$this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('Online Sistem Matakuliah Khusus - Departemen Metalurgi');
		$this->SetTitle($data['pdf_title']);
		$this->SetSubject($data['pdf_title']);
		$this->SetKeywords('Laporan, Online Sistem Matakuliah Khusus - Departemen Metalurgi');
		
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		$this->setPrintHeader(false);
		$this->setPrintFooter(true);
		if(isset($data['pdf_margin'])){ $this->SetMargins($data['pdf_margin'][0], $data['pdf_margin'][1], $data['pdf_margin'][2], true); } 
		else { $this->SetMargins(20, 10, 20, true); }
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		#$this->setLanguageArray($l);
		
		$this->SetCellPadding(0);
		$this->setCellHeightRatio(1.25);
		$this->setImageScale(0.47);
		$tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		$this->setHtmlVSpace($tagvs);
		
		$this->startPageGroup();
		
		
		
	}
	
	public function sia_set_paperP1(){ //setting Portrait-1
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		$this->setPrintHeader(false);
		$this->setPrintFooter(true);
		$this->SetMargins(20, 10, 20, true);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		#$this->setLanguageArray($l);
		
		$this->SetCellPadding(0);
		$this->setCellHeightRatio(1.25);
		$this->setImageScale(0.47);
		$tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		$this->setHtmlVSpace($tagvs);
		
		$this->startPageGroup();
	}
	
	public function sia_set_paperL1(){ //setting Landscape-1
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		$this->setPrintHeader(false);
		$this->setPrintFooter(true);
		$this->SetMargins(20, 10, 20, true);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		#$this->setLanguageArray($l);
		
		$this->SetFont('helvetica', '', 9);
		
		$this->SetCellPadding(0);
		$this->setCellHeightRatio(1.25);
		$this->setImageScale(0.47);
		$tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		$this->setHtmlVSpace($tagvs);
		
		$this->startPageGroup();
	}
	
	public function Footer() {
		
		$this->SetY(-10);
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(17, 10, ''.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		//	Date printed
		$this->Cell(10, 10, ''.date('d').'/'.date('m').'/'.date('Y'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
	}
}