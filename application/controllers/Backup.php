<?php 
class Backup extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$role = $this->session->userdata('role');
		if(empty($role)){ redirect('login'); }
		if(!in_array(1, $role) && !in_array(2, $role)){ redirect('dashboard'); }
	}
	public function index($path=''){
		if($path==''){die('please specify folder name');}
		$this->downloadAsTgz(__DIR__ .'/../../'.$path);
	}
	function __computeUnsignedChecksum($bytestring) {
		$unsigned_chksum = 0;
		for($i=0; $i<512; $i++)
			$unsigned_chksum += ord($bytestring[$i]);
		for($i=0; $i<8; $i++)
			$unsigned_chksum -= ord($bytestring[148 + $i]);
		$unsigned_chksum += ord(" ") * 8;

		return $unsigned_chksum;
	}

	// Generates a TAR file from the processed data
	// PRIVATE ACCESS FUNCTION
	function tarSection($Name, $Data, $information=NULL) {
		// Generate the TAR header for this file

		$header = str_pad($Name,100,chr(0));
		$header .= str_pad("777",7,"0",STR_PAD_LEFT) . chr(0);
		$header .= str_pad(decoct($information["user_id"]),7,"0",STR_PAD_LEFT) . chr(0);
		$header .= str_pad(decoct($information["group_id"]),7,"0",STR_PAD_LEFT) . chr(0);
		$header .= str_pad(decoct(strlen($Data)),11,"0",STR_PAD_LEFT) . chr(0);
		$header .= str_pad(decoct(time(0)),11,"0",STR_PAD_LEFT) . chr(0);
		$header .= str_repeat(" ",8);
		$header .= "0";
		$header .= str_repeat(chr(0),100);
		$header .= str_pad("ustar",6,chr(32));
		$header .= chr(32) . chr(0);
		$header .= str_pad($information["user_name"],32,chr(0));
		$header .= str_pad($information["group_name"],32,chr(0));
		$header .= str_repeat(chr(0),8);
		$header .= str_repeat(chr(0),8);
		$header .= str_repeat(chr(0),155);
		$header .= str_repeat(chr(0),12);

		// Compute header checksum
		$checksum = str_pad(decoct($this->__computeUnsignedChecksum($header)),6,"0",STR_PAD_LEFT);
		for($i=0; $i<6; $i++) {
			$header[(148 + $i)] = substr($checksum,$i,1);
		}
		$header[154] = chr(0);
		$header[155] = chr(32);

		// Pad file contents to byte count divisible by 512
		$file_contents = str_pad($Data,(ceil(strlen($Data) / 512) * 512),chr(0));

		// Add new tar formatted data to tar file contents
		$tar_file = $header . $file_contents;

		return $tar_file;
	}

	function targz($Name, $Data) {
		return gzencode($this->tarSection($Name,$Data),9);
	}

	function compress( $path = '.', $level = 0 ){ 
			$ignore = array( 'cgi-bin', '.', '..' ); 
			$dh = @opendir( $path );
			while( false !== ( $file = readdir( $dh ) ) ){
					if( !in_array( $file, $ignore ) ){
							if( is_dir( "$path/$file" ) ){ // Go to the subdirs to compress files inside the subdirs
									// echo "compress $path/$file<br>";
									$this->compress( "$path/$file", ($level+1) );                                           
							} else {
									$getfile = file_get_contents($path. '/' .$file);
									// get the last dir in the $path
									$dirs = array_filter( explode('/', $path) );
									$dir = array_pop($dirs);

									// if we're not in a sub dir just compress the file in root otherwise add it on the subdir...
									if ($level < 1) {
											// echo "targz($file, $getfile)<br>";
											echo $this->targz($file, $getfile);
									} else {
											// add all top level subdirs when $level is > 2
											for ($i = 0; $i < $level - 1; $i++) {
													$temp = array_pop($dirs);
													$dir = $temp.'/'.$dir;
											}
											echo $this->targz($dir. '/' .$file, $getfile);
											// echo "targz($dir. '/' .$file, $getfile)<br>";
									}
							}                                        
					}                                    
			} 

			closedir( $dh ); 
	}

	function downloadAsTgz($dir=null){
		// valid example for $dir:
		// $dir = __DIR__ .'/tes/Proposal BD MOOCs Teknik Komputer - Jarkom.docx';
		// $dir = __DIR__ .'/tes';
		
		header("Content-Disposition: attachment; filename=backup.tar.gz");
		header("Content-type: application/x-gzip");
		
		if(is_null($dir)){ //by default, compress everything where this file resides and all subdirs.
			$dir = __DIR__;
		}
		if (is_file($dir)) { // If it's a file path just compress it & push it to output
				$getfile = file_get_contents($dir);
				echo $this->targz(basename($dir), $getfile);
		} elseif(is_dir($dir)) {
				return $this->compress($dir);
		}	
	}


}