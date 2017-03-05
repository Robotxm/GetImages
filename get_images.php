<?php
/**
*	Name:			Get Images
*	URI:			https://github.com/Robotxm/GetImages
*	Description:	Get remote images in order to show over SSL.
*	Version:		1.0.0.0
*	Author:			Robotxm
*	Author URI:		http://blog.moefactory.com
**/
	//Disable the warning and the notice
	//ini_set("display_errors", 0);
	//error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(E_ALL ^ E_WARNING);
	
	$url = $_GET["url"]; // Get the URL of the image
    $path = "./images/"; // Specify the path to save the image. If it doesn't exist, it will be created automatically
	$max_size = "20"; // Specify the max size of the directory (MB). If the real size is larger than it, the directory will be cleaned automatically.
	$filename = md5($url); // Generate the file name
	
	// Check if the URL of the image is empty
	if($url==""){
		echo 'Empty URL.';
		exit;
	}
	// Check if the directory exists
    if(!is_dir($path)){
		mkdir($path, 0777, true);
    }
	if(file_exists($path . $filename . ".png")){
		// Show the image
		header('Content-Type:image/png');
		echo file_get_contents($path . $filename . ".png");
	}else{
		$data = file_get_contents($url); // Get the content or the image
		$fp = @fopen($path . $filename . ".png","w");
		@fwrite($fp,$data);
		fclose($fp);
		// Show the image
		header('Content-Type:image/png');
		echo file_get_contents($path . $filename . ".png");
	}
	
	// Check File Type
	function file_type($filename){
		$file = fopen($filename, "rb");
		$bin = fread($file, 2);
		fclose($file);
		$strInfo = @unpack("C2chars", $bin);
		$typeCode = intval($strInfo['chars1'].$strInfo['chars2']);
		$fileType = '';
		switch ($typeCode)
		{
			case 255216:
				$fileType = 'jpg';
				break;
			case 7173:
				$fileType = 'gif';
				break;
			case 6677:
				$fileType = 'bmp';
				break;
			case 13780:
				$fileType = 'png';
				break;
		}
		return $fileType;
	}
?>