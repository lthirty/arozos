<?php
include '../../../auth.php';
?>
<?php
function mv($var){
		if (isset($_GET[$var]) !== false && $_GET[$var] != ""){
			return $_GET[$var];
		}else{
			return null;
		}
	}
function is_utf8($str) {
    return (bool) preg_match('//u', $str);
}

//Get all the files in the given dir and turn it into json files
$dirs = [];
$files = [];
if (mv("dir") != null){
	$path = mv("dir");
	if (file_exists($path) && is_dir($path)){
		$filelist = glob($path . "/*");
		foreach ($filelist as $file){
			if (is_utf8($file)){
				if (is_file($file)){
					array_push($files,$file);
				}else{
					array_push($dirs,$file);
				}
			}else{
				//This file is not encoded in UTF-8 format. Unable to read so this file will be skipped.
				
			}
		}
		$result[0] = $dirs;
		$result[1] = $files;
		header('Content-Type: application/json');
		echo json_encode($result);
		//print_r($result);
	}elseif(file_exists(realpath($path))){
		die("ERROR, Please use real path instead of relative path for dir variable.");
	}else{
		die("ERROR, directory not exists or it is not a folder.\n" . $path);
	}
}else{
	die("ERROR, dir is empty.");
}


?>